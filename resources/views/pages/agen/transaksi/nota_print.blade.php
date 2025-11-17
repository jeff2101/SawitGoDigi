<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Nota Transaksi</title>
    <style>
        body {
            font-family: 'Courier New', monospace;
            margin: 0;
            padding: 20px;
            background-color: #f8f9fa;
            color: #333;
        }

        .receipt {
            width: 320px;
            margin: 0 auto;
            background: white;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .receipt-header {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
            text-align: center;
            padding: 15px;
        }

        .logo-img {
            height: 40px;
            margin-bottom: 5px;
        }

        .logo-text {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 3px;
        }

        .receipt-body {
            padding: 20px;
        }

        .info-row,
        .calc-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            font-size: 13px;
        }

        .item {
            margin-bottom: 12px;
        }

        .item-header {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .calc-row.total {
            border-top: 2px solid #28a745;
            padding-top: 10px;
            margin-top: 10px;
            font-weight: bold;
            font-size: 16px;
            color: #28a745;
        }

        .footer {
            text-align: center;
            padding-top: 10px;
            border-top: 1px dashed #ccc;
            font-size: 12px;
            color: #666;
        }

        .actions {
            text-align: center;
            margin-top: 20px;
        }

        .btn {
            display: inline-block;
            margin: 5px;
            padding: 10px 16px;
            font-size: 14px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #218838;
        }

        .btn-secondary {
            background-color: #6c757d;
        }

        .btn-secondary:hover {
            background-color: #545b62;
        }

        @media print {
            @page {
                size: 80mm auto;
                margin: 0;
            }

            body {
                background: white;
                padding: 0;
            }

            .receipt {
                box-shadow: none;
                border: none;
                margin: 0 auto;
                width: 100%;
                max-width: 80mm;
            }

            .actions {
                display: none !important;
            }
        }
    </style>
</head>

<body>
    <div class="receipt">
        <div class="receipt-header">
            <img src="{{ asset('assets/img/sawit.png') }}" alt="Logo" class="logo-img">
            <div class="logo-text">SawitGoDigi</div>
            <small>Nota Transaksi</small>
        </div>

        <div class="receipt-body">
            <div class="info-row"><strong>Tanggal:</strong>
                {{ \Carbon\Carbon::parse($transaksi->tanggal)->format('d M Y') }}</div>
            <div class="info-row"><strong>Petani:</strong> {{ $transaksi->petani->nama ?? '-' }}</div>
            <div class="info-row"><strong>Agen:</strong> {{ $transaksi->agen->nama }}</div>

            <div class="item">
                <div class="item-header">Rincian Berat & Harga</div>
                @php
                    $alas = $transaksi->potongan_alas_timbang ?? 0;
                    $persen = $transaksi->potongan_persen ?? 0;

                    $a_bersih = max(0, ($transaksi->berat_tbs_a - $alas) * (1 - $persen / 100));
                    $a_total = $a_bersih * $transaksi->harga_tbs_a;

                    $b_bersih = max(0, ($transaksi->berat_tbs_b - $alas) * (1 - $persen / 100));
                    $b_total = $b_bersih * $transaksi->harga_tbs_b;

                    $brondol_bersih = max(0, ($transaksi->berat_brondol - $alas) * (1 - $persen / 100));
                    $brondol_total = $brondol_bersih * $transaksi->harga_brondol;
                @endphp

                <div class="calc-row">Buah A ({{ ucfirst($transaksi->mutu_buah_a) }}):
                    <span>{{ number_format($a_bersih, 2) }} Kg x Rp
                        {{ number_format($transaksi->harga_tbs_a, 0, ',', '.') }}</span>
                </div>
                <div class="calc-row">Subtotal A: <span>Rp {{ number_format($a_total, 0, ',', '.') }}</span></div>

                <div class="calc-row">Buah B ({{ ucfirst($transaksi->mutu_buah_b) }}):
                    <span>{{ number_format($b_bersih, 2) }} Kg x Rp
                        {{ number_format($transaksi->harga_tbs_b, 0, ',', '.') }}</span>
                </div>
                <div class="calc-row">Subtotal B: <span>Rp {{ number_format($b_total, 0, ',', '.') }}</span></div>

                <div class="calc-row">Brondol:
                    <span>{{ number_format($brondol_bersih, 2) }} Kg x Rp
                        {{ number_format($transaksi->harga_brondol, 0, ',', '.') }}</span>
                </div>
                <div class="calc-row">Subtotal Brondol: <span>Rp {{ number_format($brondol_total, 0, ',', '.') }}</span>
                </div>

                <div class="calc-row total">Total Dibayar:
                    <span>Rp {{ number_format($transaksi->total_bersih, 0, ',', '.') }}</span>
                </div>
            </div>

            <div class="footer">
                <p>Pembayaran: {{ ucfirst($transaksi->metode_pembayaran) }}</p>
                <p>Dicetak: {{ now()->format('d M Y H:i') }}</p>
                <p style="font-size: 11px;">Terima kasih atas kepercayaan Anda</p>
            </div>
        </div>
    </div>

    <div class="actions">
        <button class="btn" onclick="window.print()">📄 Cetak Ulang</button>
        <a href="{{ route('agen.transaksi.index') }}" class="btn btn-secondary">↩️ Kembali</a>
    </div>
</body>

</html>