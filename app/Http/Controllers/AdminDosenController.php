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

        foreach ($dosens as $dosen) {
            $matkuls = DB::table('dosen_mata_kuliah')
                ->join('mata_kuliah', 'dosen_mata_kuliah.mk_id', '=', 'mata_kuliah.id')
                ->where('dosen_mata_kuliah.dosen_id', $dosen->id)
                ->pluck('mata_kuliah.nama_mk')
                ->toArray();
            $dosen->daftar_matkul = !empty($matkuls) ? implode(', ', $matkuls) : '-';
        }

        return view('admin.dosen.dosen', compact('dosens'));
    }
        public function create()
    {
        $matkuls = DB::table('mata_kuliah')->get();
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
            'matkul'   => 'nullable|array',
        ]);

        DB::beginTransaction();
        try {
            $userId = DB::table('users')->insertGetId([
                'name'       => $request->nama,
                'email'      => $request->email,
                'password'   => Hash::make($request->password),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            $roleDosen = DB::table('roles')->where('name', 'dosen')->first();
            if ($roleDosen) {
                DB::table('model_has_roles')->insert([
                    'role_id'    => $roleDosen->id,
                    'model_type' => 'App\Models\User',
                    'model_id'   => $userId
                ]);
            }

            $filename = null;
            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('asset/img/dosen'), $filename);
            }

            $dosenId = DB::table('dosen')->insertGetId([
                'user_id'      => $userId,
                'nama_lengkap' => $request->nama,
                'nip'          => $request->nip,
                'prodi'        => $request->prodi,
                'status'       => $request->status ?? 'Aktif',
                'foto_profil'  => $filename,
            ]);

            if ($request->has('matkul') && is_array($request->matkul)) {
                $matkulData = [];
                foreach ($request->matkul as $mk_id) {
                    $matkulData[] = [
                        'dosen_id' => $dosenId,
                        'mk_id'    => $mk_id
                    ];
                }
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

        if (!$dosen) abort(404);

        $matkuls = DB::table('mata_kuliah')->get();

        $dosen_mk = DB::table('dosen_mata_kuliah')
            ->where('dosen_id', $id)
            ->pluck('mk_id')
            ->toArray();

        $prodis = DB::table('prodi')->get();

        return view('admin.dosen.edit_dosen', compact('dosen', 'matkuls', 'dosen_mk', 'prodis'));
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
            'matkul' => 'nullable|array', 
        ]);

        DB::beginTransaction();
        try {
            if ($dosen->user_id) {
                $userData = [
                    'name'       => $request->nama,
                    'email'      => $request->email,
                    'updated_at' => Carbon::now(),
                ];

                if ($request->filled('password')) {
                    $userData['password'] = Hash::make($request->password);
                }

                DB::table('users')->where('id', $dosen->user_id)->update($userData);
            }

            $filename = $dosen->foto_profil;
            if ($request->hasFile('foto')) {

                if ($filename && File::exists(public_path('asset/img/dosen/' . $filename))) {
                    File::delete(public_path('asset/img/dosen/' . $filename));
                }

                $file = $request->file('foto');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('asset/img/dosen'), $filename);
            }

            DB::table('dosen')->where('id', $id)->update([
                'nama_lengkap' => $request->nama,
                'nip'          => $request->nip,
                'prodi'        => $request->prodi,
                'status'       => $request->status ?? 'Aktif',
                'foto_profil'  => $filename,
            ]);

            DB::table('dosen_mata_kuliah')->where('dosen_id', $id)->delete();

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
            if ($dosen->foto_profil) {
                $path = public_path('asset/img/dosen/' . $dosen->foto_profil);
                if (File::exists($path)) {
                    File::delete($path);
                }
            }

            if ($dosen->user_id) {
                DB::table('users')->where('id', $dosen->user_id)->delete();
                DB::table('model_has_roles')->where('model_id', $dosen->user_id)->delete();
            }

            DB::table('dosen')->where('id', $id)->delete();

            DB::commit();
            return redirect()->route('admin.dosen.index')->with('success', 'Data Dosen dan Akun berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Gagal menghapus data.']);
        }
    }
}