<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Step 1: Add column as nullable first (so existing rows don't fail)
        Schema::table('bank_soals', function (Blueprint $table) {
            $table->foreignId('kelas_id')->nullable()->after('mapel_id');
        });

        // Step 2: Backfill existing rows — resolve kelas_id from mapel → pengajaran → kelas
        $soals = DB::table('bank_soals')->whereNull('kelas_id')->get();
        foreach ($soals as $soal) {
            $kelasId = DB::table('pengajaran')
                ->where('mapel_id', $soal->mapel_id)
                ->value('kelas_id');

            if ($kelasId) {
                DB::table('bank_soals')
                    ->where('id', $soal->id)
                    ->update(['kelas_id' => $kelasId]);
            }
        }

        // Step 3: Make column NOT NULL and add FK + index
        Schema::table('bank_soals', function (Blueprint $table) {
            // For any remaining nulls (orphan mapels), assign first kelas as fallback
            $fallbackKelasId = DB::table('kelas')->value('id');
            if ($fallbackKelasId) {
                DB::table('bank_soals')
                    ->whereNull('kelas_id')
                    ->update(['kelas_id' => $fallbackKelasId]);
            }
        });

        // Step 4: Alter column to NOT NULL and add constraints
        Schema::table('bank_soals', function (Blueprint $table) {
            $table->unsignedBigInteger('kelas_id')->nullable(false)->change();
            $table->foreign('kelas_id')->references('id')->on('kelas')->cascadeOnDelete();
            $table->index('kelas_id');
        });
    }

    public function down(): void
    {
        Schema::table('bank_soals', function (Blueprint $table) {
            $table->dropForeign(['kelas_id']);
            $table->dropIndex(['kelas_id']);
            $table->dropColumn('kelas_id');
        });
    }
};
