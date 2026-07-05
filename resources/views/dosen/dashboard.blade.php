@extends('layouts.dosen')

@section('content')
<div class="max-w-7xl mx-auto">
    
    <!-- Card Ucapan Selamat Datang -->
    <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6 mb-6">
        <h2 class="text-2xl font-bold text-black mb-2">Selamat Datang, {{ Auth::user()->name ?? 'Evelyn Isabella' }}</h2>
        <p class="text-gray-600 text-sm mb-4">
            Selamat datang di Dashboard Evaluasi Dosen Oleh Mahasiswa (EDOM). Melalui halaman ini, Anda dapat memantau ringkasan nilai evaluasi, tingkat partisipasi, serta umpan balik dari mahasiswa.
        </p>
        
        <!-- Filter Semester (Opsional, sesuai gambar mockup Anda) -->
        <div class="inline-block">
            <select class="border border-gray-300 text-sm rounded px-3 py-1.5 text-[#004684] focus:outline-none focus:border-[#004684]">
                <option>Semester : 2025/2026 Ganjil</option>
                <option>Semester : 2024/2025 Genap</option>
            </select>
        </div>
    </div>

    <!-- Tempat untuk statistik box di bawahnya (Jumlah MK, Respon, Rata-rata) -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Box statistik akan diletakkan di sini -->
    </div>

</div>
@endsection