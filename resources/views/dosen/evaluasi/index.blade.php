@extends('layouts.dosen')

@section('content')
<div class="max-w-7xl mx-auto min-h-screen">
    
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-black tracking-wide">Evaluasi Anda</h1>
        <p class="text-gray-600 mt-1">Lihat Mata Kuliah yang dievaluasi</p>
    </div>

    <div class="bg-white border border-gray-300 rounded-sm overflow-hidden mb-8">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-[#004684] text-white">
                    <th class="py-3 px-4 font-semibold text-sm w-48">Kode Mata Kuliah</th>
                    <th class="py-3 px-4 font-semibold text-sm">Nama Mata Kuliah</th>
                    <th class="py-3 px-4 font-semibold text-sm text-center w-32">Semester</th>
                    <th class="py-3 px-4 font-semibold text-sm text-center w-32">Nilai</th>
                    <th class="py-3 px-4 font-semibold text-sm text-center w-32">Detail</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($mataKuliahs as $mk)
                <tr class="border-b border-gray-200 hover:bg-gray-50">
                    <td class="py-3 px-4 text-sm text-black">{{ $mk->kode_mk }}</td>
                    <td class="py-3 px-4 text-sm text-black">{{ $mk->nama_mk }}</td>
                    <td class="py-3 px-4 text-sm text-center text-black">{{ $mk->semester }}</td>
                    
                    @if($mk->rata_rata)
                        @php
                            $colorClass = 'text-black';
                            if($mk->rata_rata >= 3.5) $colorClass = 'text-green-600';
                            elseif($mk->rata_rata >= 3.0) $colorClass = 'text-orange-500';
                            elseif($mk->rata_rata >= 2.0) $colorClass = 'text-red-500';
                            else $colorClass = 'text-red-700';
                        @endphp
                        
                        <td class="py-3 px-4 text-sm text-center font-bold {{ $colorClass }}">
                            {{ $mk->rata_rata }}/4.0
                        </td>
                        <td class="py-3 px-4 text-center">
                            <a href="{{ route('dosen.evaluasi.show', $mk->dosen_mk_id) }}" class="text-blue-500 hover:underline text-sm">Detail</a>
                        </td>
                    @else
                        <td class="py-3 px-4 text-sm text-center text-black font-bold">-</td>
                        <td class="py-3 px-4 text-center">
                            <a href="{{ route('dosen.evaluasi.show', $mk->dosen_mk_id) }}" class="text-blue-500 hover:underline text-sm">Detail</a>
                        </td>
                    @endif
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-4 px-4 text-center text-black font-medium">Tidak ada mata kuliah yang diampu.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="bg-white border border-gray-200 rounded-md p-5 inline-block min-w-[300px] shadow-sm">
        <h3 class="font-bold text-black mb-3">Keterangan Nilai Evaluasi</h3>
        <table class="text-sm text-black w-full">
            <tr><td class="py-1">Sangat baik</td><td class="py-1 px-4">: 3.5 - 4.0</td></tr>
            <tr><td class="py-1">Baik</td><td class="py-1 px-4">: 3.0 - 3.4</td></tr>
            <tr><td class="py-1">Cukup</td><td class="py-1 px-4">: 2.0 - 2.9</td></tr>
            <tr><td class="py-1">Perlu Evaluasi</td><td class="py-1 px-4">: 0 - 1.9</td></tr>
        </table>
    </div>

</div>
@endsection