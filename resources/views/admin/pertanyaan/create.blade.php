@extends('layouts.admin')

@section('content')
<div class="p-8 bg-gray-50 min-h-screen">
    <div class="flex items-center gap-4 mb-10">
        <a href="{{ route('admin.pertanyaan.index') }}" class="bg-[#004684] hover:bg-[#003366] text-white p-1.5 rounded transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-black tracking-wide">Tambah Pertanyaan Evaluasi</h1>
            <p class="text-gray-600 text-sm mt-1">Kelola pertanyaan evaluasi dosen</p>
        </div>
    </div>

    <form action="{{ route('admin.pertanyaan.store') }}" method="POST" class="max-w-4xl">
        @csrf

        <div class="grid grid-cols-[200px_1fr] items-start gap-4 mb-4">
            <label class="font-medium text-black mt-2">Isi Pertanyaan :</label>
            <textarea name="teks_pertanyaan" rows="4" placeholder="Masukkan pertanyaan evaluasi" required class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:border-[#004684]"></textarea>
        </div>

        <div class="grid grid-cols-[200px_1fr] items-start gap-4 mb-10">
            <label class="font-medium text-black mt-2">Kategori :</label>
            <select name="kategori_id" required class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:border-[#004684] bg-white appearance-none">
                <option value="" disabled selected>Pilih Kategori</option>
                @foreach ($kategoris as $k)
                    <option value="{{ $k->id }}">{{ $k->nama_kategori }}</option>
                @endforeach
            </select>
        </div>

        <div class="flex gap-4 ml-[216px]">
            <a href="{{ route('admin.pertanyaan.index') }}" class="px-6 py-2 border border-gray-300 text-black font-medium rounded hover:bg-gray-100 transition">Batal</a>
            <button type="submit" class="px-6 py-2 bg-[#007BFF] hover:bg-blue-600 text-white font-medium rounded transition">Simpan</button>
        </div>
    </form>
</div>
@endsection