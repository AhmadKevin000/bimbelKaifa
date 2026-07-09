<?php

namespace App\Console\Commands;

use App\Mail\SppReminderMail;
use App\Models\Siswa;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestSppReminder extends Command
{
    protected $signature = 'app:test-spp-reminder {email : Email tujuan pengiriman test}';

    protected $description = 'Kirim email test pengingat SPP ke email yang ditentukan';

    public function handle(): int
    {
        $recipient = $this->argument('email');
        
        // Cari siswa pertama, jika tidak ada, buat objek dummy
        $siswa = Siswa::first();
        if (!$siswa) {
            $siswa = new Siswa();
            $siswa->nama = 'Siswa Uji Coba';
            $siswa->nama_wali = 'Wali Uji Coba';
        }

        $unpaidMonths = [
            [
                'label' => 'Juni 2026',
                'due_date' => '2026-06-10',
                'nominal' => 250000,
            ]
        ];

        $this->info("Mengirim email test SPP reminder ke: {$recipient}...");

        try {
            Mail::to($recipient)->send(new SppReminderMail($siswa, $unpaidMonths, 250000));
            $this->info("Email test berhasil dikirim!");
        } catch (\Throwable $e) {
            $this->error("Gagal mengirim email test: " . $e->getMessage());
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}
