<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penilaian_sikap', function (Blueprint $table) {
            $table->id('id_penilaian_sikap');
            $table->foreignId('id_penugasan_fk')->constrained('penugasan', 'id_penugasan')->onDelete('cascade');
            $table->foreignId('id_siswa_fk')->constrained('siswa', 'id_siswa')->onDelete('cascade');
            $table->foreignId('id_pembimbing_fk')->constrained('users', 'id')->onDelete('cascade');
            $table->integer('nilai_kedisiplinan')->default(0);
            $table->integer('nilai_kerjasama')->default(0);
            $table->integer('nilai_tanggung_jawab')->default(0);
            $table->integer('nilai_inisiatif')->default(0);
            $table->decimal('nilai_rata_rata_sikap', 5, 2)->default(0.00);
            $table->text('catatan_kedisiplinan')->nullable();
            $table->text('catatan_kerjasama')->nullable();
            $table->text('catatan_tanggung_jawab')->nullable();
            $table->text('catatan_inisiatif')->nullable();
            $table->text('catatan_umum')->nullable();
            $table->enum('status', ['draft', 'submitted', 'finalized'])->default('draft');
            $table->date('tgl_penilaian')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penilaian_sikap');
    }
};
