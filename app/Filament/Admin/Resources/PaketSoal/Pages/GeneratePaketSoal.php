<?php

namespace App\Filament\Admin\Resources\PaketSoal\Pages;

use App\Filament\Admin\Resources\PaketSoal\PaketSoalResource;
use App\Models\BankSoal;
use App\Models\Jenjang;
use App\Models\Mapel;
use App\Models\PaketSoal as PaketSoalModel;
use App\Models\PaketSoalItem;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Page;
use Livewire\Attributes\Computed;

class GeneratePaketSoal extends Page
{
    protected static string $resource = PaketSoalResource::class;
    protected string $view = 'filament.admin.resources.paket-soal.pages.generate-paket-soal';

    // ── Wizard State ───────────────────────────────────────────────────────
    public int $step = 1; // Step 1: Jenjang & Mapel, Step 2: Metode & Soal, Step 3: Preview & Submit

    // Step 1 Fields
    public array $selectedJenjangIds = []; // Bisa pilih beberapa untuk acak
    public ?int $mapel_id = null; // Hanya jika 1 jenjang dipilih
    public ?int $kelas_id = null; // Kelas filter (wajib untuk random query)

    // Step 2 Fields
    public string $metode = 'acak'; // acak | manual
    public ?string $tipe_soal = null; // null = campur, atau 'pilihan_ganda'/'esai'
    public int $jumlah_soal = 10;
    public string $judul = '';
    public array $selectedSoalIds = []; // Checklist untuk manual mode

    // Step 3 State
    public array $paketDibuatList = []; // List paket yang baru saja di-generate
    public array $tempPreviewSoals = []; // Data preview soal di step 3 sebelum disimpan

    // ── Computed Properties ────────────────────────────────────────────────

    #[Computed]
    public function jenjangOptions(): array
    {
        return Jenjang::pluck('nama', 'id')->toArray();
    }

    #[Computed]
    public function mapelOptions(): array
    {
        if (count($this->selectedJenjangIds) !== 1) return [];
        $jenjangId = $this->selectedJenjangIds[0];
        return Mapel::where('jenjang_id', $jenjangId)->pluck('nama', 'id')->toArray();
    }

    #[Computed]
    public function kelasOptions(): array
    {
        return \App\Models\Kelas::pluck('nama_kelas', 'id')->toArray();
    }

    #[Computed]
    public function tersediaSoal(): int
    {
        if (empty($this->selectedJenjangIds)) return 0;
        
        return BankSoal::whereHas('mapel', function ($q) {
                $q->whereIn('jenjang_id', $this->selectedJenjangIds);
            })
            ->when($this->mapel_id, fn ($q) => $q->where('mapel_id', $this->mapel_id))
            ->when($this->kelas_id, fn ($q) => $q->where('kelas_id', $this->kelas_id))
            ->when($this->tipe_soal, fn ($q) => $q->where('tipe_soal', $this->tipe_soal))
            ->count();
    }

    // List Soal untuk manual checklist (Step 2)
    #[Computed]
    public function soalTersediaList(): array
    {
        if (empty($this->selectedJenjangIds)) return [];

        return BankSoal::with(['mapel'])
            ->whereHas('mapel', function ($q) {
                $q->whereIn('jenjang_id', $this->selectedJenjangIds);
            })
            ->when($this->mapel_id, fn ($q) => $q->where('mapel_id', $this->mapel_id))
            ->when($this->kelas_id, fn ($q) => $q->where('kelas_id', $this->kelas_id))
            ->orderBy('id', 'desc')
            ->get()
            ->map(function ($soal) {
                return [
                    'id' => $soal->id,
                    'pertanyaan' => $soal->pertanyaan,
                    'tipe_soal' => $soal->tipe_soal,
                    'mapel_nama' => $soal->mapel->nama,
                    'jenjang_nama' => $soal->mapel->jenjang->nama,
                    'gambar_soal' => $soal->gambar_soal,
                ];
            })
            ->toArray();
    }

    // ── Navigation ─────────────────────────────────────────────────────────

    public function toggleJenjang(int $id): void
    {
        if (in_array($id, $this->selectedJenjangIds)) {
            $this->selectedJenjangIds = array_diff($this->selectedJenjangIds, [$id]);
        } else {
            $this->selectedJenjangIds[] = $id;
        }
        $this->selectedJenjangIds = array_values($this->selectedJenjangIds);
        $this->updatedSelectedJenjangIds();
    }

