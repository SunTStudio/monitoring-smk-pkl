<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kehadiran', function (Blueprint $table) {
            $table->id('id_kehadiran');
            $table->foreignId('id_penugasan_fk')->constrained('penugasan', 'id_penugasan')->onDelete('cascade');
            $table->foreignId('id_siswa_fk')->constrained('siswa', 'id_siswa')->onDelete('cascade');
            $table->date('tgl_absen');
            $table->enum('status_kehadiran', ['hadir', 'alpa', 'izin', 'sakit', 'cuti'])->default('hadir');
            $table->time('waktu_checkin')->nullable();
            $table->time('waktu_checkout')->nullable();
            $table->decimal('jam_kerja_real', 5, 2)->nullable();
            $table->string('lokasi_checkin', 100)->nullable();
            $table->string('bukti_foto_checkin', 255)->nullable();
            $table->string('bukti_foto_checkout', 255)->nullable();
            $table->text('keterangan_izin')->nullable();
            $table->foreignId('id_pengguna_input')->nullable()->constrained('users', 'id')->onDelete('set null');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kehadiran');
    }
};
