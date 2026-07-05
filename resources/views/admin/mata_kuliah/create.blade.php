@extends('layouts.admin')

@section('content')
<div class="p-8 bg-gray-50 min-h-screen">
    <div class="flex items-center gap-4 mb-10">
        <a href="{{ route('admin.mata_kuliah.index') }}" class="bg-[#004684] hover:bg-[#003366] text-white p-1.5 rounded transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </a>
        <h1 class="text-2xl font-bold text-black tracking-wide">Tambah Mata Kuliah</h1>
    </div>

    <form action="{{ route('admin.mata_kuliah.store') }}" method="POST" class="max-w-3xl">
        @csrf
        
        <div class="grid grid-cols-[200px_1fr] items-center gap-4 mb-4">
            <label class="font-medium text-black">Kode Mata Kuliah :</label>
            <input type="text" name="kode_mk" placeholder="Masukkan kode" required class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:border-[#004684]">
        </div>

        <div class="grid grid-cols-[200px_1fr] items-center gap-4 mb-4">
            <label class="font-medium text-black">Nama Mata Kuliah :</label>
            <input type="text" name="nama_mk" placeholder="Masukkan nama mata kuliah" required class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:border-[#004684]">
        </div>

        <div class="grid grid-cols-[200px_1fr] items-center gap-4 mb-4">
            <label class="font-medium text-black">Program Studi :</label>
            <select name="prodi_id" required class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:border-[#004684] bg-white appearance-none">
                <option value="" disabled selected>Pilih Prodi</option>
                @foreach ($prodi as $p)
                    <option value="{{ $p->id }}">{{ $p->nama_prodi }}</option>
                @endforeach
            </select>
        </div>

        <div class="grid grid-cols-[200px_1fr] items-center gap-4 mb-10">
            <label class="font-medium text-black">Semester :</label>
            <select name="semester" required class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:border-[#004684] bg-white appearance-none">
                <option value="" disabled selected>Semester</option>
                @for ($i = 1; $i <= 8; $i++)
                    <option value="{{ $i }}">{{ $i }}</option>
                @endfor
            </select>
        </div>

        <div class="flex gap-4 ml-[216px]">
            <a href="{{ route('mata_kuliah.index') }}" class="px-6 py-2 border border-gray-300 text-black font-medium rounded hover:bg-gray-100 transition">Batal</a>
            <button type="submit" class="px-6 py-2 bg-[#007BFF] hover:bg-blue-600 text-white font-medium rounded transition">Simpan</button>
        </div>
    </form>
</div>
@endsection