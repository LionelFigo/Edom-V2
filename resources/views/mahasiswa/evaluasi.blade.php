@extends('layouts.mahasiswa')

@section('content')
<div class="max-w-7xl mx-auto p-6 min-h-screen bg-gray-50">
    @if(session('error'))
        <div class="mb-6 p-4 bg-red-100 border border-red-300 text-red-700 rounded-md shadow-sm">
            <strong>Terjadi Kesalahan:</strong> {{ session('error') }}
        </div>
    @endif
    
    <!-- Profil Dosen Card -->
    <div class="flex items-start gap-4 mb-8">
        <a href="{{ route('mahasiswa.dashboard') }}" class="bg-[#004684] text-white p-2 rounded hover:bg-[#003366] mt-1">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
        </a>

        <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-5 flex-1 flex gap-6 items-center">
            @if($jadwal->foto_profil)
                <img src="{{ asset('asset/img/dosen/'.$jadwal->foto_profil) }}" class="w-24 h-24 object-cover rounded-md border border-gray-200">
            @else
                <div class="w-24 h-24 bg-gray-200 flex items-center justify-center rounded-md border border-gray-300">No Foto</div>
            @endif
            
            <div>
                <h2 class="text-xl font-bold text-black">{{ $jadwal->nama_lengkap }}</h2>
                <p class="text-gray-600 font-medium text-sm mb-4">NIP/NIDN : {{ $jadwal->nip }}</p>
                <div class="flex gap-4">
                    <div class="border border-gray-200 rounded-md p-2 min-w-[250px]">
                        <p class="text-xs text-[#004684] font-bold">Mata Kuliah</p>
                        <p class="text-sm text-black">{{ $jadwal->nama_mk }}</p>
                    </div>
                    <div class="border border-gray-200 rounded-md p-2 min-w-[150px]">
                        <p class="text-xs text-[#004684] font-bold">Semester</p>
                        <p class="text-sm text-black">{{ $jadwal->semester }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Penilaian Berbasis Wizard -->
    <form id="formEvaluasi" action="{{ route('mahasiswa.evaluasi.store', $jadwal->dosen_mk_id) }}" method="POST">
        @csrf
        
        @php
            $romawi = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X'];
            $totalKategori = count($kategoris);
        @endphp

        <!-- 1. Looping Kategori Pertanyaan -->
        @foreach($kategoris as $index => $kategori)
        <div id="step-{{ $index + 1 }}" class="step-container" style="{{ $index === 0 ? 'display:block;' : 'display:none;' }}">
            <div class="mb-4">
                <div class="flex items-center gap-3 mb-2">
                    <span class="bg-[#004684] text-white px-3 py-1 font-bold rounded-md">{{ $romawi[$index] ?? ($index+1) }}</span>
                    <h3 class="text-xl font-bold text-black">{{ $kategori->nama_kategori }}</h3>
                </div>
            </div>

            <div class="bg-white border border-gray-300 rounded-sm overflow-hidden mb-6">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-[#004684] text-white">
                            <th class="py-3 px-4 font-semibold text-sm w-12 text-center border-r border-[#003366]">No</th>
                            <th class="py-3 px-4 font-semibold text-sm border-r border-[#003366]">Pertanyaan</th>
                            <th class="py-3 px-4 font-semibold text-sm text-center w-24 border-r border-[#003366]">Tidak Puas</th>
                            <th class="py-3 px-4 font-semibold text-sm text-center w-24 border-r border-[#003366]">Cukup Puas</th>
                            <th class="py-3 px-4 font-semibold text-sm text-center w-24 border-r border-[#003366]">Puas</th>
                            <th class="py-3 px-4 font-semibold text-sm text-center w-24">Sangat Puas</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @php $no = 1; @endphp
                        @foreach($pertanyaans->where('kategori_id', $kategori->id) as $p)
                        <tr class="hover:bg-gray-50 row-pertanyaan">
                            <td class="py-3 px-4 text-sm text-center border-r border-gray-200">{{ $no++ }}</td>
                            <td class="py-3 px-4 text-sm text-black border-r border-gray-200">{{ $p->teks_pertanyaan }}</td>
                            <!-- Hilangkan atribut required agar tidak berbenturan dengan hidden step browser -->
                            <td class="py-3 px-4 text-center border-r border-gray-200">
                                <input type="radio" name="q_{{ $p->id }}" value="1" class="w-5 h-5 text-[#004684]">
                            </td>
                            <td class="py-3 px-4 text-center border-r border-gray-200">
                                <input type="radio" name="q_{{ $p->id }}" value="2" class="w-5 h-5 text-[#004684]">
                            </td>
                            <td class="py-3 px-4 text-center border-r border-gray-200">
                                <input type="radio" name="q_{{ $p->id }}" value="3" class="w-5 h-5 text-[#004684]">
                            </td>
                            <td class="py-3 px-4 text-center">
                                <input type="radio" name="q_{{ $p->id }}" value="4" class="w-5 h-5 text-[#004684]">
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Tombol Navigasi Kategori -->
            <div class="flex justify-end gap-4 mb-10">
                @if($index === 0)
                    <a href="{{ route('mahasiswa.dashboard') }}" class="px-8 py-2 bg-white text-black font-bold border border-gray-300 rounded shadow-sm hover:bg-gray-50 transition">Batal</a>
                @else
                    <button type="button" onclick="prevStep()" class="px-8 py-2 bg-white text-black font-bold border border-gray-300 rounded shadow-sm hover:bg-gray-50 transition">Kembali</button>
                @endif
                
                <button type="button" onclick="nextStep()" class="px-8 py-2 bg-[#007BFF] text-white font-bold rounded shadow-sm hover:bg-blue-600 transition flex items-center gap-2">
                    Selanjutnya 
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                </button>
            </div>
        </div>
        @endforeach

        <!-- 2. Halaman Terakhir: Saran dan Komentar -->
        <div id="step-{{ $totalKategori + 1 }}" class="step-container" style="display:none;">
            <div class="mb-4">
                <div class="flex items-center gap-3 mb-4">
                    <span class="bg-[#004684] text-white px-3 py-1 font-bold rounded-md">{{ $romawi[$totalKategori] ?? 'X' }}</span>
                    <h3 class="text-xl font-bold text-black">Saran dan Komentar</h3>
                </div>
                <p class="text-sm text-gray-700 mb-3">Berikan evaluasi, saran, atau komentar Anda secara umum terkait proses pembelajaran. (Opsional)</p>
                <textarea name="saran_komentar" rows="6" class="w-full border border-gray-300 rounded-md p-4 focus:outline-none focus:border-[#004684]" placeholder="Tulis saran dan komentar Anda di sini..."></textarea>
            </div>

            <!-- Tombol Submit Akhir -->
            <div class="flex justify-end gap-4 mb-10">
                <button type="button" onclick="prevStep()" class="px-8 py-2 bg-white text-black font-bold border border-gray-300 rounded shadow-sm hover:bg-gray-50 transition">Kembali</button>
                <button type="submit" class="px-8 py-2 bg-[#007BFF] text-white font-bold rounded shadow-sm hover:bg-blue-600 transition flex items-center gap-2">
                    Submit 
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" /></svg>
                </button>
            </div>
        </div>
    </form>
</div>

<!-- Logika JavaScript untuk Pindah Halaman -->
<script>
    let currentStep = 1;
    const totalSteps = {{ $totalKategori + 1 }};

    function showStep(step) {
        // Sembunyikan semua step
        document.querySelectorAll('.step-container').forEach(el => {
            el.style.display = 'none';
        });
        // Tampilkan step yang aktif
        document.getElementById('step-' + step).style.display = 'block';
        // Scroll kembali ke atas dengan halus
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function nextStep() {
        const stepContainer = document.getElementById('step-' + currentStep);
        const rows = stepContainer.querySelectorAll('.row-pertanyaan');
        let allAnswered = true;

        // Validasi: Cek setiap baris tabel pada step ini apakah sudah ada radio yang di-check
        rows.forEach(row => {
            const isChecked = row.querySelector('input[type="radio"]:checked');
            if (!isChecked) {
                allAnswered = false;
                row.classList.add('bg-red-50'); // Beri highlight merah pada baris yang belum diisi
            } else {
                row.classList.remove('bg-red-50');
            }
        });

        if (!allAnswered) {
            alert('Mohon berikan penilaian (1-4) untuk semua pertanyaan pada halaman ini sebelum melanjutkan.');
            return;
        }

        // Pindah ke halaman selanjutnya
        if (currentStep < totalSteps) {
            currentStep++;
            showStep(currentStep);
        }
    }

    function prevStep() {
        if (currentStep > 1) {
            currentStep--;
            showStep(currentStep);
        }
    }
</script>
@endsection