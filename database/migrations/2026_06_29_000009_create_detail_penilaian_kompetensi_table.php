<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_penilaian_kompetensi', function (Blueprint $table) {
            $table->id('id_detail');
            $table->foreignId('id_penilaian_kompetensi_fk')->constrained('penilaian_kompetensi', 'id_penilaian_kompetensi')->onDelete('cascade');
            $table->foreignId('id_kompetensi_fk')->constrained('kompetensi_jurusan', 'id_kompetensi')->onDelete('cascade');
            $table->integer('nilai')->default(0);
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_penilaian_kompetensi');
    }
};
