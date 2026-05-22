<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('siswa', function (Blueprint $table) {
            $table->string('email', 255)->nullable()->after('no_hp');
            $table->string('email_wali', 255)->nullable()->after('email');
            $table->string('nama_wali', 100)->nullable()->after('email_wali');
        });
    }

    public function down(): void
    {
        Schema::table('siswa', function (Blueprint $table) {
            $table->dropColumn(['email', 'email_wali', 'nama_wali']);
        });
    }
};
