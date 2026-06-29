<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kelas', function (Blueprint $table) {
            $table->id('id_kelas');
            $table->string('nama_kelas', 50);
            $table->string('jurusan', 50);
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });

        Schema::table('siswa', function (Blueprint $table) {
            $table->foreignId('id_kelas_fk')->nullable()->after('id_siswa')->constrained('kelas', 'id_kelas')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('siswa', function (Blueprint $table) {
            $table->dropForeign(['id_kelas_fk']);
            $table->dropColumn('id_kelas_fk');
        });

        Schema::dropIfExists('kelas');
    }
};
