@extends('layouts.admin')

@section('content')
<div class="p-8 bg-gray-50 min-h-screen">
    <div class="flex justify-between items-start mb-8">
        <div>
            <h1 class="text-2xl font-bold text-black tracking-wide">Data Mata Kuliah</h1>
            <p class="text-gray-600 mt-1">Kelola data mata kuliah</p>
        </div>
        <a href="{{ route('admin.mata_kuliah.create') }}" class="bg-[#004684] hover:bg-[#003366] text-white px-4 py-2 rounded flex items-center gap-2 transition">
            <span>+</span> Tambah Mata Kuliah
        </a>
    </div>

    <div class="bg-white border border-gray-300">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-[#004684] text-white">
                    <th class="py-3 px-4 font-semibold text-sm">Kode Mata Kuliah</th>
                    <th class="py-3 px-4 font-semibold text-sm">Nama Mata Kuliah</th>
                    <th class="py-3 px-4 font-semibold text-sm">Program Studi</th>
                    <th class="py-3 px-4 font-semibold text-sm">Semester</th>
                    <th class="py-3 px-4 font-semibold text-sm text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($mataKuliah as $mk)
                <tr class="border-b border-gray-200 hover:bg-gray-50">
                    <td class="py-3 px-4 text-sm">{{ $mk->kode_mk }}</td>
                    <td class="py-3 px-4 text-sm">{{ $mk->nama_mk }}</td>
                    <td class="py-3 px-4 text-sm">{{ $mk->nama_prodi ?? $mk->prodi }}</td>
                    <td class="py-3 px-4 text-sm">{{ $mk->semester }}</td>
                    <td class="py-2 px-4 text-center">
                        <div class="flex items-center justify-center gap-2 text-xs">
                            <a href="{{ route('admin.mata_kuliah.edit', $mk->id) }}" class="text-blue-600 hover:underline">Edit</a>
                            <span class="text-slate-300">|</span>
                            <form action="{{ route('admin.mata_kuliah.destroy', $mk->id) }}" method="POST" onsubmit="return confirm('Hapus mata kuliah ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-4 px-4 text-center text-black font-medium border-b border-gray-300">
                        Tidak Ada Data
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection