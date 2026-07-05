<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class MahasiswaController extends Controller
{
    public function index()
    {
        $userId = Auth::id(); // Mengambil ID mahasiswa yang sedang login

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

        // Mengecek status apakah mahasiswa ini sudah mengisi evaluasi untuk tiap matkul
        $evaluasiSelesai = 0;
        foreach ($jadwals as $jadwal) {
            $isEvaluated = DB::table('evaluasi')
                ->where('dosen_mk_id', $jadwal->dosen_mk_id)
                ->where('user_id', $userId)
                ->exists();
            
            $jadwal->status = $isEvaluated ? 'Selesai' : 'Belum Diisi';
            if ($isEvaluated) {
                $evaluasiSelesai++;
            }
        }

        $totalEvaluasi = count($jadwals);
        $evaluasiBelum = $totalEvaluasi - $evaluasiSelesai;

        // Mengirimkan variabel $jadwals, $evaluasiSelesai, dan $evaluasiBelum ke view
        return view('mahasiswa.dashboard', compact('jadwals', 'evaluasiSelesai', 'evaluasiBelum'));
    }

    public function panduan()
    {
        return view('mahasiswa.panduan');
    }
}
