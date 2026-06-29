<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifikasi', function (Blueprint $table) {
            $table->id('id_notifikasi');
            $table->foreignId('id_pengguna_tujuan_fk')->constrained('users', 'id')->onDelete('cascade');
            $table->string('judul_notifikasi', 150);
            $table->text('pesan_notifikasi');
            $table->enum('tipe_notifikasi', ['info', 'warning', 'error', 'success'])->default('info');
            $table->enum('kategori', ['absen', 'laporan', 'nilai', 'sistem', 'umum'])->default('umum');
            $table->unsignedBigInteger('id_referensi')->nullable();
            $table->string('tipe_referensi', 50)->nullable();
            $table->boolean('status_dibaca')->default(false);
            $table->timestamp('tgl_dibaca')->nullable();
            $table->timestamp('tgl_notifikasi')->useCurrent();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifikasi');
    }
};