    public function updatedSelectedJenjangIds(): void
    {
        $this->mapel_id = null;
        $this->kelas_id = null;
        $this->autofillJudul();
    }

    public function updatedMapelId(): void
    {
        $this->autofillJudul();
    }

    public function updatedTipeSoal(): void
    {
        $this->autofillJudul();
    }

    public function updatedKelasId(): void
    {
        $this->autofillJudul();
    }

    protected function autofillJudul(): void
    {
        if (count($this->selectedJenjangIds) === 1) {
            $jenjang = Jenjang::find($this->selectedJenjangIds[0])?->nama;
            $mapel   = $this->mapel_id ? Mapel::find($this->mapel_id)?->nama : '';
            $kelas   = $this->kelas_id ? \App\Models\Kelas::find($this->kelas_id)?->nama_kelas : '';
            $tipe    = match ($this->tipe_soal) {
                'pilihan_ganda' => ' (PG)',
                'esai'          => ' (Esai)',
                default         => '',
            };
            if ($jenjang) {
                $suffix = $kelas ?: $jenjang;
                $this->judul = "Paket Soal " . ($mapel ?: 'Semua Mapel') . " - {$suffix}{$tipe}";
            }
        } else {
            $this->judul = "Paket Soal Multi-Jenjang " . date('d/m/Y H:i');
        }
    }

    public function nextStep(): void
    {
        if ($this->step === 1) {
            $this->validate([
                'selectedJenjangIds' => 'required|array|min:1',
                'mapel_id'           => 'nullable|integer|exists:mapel,id',
            ], [
                'selectedJenjangIds.required' => 'Pilih minimal satu jenjang untuk melanjutkan.',
            ]);

            // Jika pilih > 1 jenjang, mode dipaksa acak (manual checklist hanya masuk akal per jenjang)
            if (count($this->selectedJenjangIds) > 1) {
                $this->metode = 'acak';
            }

            $this->autofillJudul();
            $this->step = 2;
        } elseif ($this->step === 2) {
            if ($this->metode === 'acak') {
                $this->validate([
                    'jumlah_soal' => 'required|integer|min:1|max:200',
                    'judul'       => 'required|string|max:255',
                ]);

                $tersedia = $this->tersediaSoal;
                if ($tersedia === 0) {
                    Notification::make()
                        ->title('Tidak ada soal tersedia')
                        ->body('Kurangi filter atau tambahkan soal di Bank Soal terlebih dahulu.')
                        ->danger()->send();
                    return;
                }

                // Untuk multiple jenjang, pastikan kuota soal per jenjang juga mencukupi (atau minimal ada soal)
                if (count($this->selectedJenjangIds) > 1) {
                    foreach ($this->selectedJenjangIds as $jId) {
                        $count = BankSoal::jenjang($jId)
                            ->when($this->mapel_id, fn ($q) => $q->where('mapel_id', $this->mapel_id))
                            ->when($this->kelas_id, fn ($q) => $q->where('kelas_id', $this->kelas_id))
                            ->when($this->tipe_soal, fn ($q) => $q->where('tipe_soal', $this->tipe_soal))
                            ->count();
                        if ($count < $this->jumlah_soal) {
                            $jName = Jenjang::find($jId)?->nama;
                            Notification::make()
                                ->title("Soal jenjang {$jName} tidak cukup")
                                ->body("Hanya tersedia {$count} soal dari quota {$this->jumlah_soal}. Silakan kurangi jumlah soal.")
                                ->warning()->send();
                            return;
                        }
                    }
                } else {
                    if ($this->jumlah_soal > $tersedia) {
                        Notification::make()
                            ->title("Soal tidak cukup")
                            ->body("Hanya tersedia {$tersedia} soal.")
                            ->warning()->send();
                        return;
                    }
                }
            } else {
                // Manual Mode
                $this->validate([
                    'selectedSoalIds' => 'required|array|min:1',
                    'judul'           => 'required|string|max:255',
                ], [
                    'selectedSoalIds.required' => 'Pilih minimal satu soal untuk dimasukkan ke paket.',
                ]);
            }

            // Build data preview untuk step 3
            $this->buildPreview();
            $this->step = 3;
        }
    }

    public function prevStep(): void
    {
        if ($this->step > 1) {
            $this->step--;
        }
    }

    // ── Preview Generation (Step 3) ────────────────────────────────────────

