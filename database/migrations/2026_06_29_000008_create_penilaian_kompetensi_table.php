<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penilaian_kompetensi', function (Blueprint $table) {
            $table->id('id_penilaian_kompetensi');
            $table->foreignId('id_penugasan_fk')->constrained('penugasan', 'id_penugasan')->onDelete('cascade');
            $table->foreignId('id_siswa_fk')->constrained('siswa', 'id_siswa')->onDelete('cascade');
            $table->foreignId('id_industri_penilai_fk')->constrained('users', 'id')->onDelete('cascade');
            $table->decimal('nilai_rata_rata_kompetensi', 5, 2)->default(0.00);
            $table->text('catatan_umum')->nullable();
            $table->text('rekomendasi_industri')->nullable();
            $table->enum('status', ['draft', 'submitted', 'finalized'])->default('draft');
            $table->date('tgl_penilaian')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penilaian_kompetensi');
    }
};
