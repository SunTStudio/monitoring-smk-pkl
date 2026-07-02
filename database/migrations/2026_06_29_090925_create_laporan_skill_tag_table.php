<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laporan_skill_tag', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_laporan_fk')->constrained('laporan_harian', 'id_laporan')->onDelete('cascade');
            $table->foreignId('id_kompetensi_fk')->constrained('kompetensi_jurusan', 'id_kompetensi')->onDelete('cascade');
            $table->timestamps();

            // Prevent duplicate tags on same laporan
            $table->unique(['id_laporan_fk', 'id_kompetensi_fk'], 'unique_laporan_skill');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan_skill_tag');
    }
};
