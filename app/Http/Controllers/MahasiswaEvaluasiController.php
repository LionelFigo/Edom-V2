<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class MahasiswaEvaluasiController extends Controller
{
    // Menampilkan Dashboard Dinamis
    public function index()
    {
        $userId = Auth::id(); // Mengambil ID user yang sedang login

        // Mengambil daftar dosen & mata kuliah dari tabel pivot
        $jadwals = DB::table('dosen_mata_kuliah')
            ->join('dosen', 'dosen_mata_kuliah.dosen_id', '=', 'dosen.id')
            ->join('mata_kuliah', 'dosen_mata_kuliah.mk_id', '=', 'mata_kuliah.id')
            ->select(
                'dosen_mata_kuliah.id as dosen_mk_id', 
                'dosen.nama_lengkap', 
                'mata_kuliah.kode_mk', 
                'mata_kuliah.nama_mk', 
                'mata_kuliah.semester'
            )
            ->get();

        // Mengecek status apakah mahasiswa sudah mengisi evaluasi ini
        $evaluasiSelesai = 0;
        foreach ($jadwals as $jadwal) {
            $isEvaluated = DB::table('evaluasi')
                ->where('dosen_mk_id', $jadwal->dosen_mk_id)
                ->where('user_id', $userId) // Pastikan Anda sudah membuat kolom user_id di tabel evaluasi
                ->exists();
            
            $jadwal->status = $isEvaluated ? 'Selesai' : 'Belum Diisi';
            if ($isEvaluated) $evaluasiSelesai++;
        }

        $totalEvaluasi = count($jadwals);
        $evaluasiBelum = $totalEvaluasi - $evaluasiSelesai;

        return view('mahasiswa.dashboard', compact('jadwals', 'evaluasiSelesai', 'evaluasiBelum'));
    }

    // Menampilkan Form Evaluasi
    public function show($dosen_mk_id)
    {
        $userId = Auth::id();

        // Cegah akses jika sudah diisi
        $sudahIsi = DB::table('evaluasi')
            ->where('dosen_mk_id', $dosen_mk_id)
            ->where('user_id', $userId)
            ->exists();

        if ($sudahIsi) {
            return redirect()->route('mahasiswa.dashboard')->with('error', 'Anda sudah mengisi evaluasi untuk mata kuliah ini.');
        }

        // Detail Dosen dan Mata Kuliah
        $jadwal = DB::table('dosen_mata_kuliah')
            ->join('dosen', 'dosen_mata_kuliah.dosen_id', '=', 'dosen.id')
            ->join('mata_kuliah', 'dosen_mata_kuliah.mk_id', '=', 'mata_kuliah.id')
            ->where('dosen_mata_kuliah.id', $dosen_mk_id)
            ->select('dosen_mata_kuliah.id as dosen_mk_id', 'dosen.nama_lengkap', 'dosen.nip', 'dosen.foto_profil', 'mata_kuliah.nama_mk', 'mata_kuliah.semester')
            ->first();

        if (!$jadwal) abort(404);

        // Ambil Data Kategori & Pertanyaan
        $kategoris = DB::table('kategori_pertanyaan')->get();
        $pertanyaans = DB::table('pertanyaan')->get();

        return view('mahasiswa.evaluasi', compact('jadwal', 'kategoris', 'pertanyaans'));
    }

    // Menyimpan Data Evaluasi
    public function store(Request $request, $dosen_mk_id)
    {
        $userId = Auth::id();
        $namaMahasiswa = Auth::user()->name; // Asumsi kolom nama di tabel users adalah 'name'

        DB::beginTransaction();
        try {
            // 1. Simpan ke tabel evaluasi (Induk)
            $evaluasiId = DB::table('evaluasi')->insertGetId([
                'dosen_mk_id'    => $dosen_mk_id,
                'user_id'        => $userId, // Tambahkan kolom ini di DB
                'nama_mahasiswa' => $namaMahasiswa,
                'saran_komentar' => $request->saran_komentar,
                'tanggal_isi'    => Carbon::now()
            ]);

            // 2. Simpan skor ke tabel detail_evaluasi
            $detailData = [];
            $pertanyaans = DB::table('pertanyaan')->pluck('id');
            
            foreach ($pertanyaans as $p_id) {
                // Mengambil input radio button dengan name="q_1", "q_2", dst.
                $skor = $request->input('q_' . $p_id); 
                
                if ($skor) {
                    $detailData[] = [
                        'evaluasi_id'   => $evaluasiId,
                        'pertanyaan_id' => $p_id,
                        'skor'          => $skor
                    ];
                }
            }

            // Insert massal ke detail_evaluasi
            if (!empty($detailData)) {
                DB::table('detail_evaluasi')->insert($detailData);
            }

            DB::commit();
            return redirect()->route('mahasiswa.dashboard')->with('success', 'Evaluasi berhasil disimpan!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal menyimpan evaluasi: ' . $e->getMessage());
        }
    }
}