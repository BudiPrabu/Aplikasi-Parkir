<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Tarif</title>
    <style>
        :root {
            --bg-color: #f8fafc;
            --border-color: #e2e8f0;
            --text-dark: #1e293b;
            --sidebar-width: 260px;
            --primary-color: #4f46e5;
            --danger-color: #ef4444;
        }

        body {
            margin: 0;
            background-color: var(--bg-color);
            font-family: 'Inter', sans-serif;
        }

        .sidebar {
            width: var(--sidebar-width);
            background-color: #1e293b;
            color: white;
            position: fixed;
            height: 100vh;
            left: 0; top: 0;
            display: flex;
            flex-direction: column;
            z-index: 100;
        }

        .main-container {
            margin-left: var(--sidebar-width);
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .topbar {
            height: 70px;
            background-color: #ffffff;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 40px;
            border-bottom: 1px solid var(--border-color);
            position: sticky;
            top: 0;
            z-index: 90;
        }

        .content { 
            padding: 30px 40px;
        }

        .card-table {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .card-header-flex {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .table-responsive {
            width: 100%;
            border-collapse: collapse;
        }

        .table-responsive th, .table-responsive td {
            padding: 15px;
            border-bottom: 1px solid var(--border-color);
            text-align: left;
        }

        .container-center {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 80vh;
            padding-top: 30px;
        }

        .card-form {
            width: 100%;
            max-width: 500px;
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
        }

        .card-title {
            text-align: center;
            margin-bottom: 25px;
            font-size: 1.4rem;
            color: var(--text-dark);
        }

        .form-group { margin-bottom: 20px; }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #374151;
        }

        .form-control {
            width: 100%;
            padding: 12px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            box-sizing: border-box;
            outline: none;
            transition: 0.3s;
        }

        .form-control:focus { 
            border-color: var(--primary-color); 
        }

        .btn-primary {
            width: 100%;
            padding: 14px;
            background: var(--primary-color);
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 700;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn-add {
            background: var(--primary-color);
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
        }

        .badge {
            background: #e2e8f0;
            padding: 4px 10px;
            border-radius: 10px;
            font-size: 0.8rem;
        }
        .link-back {
            display: block;
            text-align: center;
            margin-top: 25px;
            color: #64748b;
            text-decoration: none;
            font-size: 0.9rem;
        }

        .link-back:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    @extends('layouts.app')

    @section('page_name', 'Tambah Tarif')

    @section('content')
    <div class="container-center">
        <div class="card-form">
            <h2 class="card-title">TAMBAH TARIF</h2>
            
            @if(session('error'))
                <div style="padding: 15px; background: #fee2e2; color: #b91c1c; border-radius: 8px; margin-bottom: 20px; font-weight: bold; text-align: center;">
                    🚨 {{ session('error') }}
                </div>
            @endif
            <form action="{{ route('tarif.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Jenis Kendaraan</label>
                    <select name="jenis_kendaraan" class="form-control" required>
                        <option value="motor">Motor</option>
                        <option value="mobil">Mobil</option>
                        <option value="lainnya">Lainnya</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Tarif per Jam</label>
                    <input type="number" name="tarif_per_jam" class="form-control" placeholder="3000" required>
                </div>

                <button type="submit" class="btn-primary">Simpan Tarif</button>
            </form>
            
            <a href="{{ route('tarif.index') }}" class="link-back">
                &larr; Batal dan Kembali
            </a>
        </div>
    </div>
    @endsection
</body>
</html>