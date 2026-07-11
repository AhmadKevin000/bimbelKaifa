<?php

namespace App\Filament\Admin\Resources\BankSoal\Pages;

use App\Filament\Admin\Resources\BankSoal\BankSoalResource;
use App\Imports\PilihanGandaSheetImport;
use App\Imports\EsaiSheetImport;
use App\Models\BankSoal as BankSoalModel;
use App\Models\OpsiJawaban;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class ImportBankSoal extends Page
{
    use WithFileUploads;

    protected static string $resource = BankSoalResource::class;
    protected string $view = 'filament.admin.resources.bank-soal.pages.import-bank-soal';

    // Session key untuk menyimpan data parsed yang besar
    const SESSION_KEY_PG   = 'import_bank_soal_pg';
    const SESSION_KEY_ESAI = 'import_bank_soal_esai';

    #[Url(as: 'jenjang_id')]
    public ?int $prefillJenjangId = null;
    public ?string $prefillJenjangNama = null;

    public function mount(): void
    {
        if ($this->prefillJenjangId) {
            $this->prefillJenjangNama = \App\Models\Jenjang::find($this->prefillJenjangId)?->nama;
        }
        // Bersihkan session lama saat halaman pertama kali dibuka
        Session::forget([self::SESSION_KEY_PG, self::SESSION_KEY_ESAI]);
    }

    // ── Upload fields ──────────────────────────────────────────────────────
    public $excelFile = null;
    public array $imageFiles = [];

    // ── State (ringan, tidak mengandung data besar) ─────────────────────────
    public bool $isParsed     = false;
    public bool $isParsing    = false;  // dikunci dari server saat parse() berjalan
    public string $activeTab  = 'pilihan_ganda';
    public array $commitErrors = [];

    // Statistik ringkasan (hanya angka, bukan data lengkap)
    public int $pgValidCount   = 0;
    public int $pgErrorCount   = 0;
    public int $esaiValidCount = 0;
    public int $esaiErrorCount = 0;

    // ── Getter data dari Session (untuk blade template) ────────────────────
    #[Computed]
    public function parsedPG(): array
    {
        return Session::get(self::SESSION_KEY_PG, []);
    }

    #[Computed]
    public function parsedEsai(): array
    {
        return Session::get(self::SESSION_KEY_ESAI, []);
    }

    // ── Parse: Upload Excel + Gambar → Preview ─────────────────────────────
    public function parse(): void
    {
        $this->validate([
            'excelFile'    => 'required|file|mimes:xlsx,xls',
            'imageFiles'   => 'nullable|array',
            'imageFiles.*' => 'file|image|max:5120',
        ]);

        // Simpan gambar ke temp dan buat map: nama_file => path
        $imageMap = [];
        foreach ($this->imageFiles as $imgFile) {
            $originalName = $imgFile->getClientOriginalName();
            $tempPath = $imgFile->store('bank_soal_temp', 'public');
            $imageMap[$originalName] = $tempPath;
            $imageMap[strtolower(trim($originalName))] = $tempPath;
        }

        // Simpan Excel ke temp
        $excelPath     = $this->excelFile->store('bank_soal_temp', 'public');
        $excelFullPath = Storage::disk('public')->path($excelPath);

        // Parse kedua sheet
        $pgImport   = new PilihanGandaSheetImport($imageMap);
        $esaiImport = new EsaiSheetImport($imageMap);

        $sheetsToImport = [];
        try {
            $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReaderForFile($excelFullPath);
            $reader->setReadDataOnly(true);
            $spreadsheet = $reader->load($excelFullPath);
            $sheetNames = $spreadsheet->getSheetNames();
            
            foreach ($sheetNames as $name) {
                $sheet = $spreadsheet->getSheetByName($name);
                $highestColumn = $sheet->getHighestColumn();
                $firstRow = $sheet->rangeToArray('A1:' . $highestColumn . '1', null, true, false)[1] ?? [];
                $headings = array_map(fn($val) => strtolower(trim((string)$val)), $firstRow);

                if (in_array('opsi_a', $headings) || in_array('opsi_b', $headings)) {
                    $sheetsToImport[$name] = $pgImport;
                } elseif (in_array('kunci_jawaban_esai', $headings)) {
                    $sheetsToImport[$name] = $esaiImport;
                } else {
                    // Match by sheet name case-insensitive
                    $cleanedName = strtolower(str_replace(['_', '-'], ' ', trim($name)));
                    if (str_contains($cleanedName, 'ganda') || str_contains($cleanedName, 'pg') || str_contains($cleanedName, 'pilihan')) {
                        $sheetsToImport[$name] = $pgImport;
                    } elseif (str_contains($cleanedName, 'esai') || str_contains($cleanedName, 'essay')) {
                        $sheetsToImport[$name] = $esaiImport;
                    }
                }
            }
            $spreadsheet->disconnectWorksheets();
            unset($spreadsheet);
        } catch (\Exception $e) {
            Log::warning('Excel sheet inspection failed: ' . $e->getMessage());
        }

        // Fallback jika tidak terdeteksi otomatis, gunakan default sheet names
        if (empty($sheetsToImport)) {
            $sheetsToImport = [
                'Pilihan Ganda' => $pgImport,
                'Esai'          => $esaiImport,
            ];
        }

        try {
            Excel::import(
                new class($sheetsToImport) implements \Maatwebsite\Excel\Concerns\WithMultipleSheets {
                    public function __construct(protected array $sheetsMap) {}

                    public function sheets(): array {
                        return $this->sheetsMap;
                    }
                },
                $excelFullPath
            );
        } catch (\Exception $e) {
            Notification::make()->title('Gagal membaca file Excel')->body($e->getMessage())->danger()->send();
            Storage::disk('public')->delete($excelPath);
            return;
        }

        $parsedPG   = $pgImport->getRows();
        $parsedEsai = $esaiImport->getRows();

        // Simpan data besar ke Session, bukan ke Livewire state
        Session::put(self::SESSION_KEY_PG,   $parsedPG);
        Session::put(self::SESSION_KEY_ESAI, $parsedEsai);

        // Hanya statistik ringkasan di Livewire state
        $this->pgValidCount   = count(array_filter($parsedPG,   fn ($r) => $r['status'] === 'valid'));
        $this->pgErrorCount   = count(array_filter($parsedPG,   fn ($r) => $r['status'] === 'error'));
        $this->esaiValidCount = count(array_filter($parsedEsai, fn ($r) => $r['status'] === 'valid'));
        $this->esaiErrorCount = count(array_filter($parsedEsai, fn ($r) => $r['status'] === 'error'));
        $this->isParsed       = true;

        // Hapus file excel temp (gambar masih disimpan untuk commit)
        Storage::disk('public')->delete($excelPath);

        $totalValid = $this->pgValidCount + $this->esaiValidCount;
        $totalError = $this->pgErrorCount + $this->esaiErrorCount;

        Notification::make()
            ->title("Parsing selesai: {$totalValid} valid, {$totalError} error")
            ->color($totalError > 0 ? 'warning' : 'success')
            ->send();
    }

    // ── Commit: Simpan baris valid ke DB ───────────────────────────────────
    public function simpanSoal(): void
    {
        Log::info('ImportBankSoal::simpanSoal() called.', [
            'isParsed'    => $this->isParsed,
            'pgValid'     => $this->pgValidCount,
            'esaiValid'   => $this->esaiValidCount,
        ]);

        if (!$this->isParsed) {
            Log::warning('simpanSoal aborted: isParsed is false.');
            return;
        }

        // Ambil data dari Session
        $parsedPG   = Session::get(self::SESSION_KEY_PG, []);
        $parsedEsai = Session::get(self::SESSION_KEY_ESAI, []);

        Log::info('Data from session:', [
            'pg_count'   => count($parsedPG),
            'esai_count' => count($parsedEsai),
        ]);

        $savedPG      = 0;
        $savedEsai    = 0;
        $skippedCount = 0;
        $duplicateCount = 0;
        $this->commitErrors = [];
        $savedPerJenjang    = [];

        // Pindahkan gambar dari temp ke permanent
        $moveImage = function (?string $tempPath): ?string {
            if (!$tempPath) return null;
            $fileName = basename($tempPath);
            $permPath = 'bank_soal/' . $fileName;
            if (Storage::disk('public')->exists($tempPath)) {
                Storage::disk('public')->move($tempPath, $permPath);
            }
            return $permPath;
        };

        // Simpan Pilihan Ganda
        foreach ($parsedPG as $row) {
            if ($row['status'] !== 'valid') {
                $skippedCount++;
                continue;
            }
            try {
                // Cek duplikat sebelum simpan
                $isDuplicate = BankSoalModel::where('mapel_id', $row['mapel_id'])
                    ->where('tipe_soal', 'pilihan_ganda')
                    ->whereRaw('LOWER(TRIM(pertanyaan)) = ?', [mb_strtolower(trim($row['pertanyaan']))])
                    ->exists();

                if ($isDuplicate) {
                    $duplicateCount++;
                    continue;
                }

                $soal = BankSoalModel::create([
                    'mapel_id'    => $row['mapel_id'],
                    'kelas_id'    => $row['kelas_id'],
                    'tipe_soal'   => 'pilihan_ganda',
                    'pertanyaan'  => $row['pertanyaan'],
                    'gambar_soal' => $moveImage($row['gambar_soal']),
                ]);

                foreach (['a', 'b', 'c', 'd'] as $label) {
                    OpsiJawaban::create([
                        'bank_soal_id' => $soal->id,
                        'label'        => strtoupper($label),
                        'teks'         => $row['opsi'][$label]['teks'],
                        'gambar'       => $moveImage($row['opsi'][$label]['gambar_path']),
                        'is_benar'     => strtoupper($label) === $row['jawaban_benar'],
                    ]);
                }
                $savedPG++;
                $jenName = $row['jenjang_nama'] ?: 'Tanpa Jenjang';
                $savedPerJenjang[$jenName] = ($savedPerJenjang[$jenName] ?? 0) + 1;
            } catch (\Exception $e) {
                Log::error('Commit PG error row '.$row['row_num'].': '.$e->getMessage());
                $this->commitErrors[] = "Baris {$row['row_num']} (PG): " . $e->getMessage();
                $skippedCount++;
            }
        }

        // Simpan Esai
        foreach ($parsedEsai as $row) {
            if ($row['status'] !== 'valid') {
                $skippedCount++;
                continue;
            }
            try {
                // Cek duplikat sebelum simpan
                $isDuplicate = BankSoalModel::where('mapel_id', $row['mapel_id'])
                    ->where('tipe_soal', 'esai')
                    ->whereRaw('LOWER(TRIM(pertanyaan)) = ?', [mb_strtolower(trim($row['pertanyaan']))])
                    ->exists();

                if ($isDuplicate) {
                    $duplicateCount++;
                    continue;
                }

                BankSoalModel::create([
                    'mapel_id'           => $row['mapel_id'],
                    'kelas_id'           => $row['kelas_id'],
                    'tipe_soal'          => 'esai',
                    'pertanyaan'         => $row['pertanyaan'],
                    'gambar_soal'        => $moveImage($row['gambar_soal']),
                    'kunci_jawaban_esai' => $row['kunci_jawaban_esai'],
                ]);
                $savedEsai++;
                $jenName = $row['jenjang_nama'] ?: 'Tanpa Jenjang';
                $savedPerJenjang[$jenName] = ($savedPerJenjang[$jenName] ?? 0) + 1;
            } catch (\Exception $e) {
                Log::error('Commit Esai error row '.$row['row_num'].': '.$e->getMessage());
                $this->commitErrors[] = "Baris {$row['row_num']} (Esai): " . $e->getMessage();
                $skippedCount++;
            }
        }

        $total = $savedPG + $savedEsai;
        $body  = "{$total} soal berhasil disimpan ({$savedPG} pilihan ganda, {$savedEsai} esai)";
        if ($duplicateCount > 0) {
            $body .= ", {$duplicateCount} soal dilewati (duplikat sudah ada di bank soal)";
        }
        if ($skippedCount > 0) {
            $body .= ", {$skippedCount} baris dilewati karena error";
        }
        $body .= ".";

        $notifColor = $duplicateCount > 0 || $skippedCount > 0 ? 'warning' : 'success';
        if ($total === 0 && $duplicateCount > 0) {
            $notifColor = 'warning';
        }

        if (count($savedPerJenjang) > 0) {
            $breakdowns = [];
            foreach ($savedPerJenjang as $jName => $cnt) {
                $breakdowns[] = "{$jName}: {$cnt} soal";
            }
            $body .= " Rincian: " . implode(', ', $breakdowns);
        }

        Log::info('Commit selesai: '.$body);

        Notification::make()
            ->title("Proses Simpan Selesai")
            ->body($body)
            ->color($notifColor)
            ->send();

        $this->resetState();
    }

    public function uploadUlang(): void
    {
        Log::info('ImportBankSoal::uploadUlang() called.');
        $this->resetState();
    }

    private function resetState(): void
    {
        $this->isParsed       = false;
        $this->pgValidCount   = 0;
        $this->pgErrorCount   = 0;
        $this->esaiValidCount = 0;
        $this->esaiErrorCount = 0;
        $this->excelFile      = null;
        $this->imageFiles     = [];
        Session::forget([self::SESSION_KEY_PG, self::SESSION_KEY_ESAI]);
    }

    // Computed helpers tetap ada (baca dari property ringkasan)
    #[Computed]
    public function pgValid(): int   { return $this->pgValidCount; }

    #[Computed]
    public function pgError(): int   { return $this->pgErrorCount; }

    #[Computed]
    public function esaiValid(): int { return $this->esaiValidCount; }

    #[Computed]
    public function esaiError(): int { return $this->esaiErrorCount; }
}
