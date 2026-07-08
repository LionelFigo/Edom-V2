<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AdminDosenController extends Controller
{
    public function index()
    {
        $dosens = DB::table('dosen')->get();

        // Looping untuk mencari mata kuliah tiap dosen
        foreach ($dosens as $dosen) {
            // Ambil daftar nama mata kuliah dari tabel pivot dosen_mata_kuliah
            $matkuls = DB::table('dosen_mata_kuliah')
                ->join('mata_kuliah', 'dosen_mata_kuliah.mk_id', '=', 'mata_kuliah.id') // <-- INI YANG DIPERBAIKI
                ->where('dosen_mata_kuliah.dosen_id', $dosen->id)
                ->pluck('mata_kuliah.nama_mk') // Memanggil nama_mk dari tabel mata_kuliah
                ->toArray();
            
            // Gabungkan array mata kuliah menjadi string (Contoh: "Pemrograman Web, Basis Data")
            $dosen->daftar_matkul = !empty($matkuls) ? implode(', ', $matkuls) : '-';
        }

        return view('admin.dosen.dosen', compact('dosens'));
    }
        public function create()
    {
        // Mengambil data mata kuliah untuk form select multiple
        $matkuls = DB::table('mata_kuliah')->get();
        
        // Mengambil data prodi dari tabel prodi
        $prodis = DB::table('prodi')->get(); 

        return view('admin.dosen.tambah_dosen', compact('matkuls', 'prodis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'     => 'required',
            'nip'      => 'required|unique:dosen,nip',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'prodi'    => 'required',
            'foto'     => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'matkul'   => 'nullable|array', // Tambahkan validasi ini
        ]);

        DB::beginTransaction();
        try {
            // 1. Buat Akun di tabel Users
            $userId = DB::table('users')->insertGetId([
                'name'       => $request->nama,
                'email'      => $request->email,
                'password'   => Hash::make($request->password),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            // 2. Beri Role 'dosen' menggunakan Spatie Role (Query Builder)
            $roleDosen = DB::table('roles')->where('name', 'dosen')->first();
            if ($roleDosen) {
                DB::table('model_has_roles')->insert([
                    'role_id'    => $roleDosen->id,
                    'model_type' => 'App\Models\User',
                    'model_id'   => $userId
                ]);
            }

            // 3. Proses Foto
            $filename = null;
            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('asset/img/dosen'), $filename);
            }

            // 4. Masukkan Profil ke tabel Dosen (UBAH insert MENJADI insertGetId)
            $dosenId = DB::table('dosen')->insertGetId([
                'user_id'      => $userId,
                'nama_lengkap' => $request->nama,
                'nip'          => $request->nip,
                'prodi'        => $request->prodi,
                'status'       => $request->status ?? 'Aktif',
                'foto_profil'  => $filename,
            ]);

            // 5. Masukkan data ke tabel dosen_mata_kuliah jika ada mata kuliah yang dipilih
            if ($request->has('matkul') && is_array($request->matkul)) {
                $matkulData = [];
                foreach ($request->matkul as $mk_id) {
                    $matkulData[] = [
                        'dosen_id' => $dosenId,
                        'mk_id'    => $mk_id
                    ];
                }
                // Simpan semua mata kuliah sekaligus
                DB::table('dosen_mata_kuliah')->insert($matkulData);
            }

            DB::commit();
            return redirect()->route('admin.dosen.index')->with('success', 'Data Dosen & Akun berhasil ditambahkan!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Gagal menyimpan data: ' . $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $dosen = DB::table('dosen')
            ->leftJoin('users', 'dosen.user_id', '=', 'users.id')
            ->select('dosen.*', 'users.email')
            ->where('dosen.id', $id)
            ->first();

        $matkuls = DB::table('mata_kuliah')->get();

        if (!$dosen) {
            abort(404);
        }

        // Ambil ID mata kuliah yang sudah dipilih oleh dosen ini sebelumnya
        $selected_matkuls = DB::table('dosen_mata_kuliah')
            ->where('dosen_id', $id)
            ->pluck('mk_id')
            ->toArray();

        // Tambahkan $selected_matkuls ke dalam compact
        return view('admin.dosen.edit_dosen', compact('dosen', 'matkuls', 'selected_matkuls'));
    }

    public function update(Request $request, $id)
    {
        $dosen = DB::table('dosen')->where('id', $id)->first();
        if (!$dosen) {
            abort(404);
        }

        $request->validate([
            'nama'   => 'required',
            'nip'    => 'required|unique:dosen,nip,' . $id,
            'email'  => 'required|email|unique:users,email,' . $dosen->user_id,
            'prodi'  => 'required',
            'foto'   => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'matkul' => 'nullable|array', // Tambahkan validasi ini
        ]);

        DB::beginTransaction();
        try {
            // 1. Update Akun di tabel Users (Jika user_id tersedia)
            if ($dosen->user_id) {
                $userData = [
                    'name'       => $request->nama,
                    'email'      => $request->email,
                    'updated_at' => Carbon::now(),
                ];

                // Hanya update password jika form password diisi
                if ($request->filled('password')) {
                    $userData['password'] = Hash::make($request->password);
                }

                DB::table('users')->where('id', $dosen->user_id)->update($userData);
            }

            // 2. Proses Update Foto
            $filename = $dosen->foto_profil;
            if ($request->hasFile('foto')) {
                // Hapus foto lama
                if ($filename && File::exists(public_path('asset/img/dosen/' . $filename))) {
                    File::delete(public_path('asset/img/dosen/' . $filename));
                }

                // Upload foto baru
                $file = $request->file('foto');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('asset/img/dosen'), $filename);
            }

            // 3. Update Profil di tabel Dosen
            DB::table('dosen')->where('id', $id)->update([
                'nama_lengkap' => $request->nama,
                'nip'          => $request->nip,
                'prodi'        => $request->prodi,
                'status'       => $request->status ?? 'Aktif',
                'foto_profil'  => $filename,
            ]);

            // 4. Update relasi Mata Kuliah
            // Hapus semua data lama untuk dosen ini di tabel pivot
            DB::table('dosen_mata_kuliah')->where('dosen_id', $id)->delete();

            // Masukkan data mata kuliah yang baru dipilih (jika ada)
            if ($request->has('matkul') && is_array($request->matkul)) {
                $matkulData = [];
                foreach ($request->matkul as $mk_id) {
                    $matkulData[] = [
                        'dosen_id' => $id,
                        'mk_id'    => $mk_id
                    ];
                }
                DB::table('dosen_mata_kuliah')->insert($matkulData);
            }

            DB::commit();
            return redirect()->route('admin.dosen.index')->with('success', 'Data Dosen berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Gagal memperbarui data: ' . $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        $dosen = DB::table('dosen')->where('id', $id)->first();
        if (!$dosen) {
            abort(404);
        }

        DB::beginTransaction();
        try {
            // Hapus File Foto
            if ($dosen->foto_profil) {
                $path = public_path('asset/img/dosen/' . $dosen->foto_profil);
                if (File::exists($path)) {
                    File::delete($path);
                }
            }

            // Hapus Akun User (Otomatis akan menghapus relasi role jika database Anda menggunakan Cascade On Delete, jika tidak biarkan manual)
            if ($dosen->user_id) {
                DB::table('users')->where('id', $dosen->user_id)->delete();
                DB::table('model_has_roles')->where('model_id', $dosen->user_id)->delete();
            }

            // Hapus Data Dosen
            DB::table('dosen')->where('id', $id)->delete();

            DB::commit();
            return redirect()->route('admin.dosen.index')->with('success', 'Data Dosen dan Akun berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Gagal menghapus data.']);
        }
    }
}