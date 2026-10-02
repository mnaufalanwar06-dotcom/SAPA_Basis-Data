<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('laporan')) {
            Schema::create('laporan', function (Blueprint $table) {
                $table->increments('id_laporan');
                $table->string('nomor_laporan', 50)->nullable();
                $table->unsignedBigInteger('id_pengguna')->nullable()->default(1);
                $table->string('nama_pelapor', 100)->nullable();
                $table->string('kategori', 100);
                $table->string('sebagai', 50)->nullable();
                $table->string('lokasi_kejadian', 255)->nullable();
                $table->date('tanggal_kejadian')->nullable();
                $table->text('kronologi')->nullable();
                $table->string('bukti_lampiran', 255)->nullable();
                $table->string('status_penanganan', 50)->default('Menunggu Verifikasi');
                $table->text('catatan_admin')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan');
    }
};