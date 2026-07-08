@extends('layouts.dosen')

@section('content')
<div class="max-w-5xl mx-auto min-h-screen">
    
    <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6 mb-6">
        <h2 class="text-2xl font-bold text-black mb-2">Selamat Datang, {{ Auth::user()->name }}</h2>
        <p class="text-gray-600 text-sm mb-4">Evaluasi Dosen untuk semester ini</p>
        
        <div class="inline-block">
            <select class="border border-[#004684] text-sm rounded px-3 py-2 text-[#004684] font-medium focus:outline-none bg-white">
                <option>Semester : 2025/2026 Ganjil</option>
            </select>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-5 flex flex-col justify-center">
            <div class="flex items-center gap-3 mb-2">
                <div class="p-2 bg-blue-50 rounded text-[#004684]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
                <h3 class="font-bold text-black text-sm">Jumlah Mata Kuliah</h3>
            </div>
            <p class="text-3xl font-bold text-[#004684] mb-1">{{ $jumlahMk > 0 ? $jumlahMk : '-' }}</p>
            <p class="text-xs text-gray-500">Mata Kuliah Semester Ini</p>
        </div>

        <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-5 flex flex-col justify-center">
            <div class="flex items-center gap-3 mb-2">
                <div class="p-2 bg-yellow-50 rounded text-yellow-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <h3 class="font-bold text-black text-sm">Respon Mahasiswa</h3>
            </div>
            <p class="text-3xl font-bold text-yellow-600 mb-1">{{ $responMahasiswa > 0 ? $responMahasiswa : '-' }}</p>
            <p class="text-xs text-gray-500">Mahasiswa yang memberikan Evaluasi</p>
        </div>

        <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-5 flex flex-col justify-center">
            <div class="flex items-center gap-3 mb-2">
                <div class="p-2 bg-green-50 rounded text-green-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                    </svg>
                </div>
                <h3 class="font-bold text-black text-sm">Rata-rata Nilai Evaluasi</h3>
            </div>
            <p class="text-3xl font-bold text-green-600 mb-1">{{ $rataRata }}</p>
            <p class="text-xs text-gray-500">Dari Skala 1-4</p>
        </div>
    </div>

    <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6 mb-6">
        <h3 class="text-xl font-bold text-black mb-4">Ringkasan Evaluasi Semester Ini</h3>
        <ul class="list-disc list-inside space-y-3 text-sm text-black">
            <li>
                <strong>Mata Kuliah Terbaik :</strong> 
                {{ $mkTerbaik ? $mkTerbaik->nama_mk . ' dengan nilai rata-rata ' . number_format($mkTerbaik->avg_nilai, 1) : '(-)' }}
            </li>
            <li>
                <strong>Aspek terbaik :</strong> 
                {{ $aspekTerbaik ? $aspekTerbaik : '(-)' }}
            </li>
            <li>
                <strong>Aspek yang perlu diperbaiki :</strong> 
                {{ $aspekPerbaikan ? $aspekPerbaikan : '(-)' }}
            </li>
        </ul>
    </div>

    <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-bold text-black">Saran dan komentar terbaru dari Mahasiswa</h3>
            <a href="#" class="text-sm font-bold text-[#004684] hover:underline">Lihat Lainnya</a>
        </div>

        <div class="space-y-4">
            @forelse($komentars as $komentar)
            <div class="border border-gray-200 rounded-md p-5 bg-white shadow-sm">
                <div class="flex justify-between items-start mb-2">
                    <div>
                        <h4 class="font-bold text-[#004684] text-sm">Anonymous</h4>
                        <p class="text-xs text-gray-500">{{ $komentar->kode_mk }} - {{ $komentar->nama_mk }}</p>
                    </div>
                    <span class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($komentar->tanggal_isi)->translatedFormat('d M, Y') }}</span>
                </div>
                <p class="text-sm text-gray-800 leading-relaxed mt-3">
                    {{ $komentar->saran_komentar }}
                </p>
            </div>
            @empty
            <div class="border border-gray-200 rounded-md p-5 text-center text-gray-500 text-sm">
                Belum ada saran atau komentar dari mahasiswa.
            </div>
            @endforelse
        </div>
    </div>

</div>
@endsection