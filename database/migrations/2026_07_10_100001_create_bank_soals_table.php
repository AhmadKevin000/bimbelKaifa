<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bank_soals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mapel_id')->constrained('mapel')->cascadeOnDelete();
            $table->enum('tipe_soal', ['pilihan_ganda', 'esai'])->default('pilihan_ganda');
            $table->text('pertanyaan');
            $table->string('gambar_soal')->nullable(); // path gambar pendukung soal
            $table->text('kunci_jawaban_esai')->nullable(); // hanya untuk esai
            $table->timestamps();

            $table->index('mapel_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bank_soals');
    }
};
