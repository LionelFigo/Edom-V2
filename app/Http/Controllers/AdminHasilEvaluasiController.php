<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminHasilEvaluasiController extends Controller
{
    public function index()
    {
        // Ambil semua pasangan Dosen dan Mata Kuliah
        $hasils = DB::table('dosen_mata_kuliah')
            ->join('dosen', 'dosen_mata_kuliah.dosen_id', '=', 'dosen.id')
            ->join('mata_kuliah', 'dosen_mata_kuliah.mk_id', '=', 'mata_kuliah.id')
            ->select(
                'dosen_mata_kuliah.id as dosen_mk_id',
                'dosen.nama_lengkap',
                'mata_kuliah.nama_mk',
                'mata_kuliah.semester'
            )
            ->get();

        // Hitung respon dan rata-rata untuk masing-masing baris
        foreach ($hasils as $h) {
            $evaluasiIds = DB::table('evaluasi')->where('dosen_mk_id', $h->dosen_mk_id)->pluck('id');
            $h->respon = $evaluasiIds->count();

            if ($h->respon > 0) {
                // Hitung rata-rata nilai dari detail_evaluasi
                $avg = DB::table('detail_evaluasi')->whereIn('evaluasi_id', $evaluasiIds)->avg('nilai');
                $h->rata_rata = number_format($avg, 1);
            } else {
                $h->rata_rata = null;
            }
        }

        return view('admin.hasil.index', compact('hasils'));
    }

    public function show($dosen_mk_id)
    {
        // 1. Ambil Info Dosen & MK
        $info = DB::table('dosen_mata_kuliah')
            ->join('dosen', 'dosen_mata_kuliah.dosen_id', '=', 'dosen.id')
            ->join('mata_kuliah', 'dosen_mata_kuliah.mk_id', '=', 'mata_kuliah.id')
            ->where('dosen_mata_kuliah.id', $dosen_mk_id)
            ->select('dosen.nama_lengkap', 'mata_kuliah.kode_mk', 'mata_kuliah.nama_mk')
            ->first();

        if (!$info) abort(404);

        $evaluasiIds = DB::table('evaluasi')->where('dosen_mk_id', $dosen_mk_id)->pluck('id');

        // Jika belum ada yang mengisi, kembalikan ke index
        if ($evaluasiIds->isEmpty()) {
            return redirect()->route('admin.hasil.index')->with('error', 'Belum ada data evaluasi untuk kelas ini.');
        }

        // 2. Hitung Rata-rata Per Kategori
        $kategoriScores = DB::table('detail_evaluasi')
            ->join('pertanyaan', 'detail_evaluasi.pertanyaan_id', '=', 'pertanyaan.id')
            ->join('kategori_pertanyaan', 'pertanyaan.kategori_id', '=', 'kategori_pertanyaan.id')
            ->whereIn('detail_evaluasi.evaluasi_id', $evaluasiIds)
            ->select('kategori_pertanyaan.nama_kategori', DB::raw('AVG(detail_evaluasi.nilai) as rata_rata'))
            ->groupBy('kategori_pertanyaan.id', 'kategori_pertanyaan.nama_kategori')
            ->get();

        // 3. Hitung Rata-rata Per Pertanyaan
        $pertanyaanScores = DB::table('detail_evaluasi')
            ->join('pertanyaan', 'detail_evaluasi.pertanyaan_id', '=', 'pertanyaan.id')
            ->whereIn('detail_evaluasi.evaluasi_id', $evaluasiIds)
            ->select('pertanyaan.teks_pertanyaan', DB::raw('AVG(detail_evaluasi.nilai) as rata_rata'))
            ->groupBy('pertanyaan.id', 'pertanyaan.teks_pertanyaan')
            ->get();

        // 4. Ambil Saran dan Komentar (Ditampilkan sebagai Anonymous untuk menjaga kerahasiaan)
        $komentars = DB::table('evaluasi')
            ->where('dosen_mk_id', $dosen_mk_id)
            ->whereNotNull('saran_komentar')
            ->where('saran_komentar', '!=', '')
            ->select('saran_komentar', 'tanggal_isi')
            ->orderBy('tanggal_isi', 'desc')
            ->get();

        return view('admin.hasil.show', compact('info', 'kategoriScores', 'pertanyaanScores', 'komentars'));
    }
}