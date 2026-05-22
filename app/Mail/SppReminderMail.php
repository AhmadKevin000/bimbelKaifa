<?php

namespace App\Mail;

use App\Models\Siswa;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SppReminderMail extends Mailable
{
    use Queueable, SerializesModels;

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

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '[Kaifa Bimbel] Pengingat Pembayaran SPP – ' . $this->siswa->nama,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.spp-reminder',
            with: [
                'siswa'        => $this->siswa,
                'unpaidMonths' => $this->unpaidMonths,
                'totalNominal' => $this->totalNominal,
                'namaWali'     => $this->siswa->nama_wali ?? 'Orang Tua/Wali',
            ],
        );
    }
}
