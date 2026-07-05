@extends('layouts.admin')

@section('content')
<div class="p-8">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-black mb-1">Data Dosen</h1>
            <p class="text-black text-sm">Data Dosen Pengampu Mata Kuliah</p>
        </div>
        <a href="{{ route('admin.dosen.create') }}" class="bg-[#004684] hover:bg-[#003366] text-white px-4 py-2 rounded-md text-sm font-medium flex items-center gap-2 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Dosen
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-md text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-sm border border-slate-300 overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead class="bg-[#004684] text-white text-sm">
                <tr>
                    <th class="py-3 px-4 font-semibold">Foto</th>
                    <th class="py-3 px-4 font-semibold">Nama</th>
                    <th class="py-3 px-4 font-semibold">NIP/NIDN</th>
                    <th class="py-3 px-4 font-semibold">Program Studi</th>
                    <th class="py-3 px-4 font-semibold">Mata Kuliah</th>
                    <th class="py-3 px-4 font-semibold text-center">Status</th>
                    <th class="py-3 px-4 font-semibold text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-sm text-black divide-y divide-slate-200">
                @forelse($dosens as $dosen)
                <tr class="hover:bg-slate-50">
                    <td class="py-2 px-4">
                        @if($dosen->foto_profil)
                            <img src="{{ asset('asset/img/dosen/'.$dosen->foto_profil) }}" class="w-10 h-10 object-cover rounded">
                        @else
                            <div class="w-10 h-10 bg-slate-200 text-slate-500 flex items-center justify-center rounded text-xs">No Foto</div>
                        @endif
                    </td>
                    <td class="py-2 px-4">{{ $dosen->nama_lengkap }}</td>
                    <td class="py-2 px-4">{{ $dosen->nip ?? $dosen->nip_nidn }}</td>
                    <td class="py-2 px-4">{{ $dosen->prodi }}</td>
                    <td class="py-2 px-4">{{ $dosen->daftar_matkul }}</td>
                    <td class="py-2 px-4 text-center">{{ $dosen->status }}</td>
                    <td class="py-2 px-4 text-center">
                        <div class="flex items-center justify-center gap-2 text-xs">
                            <a href="{{ route('admin.dosen.edit', $dosen->id) }}" class="text-blue-600 hover:underline">Edit</a>
                            <span class="text-slate-300">|</span>
                            <form action="{{ route('admin.dosen.destroy', $dosen->id) }}" method="POST" onsubmit="return confirm('Hapus dosen ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="py-3 px-4 text-center text-black">Tidak Ada Data</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection