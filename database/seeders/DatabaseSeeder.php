<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Siswa;
use App\Models\Pengajaran;
use App\Models\JadwalSesi;
use App\Models\TarifSpp;
use App\Models\TarifGaji;
use App\Models\LandingPhoto;
use App\Models\BankSoal;
use App\Models\PaketSoal;
use App\Models\PaketSoalItem;
use App\Models\OpsiJawaban;
use App\Models\AbsensiGuru;
use App\Models\AbsensiSiswa;
use App\Models\Cashflow;
use App\Models\Rapor;
use App\Models\Penggajian;
use App\Models\SesiKelas;
use App\Models\Jenjang;
use App\Models\Program;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 0. Clean old sample & user data
        Schema::disableForeignKeyConstraints();
        Kelas::truncate();
        Mapel::truncate();
        Siswa::truncate();
        Pengajaran::truncate();
        Guru::truncate();
        User::truncate();
        JadwalSesi::truncate();
        TarifSpp::truncate();
        TarifGaji::truncate();
        LandingPhoto::truncate();
        BankSoal::truncate();
        PaketSoal::truncate();
        PaketSoalItem::truncate();
        OpsiJawaban::truncate();
        AbsensiGuru::truncate();
        AbsensiSiswa::truncate();
        Cashflow::truncate();
        Rapor::truncate();
        Penggajian::truncate();
        SesiKelas::truncate();
        Jenjang::truncate();
        Program::truncate();
        Schema::enableForeignKeyConstraints();

        // 1. Admin User
        User::create([
            'email' => 'admin@admin.com',
            'name' => 'Administrator',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // 2. Core Config & Master Seeders
        $this->call([
            MasterSesiSeeder::class,
            TarifSppSeeder::class,
            TarifGajiSeeder::class,
            LandingPhotoSeeder::class,
        ]);
    }
}
