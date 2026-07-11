<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DosenSaranController extends Controller
{
    public function index(Request $request)
    {
        $dosen = DB::table('dosen')->where('user_id', Auth::id())->first();
        if (!$dosen) abort(403, 'Profil dosen tidak ditemukan.');

        $dosenMkIds = DB::table('dosen_mata_kuliah')
            ->where('dosen_id', $dosen->id)
            ->pluck('id');

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

        if ($request->has('search') && $request->search != '') {
            $keyword = $request->search;
            $query->where(function($q) use ($keyword) {
                $q->where('mata_kuliah.nama_mk', 'like', '%' . $keyword . '%')
                  ->orWhere('mata_kuliah.kode_mk', 'like', '%' . $keyword . '%');
            });
        }

        $komentars = $query->orderBy('evaluasi.tanggal_isi', 'desc')->get();
        $totalRespon = $komentars->count();

        return view('dosen.saran.index', compact('komentars', 'totalRespon'));
    }
}