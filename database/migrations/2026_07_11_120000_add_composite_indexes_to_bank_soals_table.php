<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bank_soals', function (Blueprint $table) {
            // Composite index for the most common query pattern:
            // WHERE kelas_id = ? AND mapel_id = ? (soal list, soal count per mapel)
            $table->index(['kelas_id', 'mapel_id'], 'bank_soals_kelas_mapel_idx');
        });
    }

    public function down(): void
    {
        Schema::table('bank_soals', function (Blueprint $table) {
            $table->dropIndex('bank_soals_kelas_mapel_idx');
        });
    }
};
