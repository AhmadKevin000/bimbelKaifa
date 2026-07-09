<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('absensi_guru', function (Blueprint $table) {
            $table->string('kelas_name_snapshot')->nullable()->after('mapel_id');
            $table->string('guru_name_snapshot')->nullable()->after('kelas_name_snapshot');
            $table->string('mapel_name_snapshot')->nullable()->after('guru_name_snapshot');

            $table->dropForeign(['sesi_kelas_id']);
        });

        Schema::table('absensi_guru', function (Blueprint $table) {
            $table->foreignId('sesi_kelas_id')->nullable()->change();
            $table->foreign('sesi_kelas_id')->references('id')->on('sesi_kelas')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('absensi_guru', function (Blueprint $table) {
            $table->dropForeign(['sesi_kelas_id']);
        });

        Schema::table('absensi_guru', function (Blueprint $table) {
            $table->foreignId('sesi_kelas_id')->nullable(false)->change();
            $table->foreign('sesi_kelas_id')->references('id')->on('sesi_kelas')->onDelete('cascade');

            $table->dropColumn(['kelas_name_snapshot', 'guru_name_snapshot', 'mapel_name_snapshot']);
        });
    }
};