    protected function buildPreview(): void
    {
        $this->tempPreviewSoals = [];

        if ($this->metode === 'acak') {
            // Kita generate sementara list ID yang akan terpilih
            foreach ($this->selectedJenjangIds as $jId) {
                $jName = Jenjang::find($jId)?->nama;
                $query = BankSoal::with(['mapel', 'opsiJawaban'])
                    ->jenjang($jId)
                    ->when($this->mapel_id, fn ($q) => $q->where('mapel_id', $this->mapel_id))
                    ->when($this->kelas_id, fn ($q) => $q->where('kelas_id', $this->kelas_id))
                    ->when($this->tipe_soal, fn ($q) => $q->where('tipe_soal', $this->tipe_soal));

                $soals = $query->inRandomOrder()->limit($this->jumlah_soal)->get();

                $this->tempPreviewSoals[$jId] = [
                    'jenjang_nama' => $jName,
                    'judul' => count($this->selectedJenjangIds) > 1 ? "{$this->judul} - {$jName}" : $this->judul,
                    'soals' => $soals->map(function ($soal) {
                        return [
                            'id' => $soal->id,
                            'pertanyaan' => $soal->pertanyaan,
                            'tipe_soal' => $soal->tipe_soal,
                            'gambar_soal' => $soal->gambar_soal,
                            'opsi' => $soal->opsiJawaban->map(fn ($o) => [
                                'label' => $o->label,
                                'teks' => $o->teks,
                                'gambar' => $o->gambar,
                            ])->toArray(),
                        ];
                    })->toArray(),
                ];
            }
        } else {
            // Manual Mode (selalu 1 jenjang)
            $jId = $this->selectedJenjangIds[0];
            $jName = Jenjang::find($jId)?->nama;
            $soals = BankSoal::with(['mapel', 'opsiJawaban'])
                ->whereIn('id', $this->selectedSoalIds)
                ->get();

            $this->tempPreviewSoals[$jId] = [
                'jenjang_nama' => $jName,
                'judul' => $this->judul,
                'soals' => $soals->map(function ($soal) {
                    return [
                        'id' => $soal->id,
                        'pertanyaan' => $soal->pertanyaan,
                        'tipe_soal' => $soal->tipe_soal,
                        'gambar_soal' => $soal->gambar_soal,
                        'opsi' => $soal->opsiJawaban->map(fn ($o) => [
                            'label' => $o->label,
                            'teks' => $o->teks,
                            'gambar' => $o->gambar,
                        ])->toArray(),
                    ];
                })->toArray(),
            ];
        }
    }

    // ── Generate: Commit data ke Database ──────────────────────────────────

    public function generate(): void
    {
        $this->paketDibuatList = [];

        foreach ($this->tempPreviewSoals as $jId => $data) {
            // Tentukan mapel_id untuk header paket
            // Jika mode manual / mapel_id diset, pakai itu. Jika tidak, pakai mapel pertama dari kumpulan soal
            $mapelId = $this->mapel_id;
            if (!$mapelId && !empty($data['soals'])) {
                $firstSoal = BankSoal::find($data['soals'][0]['id']);
                $mapelId = $firstSoal?->mapel_id;
            }

            $paket = PaketSoalModel::create([
                'judul'       => $data['judul'],
                'mapel_id'    => $mapelId,
                'dibuat_oleh' => auth()->id(),
            ]);

            foreach ($data['soals'] as $i => $soalData) {
                PaketSoalItem::create([
                    'paket_soal_id' => $paket->id,
                    'bank_soal_id'  => $soalData['id'],
                    'urutan'        => $i + 1,
                ]);
            }

            $this->paketDibuatList[] = [
                'id' => $paket->id,
                'judul' => $paket->judul,
            ];
        }

        Notification::make()
            ->title("Paket soal berhasil dibuat!")
            ->body(count($this->paketDibuatList) . " paket berhasil disimpan ke database.")
            ->success()
            ->send();
            
        // Reset state input tapi tetap di halaman hasil preview
        $this->selectedJenjangIds = [];
        $this->selectedSoalIds = [];
        $this->mapel_id = null;
    }

    public function resetWizard(): void
    {
        $this->step = 1;
        $this->selectedJenjangIds = [];
        $this->selectedSoalIds = [];
        $this->mapel_id = null;
        $this->kelas_id = null;
        $this->paketDibuatList = [];
        $this->tempPreviewSoals = [];
    }
}
