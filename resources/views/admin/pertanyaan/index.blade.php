@extends('layouts.admin')

@section('content')
<div class="p-8 bg-gray-50 min-h-screen">
    <div class="flex justify-between items-start mb-8">
        <div>
            <h1 class="text-2xl font-bold text-black tracking-wide">Pertanyaan Evaluasi</h1>
            <p class="text-gray-600 mt-1">Kelola pertanyaan evaluasi dosen</p>
        </div>
        <a href="{{ route('admin.pertanyaan.create') }}" class="bg-[#004684] hover:bg-[#003366] text-white px-4 py-2 rounded flex items-center gap-2 transition">
            <span>+</span> Tambah Pertanyaan
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-md text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white border border-gray-300">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-[#004684] text-white">
                    <th class="py-3 px-4 font-semibold text-sm w-16">No</th>
                    <th class="py-3 px-4 font-semibold text-sm">Pertanyaan Evaluasi</th>
                    <th class="py-3 px-4 font-semibold text-sm w-1/4">Kategori</th>
                    <th class="py-3 px-4 font-semibold text-sm text-center w-32">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pertanyaans as $p)
                <tr class="border-b border-gray-200 hover:bg-gray-50">
                    <td class="py-3 px-4 text-sm">{{ $loop->iteration }}</td>
                    <td class="py-3 px-4 text-sm">{{ $p->teks_pertanyaan }}</td>
                    <td class="py-3 px-4 text-sm">{{ $p->nama_kategori }}</td>
                    <td class="py-3 px-4 text-center">
                        <div class="flex items-center justify-center gap-2 text-xs">
                            <a href="{{ route('admin.pertanyaan.edit', $p->id) }}" class="text-blue-600 hover:underline">Edit</a>
                            <span class="text-slate-300">|</span>
                            <form action="{{ route('admin.pertanyaan.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Hapus pertanyaan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="py-4 px-4 text-center text-black font-medium border-b border-gray-300">
                        Tidak Ada Data
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection