@extends('layouts.mahasiswa')

@section('content')
<div class="max-w-7xl mx-auto p-6 min-h-screen bg-gray-50">
    <div class="text-center mb-10 mt-8">
        <h1 class="text-3xl font-bold text-black mb-4">PANDUAN PENGISIAN EDOM</h1>
        <p class="text-gray-600 max-w-2xl mx-auto">EDOM merupakan bagian penting dalam peningkatan kualitas pembelajaran di Politeknik Negeri Cilacap. Berikut informasi lengkap yang perlu Anda ketahui sebelum melakukan pengisian evaluasi.</p>
        
        <div class="mt-6 inline-flex items-center gap-2 px-4 py-2 bg-blue-50 text-[#004684] text-sm font-medium rounded-full border border-blue-100">
            <span class="w-5 h-5 bg-[#004684] text-white rounded-full flex items-center justify-center text-xs font-bold">i</span>
            Periode Pengisian EDOM Tahun Akademik 2025/2026 Semester Ganjil
        </div>
    </div>

    <!-- Grid Panduan -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-5xl mx-auto">
        
        <!-- Card 1 -->
        <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-200 text-center">
            <div class="w-14 h-14 bg-[#004684] text-white rounded-full flex items-center justify-center mx-auto mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
            <h3 class="font-bold text-lg text-black mb-3">Apa itu EDOM?</h3>
            <p class="text-sm text-gray-600 leading-relaxed">EDOM (Evaluasi Dosen Oleh Mahasiswa) adalah sistem penilaian yang dilakukan oleh mahasiswa untuk mengevaluasi kinerja dosen dalam proses pembelajaran selama satu semester. Hasil evaluasi digunakan sebagai bahan perbaikan dan peningkatan mutu pembelajaran.</p>
        </div>

        <!-- Card 2 -->
        <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-200 text-center">
            <div class="w-14 h-14 bg-[#004684] text-white rounded-full flex items-center justify-center mx-auto mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
            <h3 class="font-bold text-lg text-black mb-3">Kapan Waktu Pengisian EDOM?</h3>
            <p class="text-sm text-gray-600 leading-relaxed">Pengisian EDOM dilakukan pada akhir semester setelah perkuliahan selesai dan sebelum pelaksanaan Ujian Akhir Semester (UAS). Periode pengisian biasanya dibuka selama 2-3 minggu sesuai dengan kalender akademik.</p>
        </div>

        <!-- Card 3 -->
        <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-200 text-center">
            <div class="w-14 h-14 bg-[#004684] text-white rounded-full flex items-center justify-center mx-auto mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <h3 class="font-bold text-lg text-black mb-3">Mengapa Harus Mengisi EDOM?</h3>
            <p class="text-sm text-gray-600 leading-relaxed">Partisipasi mahasiswa dalam pengisian EDOM sangat penting untuk meningkatkan kualitas pembelajaran. Masukan yang diberikan akan digunakan sebagai bahan evaluasi dan pengembangan metode pengajaran dosen di semester berikutnya.</p>
        </div>

        <!-- Card 4 -->
        <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-200 text-center">
            <div class="w-14 h-14 bg-[#004684] text-white rounded-full flex items-center justify-center mx-auto mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122" />
                </svg>
            </div>
            <h3 class="font-bold text-lg text-black mb-3">Cara Mengisi EDOM</h3>
            <p class="text-sm text-gray-600 leading-relaxed">Mahasiswa memilih mata kuliah yang tersedia pada Beranda, kemudian memberikan penilaian terhadap dosen pengajar berdasarkan beberapa aspek pembelajaran. Setiap pertanyaan memiliki skala penilaian dari 1 hingga 5.</p>
        </div>

        <!-- Card 5 -->
        <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-200 text-center">
            <div class="w-14 h-14 bg-[#004684] text-white rounded-full flex items-center justify-center mx-auto mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                </svg>
            </div>
            <h3 class="font-bold text-lg text-black mb-3">Ketentuan Pengisian</h3>
            <p class="text-sm text-gray-600 leading-relaxed">Setiap mahasiswa diwajibkan mengisi evaluasi untuk seluruh mata kuliah yang diambil pada semester berjalan. Evaluasi hanya dapat diisi satu kali untuk setiap mata kuliah.</p>
        </div>

        <!-- Card 6 -->
        <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-200 text-center">
            <div class="w-14 h-14 bg-[#004684] text-white rounded-full flex items-center justify-center mx-auto mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
            </div>
            <h3 class="font-bold text-lg text-black mb-3">Kerahasiaan Data</h3>
            <p class="text-sm text-gray-600 leading-relaxed">Seluruh hasil evaluasi yang diberikan mahasiswa bersifat anonim dan dirahasiakan. Data hanya digunakan untuk keperluan peningkatan kualitas pembelajaran.</p>
        </div>

    </div>
</div>
@endsection