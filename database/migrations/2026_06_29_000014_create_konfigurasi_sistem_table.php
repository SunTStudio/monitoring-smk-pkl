<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('konfigurasi_sistem', function (Blueprint $table) {
            $table->id('id_konfigurasi');
            $table->string('nama_konfigurasi', 100)->unique();
            $table->text('nilai_konfigurasi')->nullable();
            $table->enum('tipe_data', ['string', 'integer', 'decimal', 'boolean', 'json'])->default('string');
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('konfigurasi_sistem');
    }
};
