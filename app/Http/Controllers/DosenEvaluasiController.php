<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DosenEvaluasiController extends Controller
{
    // Menampilkan Daftar Mata Kuliah yang Dievaluasi
    public function index()
    {
        $dosen = DB::table('dosen')->where('user_id', Auth::id())->first();
        if (!$dosen) abort(403, 'Profil dosen tidak ditemukan.');

        // Hanya ambil mata kuliah yang diajar oleh dosen ini
        $mataKuliahs = DB::table('dosen_mata_kuliah')
            ->join('mata_kuliah', 'dosen_mata_kuliah.mk_id', '=', 'mata_kuliah.id')
            ->where('dosen_mata_kuliah.dosen_id', $dosen->id)
            ->select('dosen_mata_kuliah.id as dosen_mk_id', 'mata_kuliah.kode_mk', 'mata_kuliah.nama_mk', 'mata_kuliah.semester')
            ->get();

        foreach ($mataKuliahs as $mk) {
            $evaluasiIds = DB::table('evaluasi')->where('dosen_mk_id', $mk->dosen_mk_id)->pluck('id');
            
            if ($evaluasiIds->count() > 0) {
                $avg = DB::table('detail_evaluasi')->whereIn('evaluasi_id', $evaluasiIds)->avg('nilai');
                $mk->rata_rata = number_format($avg, 1);
            } else {
                $mk->rata_rata = null;
            }
        }

        return view('dosen.evaluasi.index', compact('mataKuliahs'));
    }

    // Menampilkan Detail Evaluasi Per Mata Kuliah
    public function show($dosen_mk_id)
    {
        $dosen = DB::table('dosen')->where('user_id', Auth::id())->first();
        if (!$dosen) abort(403);

        // Verifikasi kepemilikan: Pastikan jadwal ini benar-benar milik dosen yang login
        $jadwal = DB::table('dosen_mata_kuliah')
            ->join('mata_kuliah', 'dosen_mata_kuliah.mk_id', '=', 'mata_kuliah.id')
            ->where('dosen_mata_kuliah.id', $dosen_mk_id)
            ->where('dosen_mata_kuliah.dosen_id', $dosen->id)
            ->select('dosen_mata_kuliah.id as dosen_mk_id', 'mata_kuliah.nama_mk', 'mata_kuliah.semester')
            ->first();

        if (!$jadwal) abort(404, 'Data tidak ditemukan atau Anda tidak memiliki akses ke mata kuliah ini.');

        $evaluasiIds = DB::table('evaluasi')->where('dosen_mk_id', $dosen_mk_id)->pluck('id');
        $totalRespon = $evaluasiIds->count();

        // Deklarasi awal
        $rataRataKeseluruhan = '-';
        
        // 1. Jika ADA data evaluasi
        if ($totalRespon > 0) {
            $avg = DB::table('detail_evaluasi')->whereIn('evaluasi_id', $evaluasiIds)->avg('nilai');
            $rataRataKeseluruhan = number_format($avg, 1) . '/4.0';

            $kategoriScores = DB::table('detail_evaluasi')
                ->join('pertanyaan', 'detail_evaluasi.pertanyaan_id', '=', 'pertanyaan.id')
                ->join('kategori_pertanyaan', 'pertanyaan.kategori_id', '=', 'kategori_pertanyaan.id')
                ->whereIn('detail_evaluasi.evaluasi_id', $evaluasiIds)
                ->select('kategori_pertanyaan.nama_kategori', DB::raw('AVG(detail_evaluasi.nilai) as rata_rata'))
                ->groupBy('kategori_pertanyaan.id', 'kategori_pertanyaan.nama_kategori')
                ->get();

            $pertanyaanScores = DB::table('detail_evaluasi')
                ->join('pertanyaan', 'detail_evaluasi.pertanyaan_id', '=', 'pertanyaan.id')
                ->whereIn('detail_evaluasi.evaluasi_id', $evaluasiIds)
                ->select('pertanyaan.teks_pertanyaan', DB::raw('AVG(detail_evaluasi.nilai) as rata_rata'))
                ->groupBy('pertanyaan.id', 'pertanyaan.teks_pertanyaan')
                ->get();
        } 
        // 2. Jika BELUM ADA data (Kosong) -> Tetap tampilkan kategori & pertanyaan dengan nilai null
        else {
            $kategoriScores = DB::table('kategori_pertanyaan')
                ->select('nama_kategori', DB::raw('null as rata_rata'))
                ->get();
                
            $pertanyaanScores = DB::table('pertanyaan')
                ->select('teks_pertanyaan', DB::raw('null as rata_rata'))
                ->get();
        }

        return view('dosen.evaluasi.show', compact('jadwal', 'totalRespon', 'rataRataKeseluruhan', 'kategoriScores', 'pertanyaanScores'));
    }
}