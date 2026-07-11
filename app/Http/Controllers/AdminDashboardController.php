<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalDosen = DB::table('dosen')->count();
        $evaluasiMasuk = DB::table('evaluasi')->count();
        
        $rataRataTotal = DB::table('detail_evaluasi')->avg('nilai');
        $rataRataTotal = $rataRataTotal ? number_format($rataRataTotal, 1) : '0.0';

        if ($evaluasiMasuk > 0) {
            $topDosen = DB::table('dosen')
                ->join('dosen_mata_kuliah', 'dosen.id', '=', 'dosen_mata_kuliah.dosen_id')
                ->join('evaluasi', 'dosen_mata_kuliah.id', '=', 'evaluasi.dosen_mk_id')
                ->join('detail_evaluasi', 'evaluasi.id', '=', 'detail_evaluasi.evaluasi_id')
                ->select(
                    'dosen.nama_lengkap',
                    DB::raw('COUNT(DISTINCT evaluasi.id) as total_evaluasi'),
                    DB::raw('AVG(detail_evaluasi.nilai) as rata_rata')
                )
                ->groupBy('dosen.id', 'dosen.nama_lengkap')
                ->orderBy('rata_rata', 'desc')
                ->limit(5)
                ->get();
        } else {
            $topDosen = DB::table('dosen')
                ->select('nama_lengkap')
                ->limit(5)
                ->get()
                ->map(function ($item) {
                    $item->total_evaluasi = 0;
                    $item->rata_rata = '0.0';
                    return $item;
                });
        }

        $evaluasiTerbaru = DB::table('evaluasi')
            ->join('dosen_mata_kuliah', 'evaluasi.dosen_mk_id', '=', 'dosen_mata_kuliah.id')
            ->join('dosen', 'dosen_mata_kuliah.dosen_id', '=', 'dosen.id')
            ->join('mata_kuliah', 'dosen_mata_kuliah.mk_id', '=', 'mata_kuliah.id')
            ->select('dosen.nama_lengkap', 'mata_kuliah.nama_mk')
            ->orderBy('evaluasi.tanggal_isi', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('totalDosen', 'evaluasiMasuk', 'rataRataTotal', 'topDosen', 'evaluasiTerbaru'));
    }
}