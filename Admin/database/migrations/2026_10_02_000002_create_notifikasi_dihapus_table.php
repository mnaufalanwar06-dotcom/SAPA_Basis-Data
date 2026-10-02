<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifikasi_dihapus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_pengguna')->constrained('user')->cascadeOnDelete();
            $table->unsignedInteger('id_laporan');
            $table->timestamp('laporan_updated_at')->nullable();
            $table->timestamps();
            $table->foreign('id_laporan')
                ->references('id_laporan')
                ->on('laporan')
                ->cascadeOnDelete();
            $table->unique(['id_pengguna', 'id_laporan']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifikasi_dihapus');
    }
};