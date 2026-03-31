<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Area</title>
    <style>
        .container-center {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 80vh;
            padding-top: 50px;
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
            font-weight: 700;
            color: #1e293b;
            text-transform: uppercase;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-control {
            width: 100%;
            padding: 12px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            box-sizing: border-box;
            outline: none;
        }

        .btn-primary {
            width: 100%;
            padding: 14px;
            background-color: #4f46e5; 
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 700;
            cursor: pointer;
            transition: 0.3s;
        }

        .link-back {
            display: block;
            text-align: center;
            margin-top: 20px;
            text-decoration: none;
            color: #64748b;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    @extends('layouts.app')

    @section('page_name', 'Edit Area Parkir')

    @section('content')
    <div class="container-center">
        <div class="card-form">
            <h2 class="card-title">EDIT AREA</h2>

            <form action="{{ route('area.update', $area->id_area) }}" method="POST">
                @csrf
                @method('PUT') 
                
                <div class="form-group">
                    <label>Nama Area / Blok</label>
                    <input type="text" name="nama_area" class="form-control" 
                        value="{{ $area->nama_area }}" required>
                </div>

                <div class="form-group">
                    <label>Total Kapasitas</label>
                    <input type="number" name="kapasitas" class="form-control" 
                        value="{{ $area->kapasitas }}" required min="1">
                </div>

                <div class="form-group">
                    <label>Jumlah Terisi</label>
                    <input type="number" name="terisi" class="form-control" 
                         value="{{ $area->terisi_saat_ini }}" required min="0">
                    <small style="color: #64748b;">*Sesuaikan jika ada selisih data di lapangan</small>
                </div>

                <button type="submit" class="btn-primary">
                    Update Data Area
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