<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kompetensi_jurusan', function (Blueprint $table) {
            $table->id('id_kompetensi');
            $table->string('jurusan', 50)->index();
            $table->string('nama_aspek', 100);
            $table->text('deskripsi_aspek')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kompetensi_jurusan');
    }
};
