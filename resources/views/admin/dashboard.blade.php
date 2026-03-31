<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <style>
       .grid-4 {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.03);
            border-bottom: 5px solid #4f46e5;
        }

        .stat-card:nth-child(2) {
            border-bottom-color: #10b981;
        }

        .stat-card:nth-child(3) {
            border-bottom-color: #f59e0b;
        }

        .stat-card:nth-child(4) {
            border-bottom-color: #ec4899;
        }

        .stat-value {
            font-size: 2.5rem;
            font-weight: 800;
            color: #1e293b;
            margin-bottom: 5px;
        }

        .stat-label {
            color: #64748b;
            font-size: 0.95rem;
            font-weight: 600;
        }

        .monitor-section {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.03);
        }

        .monitor-title {
            color: #1e293b;
            font-weight: 700;
            margin-top: 0;
            font-size: 1.2rem;
        }

        .grid-3 {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-top: 20px;
        }

        .area-card {
            border: 1px solid #e2e8f0;
            padding: 20px;
            border-radius: 10px;
        }

        .area-header {
            display: flex;
            justify-content: space-between;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 15px;
        }

        .progress-bg {
            background: #f1f5f9;
            height: 8px;
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 15px;
        }

        .progress-fill {
            background: #4f46e5;
            height: 100%;
            border-radius: 10px;
            transition: width 0.5s ease;
        }

        .area-footer {
            display: flex;
            justify-content: space-between;
            font-size: 0.9rem;
            color: #64748b;
            align-items: center;
        }

        .badge-sisa {
            background: #dcfce7;
            color: #166534;
            padding: 4px 10px;
            border-radius: 6px;
            font-weight: 700;
            font-size: 0.8rem;
        }

        .badge-penuh {
            background: #fee2e2;
            color: #b91c1c;
            padding: 4px 10px;
            border-radius: 6px;
            font-weight: 700;
            font-size: 0.8rem;
        }
    </style>
</head>
<body>
    @extends('layouts.app')

    @section('page_name', 'Dashboard Administrator')

    @section('content')
    
    <p style="color: #64748b; margin-bottom: 25px;">Selamat datang, Administrator Sistem</p>

    <div class="grid-4">
        <div class="stat-card">
            <div class="stat-value">{{ $total_kendaraan }}</div>
            <div class="stat-label">Total Kendaraan Terdaftar</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">{{ $total_area }}</div>
            <div class="stat-label">Jumlah Area Parkir</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">{{ $user_aktif }}</div>
            <div class="stat-label">User Aktif Sistem</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">{{ $terpakai_global }} / {{ $kapasitas_global }}</div>
            <div class="stat-label">Slot Terpakai Saat Ini</div>
        </div>
    </div>

    <div class="monitor-section">
        <h3 class="monitor-title">Monitor Kapasitas Area</h3>
        
        <div class="grid-3">
            @foreach($areas as $area)
            
            @php 
                $persen = ($area->kapasitas > 0) ? ($area->terisi_saat_ini / $area->kapasitas) * 100 : 0; 
                // Jika mau ganti warna bar kalau mau penuh (opsional)
                $warna_bar = ($persen >= 90) ? '#ef4444' : '#4f46e5'; 
            @endphp

            <div class="area-card">
                <div class="area-header">
                    <span>{{ $area->nama_area }}</span>
                    <span>{{ $area->terisi_saat_ini }} / {{ $area->kapasitas }}</span>
                </div>
                
                <div class="progress-bg">
                    <div class="progress-fill" style="width: {{ $persen }}%; background-color: {{ $warna_bar }};"></div>
                </div>
                
                <div class="area-footer">
                    <span>Terisi: <b style="color:#1e293b;">{{ $area->terisi_saat_ini }}</b></span>
                    
                    @if($area->sisa_slot <= 0)
                        <span class="badge-penuh">PENUH</span>
                    @else
                        <span class="badge-sisa">Sisa: {{ $area->sisa_slot }} Slot</span>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
    
    @endsection
</body>
</html>