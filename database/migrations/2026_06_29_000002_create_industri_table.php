<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('industri', function (Blueprint $table) {
            $table->id('id_industri');
            $table->string('nama_industri', 150);
            $table->string('jenis_industri', 50)->nullable();
            $table->text('alamat_lengkap')->nullable();
            $table->string('kota', 50)->nullable();
            $table->string('propinsi', 50)->nullable();
            $table->string('no_telp', 15)->nullable();
            $table->string('email_industri', 100)->nullable();
            $table->string('nama_kontak_person', 100)->nullable();
            $table->string('jabatan_kontak', 50)->nullable();
            $table->string('no_hp_kontak', 15)->nullable();
            $table->integer('kapasitas_siswa')->default(0);
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->enum('status', ['aktif', 'non_aktif', 'archived'])->default('aktif');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('industri');
    }
};
