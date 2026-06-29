<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('aktivitas_log', function (Blueprint $table) {
            $table->id('id_log');
            $table->foreignId('id_pengguna_fk')->nullable()->constrained('users', 'id')->onDelete('set null');
            $table->string('tipe_aktivitas', 100);
            $table->text('deskripsi_aktivitas');
            $table->string('tabel_terdampak', 50)->nullable();
            $table->unsignedBigInteger('id_record_terdampak')->nullable();
            $table->json('nilai_lama')->nullable();
            $table->json('nilai_baru')->nullable();
            $table->string('ip_address', 50)->nullable();
            $table->string('user_agent', 255)->nullable();
            $table->timestamp('tgl_aktivitas')->useCurrent();
            $table->enum('status', ['sukses', 'gagal'])->default('sukses');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('aktivitas_log');
    }
};
