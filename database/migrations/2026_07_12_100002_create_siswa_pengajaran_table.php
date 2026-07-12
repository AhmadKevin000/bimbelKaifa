<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('siswa_pengajaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswa')->onDelete('cascade');
            $table->foreignId('pengajaran_id')->constrained('pengajaran')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['siswa_id', 'pengajaran_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('siswa_pengajaran');
    }
};
