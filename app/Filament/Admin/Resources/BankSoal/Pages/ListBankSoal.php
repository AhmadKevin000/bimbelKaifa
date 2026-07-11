<?php

namespace App\Filament\Admin\Resources\BankSoal\Pages;

use App\Filament\Admin\Resources\BankSoal\BankSoalResource;
use App\Models\BankSoal as BankSoalModel;
use App\Models\Jenjang;
use App\Models\Mapel;
use App\Models\OpsiJawaban;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ListBankSoal extends Page
{
    use WithFileUploads;
    use WithPagination;

    protected static string $resource = BankSoalResource::class;
    protected string $view = 'filament.admin.resources.bank-soal.pages.list-bank-soal';

    protected $paginationTheme = 'tailwind';

    // ── State navigasi 3-tingkat (Jenjang, Kelas & Mapel) ──────────────────
    #[Url]
    public ?int $selectedKelasId = null;
    public ?string $selectedKelasNama = null;

    #[Url]
    public ?int $selectedMapelId = null;

    #[Url]
    public ?int $filterJenjangId = null; // Filter kelas berdasarkan jenjang card

    public function mount(): void
    {
        if ($this->selectedKelasId && !$this->selectedKelasNama) {
            $kelas = \App\Models\Kelas::find($this->selectedKelasId);
            if ($kelas) {
                $this->selectedKelasNama = $kelas->nama_kelas;
            }
        }
    }

    // ── Filter & Search ────────────────────────────────────────────────────
    public string $search = '';

    // ── Modal Tambah / Edit Soal ───────────────────────────────────────────
    public bool $showModal = false;
    public ?int $editingId = null;
    public string $modalMode = 'pilihan_ganda'; // pilihan_ganda | esai

    // Form fields
    public ?int $formMapelId = null;
    public ?int $formKelasId = null;
    public string $formPertanyaan = '';
    public $formGambarSoal = null;
    public string $formKunciEsai = '';

    // Opsi PG: array [label => [teks, gambar, is_benar]]
    public array $formOpsi = [
        'A' => ['teks' => '', 'gambar' => null, 'is_benar' => false],
        'B' => ['teks' => '', 'gambar' => null, 'is_benar' => false],
        'C' => ['teks' => '', 'gambar' => null, 'is_benar' => false],
        'D' => ['teks' => '', 'gambar' => null, 'is_benar' => false],
    ];
    public string $formJawabanBenar = 'A'; // label yang benar untuk PG

    // ── Konfirmasi hapus ───────────────────────────────────────────────────
    public ?int $confirmDeleteId = null;

    // ── Bulk Actions ───────────────────────────────────────────────────────
    public array $selectedSoalBulk = [];
    public bool $selectAll = false;
    public bool $showBulkDeleteModal = false;

    // ── Computed: data grid jenjang ────────────────────────────────────────
    #[Computed]
    public function jenjangGrid(): array
    {
        $jenjangs = Jenjang::withCount('mapels')->get();

        $soalCounts = BankSoalModel::join('mapel', 'bank_soals.mapel_id', '=', 'mapel.id')
            ->select('mapel.jenjang_id', DB::raw('count(bank_soals.id) as total'))
            ->groupBy('mapel.jenjang_id')
            ->pluck('total', 'jenjang_id')
            ->toArray();

        $mapelPunyaSoalCounts = Mapel::has('bankSoals')
            ->select('jenjang_id', DB::raw('count(id) as total'))
            ->groupBy('jenjang_id')
            ->pluck('total', 'jenjang_id')
            ->toArray();

        return $jenjangs->map(function (Jenjang $j) use ($soalCounts, $mapelPunyaSoalCounts) {
            return [
                'id'               => $j->id,
                'nama'             => $j->nama,
                'total_soal'       => $soalCounts[$j->id] ?? 0,
                'mapel_punya_soal' => $mapelPunyaSoalCounts[$j->id] ?? 0,
                'total_mapel'      => $j->mapels_count,
            ];
        })
        ->toArray();
    }

    // ── Computed: data tabel kelas ──────────────────────────────────────────
    #[Computed]
    public function kelasTable(): array
    {
        $kelasQuery = \App\Models\Kelas::with(['pengajaran.mapel.jenjang'])
            ->withCount('bankSoals')
            ->when($this->filterJenjangId, function ($query) {
                $query->whereHas('pengajaran.mapel', function ($q) {
                    $q->where('jenjang_id', $this->filterJenjangId);
                });
            })
            ->get();

        $mapelWithSoalCounts = BankSoalModel::select('kelas_id', DB::raw('count(distinct mapel_id) as total'))
            ->groupBy('kelas_id')
            ->pluck('total', 'kelas_id')
            ->toArray();

        return $kelasQuery->map(function (\App\Models\Kelas $k) use ($mapelWithSoalCounts) {
            $mapelIds = $k->pengajaran->pluck('mapel_id')->unique()->toArray();
            
            // Get Jenjang name
            $jenjangNama = '-';
            $firstTeaching = $k->pengajaran->first();
            if ($firstTeaching && $firstTeaching->mapel && $firstTeaching->mapel->jenjang) {
                $jenjangNama = $firstTeaching->mapel->jenjang->nama;
            }

            return [
                'id'               => $k->id,
                'nama'             => $k->nama_kelas,
                'total_soal'       => $k->bank_soals_count,
                'mapel_punya_soal' => $mapelWithSoalCounts[$k->id] ?? 0,
                'total_mapel'      => count($mapelIds),
                'jenjang_nama'     => $jenjangNama,
                'keterangan'       => $k->keterangan ?? '-',
            ];
        })
        ->toArray();
    }

    // ── Computed: mapel terdaftar di kelas ───────────────────────────────
    #[Computed]
    public function mapelsInKelas(): array
    {
        if (!$this->selectedKelasId) return [];

        $soalCounts = BankSoalModel::where('kelas_id', $this->selectedKelasId)
            ->select('mapel_id', DB::raw('count(id) as total'))
            ->groupBy('mapel_id')
            ->pluck('total', 'mapel_id')
            ->toArray();

        $mapels = Mapel::whereHas('pengajaran', function ($q) {
            $q->where('kelas_id', $this->selectedKelasId);
        })->get();

        return $mapels->map(function (Mapel $m) use ($soalCounts) {
            return [
                'id' => $m->id,
                'nama' => $m->nama,
                'soal_count' => $soalCounts[$m->id] ?? 0,
            ];
        })
        ->toArray();
    }

    // ── Computed: soal list (paginated) per mapel ─────────────────────────
    #[Computed]
    public function soalPaginator()
    {
        if (!$this->selectedKelasId || !$this->selectedMapelId) return null;

        return BankSoalModel::with(['mapel', 'opsiJawaban'])
            ->where('mapel_id', $this->selectedMapelId)
            ->where('kelas_id', $this->selectedKelasId)
            ->when($this->search, fn ($q) => $q->where('pertanyaan', 'like', '%' . $this->search . '%'))
            ->orderBy('id', 'desc')
            ->paginate(20);
    }

    // ── Computed: total soal kelas terpilih ──────────────────────────────
    #[Computed]
    public function totalSoalKelas(): int
    {
        if (!$this->selectedKelasId) return 0;
        return BankSoalModel::where('kelas_id', $this->selectedKelasId)->count();
    }

    // ── Computed: mapel options untuk filter & form ───────────────────────
    #[Computed]
    public function mapelOptions(): array
    {
        if (!$this->selectedKelasId) return [];
        return Mapel::whereHas('pengajaran', function ($q) {
            $q->where('kelas_id', $this->selectedKelasId);
        })
        ->pluck('nama', 'id')
        ->toArray();
    }

    #[Computed]
    public function kelasOptions(): array
    {
        return \App\Models\Kelas::pluck('nama_kelas', 'id')->toArray();
    }

    // ── Navigasi ──────────────────────────────────────────────────────────
    public function toggleJenjangFilter(int $id): void
    {
        if ($this->filterJenjangId === $id) {
            $this->filterJenjangId = null;
        } else {
            $this->filterJenjangId = $id;
        }
    }

    public function selectKelas(int $id, string $nama): void
    {
        $this->selectedKelasId  = $id;
        $this->selectedKelasNama = $nama;

        // Auto select first mapel if available
        $mapels = Mapel::whereHas('pengajaran', function ($q) use ($id) {
            $q->where('kelas_id', $id);
        })->get();
        
        $this->selectedMapelId = $mapels->isNotEmpty() ? $mapels->first()->id : null;

        $this->selectedSoalBulk = [];
        $this->selectAll = false;
        $this->resetPage();
        $this->search = '';
    }

    public function selectMapel(int $mapelId): void
    {
        $this->selectedMapelId = $mapelId;
        $this->selectedSoalBulk = [];
        $this->selectAll = false;
        $this->resetPage();
        $this->search = '';
    }

    public function backToGrid(): void
    {
        $this->selectedKelasId   = null;
        $this->selectedKelasNama = null;
        $this->selectedMapelId   = null;
        $this->selectedSoalBulk  = [];
        $this->selectAll         = false;
        $this->resetPage();
        unset($this->kelasTable);
    }

    // ── Cegah Filament menambahkan back button otomatis ke halaman sebelumnya ──
    public function getBackUrl(): ?string
    {
        return null;
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('back_to_grid')
                ->label('Kembali ke Daftar Kelas')
                ->icon('heroicon-m-arrow-left')
                ->color('gray')
                ->outlined()
                ->action(fn () => $this->backToGrid())
                ->visible(fn () => $this->selectedKelasId !== null),
        ];
    }

    // ── Reset page saat filter berubah ────────────────────────────────────
    public function updatedSearch(): void { $this->resetPage(); }

    protected function getSelectedJenjangId(): ?int
    {
        if (!$this->selectedKelasId) return null;
        $firstTeaching = \App\Models\Pengajaran::with('mapel.jenjang')
            ->where('kelas_id', $this->selectedKelasId)
            ->first();
        return $firstTeaching?->mapel?->jenjang_id;
    }

    // ── Modal: Tambah Soal ────────────────────────────────────────────────
    public function openAddModal(): void
    {
        $this->resetModalForm();
        $this->editingId = null;
        // Pre-fill kelas_id dari kelas yang sedang dipilih
        $this->formKelasId = $this->selectedKelasId;
        $this->showModal = true;
    }

    // ── Modal: Edit Soal ──────────────────────────────────────────────────
    public function editSoal(int $id): void
    {
        $soal = BankSoalModel::with('opsiJawaban')->findOrFail($id);
        $this->editingId        = $id;
        $this->modalMode        = $soal->tipe_soal;
        $this->formMapelId      = $soal->mapel_id;
        $this->formKelasId      = $soal->kelas_id;
        $this->formPertanyaan   = $soal->pertanyaan;
        $this->formGambarSoal   = null; // reset upload
        $this->formKunciEsai    = $soal->kunci_jawaban_esai ?? '';
        $this->formJawabanBenar = 'A';

        $this->formOpsi = [
            'A' => ['teks' => '', 'gambar' => null, 'is_benar' => false],
            'B' => ['teks' => '', 'gambar' => null, 'is_benar' => false],
            'C' => ['teks' => '', 'gambar' => null, 'is_benar' => false],
            'D' => ['teks' => '', 'gambar' => null, 'is_benar' => false],
        ];

        foreach ($soal->opsiJawaban as $opsi) {
            $lbl = $opsi->label; // A/B/C/D
            $this->formOpsi[$lbl] = [
                'teks'     => $opsi->teks ?? '',
                'gambar'   => null,
                'is_benar' => (bool) $opsi->is_benar,
            ];
            if ($opsi->is_benar) {
                $this->formJawabanBenar = $lbl;
            }
        }

        $this->showModal = true;
    }

    // ── Modal: Simpan ─────────────────────────────────────────────────────
    public function simpanSoal(): void
    {
        $this->validate([
            'formMapelId'    => 'required|exists:mapel,id',
            'formKelasId'    => 'required|exists:kelas,id',
            'formPertanyaan' => 'required|string|min:5',
            'formGambarSoal' => 'nullable|image|max:5120',
        ]);

        // ── Validasi duplikat ─────────────────────────────────────────────
        $dupQuery = BankSoalModel::where('mapel_id', $this->formMapelId)
            ->where('tipe_soal', $this->modalMode)
            ->whereRaw('LOWER(TRIM(pertanyaan)) = ?', [mb_strtolower(trim($this->formPertanyaan))]);

        // Saat mode edit, exclude soal yang sedang diedit
        if ($this->editingId) {
            $dupQuery->where('id', '!=', $this->editingId);
        }

        if ($dupQuery->exists()) {
            Notification::make()
                ->title('Soal Duplikat')
                ->body('Soal dengan pertanyaan, mapel, dan tipe yang sama sudah ada di bank soal.')
                ->warning()
                ->send();
            return;
        }

        // Simpan atau update gambar soal
        $gambarPath = null;
        if ($this->formGambarSoal) {
            $gambarPath = $this->formGambarSoal->store('bank_soal', 'public');
        }

        $data = [
            'mapel_id'   => $this->formMapelId,
            'kelas_id'   => $this->formKelasId,
            'tipe_soal'  => $this->modalMode,
            'pertanyaan' => $this->formPertanyaan,
        ];

        if ($gambarPath) {
            $data['gambar_soal'] = $gambarPath;
        }

        if ($this->modalMode === 'esai') {
            $data['kunci_jawaban_esai'] = $this->formKunciEsai ?: null;
        }

        if ($this->editingId) {
            $soal = BankSoalModel::findOrFail($this->editingId);
            $soal->update($data);

            if ($this->modalMode === 'pilihan_ganda') {
                foreach (['A', 'B', 'C', 'D'] as $lbl) {
                    $opsiData = [
                        'teks'     => $this->formOpsi[$lbl]['teks'] ?: null,
                        'is_benar' => ($lbl === $this->formJawabanBenar),
                    ];
                    if ($this->formOpsi[$lbl]['gambar']) {
                        $opsiData['gambar'] = $this->formOpsi[$lbl]['gambar']->store('bank_soal', 'public');
                    }
                    OpsiJawaban::updateOrCreate(
                        ['bank_soal_id' => $soal->id, 'label' => $lbl],
                        $opsiData
                    );
                }
            }

            Notification::make()->title('Soal berhasil diperbarui')->success()->send();
        } else {
            $soal = BankSoalModel::create($data);

            if ($this->modalMode === 'pilihan_ganda') {
                foreach (['A', 'B', 'C', 'D'] as $lbl) {
                    $opsiData = [
                        'bank_soal_id' => $soal->id,
                        'label'        => $lbl,
                        'teks'         => $this->formOpsi[$lbl]['teks'] ?: null,
                        'is_benar'     => ($lbl === $this->formJawabanBenar),
                    ];
                    if ($this->formOpsi[$lbl]['gambar']) {
                        $opsiData['gambar'] = $this->formOpsi[$lbl]['gambar']->store('bank_soal', 'public');
                    }
                    OpsiJawaban::create($opsiData);
                }
            }

            Notification::make()->title('Soal berhasil ditambahkan')->success()->send();
        }

        $this->showModal = false;
        $this->resetModalForm();
        // Reset computed property cache (Livewire v3)
        unset($this->soalPaginator);
        unset($this->kelasTable);
        unset($this->mapelsInKelas);
        unset($this->totalSoalKelas);
        unset($this->jenjangGrid);
    }

    // ── Hapus ─────────────────────────────────────────────────────────────
    public function konfirmasiHapus(int $id): void
    {
        $this->confirmDeleteId = $id;
    }

    public function batalHapus(): void
    {
        $this->confirmDeleteId = null;
    }

    public function hapusSoal(): void
    {
        if (! $this->confirmDeleteId) return;

        $soal = BankSoalModel::findOrFail($this->confirmDeleteId);

        // Hapus gambar soal jika ada
        if ($soal->gambar_soal && Storage::disk('public')->exists($soal->gambar_soal)) {
            Storage::disk('public')->delete($soal->gambar_soal);
        }

        // Hapus gambar opsi
        foreach ($soal->opsiJawaban as $opsi) {
            if ($opsi->gambar && Storage::disk('public')->exists($opsi->gambar)) {
                Storage::disk('public')->delete($opsi->gambar);
            }
        }

        $soal->delete();

        $this->confirmDeleteId = null;
        Notification::make()->title('Soal berhasil dihapus')->success()->send();
        unset($this->soalPaginator);
        unset($this->kelasTable);
        unset($this->mapelsInKelas);
        unset($this->totalSoalKelas);
        unset($this->jenjangGrid);
    }

    // ── Bulk Delete Actions ────────────────────────────────────────────────
    public function updatedSelectAll($value): void
    {
        if ($value) {
            $this->selectedSoalBulk = $this->soalPaginator 
                ? $this->soalPaginator->pluck('id')->map(fn($id) => (string)$id)->toArray() 
                : [];
        } else {
            $this->selectedSoalBulk = [];
        }
    }

    public function updatedSelectedSoalBulk(): void
    {
        if (!$this->soalPaginator) {
            $this->selectAll = false;
            return;
        }

        $currentPageIds = $this->soalPaginator->pluck('id')->map(fn($id) => (string)$id)->toArray();
        if (empty($currentPageIds)) {
            $this->selectAll = false;
            return;
        }

        $selectedOnCurrentPage = array_intersect($this->selectedSoalBulk, $currentPageIds);
        $this->selectAll = count($selectedOnCurrentPage) === count($currentPageIds);
    }

    public function confirmBulkDelete(): void
    {
        if (empty($this->selectedSoalBulk)) {
            Notification::make()->title('Pilih setidaknya satu soal')->warning()->send();
            return;
        }
        $this->showBulkDeleteModal = true;
    }

    public function batalBulkDelete(): void
    {
        $this->showBulkDeleteModal = false;
    }

    public function bulkDeleteSoal(): void
    {
        if (empty($this->selectedSoalBulk)) return;

        $soals = BankSoalModel::whereIn('id', $this->selectedSoalBulk)->get();

        foreach ($soals as $soal) {
            if ($soal->gambar_soal && Storage::disk('public')->exists($soal->gambar_soal)) {
                Storage::disk('public')->delete($soal->gambar_soal);
            }

            foreach ($soal->opsiJawaban as $opsi) {
                if ($opsi->gambar && Storage::disk('public')->exists($opsi->gambar)) {
                    Storage::disk('public')->delete($opsi->gambar);
                }
            }

            $soal->delete();
        }

        $this->selectedSoalBulk = [];
        $this->selectAll = false;
        $this->showBulkDeleteModal = false;

        Notification::make()->title('Soal yang dipilih berhasil dihapus')->success()->send();

        unset($this->soalPaginator);
        unset($this->kelasTable);
        unset($this->mapelsInKelas);
        unset($this->totalSoalKelas);
        unset($this->jenjangGrid);
    }

    // ── Helpers ───────────────────────────────────────────────────────────
    protected function resetModalForm(): void
    {
        $this->modalMode        = 'pilihan_ganda';
        $this->formMapelId      = null;
        $this->formKelasId      = null;
        $this->formPertanyaan   = '';
        $this->formGambarSoal   = null;
        $this->formKunciEsai    = '';
        $this->formJawabanBenar = 'A';
        $this->formOpsi = [
            'A' => ['teks' => '', 'gambar' => null, 'is_benar' => false],
            'B' => ['teks' => '', 'gambar' => null, 'is_benar' => false],
            'C' => ['teks' => '', 'gambar' => null, 'is_benar' => false],
            'D' => ['teks' => '', 'gambar' => null, 'is_benar' => false],
        ];
    }

    public function getTemplateUrl(): string
    {
        return route('bank-soal.template') . ($this->selectedKelasId ? '?kelas_id=' . $this->selectedKelasId : '');
    }

    public function getImportUrl(): string
    {
        $jenjangId = $this->getSelectedJenjangId();
        return ImportBankSoal::getUrl(parameters: $jenjangId ? ['jenjang_id' => $jenjangId] : []);
    }

    // ── Warna card per index ──────────────────────────────────────────────
    public function cardGradient(int $index): string
    {
        $gradients = [
            'linear-gradient(135deg, #6366f1, #8b5cf6)',
            'linear-gradient(135deg, #0ea5e9, #38bdf8)',
            'linear-gradient(135deg, #10b981, #34d399)',
            'linear-gradient(135deg, #f59e0b, #fbbf24)',
            'linear-gradient(135deg, #ef4444, #f87171)',
            'linear-gradient(135deg, #14b8a6, #2dd4bf)',
            'linear-gradient(135deg, #8b5cf6, #a78bfa)',
            'linear-gradient(135deg, #f97316, #fb923c)',
        ];
        return $gradients[$index % count($gradients)];
    }

    public function cardShadow(int $index): string
    {
        $shadows = [
            'rgba(99,102,241,0.35)',
            'rgba(14,165,233,0.35)',
            'rgba(16,185,129,0.35)',
            'rgba(245,158,11,0.35)',
            'rgba(239,68,68,0.35)',
            'rgba(20,184,166,0.35)',
            'rgba(139,92,246,0.35)',
            'rgba(249,115,22,0.35)',
        ];
        return $shadows[$index % count($shadows)];
    }
}
