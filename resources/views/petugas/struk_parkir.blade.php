<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Parkir - {{ $transaksi->kendaraan->plat_nomor }}</title>
    <style>
        body {
            background: #e2e8f0;
            font-family: 'Courier New', Courier, monospace;
            display: flex;
            justify-content: center;
            padding: 40px;
        }

        .struk-wrapper {
            width: 350px;
        }

        .struk-container {
            background: white;
            padding: 25px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            color: #1e293b;
        }

        .struk-header {
            text-align: center;
            margin-bottom: 15px;
        }

        .struk-title {
            font-size: 1.4rem;
            font-weight: bold;
            margin: 0;
        }

        .struk-subtitle {
            font-size: 0.9rem;
            margin: 5px 0 0 0;
            color: #64748b;
        }

        .divider {
            border-top: 1px dashed #1e293b;
            margin: 15px 0;
        }

        .row {
            display: flex;
            justify-content: space-between;
            font-size: 0.95rem;
            margin-bottom: 6px;
        }

        .total-box {
            text-align: right;
            font-size: 1.5rem;
            font-weight: bold;
            margin-top: 10px;
        }
        
        .btn-print {
            display: block;
            width: 100%;
            padding: 15px;
            background: #4f46e5;
            color: white;
            text-align: center;
            text-decoration: none;
            font-weight: bold;
            margin-top: 20px;
            border: none;
            cursor: pointer;
            font-family: sans-serif;
            border-radius: 8px;
            font-size: 1.1rem;
        }

        .btn-print:hover {
            background: #3730a3;
        }

        .btn-back {
            display: block;
            text-align: center;
            margin-top: 15px;
            font-family: sans-serif;
            font-size: 0.95rem;
            color: #64748b;
            text-decoration: none;
            font-weight: 600;
        }

        .btn-back:hover {
            color: #1e293b;
            text-decoration: underline;
        }

        @media print {
            body { background: white; padding: 0; }
            .struk-container { box-shadow: none; width: 100%; border: none; }
            .btn-print, .btn-back { display: none; }
        }
    </style>
</head>
<body>

    <div class="struk-wrapper">
        <div class="struk-container">
            <div class="struk-header">
                <h2 class="struk-title">E-PARKIR SYSTEM</h2>
                <p class="struk-subtitle">Struk Bukti Pembayaran Parkir</p>
            </div>

            <div class="divider"></div>

            <div class="row">
                <span>No. Tiket:</span>
                <span>#PRK-{{ $transaksi->id_parkir }}</span>
            </div>
            <div class="row">
                <span>Plat Nomor:</span>
                <span style="font-weight: bold; font-size: 1.1rem;">{{ $transaksi->kendaraan->plat_nomor }}</span>
            </div>
            <div class="row">
                <span>Jenis:</span>
                <span>{{ $transaksi->kendaraan->jenis_kendaraan }}</span>
            </div>
            <div class="row">
                <span>Area:</span>
                <span>{{ $transaksi->area->nama_area }}</span>
            </div>

            <div class="divider"></div>

            <div class="row">
                <span>Masuk:</span>
                <span>{{ \Carbon\Carbon::parse($transaksi->waktu_masuk)->format('d/m/Y H:i') }}</span>
            </div>
            <div class="row">
                <span>Keluar:</span>
                <span>{{ \Carbon\Carbon::parse($transaksi->waktu_keluar)->format('d/m/Y H:i') }}</span>
            </div>
            <div class="row">
                <span>Durasi:</span>
                <span>{{ $transaksi->durasi_jam }} Jam</span>
            </div>

            <div class="divider"></div>

            <div class="row">
                <span style="font-weight: bold;">TOTAL BAYAR:</span>
            </div>
            <div class="total-box">
                Rp {{ number_format($transaksi->biaya_total, 0, ',', '.') }}
            </div>

            <div class="divider"></div>
            
            <div style="text-align: center; font-size: 0.85rem; margin-top: 20px;">
                Terima kasih atas kunjungan Anda.<br>
                Semoga selamat sampai tujuan!
            </div>
        </div>

        <button onclick="window.print()" class="btn-print">🖨️ CETAK STRUK SEKARANG</button>
        <a href="{{ route('petugas.dashboard') }}" class="btn-back">⬅️ Selesai & Kembali ke Dashboard</a>
    </div>

</body>
</html>