<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminPertanyaanController extends Controller
{
    public function index()
    {
        // Join tabel pertanyaan dengan kategori_pertanyaan
        $pertanyaans = DB::table('pertanyaan')
            ->leftJoin('kategori_pertanyaan', 'pertanyaan.kategori_id', '=', 'kategori_pertanyaan.id')
            ->select('pertanyaan.*', 'kategori_pertanyaan.nama_kategori')
            ->orderBy('pertanyaan.id', 'asc') 
            ->get();

        return view('admin.pertanyaan.index', compact('pertanyaans'));
    }

    public function create()
    {
        $kategoris = DB::table('kategori_pertanyaan')->get();
        return view('admin.pertanyaan.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'teks_pertanyaan' => 'required',
            'kategori_id'     => 'required',
        ]);

        DB::table('pertanyaan')->insert([
            'teks_pertanyaan' => $request->teks_pertanyaan,
            'kategori_id'     => $request->kategori_id,
        ]);

        return redirect()->route('admin.pertanyaan.index')->with('success', 'Pertanyaan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $pertanyaan = DB::table('pertanyaan')->where('id', $id)->first();
        $kategoris  = DB::table('kategori_pertanyaan')->get();
        
        if (!$pertanyaan) abort(404);

        return view('admin.pertanyaan.edit', compact('pertanyaan', 'kategoris'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'teks_pertanyaan' => 'required',
            'kategori_id'     => 'required',
        ]);

        DB::table('pertanyaan')->where('id', $id)->update([
            'teks_pertanyaan' => $request->teks_pertanyaan,
            'kategori_id'     => $request->kategori_id,
        ]);

        return redirect()->route('admin.pertanyaan.index')->with('success', 'Pertanyaan berhasil diubah.');
    }

    public function destroy($id)
    {
        DB::table('pertanyaan')->where('id', $id)->delete();
        return redirect()->route('admin.pertanyaan.index')->with('success', 'Pertanyaan berhasil dihapus.');
    }
}