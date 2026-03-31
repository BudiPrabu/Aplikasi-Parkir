<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tamabah Area</title>
    <style>
        .container-center {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 100vh;
            background-color: #f8fafc;
            padding-top: 50px;
        }

        .card-form {
            width: 100%;
            max-width: 550px; 
            background: #ffffff;
            padding: 40px;
            border-radius: 16px; 
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
        }

        .card-title {
            text-align: center;
            font-size: 1.5rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 30px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #1e293b;
            font-size: 0.95rem;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            font-size: 1rem;
            color: #475569;
            box-sizing: border-box;
            transition: border-color 0.2s;
        }

        .form-control:focus {
            outline: none;
            border-color: #4f46e5;
        }

        .btn-primary {
            width: 100%;
            padding: 14px;
            background-color: #4f46e5;
            color: #ffffff;
            border: none;
            border-radius: 10px;
            font-weight: 700;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-top: 10px;
        }

        .btn-primary:hover {
            background-color: #4338ca;
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

    @section('page_name', 'Tambah Area')

    @section('content')
    <div class="container-center">
        <div class="card-form">
            <h2 class="card-title">TAMBAH AREA</h2>

            <form action="{{ route('area.store') }}" method="POST">
                @csrf
                
                <div class="form-group">
                    <label>Nama Area / Blok</label>
                    <input type="text" name="nama_area" class="form-control" 
                        placeholder="Contoh: Blok A - Lantai 1" required>
                </div>

                <div class="form-group">
                    <label>Total Kapasitas</label>
                    <input type="number" name="kapasitas" class="form-control" 
                        placeholder="Masukkan total slot parkir" required min="1">
                </div>

                <button type="submit" class="btn-primary">
                    Simpan Area
                </button>
            </form>

            <a href="{{ route('area.index') }}" class="link-back">
                &larr; Batal dan Kembali
            </a>
        </div>
    </div>
    @endsection
</body>
</html>