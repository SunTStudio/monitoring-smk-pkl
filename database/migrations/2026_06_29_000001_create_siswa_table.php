<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('siswa', function (Blueprint $table) {
            $table->id('id_siswa');
            $table->string('nisn', 20)->unique();
            $table->string('nis', 10)->unique();
            $table->string('nama_lengkap', 100);
            $table->string('kelas', 5);
            $table->string('jurusan', 50);
            $table->string('no_hp', 15)->nullable();
            $table->string('email', 100)->nullable();
            $table->text('alamat')->nullable();
            $table->string('nama_orang_tua', 100)->nullable();
            $table->string('no_hp_orang_tua', 15)->nullable();
            $table->foreignId('id_pengguna_fk')->nullable()->constrained('users')->onDelete('cascade');
            $table->enum('status', ['aktif', 'selesai', 'dropout'])->default('aktif');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('siswa');
    }
};
