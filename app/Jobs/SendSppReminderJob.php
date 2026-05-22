<?php

namespace App\Jobs;

use App\Mail\SppReminderMail;
use App\Models\Siswa;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendSppReminderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** Maximum retry attempts before the job is failed. */
    public int $tries = 3;

    /** Wait time between retries (seconds): 60s, 300s, 600s. */
    public array $backoff = [60, 300, 600];

    /**
     * @param Siswa $siswa
     * @param array $unpaidMonths  [['label' => 'Juni 2026', 'due_date' => '2026-06-10', 'nominal' => 250000], ...]
     * @param int   $totalNominal
     */
    public function __construct(
        public readonly Siswa $siswa,
        public readonly array $unpaidMonths,
        public readonly int $totalNominal,
    ) {}

    public function handle(): void
    {
        $recipient = $this->siswa->email_wali ?? $this->siswa->email;

        if (!$recipient) {
            Log::warning("[SppReminder] Siswa ID {$this->siswa->id} ({$this->siswa->nama}) tidak memiliki email wali atau email sendiri. Dilewati.");
            return;
        }

        try {
            Mail::to($recipient)->send(new SppReminderMail(
                siswa: $this->siswa,
                unpaidMonths: $this->unpaidMonths,
                totalNominal: $this->totalNominal,
            ));

            Log::info("[SppReminder] Email berhasil dikirim ke {$recipient} untuk siswa {$this->siswa->nama}.");
        } catch (\Throwable $e) {
            Log::error("[SppReminder] Gagal mengirim email ke {$recipient} untuk siswa {$this->siswa->nama}: {$e->getMessage()}");
            // Re-throw so the queue retries
            throw $e;
        }
    }

    /** Called when all retry attempts have been exhausted. */
    public function failed(\Throwable $exception): void
    {
        Log::error("[SppReminder] Job GAGAL PERMANEN untuk siswa ID {$this->siswa->id} ({$this->siswa->nama}): {$exception->getMessage()}");
    }
}
