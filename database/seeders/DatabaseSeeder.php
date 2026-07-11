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
        // Delete in reverse dependency order to avoid foreign key violations on PostgreSQL/MySQL
        Rapor::query()->delete();
        AbsensiSiswa::query()->delete();
        AbsensiGuru::query()->delete();
        PaketSoalItem::query()->delete();
        OpsiJawaban::query()->delete();
        PaketSoal::query()->delete();
        BankSoal::query()->delete();
        Penggajian::query()->delete();
        Cashflow::query()->delete();
        SesiKelas::query()->delete();
        Pengajaran::query()->delete();
        Siswa::query()->delete();
        Kelas::query()->delete();
        Mapel::query()->delete();
        Guru::query()->delete();
        User::query()->delete();
        JadwalSesi::query()->delete();
        TarifSpp::query()->delete();
        TarifGaji::query()->delete();
        LandingPhoto::query()->delete();
        Jenjang::query()->delete();
        Program::query()->delete();

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
