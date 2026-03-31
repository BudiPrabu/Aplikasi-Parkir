<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tarif</title>
    <style>
        .card-table {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .card-header-flex {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .table-responsive {
            width: 100%;
            border-bottom: 1px solid #f1f5f9;
            border-collapse: collapse;
        }

        .table-responsive thead tr {
            text-align: left;
            border-bottom: 2px solid var(--border-color);
        }

        .table-responsive th{
            border-bottom: 1px solid #e2e8f0;
            padding: 15px;
        }

        .table-responsive td {
            padding: 15px;
            border-bottom: 1px solid #f1f5f9;
            
        }

        .table-responsive tbody tr {
            border-bottom: 1px solid var(--border-color);
            transition: 0.2s;
        }

        .table-responsive tbody tr:hover {
            background-color: #f8fafc; 
        }


        .action-group {
            display: flex; 
            justify-content: center; 
            gap: 15px;
        }

        .btn-edit {
            color: #4f46e5;
            text-decoration: none;
            font-weight: 600;
        }
        .btn-add {
            background: #4f46e5;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
        }

        .btn-add:hover {
            background: #4338ca;
        }
        
        .btn-delete {
            color: #ef4444;
            background: none;
            border: none;
            cursor: pointer;
            font-weight: 600;
        }

        .alert-success {
            padding: 15px;
            background: #dcfce7;
            color: #166534;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    @extends('layouts.app')

    @section('page_name', 'Daftar Tarif Parkir')

    @section('content')
    <div class="card-table">
        <div class="card-header-flex">
            <h3 class="card-title">Pengaturan Tarif</h3>
            <a href="{{ route('tarif.create') }}" class="btn-add">+ Tambah Tarif</a>
        </div>

        @if(session('success'))
            <div class="alert-success">
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
                    <th>Jenis Kendaraan</th>
                    <th>Tarif / Jam</th>
                    <th style="text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tarifs as $t)
                <tr>
                    <td style="text-transform: capitalize;">{{ $t->jenis_kendaraan }}</td>
                    <td>Rp {{ number_format($t->tarif_per_jam, 0, ',', '.') }}</td>
                    <td>
                        <div class="action-group">
                            <a href="{{ route('tarif.edit', $t->id_tarif) }}" class="btn-edit">Edit</a>
                            
                            <form action="{{ route('tarif.destroy', $t->id_tarif) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus tarif ini?')">
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