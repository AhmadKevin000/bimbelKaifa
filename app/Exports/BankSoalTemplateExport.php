<?php

namespace App\Exports;

use App\Models\Jenjang;
use App\Models\Mapel;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BankSoalTemplateExport implements WithMultipleSheets
{
    protected ?Jenjang $jenjang;
    protected ?\App\Models\Kelas $kelas;

    public function __construct(?int $jenjangId = null, ?int $kelasId = null)
    {
        $this->jenjang = $jenjangId ? Jenjang::find($jenjangId) : null;
        $this->kelas = $kelasId ? \App\Models\Kelas::find($kelasId) : null;
    }

    public function sheets(): array
    {
        return [
            new PilihanGandaTemplateSheet($this->jenjang, $this->kelas),
            new EsaiTemplateSheet($this->jenjang, $this->kelas),
        ];
    }
}

class PilihanGandaTemplateSheet implements FromArray, WithTitle, WithHeadings, WithStyles
{
    public function __construct(
        protected ?Jenjang $jenjang,
        protected ?\App\Models\Kelas $kelas = null
    ) {}

    public function title(): string { return 'Pilihan Ganda'; }

    public function headings(): array
    {
        return [
            'jenjang', 'mapel', 'pertanyaan',
            'opsi_a', 'opsi_b', 'opsi_c', 'opsi_d',
            'jawaban_benar',
            'gambar_soal', 'gambar_opsi_a', 'gambar_opsi_b', 'gambar_opsi_c', 'gambar_opsi_d',
        ];
    }

    public function array(): array
    {
        $jenjangNama = 'Contoh Jenjang (e.g. 4 SD)';
        if ($this->kelas) {
            $jenjangNama = $this->kelas->nama_kelas;
        } elseif ($this->jenjang) {
            $jenjangNama = $this->jenjang->nama;
        }

        $mapelNama = 'Contoh Mapel';
        if ($this->kelas) {
            $firstTeaching = $this->kelas->pengajaran()->first();
            if ($firstTeaching && $firstTeaching->mapel) {
                $mapelNama = $firstTeaching->mapel->nama;
            }
        } elseif ($this->jenjang) {
            $firstMapel = Mapel::where('jenjang_id', $this->jenjang->id)->first();
            if ($firstMapel) {
                $mapelNama = $firstMapel->nama;
            }
        }

        return [
            [
                $jenjangNama,
                $mapelNama,
                'Contoh pertanyaan pilihan ganda?',
                'Opsi A', 'Opsi B', 'Opsi C', 'Opsi D',
                'A',
                '', '', '', '', '',
            ],
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Bold heading row
        $sheet->getStyle('A1:M1')->applyFromArray([
            'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
            'fill' => ['fillType' => 'solid', 'startColor' => ['argb' => 'FF4364F7']],
        ]);
        // Auto-width
        foreach (range('A', 'M') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
    }
}

class EsaiTemplateSheet implements FromArray, WithTitle, WithHeadings, WithStyles
{
    public function __construct(
        protected ?Jenjang $jenjang,
        protected ?\App\Models\Kelas $kelas = null
    ) {}

    public function title(): string { return 'Esai'; }

    public function headings(): array
    {
        return ['jenjang', 'mapel', 'pertanyaan', 'kunci_jawaban_esai', 'gambar_soal'];
    }

    public function array(): array
    {
        $jenjangNama = 'Contoh Jenjang (e.g. 4 SD)';
        if ($this->kelas) {
            $jenjangNama = $this->kelas->nama_kelas;
        } elseif ($this->jenjang) {
            $jenjangNama = $this->jenjang->nama;
        }

        $mapelNama = 'Contoh Mapel';
        if ($this->kelas) {
            $firstTeaching = $this->kelas->pengajaran()->first();
            if ($firstTeaching && $firstTeaching->mapel) {
                $mapelNama = $firstTeaching->mapel->nama;
            }
        } elseif ($this->jenjang) {
            $firstMapel = Mapel::where('jenjang_id', $this->jenjang->id)->first();
            if ($firstMapel) {
                $mapelNama = $firstMapel->nama;
            }
        }

        return [
            [
                $jenjangNama,
                $mapelNama,
                'Contoh pertanyaan esai?',
                'Kunci jawaban opsional (boleh dikosongkan)',
                '',
            ],
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:E1')->applyFromArray([
            'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
            'fill' => ['fillType' => 'solid', 'startColor' => ['argb' => 'FF059669']],
        ]);
        foreach (range('A', 'E') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
    }
}
