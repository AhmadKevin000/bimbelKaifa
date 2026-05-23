<?php

namespace App\Console\Commands;

use App\Jobs\SendSppReminderJob;
use App\Models\Cashflow;
use App\Models\Siswa;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SendSppReminders extends Command
{
    protected $signature = 'app:send-spp-reminders
                            {--dry-run : List siswa yang akan dikirim tanpa benar-benar mengirim email}';

    protected $description = 'Kirim email pengingat SPP kepada wali siswa H-7 sebelum jatuh tempo.';

    public function handle(): int
    {
        $today    = Carbon::today();
        $isDryRun = $this->option('dry-run');

        $this->info("=== [SppReminder] Mulai pengecekan pada {$today->toDateString()} ===");
        Log::info("[SppReminder] Command dimulai pada {$today->toDateString()}");

        // Load all siswa yang punya jatuh_tempo
        $siswas = Siswa::whereNotNull('spp_jatuh_tempo')
            ->with('kelas.pengajaran.mapel.program', 'kelas.pengajaran.mapel.jenjang')
            ->get();

        $dispatched = 0;
        $skipped    = 0;

        foreach ($siswas as $siswa) {
            try {
                $unpaidMonths = $this->getUnpaidMonths($siswa, $today);

                if (empty($unpaidMonths)) {
                    $skipped++;
                    continue;
                }

                $totalNominal = array_sum(array_column($unpaidMonths, 'nominal'));

                if ($isDryRun) {
                    $recipientDisplay = $siswa->email_wali ?? $siswa->email ?? 'NO EMAIL';
                    $this->line("  [DRY RUN] Akan kirim ke: {$siswa->nama} ({$recipientDisplay})");
                    foreach ($unpaidMonths as $m) {
                        $this->line("             - {$m['label']} | Rp " . number_format($m['nominal'], 0, ',', '.'));
                    }
                } else {
                    SendSppReminderJob::dispatch($siswa, $unpaidMonths, $totalNominal);
                    Log::info("[SppReminder] Job dispatched untuk siswa ID {$siswa->id} ({$siswa->nama}).");
                }

                $dispatched++;
            } catch (\Throwable $e) {
                $this->error("  ERROR pada siswa ID {$siswa->id} ({$siswa->nama}): {$e->getMessage()}");
                Log::error("[SppReminder] Error saat proses siswa ID {$siswa->id}: {$e->getMessage()}");
            }
        }

        $this->info("=== Selesai: {$dispatched} reminder di-dispatch, {$skipped} dilewati ===");
        Log::info("[SppReminder] Selesai. Dispatched: {$dispatched}, Skipped: {$skipped}");

        return Command::SUCCESS;
    }

    /**
     * Determine which months are unpaid and trigger H-7 reminder today.
     *
     * Logic:
     * 1. Calculate the upcoming jatuh tempo date for the next month.
     * 2. If today == (jatuh_tempo_date - 7 days), proceed.
     * 3. Query cashflow to see if payment already exists for that month.
     * 4. Return array of unpaid months.
     *
     * @return array<int, array{label: string, due_date: string, nominal: int}>
     */
    private function getUnpaidMonths(Siswa $siswa, Carbon $today): array
    {
        if (!$siswa->spp_jatuh_tempo) {
            return [];
        }

        $sppNominal = (int) $siswa->spp_nominal;
        if ($sppNominal <= 0) {
            return [];
        }

        $dueDate = Carbon::parse($siswa->spp_jatuh_tempo);

        // H-7 check: only proceed if today is exactly 7 days before the due date
        $reminderDate = $dueDate->copy()->subDays(7);

        if (!$today->isSameDay($reminderDate)) {
            return [];
        }

        // Check if payment already exists in cashflow for that due date's month & year
        $alreadyPaid = Cashflow::where('reference_id', $siswa->id)
            ->where('reference_type', Siswa::class)
            ->whereYear('tanggal', $dueDate->year)
            ->whereMonth('tanggal', $dueDate->month)
            ->exists();

        if ($alreadyPaid) {
            return [];
        }

        return [
            [
                'label'    => $dueDate->isoFormat('MMMM YYYY'),
                'due_date' => $dueDate->toDateString(),
                'nominal'  => $sppNominal,
            ],
        ];
    }
}
