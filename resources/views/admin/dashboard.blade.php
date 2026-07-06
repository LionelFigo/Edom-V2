@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto p-4 min-h-screen bg-[#F8FAFC]">
    
    <!-- Header Card -->
    <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6 mb-6">
        <h2 class="text-2xl font-bold text-black mb-2">Dashboard Admin</h2>
        <p class="text-gray-600 text-sm mb-4">Evaluasi Dosen untuk semester ini</p>
        
        <div class="inline-block">
            <select class="border border-[#004684] text-sm rounded px-4 py-2 text-[#004684] font-medium focus:outline-none bg-white">
                <option>Semester : 2025/2026 Ganjil</option>
                <option>Semester : 2024/2025 Genap</option>
            </select>
        </div>
    </div>

    <!-- Statistik Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <!-- Card Total Dosen -->
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6 flex items-start gap-4">
            <div class="p-3 bg-blue-50 rounded-lg text-[#004684]">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </div>
            <div>
                <h3 class="font-bold text-black text-sm">Total Dosen</h3>
                <p class="text-3xl font-bold text-[#004684] mt-1">{{ $totalDosen }}</p>
                <p class="text-xs text-gray-500 mt-1">Total dosen yang dievaluasi</p>
            </div>
        </div>

        <!-- Card Evaluasi Masuk -->
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6 flex items-start gap-4">
            <div class="p-3 bg-blue-50 rounded-lg text-[#004684]">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
            <div>
                <h3 class="font-bold text-black text-sm">Evaluasi Masuk</h3>
                <p class="text-3xl font-bold text-[#004684] mt-1">{{ $evaluasiMasuk }}</p>
                <p class="text-xs text-gray-500 mt-1">Total evaluasi yang masuk</p>
            </div>
        </div>

        <!-- Card Rata-rata Nilai -->
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6 flex items-start gap-4">
            <div class="p-3 bg-blue-50 rounded-lg text-[#004684]">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                </svg>
            </div>
            <div>
                <h3 class="font-bold text-black text-sm">Rata-rata Nilai Evaluasi</h3>
                <p class="text-3xl font-bold text-[#004684] mt-1">{{ $rataRataTotal }}</p>
                <p class="text-xs text-gray-500 mt-1">Dari Skala 1-4</p>
            </div>
        </div>
    </div>

    <!-- Grid Layout Kiri & Kanan -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <!-- Peringkat Dosen -->
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-bold text-black mb-6">Dosen dengan Rata-rata Tertinggi</h3>
            <div class="space-y-6">
                @foreach($topDosen as $index => $dosen)
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="w-8 h-8 rounded-full bg-[#004684] text-white flex items-center justify-center font-bold text-sm">
                            {{ $index + 1 }}
                        </div>
                        <div>
                            <p class="text-sm font-medium text-black">{{ $dosen->nama_lengkap }}</p>
                            <p class="text-xs text-gray-500">{{ $dosen->total_evaluasi }} Evaluasi</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-1">
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                        <span class="font-bold text-black">{{ number_format((float)$dosen->rata_rata, 1) }}</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Evaluasi Terbaru -->
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-bold text-black mb-6">Evaluasi Terbaru</h3>
            <div class="space-y-6">
                @forelse($evaluasiTerbaru as $evaluasi)
                <div>
                    <p class="text-sm font-medium text-black">{{ $evaluasi->nama_lengkap }}</p>
                    <p class="text-xs text-gray-500">{{ $evaluasi->nama_mk }}</p>
                </div>
                @empty
                <div>
                    <p class="text-sm font-medium text-black">(-)</p>
                    <p class="text-xs text-gray-500">Belum ada evaluasi</p>
                </div>
                @endforelse
            </div>
        </div>

    </div>
</div>
@endsection