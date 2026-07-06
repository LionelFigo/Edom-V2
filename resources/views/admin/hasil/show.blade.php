@extends('layouts.admin')

@section('content')
<div class="p-8 bg-gray-50 min-h-screen">
    <div class="flex items-center gap-4 mb-8">
        <a href="{{ route('hasil.index') }}" class="bg-[#004684] hover:bg-[#003366] text-white p-1.5 rounded transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-black tracking-wide">Hasil Evaluasi</h1>
            <p class="text-gray-600 mt-1">Lihat hasil evaluasi dosen dari mahasiswa</p>
        </div>
    </div>

    <!-- Ringkasan Kategori -->
    <div class="bg-white border border-gray-200 rounded-lg p-6 mb-8 shadow-sm">
        <h3 class="text-[#004684] font-bold mb-4">Ringkasan Nilai Per Kategori</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach($kategoriScores as $kScore)
            <div class="border border-gray-200 rounded p-4">
                <p class="text-sm text-black font-semibold mb-2">{{ $kScore->nama_kategori }}</p>
                <p class="text-lg font-bold text-green-600">{{ number_format($kScore->rata_rata, 1) }}/4.0</p>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Tabel Penilaian Tiap Pertanyaan -->
    <div class="bg-white border border-gray-200 rounded-lg mb-8 shadow-sm overflow-hidden">
        <div class="p-4 border-b border-gray-200">
            <h3 class="text-[#004684] font-bold">Penilaian Tiap Pertanyaan</h3>
        </div>
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-white border-b border-gray-200">
                    <th class="py-3 px-6 font-bold text-sm text-black w-16">No</th>
                    <th class="py-3 px-6 font-bold text-sm text-black">Pertanyaan Evaluasi</th>
                    <th class="py-3 px-6 font-bold text-sm text-black text-right w-32">Nilai Rata-rata</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($pertanyaanScores as $index => $pScore)
                <tr class="hover:bg-gray-50">
                    <td class="py-4 px-6 text-sm text-black font-bold">{{ $index + 1 }}.</td>
                    <td class="py-4 px-6 text-sm text-black">{{ $pScore->teks_pertanyaan }}</td>
                    <td class="py-4 px-6 text-sm font-bold text-green-600 text-right">{{ number_format($pScore->rata_rata, 1) }}/4.0</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Saran dan Komentar Mahasiswa -->
    <div class="mb-8">
        <h2 class="text-xl font-bold text-black mb-4">Saran dan Komentar Mahasiswa</h2>
        
        <div class="space-y-4">
            @forelse($komentars as $komentar)
            <div class="bg-white border border-gray-200 rounded-lg p-5 shadow-sm">
                <div class="flex justify-between items-start mb-2">
                    <div>
                        <!-- Ditampilkan Anonymous untuk menjaga kerahasiaan -->
                        <h4 class="font-bold text-[#004684]">Anonymous</h4>
                        <p class="text-xs text-gray-500">{{ $info->kode_mk }} - {{ $info->nama_mk }}</p>
                    </div>
                    <span class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($komentar->tanggal_isi)->translatedFormat('d M, Y') }}</span>
                </div>
                <p class="text-sm text-black mt-3 leading-relaxed">
                    {{ $komentar->saran_komentar }}
                </p>
            </div>
            @empty
            <div class="bg-white border border-gray-200 rounded-lg p-5 shadow-sm text-center">
                <p class="text-sm text-gray-500">Belum ada saran atau komentar.</p>
            </div>
            @endforelse
        </div>
    </div>

</div>
@endsection