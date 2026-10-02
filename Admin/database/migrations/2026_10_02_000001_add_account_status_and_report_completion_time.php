<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('user') && !Schema::hasColumn('user', 'is_active')) {
            Schema::table('user', function (Blueprint $table) {
                $table->boolean('is_active')->default(true);
            });
        }

        if (Schema::hasTable('laporan') && !Schema::hasColumn('laporan', 'completed_at')) {
            Schema::table('laporan', function (Blueprint $table) {
                $table->timestamp('completed_at')->nullable();
            });

            DB::table('laporan')
                ->where('status_penanganan', 'Selesai')
                ->whereNull('completed_at')
                ->update(['completed_at' => DB::raw('updated_at')]);
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('user') && Schema::hasColumn('user', 'is_active')) {
            Schema::table('user', function (Blueprint $table) {
                $table->dropColumn('is_active');
            });
        }

        if (Schema::hasTable('laporan') && Schema::hasColumn('laporan', 'completed_at')) {
            Schema::table('laporan', function (Blueprint $table) {
                $table->dropColumn('completed_at');
            });
        }
    }
};