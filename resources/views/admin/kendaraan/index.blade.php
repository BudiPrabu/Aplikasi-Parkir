<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kendaraan</title>
    <style>
        .card-table {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
            margin-top: 20px;
        }

        .card-header-flex {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .card-title {
            font-size: 1.2rem;
            font-weight: 700;
            color: #1e293b;
            margin: 0;
        }

        .table-responsive {
            width: 100%;
            border-collapse: collapse;
        }

        .text-gray {
            color: #64748b;
            font-weight: 500;
        }

        .table-responsive th {
            text-align: left; 
            padding: 15px;
            color: #1e293b;
            font-weight: 700;
            border-bottom: 2px solid #f1f5f9;
        }

        .table-responsive td {
            padding: 18px 15px;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle; 
        }

        .table-responsive tbody tr:hover {
            background-color: #f8fafc; 
        }

        .text-center {
            text-align: center !important; 
        }

        .badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            display: inline-block; 
        }

        .badge-motor { 
            background: #e0e7ff; 
            color: #4338ca;
        }

        .badge-mobil { 
            background: #dcfce7; 
            color: #166534; 

        }
        .badge-lainnya { 
            background: #f1f5f9; 
            color: #475569; 
        }
        
        .badge-keluar {
            background-color: #fee2e2; 
            color: #b91c1c; 
        }

        .btn-add {
            background: #4f46e5;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            transition: 0.3s;
        }
        .btn-add:hover { background: #4338ca; }

        .action-group {
            display: flex;
            justify-content: center;
            gap: 15px;
        }

        .btn-edit { 
            color: #4f46e5; 
            font-weight: 600; 
            text-decoration: none;
        }
        .btn-delete { 
            color: #ef4444; 
            background: none; 
            border: none; 
            cursor: pointer; 
            font-weight: 600; 
            padding: 0; 
        }

        .pagination-container {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
        .pagination { 
            display: flex; 
            padding-left: 0; 
            list-style: none; 
            gap: 8px; 
            margin: 0; 
        }

        .page-item .page-link, .page-item span.page-link {
            position: relative; 
            display: flex; 
            align-items: center; 
            justify-content: center;
            min-width: 35px; 
            height: 35px; 
            padding: 0 10px; 
            color: #4f46e5; 
            text-decoration: none;
            background-color: white; 
            border: 1px solid #cbd5e1; 
            border-radius: 8px;
            font-weight: 600; 
            font-size: 0.9rem; 
            transition: all 0.2s;
        }

        .page-item .page-link:hover { 
            background-color: #e0e7ff; 
            border-color: #4f46e5; 
        }

        .page-item.active .page-link, .page-item.active span.page-link {
            z-index: 3; 
            color: white; 
            background-color: #4f46e5; 
            border-color: #4f46e5;
        }
        
        .page-item.disabled .page-link, .page-item.disabled span.page-link {
            color: #94a3b8; 
            pointer-events: none; 
            background-color: #f8fafc; 
            border-color: #e2e8f0;
        }

        nav p { 
            display: none !important; 
        }
    </style>
</head>
<body>
    @extends('layouts.app')
    @section('page_name', 'Data Kendaraan')
    @section('content')

    <div class="card-table">
        <div class="card-header-flex">
            <h3 class="card-title">Daftar Kendaraan Aktif (Sedang Parkir)</h3>
        </div>

        @if(session('success'))
            <div style="padding: 15px; background: #dcfce7; color: #166534; border-radius: 8px; margin-bottom: 20px; font-weight:bold;">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div style="padding: 15px; background: #fee2e2; color: #b91c1c; border-radius: 8px; margin-bottom: 20px; font-weight: bold;">
                {{ session('error') }}
            </div>
        @endif

        <table class="table-responsive">
            <thead>
                <tr>
                    <th>Plat Nomor</th>
                    <th class="text-center">Jenis</th>
                    <th class="text-center">Warna</th>
                    <th class="text-center">Pemilik</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kendaraan_parkir as $k)
                <tr>
                    <td style="font-weight: bold; color: #1e293b;">{{ $k->plat_nomor }}</td>
                    <td class="text-center">
                        @php
                            $badgeClass = match(strtolower($k->jenis_kendaraan)) {
                                'motor' => 'badge-motor',
                                'mobil' => 'badge-mobil',
                                default => 'badge-lainnya'
                            };
                        @endphp
                        <span class="badge {{ $badgeClass }}">{{ $k->jenis_kendaraan }}</span>
                    </td>
                    <td class="text-center text-gray">{{ $k->warna }}</td>
                    <td class="text-center">{{ $k->pemilik }}</td>
                    <td class="text-center">
                        <div class="action-group">
                            <a href="{{ route('kendaraan.edit', $k->id_kendaraan) }}" class="btn-edit">Edit</a>
                            <form action="{{ route('kendaraan.destroy', $k->id_kendaraan) }}" method="POST" onsubmit="return confirm('Hapus data ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-delete">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-gray" style="padding: 20px;">
                        Saat ini tidak ada kendaraan di area parkir.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        
        <div class="pagination-container">
            {{ $kendaraan_parkir->appends(request()->except('parkir_page'))->links('pagination::bootstrap-4') }}
        </div>

        <hr style="margin: 40px 0; border: none; border-top: 2px dashed #e2e8f0;">

        <h3 class="card-title" style="margin-bottom: 20px;">🏁 Riwayat Kendaraan Keluar</h3>
        <table class="table-responsive">
            <thead>
                <tr>
                    <th>Plat Nomor</th>
                    <th class="text-center">Jenis</th>
                    <th class="text-center">Warna</th>
                    <th class="text-center">Pemilik</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kendaraan_keluar as $k)
                <tr style="background-color: #fcfcfc; opacity: 0.85;">
                    <td style="font-weight: bold; color: #64748b;">{{ $k->plat_nomor }}</td>
                    <td class="text-center">
                        <span class="badge badge-keluar">{{ $k->jenis_kendaraan }}</span>
                    </td>
                    <td class="text-center text-gray">{{ $k->warna }}</td>
                    <td class="text-center" style="color: #94a3b8;">{{ $k->pemilik }}</td>
                    <td class="text-center">
                        <div class="action-group">
                            <a href="{{ route('kendaraan.edit', $k->id_kendaraan) }}" class="btn-edit" style="color: #94a3b8;">Edit</a>
                            <form action="{{ route('kendaraan.destroy', $k->id_kendaraan) }}" method="POST" onsubmit="return confirm('Hapus data ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-delete" style="color: #fca5a5;">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-gray" style="padding: 20px;">
                        Belum ada riwayat kendaraan keluar.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="pagination-container">
            {{ $kendaraan_keluar->appends(request()->except('keluar_page'))->links('pagination::bootstrap-4') }}
        </div>

    </div>
    @endsection
</body>
</html>