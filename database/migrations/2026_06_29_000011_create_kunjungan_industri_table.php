<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kunjungan_industri', function (Blueprint $table) {
            $table->id('id_kunjungan');
            $table->foreignId('id_pembimbing_fk')->constrained('users', 'id')->onDelete('cascade');
            $table->foreignId('id_industri_fk')->constrained('industri', 'id_industri')->onDelete('cascade');
            $table->date('tgl_kunjungan');
            $table->text('catatan_monitoring')->nullable();
            $table->string('foto_kunjungan', 255)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kunjungan_industri');
    }
};
