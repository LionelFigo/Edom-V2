@extends('layouts.dosen')

@section('content')
<div class="max-w-7xl mx-auto min-h-screen">
    
    <a href="{{ route('dosen.evaluasi.index') }}" class="inline-flex items-center gap-2 text-blue-500 hover:text-blue-700 font-medium mb-6">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Kembali ke Hasil Evaluasi
    </a>

    <div class="bg-white border border-gray-200 rounded-lg p-6 mb-8 shadow-sm">
        <h3 class="text-[#004684] font-bold text-lg mb-6">Informasi Mata Kuliah</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-y-6">
            <div>
                <p class="text-xs text-black font-medium mb-1">Mata Kuliah</p>
                <p class="text-sm font-bold text-black">{{ $jadwal->nama_mk }}</p>
            </div>
            <div>
                <p class="text-xs text-black font-medium mb-1">Total Respon Mahasiswa</p>
                <p class="text-sm font-bold text-black">{{ $totalRespon }} Mahasiswa</p>
            </div>
            <div>
                <p class="text-xs text-black font-medium mb-1">Semester</p>
                <p class="text-sm font-bold text-black">{{ $jadwal->semester }}</p>
            </div>
            <div>
                <p class="text-xs text-black font-medium mb-1">Nilai Rata-rata Evaluasi</p>
                <p class="text-sm font-bold {{ $totalRespon > 0 ? 'text-green-600' : 'text-black' }}">
                    {{ $rataRataKeseluruhan }}
                </p>
            </div>
        </div>
    </div>

    <div class="bg-white border border-gray-200 rounded-lg p-6 mb-8 shadow-sm">
        <h3 class="text-[#004684] font-bold text-lg mb-6">Ringkasan Nilai Per Kategori</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach($kategoriScores as $kScore)
            <div class="border border-gray-200 rounded p-4 flex flex-col justify-between">
                <p class="text-sm text-black font-bold mb-3">{{ $kScore->nama_kategori }}</p>
                <p class="text-sm font-bold {{ $kScore->rata_rata ? 'text-green-600' : 'text-black' }}">
                    {{ $kScore->rata_rata ? number_format($kScore->rata_rata, 1) . '/4.0' : '-' }}
                </p>
            </div>
            @endforeach
        </div>
    </div>

    <div class="bg-white border border-gray-200 rounded-lg mb-8 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-gray-200">
            <h3 class="text-[#004684] font-bold text-lg">Penilaian Tiap Pertanyaan</h3>
        </div>
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-white border-b border-gray-200">
                    <th class="py-4 px-6 font-bold text-sm text-black w-16">No</th>
                    <th class="py-4 px-6 font-bold text-sm text-black">Pertanyaan Evaluasi</th>
                    <th class="py-4 px-6 font-bold text-sm text-black text-right w-40">Nilai Rata-rata</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($pertanyaanScores as $index => $pScore)
                <tr class="hover:bg-gray-50">
                    <td class="py-4 px-6 text-sm text-black font-bold">{{ $index + 1 }}.</td>
                    <td class="py-4 px-6 text-sm text-black">{{ $pScore->teks_pertanyaan }}</td>
                    <td class="py-4 px-6 text-sm font-bold text-right {{ $pScore->rata_rata ? 'text-green-600' : 'text-black' }}">
                        {{ $pScore->rata_rata ? number_format($pScore->rata_rata, 1) . '/4.0' : '-' }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
@endsection