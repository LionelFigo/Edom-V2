@extends('layouts.admin')

@section('content')
<div class="p-8 bg-gray-50 min-h-screen">
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-black tracking-wide">Hasil Evaluasi</h1>
        <p class="text-gray-600 mt-1">Lihat hasil evaluasi dosen dari mahasiswa</p>
    </div>

    @if(session('error'))
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-md text-sm">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white border border-gray-300">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-[#004684] text-white">
                    <th class="py-3 px-4 font-semibold text-sm">Nama</th>
                    <th class="py-3 px-4 font-semibold text-sm">Mata Kuliah</th>
                    <th class="py-3 px-4 font-semibold text-sm text-center">Semester</th>
                    <th class="py-3 px-4 font-semibold text-sm text-center">Respon</th>
                    <th class="py-3 px-4 font-semibold text-sm text-center">Rata-rata Nilai</th>
                    <th class="py-3 px-4 font-semibold text-sm text-center">Detail</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($hasils as $h)
                <tr class="border-b border-gray-200 hover:bg-gray-50">
                    <td class="py-3 px-4 text-sm text-black">{{ $h->nama_lengkap }}</td>
                    <td class="py-3 px-4 text-sm text-black">{{ $h->nama_mk }}</td>
                    <td class="py-3 px-4 text-sm text-center text-black">{{ $h->semester }}</td>
                    
                    @if($h->respon > 0)
                        <td class="py-3 px-4 text-sm text-center text-black">{{ $h->respon }}</td>
                        <td class="py-3 px-4 text-sm text-center font-bold text-green-600">{{ $h->rata_rata }}/4.0</td>
                        <td class="py-3 px-4 text-center">
                            <a href="{{ route('admin.hasil.show', $h->dosen_mk_id) }}" class="text-blue-500 hover:underline text-sm">Detail</a>
                        </td>
                    @else
                        <td class="py-3 px-4 text-sm text-center text-black">-</td>
                        <td class="py-3 px-4 text-sm text-center text-black">-</td>
                        <td class="py-3 px-4 text-center text-black">-</td>
                    @endif
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="py-4 px-4 text-center text-black font-medium">Tidak Ada Data</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection