<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penugasan', function (Blueprint $table) {
            $table->id('id_penugasan');
            $table->foreignId('id_siswa_fk')->constrained('siswa', 'id_siswa')->onDelete('cascade');
            $table->foreignId('id_industri_fk')->constrained('industri', 'id_industri')->onDelete('cascade');
            $table->foreignId('id_pembimbing_fk')->constrained('users', 'id')->onDelete('cascade'); // Pembimbing Sekolah
            $table->foreignId('id_pengguna_industri_fk')->nullable()->constrained('users', 'id')->onDelete('set null'); // Pembimbing Industri (Akun)
            $table->date('tgl_mulai_pkl')->nullable();
            $table->date('tgl_selesai_pkl')->nullable();
            $table->integer('durasi_hari')->nullable();
            $table->string('lokasi_kerja', 100)->nullable();
            $table->string('divisi_departemen', 100)->nullable();
            $table->string('pembimbing_industri', 100)->nullable(); // Nama pembimbing di lapangan
            $table->enum('status', ['aktif', 'selesai', 'batal', 'on_leave'])->default('aktif');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penugasan');
    }
};
