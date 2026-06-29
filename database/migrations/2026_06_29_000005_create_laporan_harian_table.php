<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laporan_harian', function (Blueprint $table) {
            $table->id('id_laporan');
            $table->foreignId('id_penugasan_fk')->constrained('penugasan', 'id_penugasan')->onDelete('cascade');
            $table->foreignId('id_siswa_fk')->constrained('siswa', 'id_siswa')->onDelete('cascade');
            $table->date('tgl_laporan');
            $table->time('jam_mulai_kerja')->nullable();
            $table->time('jam_selesai_kerja')->nullable();
            $table->decimal('jam_kerja_total', 5, 2)->nullable();
            $table->text('aktivitas_pekerjaan');
            $table->text('hasil_pekerjaan')->nullable();
            $table->text('skill_dipraktikkan')->nullable();
            $table->text('kendala_hambatan')->nullable();
            $table->text('pembelajaran_didapat')->nullable();
            $table->string('file_lampiran', 255)->nullable();
            $table->enum('status', ['draft', 'submitted', 'approved', 'rejected'])->default('draft');
            $table->text('feedback_pembimbing')->nullable();
            $table->foreignId('id_pembimbing_review')->nullable()->constrained('users', 'id')->onDelete('set null');
            $table->timestamp('tgl_review')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan_harian');
    }
};
