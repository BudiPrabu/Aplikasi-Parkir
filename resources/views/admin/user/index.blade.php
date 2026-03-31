<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar User</title>
    <style>
        .card {
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

        .card-title {
            margin: 0;
            color: #1e293b;
        }

        .alert-success {
            padding: 15px;
            background: #dcfce7;
            color: #166534;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .table-responsive {
            width: 100%;
            border-collapse: collapse;
        }

        .table-responsive thead tr {
            text-align: left;
            border-bottom: 2px solid #f1f5f9;
        }

        .table-responsive th, 
        .table-responsive td {
            padding: 15px;
        }

        .table-responsive tbody tr {
            border-bottom: 1px solid #f1f5f9;
        }

        .table-responsive tbody tr:hover {
            background-color: #f8fafc; 
        }

        .badge-role {
            display: inline-block;
            background: #4f46e5;
            color : white;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 0.85rem;
            text-transform: capitalize; 
        }

        .action-group {
            display: flex;
            justify-content: center;
            gap: 10px;
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

        .btn-edit {
            color: #4f46e5;
            text-decoration: none;
            font-weight: 600;
        }

        .btn-delete {
            color: #ef4444;
            background: none;
            border: none;
            cursor: pointer;
            font-weight: 600;
        }
    </style>
</head>
<body>
    @extends('layouts.app')

    @section('page_name', 'Daftar User')

    @section('content')
    <div class="card">
        <div class="card-header-flex">
            <h3 class="card-title">Data User Terdaftar</h3>
            <a href="{{ route('user.create') }}" class="btn-add">+ Tambah User</a>
        </div>

        @if(session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
        @endif

        <table class="table-responsive">
            <thead>
                <tr>
                    <th>Nama Lengkap</th>
                    <th>Username</th>
                    <th style="text-align: center;">Role</th>
                    <th style="text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $u)
                <tr>
                    <td>{{ $u->nama_lengkap }}</td>
                    <td>{{ $u->username }}</td>
                    <td style="text-align: center;">
                        <span class="badge-role">{{ $u->role }}</span>
                    </td>
                    <td>
                        <div class="action-group">
                            <a href="{{ route('user.edit', $u->id_user) }}" class="btn-edit">Edit</a>
                            
                            <form action="{{ route('user.destroy', $u->id_user) }}" method="POST" onsubmit="return confirm('Hapus user ini?')">
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