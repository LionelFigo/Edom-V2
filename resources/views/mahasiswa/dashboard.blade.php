@extends('layouts.mahasiswa')

@section('content')
<div class="max-w-7xl mx-auto p-6 min-h-screen">
    
    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-md">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-md">{{ session('error') }}</div>
    @endif

    <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-5 mb-6 flex justify-between items-center">
        <div>
            <h2 class="text-xl font-bold text-black">Periode Pengisian EDOM Semester Ganjil 2025/2026</h2>
            <p class="text-gray-600 text-sm mt-1">Periode : 01 Januari - 28 Februari</p>
        </div>
    </div>

    <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
        <div class="p-4 border-b border-gray-200 flex items-center gap-2">
            <h3 class="font-bold text-black">Daftar Mata Kuliah</h3>
        </div>
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-[#004684] text-white">
                    <th class="py-3 px-4 font-semibold text-sm">Kode MK</th>
                    <th class="py-3 px-4 font-semibold text-sm">Nama Mata Kuliah</th>
                    <th class="py-3 px-4 font-semibold text-sm">Dosen Pengajar</th>
                    <th class="py-3 px-4 font-semibold text-sm text-center">Status</th>
                    <th class="py-3 px-4 font-semibold text-sm text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($jadwals as $jadwal)
                <tr class="hover:bg-gray-50">
                    <td class="py-3 px-4 text-sm text-black">{{ $jadwal->kode_mk }}</td>
                    <td class="py-3 px-4 text-sm text-black">{{ $jadwal->nama_mk }}</td>
                    <td class="py-3 px-4 text-sm text-black">{{ $jadwal->nama_lengkap }}</td>
                    <td class="py-3 px-4 text-center">
                        @if($jadwal->status == 'Selesai')
                            <span class="inline-flex items-center gap-1 px-3 py-1 bg-green-100 text-green-700 text-xs font-semibold rounded-md border border-green-300"> Selesai</span>
                        @else
                            <span class="inline-flex items-center gap-1 px-3 py-1 bg-yellow-100 text-yellow-700 text-xs font-semibold rounded-md border border-yellow-300"> Belum Diisi</span>
                        @endif
                    </td>
                    <td class="py-3 px-4 text-center">
                        @if($jadwal->status == 'Selesai')
                            <button disabled class="px-4 py-1.5 bg-blue-300 text-white text-sm font-medium rounded shadow-sm cursor-not-allowed"> Mulai</button>
                        @else
                            <a href="{{ route('mahasiswa.evaluasi.show', $jadwal->dosen_mk_id) }}" class="px-4 py-1.5 bg-[#007BFF] hover:bg-blue-600 text-white text-sm font-medium rounded shadow-sm transition"> Mulai</a>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="py-4 text-center">Tidak ada jadwal evaluasi.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6 flex gap-4">
        <span class="px-4 py-2 bg-green-100 text-green-700 font-semibold text-sm rounded-md border border-green-300"> {{ $evaluasiSelesai }} Evaluasi Selesai</span>
        <span class="px-4 py-2 bg-yellow-100 text-yellow-700 font-semibold text-sm rounded-md border border-yellow-300"> {{ $evaluasiBelum }} Evaluasi Belum Diisi</span>
    </div>
</div>
@endsection