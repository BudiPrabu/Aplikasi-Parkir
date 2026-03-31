<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Area Parkir</title>
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

        .btn-add:hover {
            background: #4338ca;
        }

        .text-center {
            text-align: center !important;
        }

        .badge-info {
            background: #e0e7ff;
            color: #4338ca;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .action-group {
            display: flex;
            justify-content: center;
            gap: 15px;
        }

        .btn-edit {
            color: #4f46e5;
            font-weight: 600;
            text-decoration: none;
            transition: 0.2s;
        }

        .btn-edit:hover {
            color: #3730a3;
            text-decoration: underline;
        }

        .btn-delete {
            color: #ef4444;
            background: none;
            border: none;
            cursor: pointer;
            font-weight: 600;
            padding: 0;
            transition: 0.2s;
        }

        .btn-delete:hover {
            color: #b91c1c;
        }
    </style>
</head>
<body>
    @extends('layouts.app')

    @section('page_name', 'Area Parkir')

    @section('content')
    <div class="card-table">
        <div class="card-header-flex">
            <h3 class="card-title">Data Area Parkir</h3>
            <a href="{{ route('area.create') }}" class="btn-add">+ Tambah Area</a>
        </div>

        @if(session('success'))
            <div class="alert-success" style="padding: 15px; background: #dcfce7; color: #166534; border-radius: 8px; margin-bottom: 20px;">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div style="padding: 15px; background: #fee2e2; color: #b91c1c; border-radius: 8px; margin-bottom: 20px; font-weight: bold;">
                🚨 {{ session('error') }}
            </div>
        @endif

        <table class="table-responsive">
            <thead>
                <tr>
                    <th>Nama Area</th>
                    <th class="text-center">Kapasitas</th>
                    <th class="text-center">Terisi</th>
                    <th class="text-center">Tersedia</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($areas as $a)
                <tr>
                    <td>{{ $a->nama_area }}</td>
                    <td class="text-center">{{ $a->kapasitas }}</td>
                    <td class="text-center">{{ $a->terisi_saat_ini }}</td>
                    <td class="text-center">
                        <span class="badge-info">{{ $a->kapasitas - $a->terisi_saat_ini }} Slot</span>
                    </td>
                    <td class="text-center">
                    <div class="action-group">
                        <a href="{{ route('area.edit', $a->id_area) }}" class="btn-edit">Edit</a>
                        
                        <form action="{{ route('area.destroy', $a->id_area) }}" method="POST" onsubmit="return confirm('Hapus area ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-delete">Hapus</button>
                        </form>
                    </div>
                </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endsection
</body>
</html>