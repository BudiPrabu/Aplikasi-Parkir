<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Owner - Laporan Keuangan</title>
    <style>
        :root {
            --indigo-primary: #4f46e5;
            --indigo-light: #e0e7ff;
            --emerald-primary: #10b981;
            --emerald-light: #d1fae5;
            --slate-bg: #f8fafc;
            --text-dark: #1e293b;
            --text-muted: #64748b;
        }

        body {
            background-color: var(--slate-bg);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
        }

        .owner-container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
        }

        .card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.03);
            margin-bottom: 25px;
        }

        .header-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .page-title {
            color: var(--text-dark);
            margin: 0;
            font-size: 1.8rem;
        }

        .filter-form {
            display: flex;
            gap: 15px;
            align-items: flex-end;
            background: var(--indigo-light);
            padding: 15px 20px;
            border-radius: 12px;
        }

        .form-group-filter label {
            display: block;
            font-size: 0.85rem;
            font-weight: bold;
            color: var(--indigo-primary);
            margin-bottom: 5px;
        }

        .input-date {
            padding: 10px;
            border: 1px solid #c7d2fe;
            border-radius: 8px;
            font-family: inherit;
            color: var(--text-dark);
            outline: none;
        }

        .btn-filter {
            background: var(--indigo-primary);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
            height: 40px; 
            transition: 0.2s;
        }

        .btn-filter:hover { 
            background: #4338ca; 
        }

        .summary-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }

        .widget {
            padding: 25px;
            border-radius: 15px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .widget-uang {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            box-shadow: 0 10px 20px rgba(16, 185, 129, 0.2);
        }

        .widget-mobil {
            background: linear-gradient(135deg, #4f46e5 0%, #3730a3 100%);
            color: white;
            box-shadow: 0 10px 20px rgba(79, 70, 229, 0.2);
        }

        .widget-title {
            font-size: 1.1rem;
            opacity: 0.9;
            margin-bottom: 5px;
        }

        .widget-value {
            font-size: 2.5rem;
            font-weight: 800;
            margin: 0;
        }

        .table-responsive {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .table-responsive th { 
            text-align: left; 
            padding: 15px; 
            border-bottom: 2px solid #f1f5f9; 
            color: var(--text-muted); 
            font-size: 0.9rem;
            text-transform: uppercase;
        }

        .table-responsive td { 
            padding: 15px; 
            border-bottom: 1px solid #f1f5f9; 
            color: var(--text-dark);
        }

        .td-uang { 
            font-weight: 800; 
            color: var(--emerald-primary); 
        }

        .td-plat { 
            font-weight: bold; 
        }
        
        .badge-durasi {
            background: var(--slate-bg);
            padding: 5px 10px;
            border-radius: 6px;
            font-size: 0.85rem;
            color: var(--text-muted);
            border: 1px solid #e2e8f0;
        }
    </style>
</head>
<body>
    @extends('layouts.app')
    @section('page_name', 'Dashboard Owner')
    @section('content')

    <div class="owner-container">
        <div class="header-section">
            <h2 class="page-title">📈 Laporan Pendapatan</h2>
            
            <form action="{{ route('owner.dashboard') }}" method="GET" class="filter-form">
                <div class="form-group-filter">
                    <label>Dari Tanggal</label>
                    <input type="date" name="start_date" class="input-date" value="{{ $start_date }}">
                </div>
                <div class="form-group-filter">
                    <label>Sampai Tanggal</label>
                    <input type="date" name="end_date" class="input-date" value="{{ $end_date }}">
                </div>
                <button type="submit" class="btn-filter">Tampilkan Data</button>
            </form>
        </div>

        <div class="summary-grid">
            <div class="widget widget-uang">
                <div class="widget-title">Total Pendapatan</div>
                <h3 class="widget-value">Rp {{ number_format($total_pendapatan, 0, ',', '.') }}</h3>
            </div>
            <div class="widget widget-mobil">
                <div class="widget-title">Total Kendaraan Keluar</div>
                <h3 class="widget-value">{{ number_format($total_kendaraan, 0, ',', '.') }} Unit</h3>
            </div>
        </div>

        <div class="card">
            <h3 style="margin-top:0; color: var(--text-dark); margin-bottom: 15px;">Rincian Transaksi Parkir</h3>
            <table class="table-responsive">
                <thead>
                    <tr>
                        <th>Plat Nomor</th>
                        <th>Jenis & Area</th>
                        <th>Waktu Masuk</th>
                        <th>Waktu Keluar</th>
                        <th>Durasi</th>
                        <th>Pendapatan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transaksis as $trx)
                    <tr>
                        <td class="td-plat">{{ $trx->kendaraan->plat_nomor }}</td>
                        <td>{{ $trx->kendaraan->jenis_kendaraan }} ({{ $trx->area->nama_area ?? '-' }})</td>
                        <td>{{ \Carbon\Carbon::parse($trx->waktu_masuk)->format('d M Y, H:i') }}</td>
                        <td>{{ \Carbon\Carbon::parse($trx->waktu_keluar)->format('d M Y, H:i') }}</td>
                        <td><span class="badge-durasi">{{ $trx->durasi_jam }} Jam</span></td>
                        <td class="td-uang">Rp {{ number_format($trx->biaya_total, 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 40px; color: var(--text-muted);">
                            <i>Tidak ada data transaksi pada rentang tanggal ini.</i>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

    @endsection
</body>
</html>