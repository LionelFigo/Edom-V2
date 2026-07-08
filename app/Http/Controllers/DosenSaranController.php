<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DosenSaranController extends Controller
{
    // Tambahkan Request $request pada parameter method
    public function index(Request $request)
    {
        // 1. Ambil data dosen yang sedang login
        $dosen = DB::table('dosen')->where('user_id', Auth::id())->first();
        if (!$dosen) abort(403, 'Profil dosen tidak ditemukan.');

        // 2. Cari ID relasi mata kuliah yang diajar dosen ini
        $dosenMkIds = DB::table('dosen_mata_kuliah')
            ->where('dosen_id', $dosen->id)
            ->pluck('id');

        // 3. Buat kueri dasar untuk mengambil data evaluasi
        $query = DB::table('evaluasi')
            ->join('dosen_mata_kuliah', 'evaluasi.dosen_mk_id', '=', 'dosen_mata_kuliah.id')
            ->join('mata_kuliah', 'dosen_mata_kuliah.mk_id', '=', 'mata_kuliah.id')
            ->whereIn('evaluasi.dosen_mk_id', $dosenMkIds)
            ->whereNotNull('evaluasi.saran_komentar')
            ->where('evaluasi.saran_komentar', '!=', '') 
            ->select(
                'evaluasi.saran_komentar',
                'evaluasi.tanggal_isi',
                'mata_kuliah.kode_mk',
                'mata_kuliah.nama_mk'
            );

        // 4. Logika Pencarian Backend (Tanpa JavaScript)
        if ($request->has('search') && $request->search != '') {
            $keyword = $request->search;
            // Cari berdasarkan Nama Mata Kuliah ATAU Kode Mata Kuliah
            $query->where(function($q) use ($keyword) {
                $q->where('mata_kuliah.nama_mk', 'like', '%' . $keyword . '%')
                  ->orWhere('mata_kuliah.kode_mk', 'like', '%' . $keyword . '%');
            });
        }

        // 5. Eksekusi Kueri
        $komentars = $query->orderBy('evaluasi.tanggal_isi', 'desc')->get();
        $totalRespon = $komentars->count();

        return view('dosen.saran.index', compact('komentars', 'totalRespon'));
    }
}