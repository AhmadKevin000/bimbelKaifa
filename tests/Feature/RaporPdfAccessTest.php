<?php

namespace Tests\Feature;

use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Pengajaran;
use App\Models\Rapor;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

/**
 * Endpoint /rapor/{siswa}/{semester}/pdf pernah bisa diakses tanpa login.
 * Test ini mengunci perilaku yang diharapkan setelah perbaikan.
 */
class RaporPdfAccessTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    private User $guruUser;

    private Guru $guru;

    private Siswa $siswaSendiri;

    private Siswa $siswaOrangLain;

    private string $semester = '1';

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::create([
            'name' => 'Admin Uji',
            'email' => 'admin-uji@example.test',
            'password' => Hash::make('rahasia-uji'),
            'role' => 'admin',
        ]);

        $this->guru = Guru::create([
            'nama' => 'Guru Uji',
            'email' => 'guru-uji@example.test',
            'no_hp' => '0800000000',
            'alamat' => 'Alamat uji',
            'status' => 'senior',
        ]);

        $this->guruUser = User::create([
            'name' => 'Guru Uji',
            'email' => 'guru-uji@example.test',
            'password' => Hash::make('rahasia-uji'),
            'role' => 'guru',
        ]);

        $this->guru->update(['user_id' => $this->guruUser->id]);

        $kelas = Kelas::create(['nama_kelas' => 'Kelas Uji']);
        $mapel = Mapel::create(['nama' => 'Matematika']);

        // Pengajaran milik guru uji.
        $pengajaranSendiri = Pengajaran::create([
            'kelas_id' => $kelas->id,
            'guru_id' => $this->guru->id,
            'mapel_id' => $mapel->id,
        ]);

        // Pengajaran milik guru lain.
        $guruLain = Guru::create([
            'nama' => 'Guru Lain',
            'email' => 'guru-lain@example.test',
            'no_hp' => '0800000000',
            'alamat' => 'Alamat uji',
            'status' => 'senior',
        ]);

        $pengajaranLain = Pengajaran::create([
            'kelas_id' => $kelas->id,
            'guru_id' => $guruLain->id,
            'mapel_id' => $mapel->id,
        ]);

        $this->siswaSendiri = $this->buatSiswa('Siswa Sendiri', $kelas->id);
        $this->siswaOrangLain = $this->buatSiswa('Siswa Orang Lain', $kelas->id);

        $this->siswaSendiri->pengajaranEnrolled()->attach($pengajaranSendiri->id);
        $this->siswaOrangLain->pengajaranEnrolled()->attach($pengajaranLain->id);

        foreach ([$pengajaranSendiri, $pengajaranLain] as $pengajaran) {
            Rapor::create([
                'siswa_id' => $pengajaran->id === $pengajaranSendiri->id
                    ? $this->siswaSendiri->id
                    : $this->siswaOrangLain->id,
                'pengajaran_id' => $pengajaran->id,
                'semester' => $this->semester,
                'nilai' => 88,
                'keterangan' => 'Baik',
            ]);
        }
    }

    private function buatSiswa(string $nama, int $kelasId): Siswa
    {
        return Siswa::create([
            'nama' => $nama,
            'tanggal_lahir' => '2012-01-01',
            'alamat' => 'Alamat uji',
            'no_hp' => '0800000000',
            'kelas_id' => $kelasId,
            'tanggal_daftar' => '2025-07-01',
            'jumlah_mapel' => 1,
        ]);
    }

    private function url(Siswa $siswa, string $semester = '1'): string
    {
        return route('rapor.pdf', ['siswa' => $siswa->id, 'semester' => $semester]);
    }

    // ── Guest ────────────────────────────────────────────────────────────

    public function test_guest_tidak_bisa_mengunduh_rapor(): void
    {
        $response = $this->get($this->url($this->siswaSendiri));

        $response->assertRedirect(route('filament.admin.auth.login'));

        // Yang penting: tidak ada PDF yang ikut terkirim.
        $this->assertStringNotContainsString('%PDF', $response->getContent());
    }

    // ── Pengguna terautentikasi tanpa kewenangan ─────────────────────────

    public function test_guru_tidak_bisa_mengunduh_rapor_siswa_luar_kewenangannya(): void
    {
        $response = $this->actingAs($this->guruUser, 'guru')
            ->get($this->url($this->siswaOrangLain));

        $response->assertForbidden();
    }

    public function test_user_tanpa_relasi_guru_ditolak(): void
    {
        $userTanpaGuru = User::create([
            'name' => 'User Tanpa Guru',
            'email' => 'tanpa-guru@example.test',
            'password' => Hash::make('rahasia-uji'),
            'role' => 'guru',
        ]);

        $this->actingAs($userTanpaGuru, 'web')
            ->get($this->url($this->siswaSendiri))
            ->assertForbidden();
    }

    // ── Pengguna berwenang ───────────────────────────────────────────────

    public function test_admin_bisa_mengunduh_rapor(): void
    {
        $response = $this->actingAs($this->admin, 'web')
            ->get($this->url($this->siswaSendiri));

        $response->assertOk();
        $this->assertStringContainsString('application/pdf', $response->headers->get('Content-Type'));
        $this->assertStringContainsString('no-store', $response->headers->get('Cache-Control'));
    }

    public function test_guru_bisa_mengunduh_rapor_siswanya_sendiri(): void
    {
        $response = $this->actingAs($this->guruUser, 'guru')
            ->get($this->url($this->siswaSendiri));

        $response->assertOk();
        $this->assertStringContainsString('application/pdf', $response->headers->get('Content-Type'));
    }

    // ── Parameter tidak valid ────────────────────────────────────────────

    public function test_siswa_tidak_dikenal_menghasilkan_404(): void
    {
        $this->actingAs($this->admin, 'web')
            ->get(route('rapor.pdf', ['siswa' => 999999, 'semester' => '1']))
            ->assertNotFound();
    }

    public function test_semester_tidak_valid_menghasilkan_404(): void
    {
        $this->actingAs($this->admin, 'web')
            ->get($this->url($this->siswaSendiri, '3'))
            ->assertNotFound();

        $this->actingAs($this->admin, 'web')
            ->get($this->url($this->siswaSendiri, 'ganjil'))
            ->assertNotFound();
    }
}
