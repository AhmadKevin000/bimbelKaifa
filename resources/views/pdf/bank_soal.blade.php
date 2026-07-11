<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ $paket->judul }}</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 11pt;
            color: #1a1a1a;
            line-height: 1.5;
        }

        /* ── Kop / Header ── */
        .kop {
            margin-bottom: 16px;
            text-align: center;
        }
        .kop img {
            width: 100%;
            height: auto;
            display: block;
        }

        /* ── Judul Ujian ── */
        .exam-title {
            text-align: center;
            margin-bottom: 14px;
            padding: 8px 0;
            border-bottom: 1px solid #ddd;
        }
        .exam-title h2 {
            font-size: 13pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #2c3e50;
        }
        .exam-title p {
            font-size: 9.5pt;
            color: #555;
            margin-top: 3px;
        }

        /* ── Info Siswa ── */
        .info-table { width: 100%; font-size: 10pt; margin-bottom: 16px; }
        .info-table td { padding: 3px 4px; }
        .info-table .label { width: 28%; font-weight: bold; }
        .info-table .dots { border-bottom: 1px dotted #999; }

        /* ── Petunjuk ── */
        .petunjuk {
            background: #f8f9fa;
            border: 1px solid #e0e0e0;
            border-radius: 4px;
            padding: 8px 12px;
            margin-bottom: 16px;
            font-size: 9pt;
            color: #444;
        }
        .petunjuk strong { color: #2c3e50; }
        .petunjuk ol { margin: 4px 0 0 16px; }
        .petunjuk li { margin-bottom: 2px; }

        /* ── Soal ── */
        .soal { margin-bottom: 16px; page-break-inside: avoid; }
        .soal-header { font-weight: bold; margin-bottom: 4px; }
        .soal-gambar { margin: 6px 0; }
        .soal-gambar img { max-width: 240px; max-height: 140px; object-fit: contain; }

        /* Opsi 2 kolom */
        .opsi-grid { display: table; width: 100%; margin-top: 6px; }
        .opsi-row { display: table-row; }
        .opsi-cell { display: table-cell; width: 50%; padding: 2px 4px 4px 0; vertical-align: top; }
        .opsi-label { font-weight: bold; display: inline-block; width: 18px; }
        .opsi-gambar img { max-width: 100px; max-height: 80px; object-fit: contain; vertical-align: middle; }

        /* Esai ruang jawaban */
        .esai-lines { margin-top: 8px; }
        .esai-line {
            border-bottom: 1px solid #aaa;
            height: 24px;
            margin-bottom: 4px;
        }

        .page-break { page-break-after: always; }

        .footer {
            font-size: 8pt;
            color: #888;
            text-align: center;
            margin-top: 24px;
            border-top: 1px solid #ddd;
            padding-top: 6px;
        }
    </style>
</head>
<body>

{{-- Kop / Header dengan Logo --}}
<div class="kop">
    <img src="{{ public_path('images/header soal kaifa.jpeg') }}" />
</div>

{{-- Judul Ujian --}}
<div class="exam-title">
    <h2>Lembar Soal</h2>
    <p>{{ $paket->judul }}</p>
    <p>Jenjang: {{ $paket->mapel?->jenjang?->nama ?? '—' }} &nbsp;|&nbsp; Mata Pelajaran: {{ $paket->mapel?->nama ?? '—' }}</p>
</div>

{{-- Info Siswa --}}
<table class="info-table">
    <tr>
        <td class="label">Nama Siswa</td>
        <td class="dots">: ___________________________________</td>
        <td class="label" style="width: 18%">Tanggal</td>
        <td class="dots">: ___________________</td>
    </tr>
    <tr>
        <td class="label">Kelas</td>
        <td class="dots">: ___________________________________</td>
        <td class="label">Waktu</td>
        <td class="dots">: ___________________</td>
    </tr>
</table>

{{-- Petunjuk Umum --}}
<div class="petunjuk">
    <strong>Petunjuk Umum:</strong>
    <ol>
        <li>Tuliskan nama, kelas, dan tanggal pada kolom yang tersedia.</li>
        <li>Untuk soal pilihan ganda, pilihlah satu jawaban yang paling tepat.</li>
        <li>Untuk soal esai, jawablah dengan jelas dan lengkap pada tempat yang disediakan.</li>
        <li>Periksa kembali jawaban Anda sebelum mengumpulkan lembar soal.</li>
    </ol>
</div>

{{-- Soal --}}
@php $no = 1; @endphp
@foreach($soals as $soal)
<div class="soal">
    {{-- Nomor + pertanyaan --}}
    <div class="soal-header">{{ $no }}. {!! nl2br(e($soal->pertanyaan)) !!}</div>

    {{-- Gambar soal (kalau ada) --}}
    @if($soal->gambar_soal)
    <div class="soal-gambar">
        <img src="{{ public_path('storage/' . $soal->gambar_soal) }}" />
    </div>
    @endif

    @if($soal->tipe_soal === 'pilihan_ganda')
    {{-- Opsi dalam 2 kolom --}}
    <div class="opsi-grid">
        @foreach($soal->opsiJawaban->chunk(2) as $baris)
        <div class="opsi-row">
            @foreach($baris as $opsi)
            <div class="opsi-cell">
                <span class="opsi-label">{{ $opsi->label }}.</span>
                @if($opsi->teks) {{ $opsi->teks }} @endif
                @if($opsi->gambar)
                <span class="opsi-gambar"><img src="{{ public_path('storage/' . $opsi->gambar) }}" /></span>
                @endif
            </div>
            @endforeach
        </div>
        @endforeach
    </div>

    @else
    {{-- Esai: ruang kosong bergaris (5 baris default) --}}
    <div class="esai-lines">
        @for($i = 0; $i < 5; $i++)
        <div class="esai-line"></div>
        @endfor
    </div>
    @endif
</div>
@php $no++; @endphp
@endforeach

<div class="footer">Lembar Soal — {{ $paket->judul }} — Bimbel Kaifa — Dicetak {{ now()->locale('id')->isoFormat('dddd, D MMMM Y') }}</div>

</body>
</html>
