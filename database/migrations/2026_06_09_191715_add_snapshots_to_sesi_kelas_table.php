<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sesi_kelas', function (Blueprint $table) {
            $table->string('kelas_name_snapshot')->nullable()->after('pengajaran_id');
            $table->string('guru_name_snapshot')->nullable()->after('kelas_name_snapshot');
            $table->string('mapel_name_snapshot')->nullable()->after('guru_name_snapshot');
            
            // Drop the old foreign key constraint
            $table->dropForeign(['pengajaran_id']);
        });

        Schema::table('sesi_kelas', function (Blueprint $table) {
            // Modify the pengajaran_id column to be nullable and set its constraint to set null on delete
            $table->foreignId('pengajaran_id')->nullable()->change();
            $table->foreign('pengajaran_id')->references('id')->on('pengajaran')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('sesi_kelas', function (Blueprint $table) {
            $table->dropForeign(['pengajaran_id']);
        });

        Schema::table('sesi_kelas', function (Blueprint $table) {
            $table->foreignId('pengajaran_id')->nullable(false)->change();
            $table->foreign('pengajaran_id')->references('id')->on('pengajaran')->onDelete('cascade');
            
            $table->dropColumn(['kelas_name_snapshot', 'guru_name_snapshot', 'mapel_name_snapshot']);
        });
    }
};
