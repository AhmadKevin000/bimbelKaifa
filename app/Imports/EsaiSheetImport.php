<?php

namespace App\Imports;

use App\Models\Kelas;
use App\Models\Mapel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;

class EsaiSheetImport implements ToCollection, WithHeadingRow
{
    protected array $uploadedImages;
    protected array $rows = [];

    public function __construct(array $uploadedImages = [])
    {
        $this->uploadedImages = $uploadedImages;
    }

    public function collection(Collection $collection): void
    {
        foreach ($collection as $index => $row) {
            $rowNum = $index + 2;
            $errors = [];

            $pertanyaan  = trim((string) ($row['pertanyaan'] ?? ''));
            $jenjangNama = trim((string) ($row['jenjang'] ?? ''));
            $mapelNama   = trim((string) ($row['mapel'] ?? ''));

            // Skip baris kosong (sisa trailing rows dari Excel)
            if (empty($pertanyaan) && empty($jenjangNama) && empty($mapelNama)) {
                continue;
            }

            if (empty($pertanyaan)) {
                $errors[] = 'Kolom pertanyaan tidak boleh kosong.';
            }

            // ── Cari Kelas (EXACT MATCH ke kelas.nama_kelas) ──────────────
            $kelasValue = preg_replace('/\s+/', ' ', trim($jenjangNama)); // Normalisasi whitespace
            $kelas = null;
            $kelasId = null;

            if ($kelasValue) {
                $kelas = Kelas::where('nama_kelas', $kelasValue)->first();
                if (!$kelas) {
                    $errors[] = "Kelas \"{$kelasValue}\" tidak ditemukan. Silakan tambahkan master kelas terlebih dahulu atau perbaiki file Excel.";
                } else {
                    $kelasId = $kelas->id;
                }
            } else {
                $errors[] = 'Kolom jenjang (kelas) harus diisi.';
            }

            // ── Cari Mapel ────────────────────────────────────────────────
            $mapel = null;
            if ($jenjangNama && $mapelNama) {
                // 1. Coba exact match ke table Jenjang
                $mapel = Mapel::whereHas('jenjang', fn ($q) => $q->where('nama', $jenjangNama))
                    ->where('nama', $mapelNama)
                    ->first();

                // 2. Jika tidak ditemukan, coba cari berdasarkan Kelas yang terdaftar
                if (!$mapel && $kelas) {
                    $jenjangNamaDariKelas = $kelas->jenjang; // Menggunakan accessor getJenjangAttribute()
                    if ($jenjangNamaDariKelas && $jenjangNamaDariKelas !== '-') {
                        $mapel = Mapel::whereHas('jenjang', fn ($q) => $q->where('nama', $jenjangNamaDariKelas))
                            ->where('nama', $mapelNama)
                            ->first();
                    }
                }

                if (!$mapel) {
                    $errors[] = "Mata pelajaran \"{$mapelNama}\" tidak ditemukan untuk jenjang/kelas \"{$jenjangNama}\".";
                }
            } else {
                if (empty($mapelNama)) {
                    $errors[] = 'Kolom mapel harus diisi.';
                }
            }

            // kunci_jawaban_esai boleh kosong (opsional)
            $kunciJawaban = trim((string) ($row['kunci_jawaban_esai'] ?? ''));

            // Validasi gambar soal (dengan fallback header & case-insensitive)
            $gambarSoalNama = trim((string) (
                $row['gambar_soal'] ?? 
                $row['gambar'] ?? 
                $row['gambar_soal_esai'] ?? 
                $row['gambar_pertanyaan'] ?? 
                ''
            ));
            $gambarSoalPath = null;
            if ($gambarSoalNama !== '') {
                $gambarSoalNamaLower = strtolower($gambarSoalNama);
                if (!array_key_exists($gambarSoalNamaLower, $this->uploadedImages)) {
                    $errors[] = "Gambar tidak ditemukan: {$gambarSoalNama}";
                } else {
                    $gambarSoalPath = $this->uploadedImages[$gambarSoalNamaLower];
                }
            }

            $this->rows[] = [
                'row_num'            => $rowNum,
                'status'             => empty($errors) ? 'valid' : 'error',
                'errors'             => $errors,
                'tipe_soal'          => 'esai',
                'mapel_id'           => $mapel?->id,
                'mapel_nama'         => $mapelNama,
                'kelas_id'           => $kelasId,
                'kelas_nama'         => $kelasValue,
                'jenjang_nama'       => $jenjangNama,
                'pertanyaan'         => $pertanyaan,
                'gambar_soal'        => $gambarSoalPath,
                'kunci_jawaban_esai' => $kunciJawaban ?: null,
            ];
        }
    }

    public function getRows(): array
    {
        return $this->rows;
    }
}
