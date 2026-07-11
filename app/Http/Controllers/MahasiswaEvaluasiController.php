<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class MahasiswaEvaluasiController extends Controller
{
    public function index()
    {
        $userId = Auth::id(); 

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

        $evaluasiSelesai = 0;
        foreach ($jadwals as $jadwal) {
            $isEvaluated = DB::table('evaluasi')
                ->where('dosen_mk_id', $jadwal->dosen_mk_id)
                ->where('user_id', $userId) 
                ->exists();
            
            $jadwal->status = $isEvaluated ? 'Selesai' : 'Belum Diisi';
            if ($isEvaluated) $evaluasiSelesai++;
        }

        $totalEvaluasi = count($jadwals);
        $evaluasiBelum = $totalEvaluasi - $evaluasiSelesai;

        return view('mahasiswa.dashboard', compact('jadwals', 'evaluasiSelesai', 'evaluasiBelum'));
    }

    public function show($dosen_mk_id)
    {
        $user = Auth::user();

        $sudahIsi = DB::table('evaluasi')
            ->where('dosen_mk_id', $dosen_mk_id)
            ->where('user_id', $user->id)
            ->exists();

        if ($sudahIsi) {
            return redirect()->route('mahasiswa.dashboard')->with('error', 'Anda sudah mengisi evaluasi untuk mata kuliah ini.');
        }

        $jadwal = DB::table('dosen_mata_kuliah')
            ->join('dosen', 'dosen_mata_kuliah.dosen_id', '=', 'dosen.id')
            ->join('mata_kuliah', 'dosen_mata_kuliah.mk_id', '=', 'mata_kuliah.id')
            ->where('dosen_mata_kuliah.id', $dosen_mk_id)
            ->where('mata_kuliah.prodi_id', $user->prodi_id) 
            ->select('dosen_mata_kuliah.id as dosen_mk_id', 'dosen.nama_lengkap', 'dosen.nip', 'dosen.foto_profil', 'mata_kuliah.nama_mk', 'mata_kuliah.semester')
            ->first();

        if (!$jadwal) abort(404, 'Mata kuliah tidak ditemukan atau bukan dari program studi Anda.');

        $kategoris = DB::table('kategori_pertanyaan')->get();
        $pertanyaans = DB::table('pertanyaan')->get();

        return view('mahasiswa.evaluasi', compact('jadwal', 'kategoris', 'pertanyaans'));
    }

    public function store(Request $request, $dosen_mk_id)
    {
        $userId = Auth::id();
        $namaMahasiswa = Auth::user()->name; 

        DB::beginTransaction();
        try {
            $evaluasiId = DB::table('evaluasi')->insertGetId([
                'dosen_mk_id'    => $dosen_mk_id,
                'user_id'        => $userId, 
                'nama_mahasiswa' => $namaMahasiswa,
                'saran_komentar' => $request->saran_komentar,
                'tanggal_isi'    => Carbon::now()
            ]);

            $detailData = [];
            $pertanyaans = DB::table('pertanyaan')->pluck('id');
            
            foreach ($pertanyaans as $p_id) {
                $skor = $request->input('q_' . $p_id); 
                
                if ($skor) {
                    $detailData[] = [
                        'evaluasi_id'   => $evaluasiId,
                        'pertanyaan_id' => $p_id,
                        'nilai'          => $skor
                    ];
                }
            }

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