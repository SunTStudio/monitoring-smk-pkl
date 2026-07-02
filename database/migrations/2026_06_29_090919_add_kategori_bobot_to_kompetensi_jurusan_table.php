<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kompetensi_jurusan', function (Blueprint $table) {
            $table->enum('kategori', ['hardskill', 'softskill'])->default('hardskill')->after('nama_aspek');
            $table->decimal('bobot', 5, 2)->default(10.00)->after('deskripsi_aspek')->comment('Bobot skill dalam perhitungan nilai akhir');
            $table->unsignedTinyInteger('urutan')->default(1)->after('bobot')->comment('Urutan tampil skill dalam form');
            $table->boolean('is_universal')->default(false)->after('urutan')->comment('Jika true, skill ini berlaku untuk semua jurusan');
        });
    }

    public function down(): void
    {
        Schema::table('kompetensi_jurusan', function (Blueprint $table) {
            $table->dropColumn(['kategori', 'bobot', 'urutan', 'is_universal']);
        });
    }
};
