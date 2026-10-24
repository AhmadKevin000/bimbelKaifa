<?php

namespace App\Http\Controllers;

use App\Models\Rapor;
use App\Models\Siswa;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class RaporPdfController extends Controller
{
    /**
     * Unduh rapor siswa dalam bentuk PDF.
     *
     * Route sudah dilindungi `auth:web,guru`; method ini menambahkan pemeriksaan
     * apakah user yang login benar-benar berhak atas rapor siswa tersebut
     * (lihat Gate "view-rapor" di AppServiceProvider).
     */
    public function download(Request $request, Siswa $siswa, string $semester)
    {
        Gate::authorize('view-rapor', $siswa);

        $rapors = Rapor::where('siswa_id', $siswa->id)
            ->where('semester', $semester)
            ->with(['pengajaran.mapel'])
            ->get();

        if ($rapors->isEmpty()) {
            return back()->with('error', 'Data rapor untuk semester ini belum tersedia.');
        }

        $pdf = Pdf::loadView('pdf.rapor', [
            'siswa' => $siswa,
            'semester' => $semester,
            'rapors' => $rapors,
        ]);

        // Nama siswa dipakai di header Content-Disposition, jadi karakter di luar
        // huruf/angka dibuang agar tidak bisa menyisipkan header tambahan.
        $safeName = preg_replace('/[^A-Za-z0-9_-]+/', '-', (string) $siswa->nama);
        $safeName = trim((string) $safeName, '-') ?: 'Siswa';

        $filename = "Rapor_{$safeName}_Semester_{$semester}.pdf";

        // Data pribadi: jangan disimpan di cache browser/proxy bersama.
        return $pdf->download($filename)
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, private')
            ->header('Pragma', 'no-cache');
    }
}
