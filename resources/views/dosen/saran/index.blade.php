@extends('layouts.dosen')

@section('content')
<div class="max-w-7xl mx-auto min-h-screen">
    
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-black tracking-wide">Saran dan Komentar Mahasiswa</h1>
        <p class="text-gray-600 mt-1">Lihat komentar dan saran yang diberikan mahasiswa terhadap proses pembelajaran Anda</p>
    </div>

    <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
        <div class="text-black">
            <span class="font-medium text-sm">Total Respon Mahasiswa :</span>
            <span class="font-bold ml-1">{{ $totalRespon }} Mahasiswa</span>
        </div>
        
        <form action="{{ route('dosen.saran') }}" method="GET" class="relative w-full md:w-96">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Ketik lalu tekan Enter..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-[#004684] focus:ring-1 focus:ring-[#004684] text-sm bg-white shadow-sm">
            
            <button type="submit" class="hidden"></button>
        </form>
    </div>

    <div class="space-y-4">
        @forelse($komentars as $komentar)
        <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
            <div class="flex justify-between items-start mb-3">
                <div>
                    <h3 class="font-bold text-[#004684] text-base">Anonymous</h3>
                    <p class="text-xs text-gray-500 mt-0.5">{{ $komentar->kode_mk }} - {{ $komentar->nama_mk }}</p>
                </div>
                <span class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($komentar->tanggal_isi)->translatedFormat('d M, Y') }}</span>
            </div>
            <p class="text-sm text-black leading-relaxed mt-4">
                {{ $komentar->saran_komentar }}
            </p>
        </div>
        @empty
        <div class="bg-white border border-gray-200 rounded-lg p-10 text-center shadow-sm">
            @if(request('search'))
                <p class="text-gray-500 font-medium">Tidak menemukan komentar untuk mata kuliah "{{ request('search') }}".</p>
                <a href="{{ route('dosen.saran') }}" class="text-blue-500 text-sm hover:underline mt-2 inline-block">Tampilkan Semua</a>
            @else
                <p class="text-gray-500 font-medium">Belum ada saran dan komentar dari mahasiswa.</p>
            @endif
        </div>
        @endforelse
    </div>

</div>
@endsection