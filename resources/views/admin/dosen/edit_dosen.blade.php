@extends('layouts.admin')

@section('content')
<div class="p-8">
    <div class="flex items-center gap-4 mb-10">
        <a href="{{ route('admin.dosen.index') }}" class="bg-[#004684] hover:bg-[#003366] text-white p-1.5 rounded transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </a>
        <h1 class="text-2xl font-bold text-black tracking-wide">Edit Data Dosen</h1>
    </div>

    @if ($errors->any())
        <div class="mb-6 p-4 bg-red-50 text-red-700 rounded-md text-sm border border-red-200 max-w-3xl">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.dosen.update', $dosen->id) }}" method="POST" enctype="multipart/form-data" class="max-w-3xl">
        @csrf
        @method('PUT')
        
        <div class="space-y-5">
            <div class="grid grid-cols-1 md:grid-cols-4 items-center gap-4">
                <label for="nama" class="text-black font-semibold text-sm md:col-span-1">Nama Dosen :</label>
                <div class="md:col-span-3">
                    <input type="text" name="nama" id="nama" value="{{ old('nama', $dosen->nama_lengkap) }}" placeholder="Masukkan nama dosen" 
                        class="w-full border border-slate-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-[#004684]" required>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 items-center gap-4">
                <label for="nip" class="text-black font-semibold text-sm md:col-span-1">NIP/NIDN :</label>
                <div class="md:col-span-3">
                    <input type="text" name="nip" id="nip" value="{{ old('nip', $dosen->nip) }}" placeholder="Masukkan NIP/NIDN" 
                        class="w-full border border-slate-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-[#004684]" required>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 items-center gap-4">
                <label for="email" class="text-black font-semibold text-sm md:col-span-1">Email Akun :</label>
                <div class="md:col-span-3">
                    <input type="email" name="email" id="email" value="{{ old('email', $dosen->email) }}" placeholder="Masukkan email untuk login dosen" 
                        class="w-full border border-slate-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-[#004684]" required>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 items-center gap-4">
                <label for="password" class="text-black font-semibold text-sm md:col-span-1">Password :</label>
                <div class="md:col-span-3">
                    <input type="password" name="password" id="password" placeholder="Kosongkan jika tidak ingin mengubah password" 
                        class="w-full border border-slate-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-[#004684]">
                    <span class="text-xs text-slate-500 mt-1 block">*Biarkan kosong jika tidak ingin mengubah password saat ini.</span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 items-center gap-4">
                <label for="prodi" class="text-black font-semibold text-sm md:col-span-1">Program Studi :</label>
                <div class="md:col-span-3">
                    <select name="prodi" id="prodi" class="w-full border border-slate-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-[#004684] bg-white" required>
                        <option value="" disabled>Pilih Prodi</option>
                        
                        @foreach ($prodis as $p)
                            <option value="{{ $p->nama_prodi }}" {{ old('prodi', $dosen->prodi) == $p->nama_prodi ? 'selected' : '' }}>
                                {{ $p->nama_prodi }}
                            </option>
                        @endforeach
                        
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 items-center gap-4">
                <label for="status" class="text-black font-semibold text-sm md:col-span-1">Status :</label>
                <div class="md:col-span-3">
                    <select name="status" id="status" class="w-full border border-slate-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-[#004684] bg-white" required>
                        <option value="Aktif" {{ old('status', $dosen->status) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="Tidak Aktif" {{ old('status', $dosen->status) == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                </div>
            </div>

            <div class="mb-4">
                <label class="block font-medium text-black mb-1">Mata Kuliah :</label>
                <select name="matkul[]" multiple class="w-full border border-slate-300 rounded px-4 py-2 focus:outline-none focus:border-[#004684] bg-white h-24">
                    @foreach ($matkuls as $mk)
                        <option value="{{ $mk->id }}" {{ in_array($mk->id, $selected_matkuls ?? []) ? 'selected' : '' }}>
                            {{ $mk->nama_mk }}
                        </option>
                    @endforeach
                </select>
                <p class="text-xs text-slate-500 mt-1">*Tahan tombol Ctrl (Windows) / Cmd (Mac) untuk memilih lebih dari satu.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 items-start gap-4 pt-2">
                <label class="text-black font-semibold text-sm md:col-span-1 mt-2">Upload Foto :</label>
                <div class="md:col-span-3">
                    @if($dosen->foto_profil)
                        <div class="mb-3">
                            <img src="{{ asset('asset/img/dosen/'.$dosen->foto_profil) }}" class="w-20 h-20 object-cover rounded shadow-sm border border-slate-200">
                        </div>
                    @endif
                    <div class="flex items-center">
                        <label for="foto" class="flex items-center gap-2 border border-slate-300 px-4 py-1.5 rounded cursor-pointer hover:bg-slate-50 text-sm text-slate-700 bg-white shadow-sm transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                            </svg>
                            Pilih File Baru
                        </label>
                        <input type="file" id="foto" name="foto" class="hidden" accept="image/*">
                        <span class="ml-3 text-sm text-slate-500" id="file-name-display">Tidak ada file baru yang dipilih</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex gap-3 mt-10">
            <a href="{{ route('admin.dosen.index') }}" class="px-8 py-2 border border-slate-300 rounded font-semibold text-black bg-white hover:bg-slate-50 transition shadow-sm text-sm">Batal</a>
            <button type="submit" class="px-8 py-2 bg-[#1877F2] hover:bg-blue-600 text-white rounded font-semibold transition shadow-sm text-sm">Simpan Perubahan</button>
        </div>
    </form>
</div>

<script>
    document.getElementById('foto').addEventListener('change', function(e) {
        var fileName = e.target.files[0] ? e.target.files[0].name : 'Tidak ada file baru yang dipilih';
        document.getElementById('file-name-display').textContent = fileName;
    });
</script>
@endsection