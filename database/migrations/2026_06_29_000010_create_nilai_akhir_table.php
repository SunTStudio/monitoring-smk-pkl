<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nilai_akhir', function (Blueprint $table) {
            $table->id('id_nilai_akhir');
            $table->foreignId('id_penugasan_fk')->constrained('penugasan', 'id_penugasan')->onDelete('cascade');
            $table->foreignId('id_siswa_fk')->constrained('siswa', 'id_siswa')->onDelete('cascade');
            $table->string('periode_pkl', 20)->nullable();
            $table->integer('total_hari_pkl')->default(0);
            $table->integer('total_hari_hadir')->default(0);
            $table->decimal('nilai_kehadiran', 5, 2)->default(0.00);
            $table->decimal('nilai_sikap_bobot', 5, 2)->default(0.00);
            $table->decimal('nilai_kompetensi_bobot', 5, 2)->default(0.00);
            $table->decimal('nilai_akhir_pkl', 5, 2)->default(0.00);
            $table->enum('grade', ['A', 'B', 'C', 'D', 'E'])->nullable();
            $table->enum('status_kelulusan', ['lulus', 'remedial', 'tidak_lulus'])->default('tidak_lulus');
            $table->text('catatan_kelulusan')->nullable();
            $table->foreignId('id_yang_finalisasi')->nullable()->constrained('users', 'id')->onDelete('set null');
            $table->timestamp('tgl_finalisasi')->nullable();
            $table->timestamp('tgl_cetak')->nullable();
            $table->string('no_sertifikat', 50)->unique()->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nilai_akhir');
    }
};
