<?php

namespace App\Imports;

use App\Models\Kelas;
use App\Models\Mapel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;

class PilihanGandaSheetImport implements ToCollection, WithHeadingRow
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
            $rowNum = $index + 2; // +2 karena row 1 = heading
            $errors = [];

            $pertanyaan  = trim((string) ($row['pertanyaan'] ?? ''));
            $jenjangNama = trim((string) ($row['jenjang'] ?? ''));
            $mapelNama   = trim((string) ($row['mapel'] ?? ''));

            // Skip baris kosong (sisa trailing rows dari Excel)
            if (empty($pertanyaan) && empty($jenjangNama) && empty($mapelNama)) {
                continue;
            }

            // Validasi kolom wajib
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

            $jawabanBenar = strtoupper(trim((string) ($row['jawaban_benar'] ?? '')));
            if (!in_array($jawabanBenar, ['A', 'B', 'C', 'D'])) {
                $errors[] = 'Kolom jawaban_benar harus salah satu A/B/C/D.';
            }

            // Validasi opsi A-D: minimal teks ATAU gambar
            $opsiLabels = ['a', 'b', 'c', 'd'];
            $opsiData = [];
            foreach ($opsiLabels as $label) {
                $teks   = trim((string) ($row["opsi_{$label}"] ?? $row["pilihan_{$label}"] ?? ''));
                $gambar = trim((string) (
                    $row["gambar_opsi_{$label}"] ?? 
                    $row["gambar_{$label}"] ?? 
                    $row["gambar_opsi_" . $label] ?? 
                    $row["opsi_{$label}_gambar"] ?? 
                    ''
                ));
                if (empty($teks) && empty($gambar)) {
                    $errors[] = "Opsi " . strtoupper($label) . ": minimal teks atau gambar harus diisi.";
                }
                $opsiData[$label] = ['teks' => $teks ?: null, 'gambar_nama' => $gambar ?: null];
            }

            // Validasi gambar soal (dengan fallback header & case-insensitive)
            $gambarSoalNama = trim((string) (
                $row['gambar_soal'] ?? 
                $row['gambar'] ?? 
                $row['gambar_soal_pg'] ?? 
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

            // Validasi gambar opsi (case-insensitive)
            foreach ($opsiLabels as $label) {
                $gambarNama = $opsiData[$label]['gambar_nama'];
                if ($gambarNama) {
                    $gambarNamaLower = strtolower($gambarNama);
                    if (!array_key_exists($gambarNamaLower, $this->uploadedImages)) {
                        $errors[] = "Gambar tidak ditemukan: {$gambarNama}";
                        $opsiData[$label]['gambar_path'] = null;
                    } else {
                        $opsiData[$label]['gambar_path'] = $this->uploadedImages[$gambarNamaLower];
                    }
                } else {
                    $opsiData[$label]['gambar_path'] = null;
                }
            }

            $this->rows[] = [
                'row_num'        => $rowNum,
                'status'         => empty($errors) ? 'valid' : 'error',
                'errors'         => $errors,
                'tipe_soal'      => 'pilihan_ganda',
                'mapel_id'       => $mapel?->id,
                'mapel_nama'     => $mapelNama,
                'kelas_id'       => $kelasId,
                'kelas_nama'     => $kelasValue,
                'jenjang_nama'   => $jenjangNama,
                'pertanyaan'     => $pertanyaan,
                'gambar_soal'    => $gambarSoalPath,
                'jawaban_benar'  => $jawabanBenar,
                'opsi'           => $opsiData,
            ];
        }
    }

    public function getRows(): array
    {
        return $this->rows;
    }
}
