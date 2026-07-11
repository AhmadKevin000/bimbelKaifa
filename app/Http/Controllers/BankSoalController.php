<?php

namespace App\Http\Controllers;

use App\Exports\BankSoalTemplateExport;
use App\Models\PaketSoal;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class BankSoalController extends Controller
{
    /**
     * Download template Excel (2 sheet: Pilihan Ganda + Esai).
     * GET /bank-soal/template?jenjang_id={id}
     */
    public function downloadTemplate(Request $request)
    {
        $jenjangId = $request->query('jenjang_id');
        $kelasId = $request->query('kelas_id');

        return Excel::download(
            new BankSoalTemplateExport(
                $jenjangId ? (int) $jenjangId : null,
                $kelasId ? (int) $kelasId : null
            ),
            'template_bank_soal.xlsx'
        );
    }

    /**
     * Cetak PDF Soal Siswa (tanpa kunci jawaban).
     * GET /bank-soal/paket/{paket}/pdf
     */
    public function cetakSoal(PaketSoal $paket)
    {
        $paket->load([
            'mapel.jenjang',
            'bankSoals.opsiJawaban',
        ]);

        $pdf = Pdf::loadView('pdf.bank_soal', [
            'paket' => $paket,
            'soals' => $paket->bankSoals,
        ])->setPaper('a4', 'portrait');

        return $pdf->download("Soal_{$paket->judul}.pdf");
    }

    /**
     * Cetak PDF Kunci Jawaban (untuk guru saja).
     * GET /bank-soal/paket/{paket}/kunci
     */
    public function cetakKunci(PaketSoal $paket)
    {
        $paket->load([
            'mapel.jenjang',
            'bankSoals.opsiJawaban',
        ]);

        $pdf = Pdf::loadView('pdf.bank_soal_kunci', [
            'paket' => $paket,
            'soals' => $paket->bankSoals,
        ])->setPaper('a4', 'portrait');

        return $pdf->download("Kunci_{$paket->judul}.pdf");
    }
}
