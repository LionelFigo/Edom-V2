<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DosenController extends Controller
{
    public function index()
    {
        $dosen = DB::table('dosen')->where('user_id', Auth::id())->first();

        if (!$dosen) {
            return view('dosen.dashboard', [
                'dosen' => (object)['nama_lengkap' => Auth::user()->name],
                'jumlahMk' => 0,
                'responMahasiswa' => 0,
                'rataRata' => '-',
                'mkTerbaik' => null,
                'aspekTerbaik' => null,
                'aspekPerbaikan' => null,
                'komentars' => []
            ]);
        }

        $dosenMkIds = DB::table('dosen_mata_kuliah')
            ->where('dosen_id', $dosen->id)
            ->pluck('id');

        $jumlahMk = $dosenMkIds->count();

        $evaluasiIds = DB::table('evaluasi')
            ->whereIn('dosen_mk_id', $dosenMkIds)
            ->pluck('id');

        $responMahasiswa = $evaluasiIds->count();

        $rataRata = '-';
        $mkTerbaik = null;
        $aspekTerbaik = null;
        $aspekPerbaikan = null;
        $komentars = [];

        if ($responMahasiswa > 0) {
            $avg = DB::table('detail_evaluasi')->whereIn('evaluasi_id', $evaluasiIds)->avg('nilai');
            $rataRata = number_format($avg, 1);

            $mkTerbaik = DB::table('detail_evaluasi')
                ->join('evaluasi', 'detail_evaluasi.evaluasi_id', '=', 'evaluasi.id')
                ->join('dosen_mata_kuliah', 'evaluasi.dosen_mk_id', '=', 'dosen_mata_kuliah.id')
                ->join('mata_kuliah', 'dosen_mata_kuliah.mk_id', '=', 'mata_kuliah.id')
                ->whereIn('evaluasi.id', $evaluasiIds)
                ->select('mata_kuliah.nama_mk', DB::raw('AVG(detail_evaluasi.nilai) as avg_nilai'))
                ->groupBy('mata_kuliah.id', 'mata_kuliah.nama_mk')
                ->orderBy('avg_nilai', 'desc')
                ->first();

            $aspekScores = DB::table('detail_evaluasi')
                ->join('pertanyaan', 'detail_evaluasi.pertanyaan_id', '=', 'pertanyaan.id')
                ->join('kategori_pertanyaan', 'pertanyaan.kategori_id', '=', 'kategori_pertanyaan.id')
                ->whereIn('detail_evaluasi.evaluasi_id', $evaluasiIds)
                ->select('kategori_pertanyaan.nama_kategori', DB::raw('AVG(detail_evaluasi.nilai) as avg_nilai'))
                ->groupBy('kategori_pertanyaan.id', 'kategori_pertanyaan.nama_kategori')
                ->orderBy('avg_nilai', 'desc')
                ->get();

            if ($aspekScores->isNotEmpty()) {
                $aspekTerbaik = $aspekScores->first()->nama_kategori;
                $aspekPerbaikan = $aspekScores->last()->nama_kategori;
            }

            $komentars = DB::table('evaluasi')
                ->join('dosen_mata_kuliah', 'evaluasi.dosen_mk_id', '=', 'dosen_mata_kuliah.id')
                ->join('mata_kuliah', 'dosen_mata_kuliah.mk_id', '=', 'mata_kuliah.id')
                ->whereIn('evaluasi.id', $evaluasiIds)
                ->whereNotNull('evaluasi.saran_komentar')
                ->where('evaluasi.saran_komentar', '!=', '')
                ->select('evaluasi.saran_komentar', 'evaluasi.tanggal_isi', 'mata_kuliah.kode_mk', 'mata_kuliah.nama_mk')
                ->orderBy('evaluasi.tanggal_isi', 'desc')
                ->limit(3)
                ->get();
        }

        return view('dosen.dashboard', compact(
            'dosen', 'jumlahMk', 'responMahasiswa', 'rataRata', 
            'mkTerbaik', 'aspekTerbaik', 'aspekPerbaikan', 'komentars'
        ));
    }
}