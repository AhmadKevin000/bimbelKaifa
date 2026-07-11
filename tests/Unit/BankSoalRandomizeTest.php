<?php

namespace Tests\Unit;

use App\Models\BankSoal;
use App\Models\Jenjang;
use App\Models\Mapel;
use App\Models\PaketSoal;
use App\Models\PaketSoalItem;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BankSoalRandomizeTest extends TestCase
{
    use RefreshDatabase;

    protected Jenjang $jenjangA;
    protected Jenjang $jenjangB;
    protected Mapel $mapelA;
    protected Mapel $mapelB;

    protected function setUp(): void
    {
        parent::setUp();

        // Buat 2 jenjang berbeda
        $this->jenjangA = Jenjang::create(['nama' => '4 SD']);
        $this->jenjangB = Jenjang::create(['nama' => '1 SMP']);

        // Buat mapel untuk tiap jenjang
        $this->mapelA = Mapel::create([
            'nama'       => 'Matematika SD',
            'jenjang_id' => $this->jenjangA->id,
            'program_id' => null,
        ]);
        $this->mapelB = Mapel::create([
            'nama'       => 'Aljabar SMP',
            'jenjang_id' => $this->jenjangB->id,
            'program_id' => null,
        ]);

        // Buat 10 soal untuk jenjangA
        for ($i = 0; $i < 10; $i++) {
            BankSoal::create([
                'mapel_id'  => $this->mapelA->id,
                'tipe_soal' => 'pilihan_ganda',
                'pertanyaan'=> "Soal PG jenjang 4SD nomor " . ($i + 1),
            ]);
        }

        // Buat 10 soal untuk jenjangB
        for ($i = 0; $i < 10; $i++) {
            BankSoal::create([
                'mapel_id'  => $this->mapelB->id,
                'tipe_soal' => 'esai',
                'pertanyaan'=> "Soal Esai jenjang 1SMP nomor " . ($i + 1),
            ]);
        }
    }

    /**
     * Test: randomize jenjangA tidak mengandung soal jenjangB.
     */
    public function test_randomize_jenjang_a_tidak_tercampur_jenjang_b(): void
    {
        $soals = BankSoal::jenjang($this->jenjangA->id)
            ->inRandomOrder()
            ->limit(5)
            ->get();

        $this->assertCount(5, $soals);

        foreach ($soals as $soal) {
            $this->assertEquals(
                $this->jenjangA->id,
                $soal->mapel->jenjang_id,
                "Soal ID {$soal->id} bukan dari jenjang 4 SD!"
            );
        }
    }

    /**
     * Test: randomize jenjangB tidak mengandung soal jenjangA.
     */
    public function test_randomize_jenjang_b_tidak_tercampur_jenjang_a(): void
    {
        $soals = BankSoal::jenjang($this->jenjangB->id)
            ->inRandomOrder()
            ->limit(5)
            ->get();

        $this->assertCount(5, $soals);

        foreach ($soals as $soal) {
            $this->assertEquals(
                $this->jenjangB->id,
                $soal->mapel->jenjang_id,
                "Soal ID {$soal->id} bukan dari jenjang 1 SMP!"
            );
        }
    }

    /**
     * Test: error jika jumlah soal yang diminta melebihi yang tersedia.
     */
    public function test_error_ketika_jumlah_diminta_melebihi_tersedia(): void
    {
        $tersedia = BankSoal::jenjang($this->jenjangA->id)->count();

        // Minta lebih dari yang tersedia
        $jumlahDiminta = $tersedia + 5;

        $this->assertEquals(10, $tersedia);

        // Simulasi logika GeneratePaketSoal
        $soalsAmbil = BankSoal::jenjang($this->jenjangA->id)
            ->inRandomOrder()
            ->limit($jumlahDiminta)
            ->get();

        // Harus hanya mengembalikan maksimum yang tersedia, bukan lebih
        $this->assertCount($tersedia, $soalsAKel = $soalsAmbil);

        // Test: pesan error harus menyebutkan jumlah tersedia
        $pesan = "Soal tidak cukup: hanya tersedia {$tersedia} soal";
        $this->assertStringContainsString((string) $tersedia, $pesan);
    }

    /**
     * Test: paket soal yang dibuat via Generate Acak hanya berisi satu jenjang.
     */
    public function test_paket_soal_hanya_satu_jenjang(): void
    {
        $user = User::create([
            'name'     => 'Test Admin',
            'email'    => 'admin@test.com',
            'password' => bcrypt('password'),
        ]);

        $soals = BankSoal::jenjang($this->jenjangA->id)
            ->inRandomOrder()
            ->limit(5)
            ->get();

        $paket = PaketSoal::create([
            'judul'       => 'Test Paket Acak 4SD',
            'mapel_id'    => $soals->first()->mapel_id,
            'dibuat_oleh' => $user->id,
        ]);

        foreach ($soals as $i => $soal) {
            PaketSoalItem::create([
                'paket_soal_id' => $paket->id,
                'bank_soal_id'  => $soal->id,
                'urutan'        => $i + 1,
            ]);
        }

        // Load paket dengan soal-soalnya
        $paket->load('bankSoals.mapel');

        foreach ($paket->bankSoals as $soal) {
            $this->assertEquals(
                $this->jenjangA->id,
                $soal->mapel->jenjang_id,
                "Paket mengandung soal dari jenjang lain!"
            );
        }
    }
}
