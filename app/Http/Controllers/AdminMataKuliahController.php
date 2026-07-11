<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminMataKuliahController extends Controller
{
    public function index()
    {
        $mataKuliah = DB::table('mata_kuliah')
            ->leftJoin('prodi', 'mata_kuliah.prodi_id', '=', 'prodi.id')
            ->select('mata_kuliah.*', 'prodi.nama_prodi')
            ->get();

        return view('admin.mata_kuliah.index', compact('mataKuliah'));
    }

    public function create()
    {
        $prodi = DB::table('prodi')->get();
        return view('admin.mata_kuliah.create', compact('prodi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_mk'  => 'required',
            'nama_mk'  => 'required',
            'prodi_id' => 'required',
            'semester' => 'required|integer',
        ]);

        DB::table('mata_kuliah')->insert([
            'kode_mk'  => $request->kode_mk,
            'nama_mk'  => $request->nama_mk,
            'prodi_id' => $request->prodi_id,
            'semester' => $request->semester,
        ]);

        return redirect()->route('admin.mata_kuliah.index')->with('success', 'Data Mata Kuliah berhasil ditambahkan.');
    }

    public function edit($id)
    {
    
        $mataKuliah = DB::table('mata_kuliah')->where('id', $id)->first();
        
        if (!$mataKuliah) {
            abort(404);
        }

        $prodis = DB::table('prodi')->get();

        return view('admin.mata_kuliah.edit', compact('mataKuliah', 'prodis'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'kode_mk'  => 'required',
            'nama_mk'  => 'required',
            'prodi_id' => 'required',
            'semester' => 'required|integer',
        ]);

        DB::table('mata_kuliah')->where('id', $id)->update([
            'kode_mk'  => $request->kode_mk,
            'nama_mk'  => $request->nama_mk,
            'prodi_id' => $request->prodi_id,
            'semester' => $request->semester,
        ]);

        return redirect()->route('admin.mata_kuliah.index')->with('success', 'Data Mata Kuliah berhasil diubah.');
    }

    public function destroy($id)
    {
        DB::table('mata_kuliah')->where('id', $id)->delete();
        return redirect()->route('admin.mata_kuliah.index')->with('success', 'Data Mata Kuliah berhasil dihapus.');
    }
}