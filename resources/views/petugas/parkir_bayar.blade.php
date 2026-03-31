<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Parkir</title>
    <style>
        .bayar-container {
             max-width: 500px; 
             margin: 40px auto; 
             background: white; 
             padding: 30px; 
             border-radius: 15px; 
             box-shadow: 0 4px 15px rgba(0,0,0,0.05); 
       }

       .bayar-header {
            text-align: center;
            border-bottom: 2px dashed #e2e8f0;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }

        .bayar-title {
            color: #1e293b;
            font-size: 1.5rem;
            margin: 0 0 5px 0;
        }

        .plat-jumbo {
            font-size: 2.5rem;
            font-weight: 800;
            color: #4f46e5;
            margin: 10px 0;
            letter-spacing: 2px;
        }

        .rincian-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            font-size: 1.1rem;
            color: #475569;
        }

        .rincian-label {
            font-weight: 600;
        }

        .rincian-value {
            font-weight: 700;
            color: #1e293b;
        }

        .total-box {
            background: #f8fafc;
            border: 2px solid #e2e8f0;
            padding: 20px;
            border-radius: 10px;
            margin: 25px 0;
            text-align: center;
        }

        .total-label {
            color: #64748b;
            font-weight: bold;
            margin-bottom: 5px;
            font-size: 1rem;
        }

        .total-harga {
            font-size: 2.5rem;
            font-weight: 800;
            color: #ef4444;
            margin: 0;
        }

        .btn-bayar {
            width: 100%;
            padding: 18px;
            font-size: 1.2rem;
            font-weight: bold;
            background: #10b981;
            color: white;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            transition: 0.3s;
            margin-bottom: 15px;
        }

        .btn-bayar:hover {
            background: #059669;
        }

        .btn-batal {
            display: block;
            text-align: center;
            color: #64748b;
            text-decoration: none;
            font-weight: 600;
        }

        .btn-batal:hover {
            color: #ef4444;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    @extends('layouts.app')
    @section('page_name', 'Konfirmasi Pembayaran')
    @section('content')

    <div class="bayar-container">
        <div class="bayar-header">
            <h2 class="bayar-title">Tagihan Parkir</h2>
            <div class="plat-jumbo">{{ $transaksi->kendaraan->plat_nomor }}</div>
            <span style="background: #e0e7ff; color: #3730a3; padding: 5px 12px; border-radius: 20px; font-weight: bold; font-size: 0.9rem;">
                {{ $transaksi->kendaraan->jenis_kendaraan }} - {{ $transaksi->area->nama_area }}
            </span>
        </div>

        <div class="rincian-row">
            <span class="rincian-label">Waktu Masuk</span>
            <span class="rincian-value">{{ $waktu_masuk->format('H:i') }} WIB</span>
        </div>
        <div class="rincian-row">
            <span class="rincian-label">Waktu Keluar</span>
            <span class="rincian-value">{{ \Carbon\Carbon::parse($waktu_keluar)->format('H:i') }} WIB</span>
        </div>
        <div class="rincian-row">
            <span class="rincian-label">Lama Parkir</span>
            <span class="rincian-value">{{ $durasi }} Jam</span>
        </div>
        <div class="rincian-row">
            <span class="rincian-label">Tarif per Jam</span>
            <span class="rincian-value">Rp {{ number_format($transaksi->tarif->tarif_per_jam, 0, ',', '.') }}</span>
        </div>

        <div class="total-box">
            <div class="total-label">TOTAL YANG HARUS DIBAYAR</div>
            <div class="total-harga">Rp {{ number_format($biaya, 0, ',', '.') }}</div>
        </div>

        <form action="{{ route('transaksi.simpan_keluar', $transaksi->id_parkir) }}" method="POST">
            @csrf
            @method('PUT') <input type="hidden" name="waktu_keluar" value="{{ $waktu_keluar }}">
            <input type="hidden" name="durasi" value="{{ $durasi }}">
            <input type="hidden" name="biaya" value="{{ $biaya }}">
            
            <button type="submit" class="btn-bayar">✅ KONFIRMASI PEMBAYARAN</button>
        </form>

        <a href="{{ route('transaksi.keluar') }}" class="btn-batal">Batalkan Pencarian</a>

    </div>
    @endsection
</body>
</html>