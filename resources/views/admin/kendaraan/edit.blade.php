<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kendaraan</title>
    <style>
        :root {
            --indigo-primary: #4f46e5;
            --indigo-hover: #4338ca;
            --slate-bg: #f1f5f9;
            --text-dark: #1e293b;
        }

        .container-center {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 80vh;
            background-color: var(--slate-bg);
            padding: 20px;
        }

        .card-form {
            background: white;
            width: 100%;
            max-width: 500px;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        .card-title {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--text-dark);
            text-align: center;
            margin-bottom: 30px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 0.9rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 8px;
        }

        .form-control {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 1rem;
            box-sizing: border-box;
            transition: border-color 0.2s;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--indigo-primary);
            ring: 2px var(--indigo-primary);
        }

        .btn-update {
            width: 100%;
            background-color: var(--indigo-primary);
            color: white;
            padding: 14px;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
        }

        .btn-update:hover {
            background-color: var(--indigo-hover);
        }

        .link-back {
            display: block;
            text-align: center;
            margin-top: 20px;
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

    @section('content')
    <link rel="stylesheet" href="{{ asset('css/kendaraan_edit.css') }}">

    <div class="container-center">
        <div class="card-form">
            <h2 class="card-title">EDIT KENDARAAN</h2>

            <form action="{{ route('kendaraan.update', $kendaraan->id_kendaraan) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label>Plat Nomor</label>
                    <input type="text" name="plat_nomor" class="form-control" 
                        value="{{ old('plat_nomor', $kendaraan->plat_nomor) }}" required>
                </div>

                <div class="form-group" style="margin-bottom: 15px;">
                    <label>Jenis Kendaraan</label>
                    <select name="jenis_kendaraan" class="form-control" required>
                        <option value="">-- Pilih Jenis Kendaraan --</option>
                        @foreach($jenis_tarif as $t)
                            <option value="{{ $t->jenis_kendaraan }}" {{ $kendaraan->jenis_kendaraan == $t->jenis_kendaraan ? 'selected' : '' }}>
                                {{ $t->jenis_kendaraan }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group" style="margin-bottom: 15px;">
                    <label>Area Parkir (Lokasi Saat Ini)</label>
                   <select name="id_area" class="form-control" required>
                        @if(!$current_area_id)
                            <option value="">-- Kendaraan Tidak Sedang Parkir --</option>
                        @endif

                        @foreach($areas as $a)
                            @php
                                $is_current = ($a->id_area == $current_area_id);
                            @endphp
                            
                            @if(!$is_current && $a->sisa_slot_asli <= 0)
                                <option value="" disabled>{{ $a->nama_area }} (PENUH)</option>
                            @else
                                <option value="{{ $a->id_area }}" {{ $is_current ? 'selected' : '' }}>
                                    {{ $a->nama_area }} (Sisa: {{ $a->sisa_slot_asli }} Slot)
                                </option>
                            @endif
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Warna</label>
                    <input type="text" name="warna" class="form-control" 
                        value="{{ old('warna', $kendaraan->warna) }}" required>
                </div>

                <div class="form-group">
                    <label>Nama Pemilik</label>
                    <input type="text" name="pemilik" class="form-control" 
                        value="{{ old('pemilik', $kendaraan->pemilik) }}" required>
                </div>

                <button type="submit" class="btn-update">
                    Update Data
                </button>
            </form>

            <a href="{{ route('kendaraan.index') }}" class="link-back">
                &larr; Batal dan Kembali
            </a>
        </div>
    </div>
    @endsection
</body>
</html>