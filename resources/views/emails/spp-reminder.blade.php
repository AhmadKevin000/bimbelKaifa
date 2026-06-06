<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Pengingat SPP</title>
    <style>
        /* Reset */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background-color: #f4f6f9;
            color: #2d3748;
            line-height: 1.6;
        }
        .wrapper {
            max-width: 600px;
            margin: 32px auto;
            background: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 24px rgba(0,0,0,0.08);
        }
        /* Header */
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 36px 40px;
            text-align: center;
        }
        .header h1 {
            color: #fff;
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 4px;
            letter-spacing: -0.3px;
        }
        .header p {
            color: rgba(255,255,255,0.82);
            font-size: 14px;
        }
        /* Body */
        .body {
            padding: 36px 40px;
        }
        .greeting {
            font-size: 15px;
            margin-bottom: 20px;
            color: #4a5568;
        }
        .greeting strong {
            color: #2d3748;
        }
        /* Info card */
        .info-card {
            background: #f7fafc;
            border-left: 4px solid #667eea;
            border-radius: 8px;
            padding: 16px 20px;
            margin-bottom: 24px;
        }
        .info-card .label {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: #718096;
            margin-bottom: 4px;
        }
        .info-card .value {
            font-size: 18px;
            font-weight: 700;
            color: #2d3748;
        }
        /* Table */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 24px;
            font-size: 14px;
        }
        table thead tr {
            background: #667eea;
            color: #fff;
        }
        table thead th {
            padding: 10px 14px;
            text-align: left;
            font-weight: 600;
        }
        table tbody tr {
            border-bottom: 1px solid #e2e8f0;
        }
        table tbody tr:last-child {
            border-bottom: none;
        }
        table tbody td {
            padding: 10px 14px;
            color: #4a5568;
        }
        table tfoot tr {
            background: #f7fafc;
        }
        table tfoot td {
            padding: 10px 14px;
            font-weight: 700;
            color: #2d3748;
        }
        /* CTA / Warning box */
        .warning-box {
            background: #fff5f5;
            border: 1px solid #fed7d7;
            border-radius: 8px;
            padding: 16px 20px;
            margin-bottom: 24px;
            font-size: 14px;
            color: #c53030;
        }
        .warning-box strong { display: block; margin-bottom: 4px; }
        /* Footer */
        .footer {
            border-top: 1px solid #e2e8f0;
            padding: 20px 40px;
            text-align: center;
            font-size: 12px;
            color: #a0aec0;
        }
        .footer a { color: #667eea; text-decoration: none; }
    </style>
</head>
<body>
<div class="wrapper">
    <!-- Header -->
    <div class="header">
        <h1>🎓 Kaifa Bimbel</h1>
        <p>Pengingat Pembayaran SPP</p>
    </div>

    <!-- Body -->
    <div class="body">
        <p class="greeting">
            Kepada Yth.<br>
            <strong>{{ $namaWali }}</strong> (Wali dari {{ $siswa->nama }}),
        </p>

        <p style="font-size:14px; color:#4a5568; margin-bottom:20px;">
            Kami ingin menginformasikan bahwa terdapat tagihan SPP yang belum diselesaikan
            untuk putra/putri Bapak/Ibu. Berikut adalah rinciannya:
        </p>

        <!-- Total card -->
        <div class="info-card">
            <div class="label">Total Tagihan</div>
            <div class="value">Rp {{ number_format($totalNominal, 0, ',', '.') }}</div>
        </div>

        <!-- Breakdown table -->
        <table>
            <thead>
                <tr>
                    <th>Bulan</th>
                    <th>Jatuh Tempo</th>
                    <th>Nominal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($unpaidMonths as $month)
                <tr>
                    <td>{{ $month['label'] }}</td>
                    <td>{{ \Carbon\Carbon::parse($month['due_date'])->isoFormat('D MMMM YYYY') }}</td>
                    <td>Rp {{ number_format($month['nominal'], 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2">Total</td>
                    <td>Rp {{ number_format($totalNominal, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>

        <!-- Warning -->
        <div class="warning-box">
            <strong>⚠️ Harap segera melunasi tagihan sebelum jatuh tempo.</strong>
            Keterlambatan pembayaran dapat mempengaruhi keikutsertaan dalam kegiatan belajar mengajar.
        </div>

        <p style="font-size:14px; color:#4a5568;">
            Pembayaran dapat dilakukan langsung ke kantor Kaifa Bimbel atau melalui transfer ke rekening yang telah ditentukan.
            Untuk konfirmasi pembayaran, harap menghubungi admin kami.
        </p>

        <p style="font-size:14px; color:#4a5568; margin-top:16px;">
            Terima kasih atas perhatian dan kerjasamanya. 🙏
        </p>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>Email ini dikirim secara otomatis oleh sistem Kaifa Bimbel.</p>
        <p>Mohon tidak membalas email ini.</p>
    </div>
</div>
</body>
</html>
