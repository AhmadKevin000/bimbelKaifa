<?php

namespace App\Providers;

use App\Models\AbsensiGuru;
use App\Models\Penggajian;
use App\Models\Siswa;
use App\Models\User;
use App\Observers\AbsensiGuruObserver;
use App\Observers\PenggajianObserver;
use App\Observers\SiswaObserver;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Siswa::observe(SiswaObserver::class);
        AbsensiGuru::observe(AbsensiGuruObserver::class);
        Penggajian::observe(PenggajianObserver::class);

        /*
         * Siapa yang boleh membuka rapor seorang siswa.
         *
         * Admin  : semua siswa (sesuai kebijakan panel admin saat ini).
         * Guru   : hanya siswa yang terdaftar pada salah satu pengajaran miliknya
         *          (siswa_pengajaran → pengajaran.guru_id).
         * Lainnya: ditolak.
         *
         * Catatan: tabel `siswa` belum punya kolom user_id, jadi akun siswa/orang
         * tua belum bisa dipetakan ke siswa mana pun. Selama relasi itu belum ada,
         * akses mandiri untuk siswa tidak bisa diaktifkan tanpa menebak lewat ID.
         */
        Gate::define('view-rapor', function (User $user, Siswa $siswa): bool {
            if ($user->isAdmin()) {
                return true;
            }

            if (! $user->isGuru()) {
                return false;
            }

            $guru = $user->guru;

            if ($guru === null) {
                return false;
            }

            return $siswa->pengajaranEnrolled()
                ->where('pengajaran.guru_id', $guru->id)
                ->exists();
        });
    }
}
