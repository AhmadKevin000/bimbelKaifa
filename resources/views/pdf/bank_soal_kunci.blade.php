<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Kunci Jawaban — {{ $paket->judul }}</title>
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
            margin-bottom: 6px;
            text-align: center;
        }
        .kop img {
            width: 100%;
            height: auto;
            display: block;
        }

        /* ── Rahasia Bar ── */
        .rahasia-bar {
            background: #c0392b;
            color: #fff;
            text-align: center;
            font-weight: bold;
            font-size: 9pt;
            padding: 5px;
            margin-bottom: 6px;
            letter-spacing: 2px;
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
            color: #c0392b;
        }
        .exam-title p {
            font-size: 9.5pt;
            color: #555;
            margin-top: 3px;
        }

        /* ── Soal ── */
        .soal { margin-bottom: 14px; page-break-inside: avoid; }
        .soal-header { font-weight: bold; margin-bottom: 4px; }
        .soal-gambar { margin: 4px 0; }
        .soal-gambar img { max-width: 200px; max-height: 120px; object-fit: contain; }

        /* Kunci PG */
        .kunci-pg {
            margin-top: 5px;
            padding: 4px 10px;
            background: #eafaf1;
            border-left: 3px solid #27ae60;
            font-weight: bold;
            color: #1e8449;
            font-size: 10.5pt;
            display: inline-block;
        }

        /* Kunci Esai */
        .kunci-esai-label { font-weight: bold; color: #8e44ad; font-size: 9.5pt; margin-top: 5px; }
        .kunci-esai-content {
            margin-top: 3px;
            padding: 6px 10px;
            background: #f5eef8;
            border-left: 3px solid #8e44ad;
            color: #6c3483;
            font-size: 10pt;
        }
        .kunci-esai-empty { color: #aaa; font-style: italic; font-size: 9.5pt; margin-top: 4px; }

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

{{-- Rahasia Bar --}}
<div class="rahasia-bar">⚠ RAHASIA — KUNCI JAWABAN — HANYA UNTUK GURU ⚠</div>

{{-- Judul Ujian --}}
<div class="exam-title">
    <h2>Kunci Jawaban</h2>
    <p>{{ $paket->judul }}</p>
    <p>Jenjang: {{ $paket->mapel?->jenjang?->nama ?? '—' }} &nbsp;|&nbsp; Mata Pelajaran: {{ $paket->mapel?->nama ?? '—' }}</p>
</div>

{{-- Soal + Kunci --}}
@php $no = 1; @endphp
@foreach($soals as $soal)
<div class="soal">
    <div class="soal-header">{{ $no }}. {!! nl2br(e($soal->pertanyaan)) !!}</div>

    @if($soal->gambar_soal)
    <div class="soal-gambar">
        <img src="{{ public_path('storage/' . $soal->gambar_soal) }}" />
    </div>
    @endif

    @if($soal->tipe_soal === 'pilihan_ganda')
        @php $jawaban = $soal->opsiBenar()->first(); @endphp
        <div class="kunci-pg">
            Jawaban: {{ $jawaban?->label ?? '?' }}
            @if($jawaban?->teks) — {{ $jawaban->teks }} @endif
        </div>

    @else
        {{-- Esai: tampilkan kunci_jawaban_esai --}}
        <div class="kunci-esai-label">Kunci Jawaban / Rubrik:</div>
        @if($soal->kunci_jawaban_esai)
            <div class="kunci-esai-content">{!! nl2br(e($soal->kunci_jawaban_esai)) !!}</div>
        @else
            <div class="kunci-esai-empty">— Dinilai manual oleh guru —</div>
        @endif
    @endif
</div>
@php $no++; @endphp
@endforeach

<div class="footer">Kunci Jawaban — {{ $paket->judul }} — Bimbel Kaifa — Dicetak {{ now()->locale('id')->isoFormat('dddd, D MMMM Y') }}</div>

</body>
</html>
