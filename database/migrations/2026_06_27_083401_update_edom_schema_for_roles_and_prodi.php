<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Buat Tabel Prodi
        Schema::create('prodi', function (Blueprint $table) {
            $table->id();
            $table->string('nama_prodi');
            $table->timestamps();
        });

        // 2. Update Tabel Users (Tambahan untuk Mahasiswa)
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('prodi_id')->nullable()->constrained('prodi')->onDelete('set null');
            $table->integer('semester_aktif')->nullable();
        });

        // 3. Update Tabel Dosen (Relasi ke User agar bisa Login)
        Schema::table('dosen', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
        });

        // 4. Update Tabel Mata Kuliah (Tambahan Prodi)
        Schema::table('mata_kuliah', function (Blueprint $table) {
            $table->foreignId('prodi_id')->nullable()->constrained('prodi')->onDelete('set null');
        });
    }

    public function down(): void
    {
        // Rollback urutan terbalik
        Schema::table('mata_kuliah', function (Blueprint $table) {
            $table->dropForeign(['prodi_id']);
            $table->dropColumn('prodi_id');
        });

        Schema::table('dosen', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['prodi_id']);
            $table->dropColumn(['prodi_id', 'semester_aktif']);
        });

        Schema::dropIfExists('prodi');
    }
};