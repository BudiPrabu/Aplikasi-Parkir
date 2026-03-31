<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Petugas</title>
    <style>
        .petugas-grid {
            display: grid;
            grid-template-columns: 1.2fr 2fr;
            gap: 20px;
            margin-top: 20px;
        }

        .col-form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .card-panel {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }

        .panel-scroll {
            max-height: 80vh;
            overflow-y: auto;
        }

        .title-primary {
            color: #3730a3;
            margin-top: 0;
            margin-bottom: 20px;
        }

        .alert-success {
            background: #dcfce7;
            color: #166534;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .alert-error {
            background: #fee2e2;
            color: #b91c1c;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .table-responsive {
            width: 100%;
            border-collapse: collapse;
        }

        .table-responsive th {
            text-align: left;
            padding: 12px;
            border-bottom: 2px solid #f1f5f9;
            color: #64748b;
        }

        .table-responsive td {
            padding: 12px;
            border-bottom: 1px solid #f1f5f9;
        }

        .td-plat {
            font-weight: 800;
            font-size: 1.1rem;
        }

        .td-empty {
            text-align: center;
            color: #94a3b8;
            padding: 30px;
        }

        .badge-masuk {
            background: #dcfce7;
            color: #166534;
            padding: 5px 10px;
            border-radius: 10px;
            font-weight: bold;
            font-size: 0.8rem;
        }

        .badge-keluar {
            background: #fee2e2;
            color: #b91c1c;
            padding: 5px 10px;
            border-radius: 10px;
            font-weight: bold;
            font-size: 0.8rem;
        }

        .baris-keluar td {
            background-color: #f8fafc;
            color: #94a3b8;
            opacity: 0.7;
        }

        .form-label {
            font-weight: bold;
            color: #64748b;
            font-size: 0.9rem;
            margin-bottom: 8px;
            display: block;
        }

        .input-jumbo {
            width: 100%;
            font-size: 1.8rem;
            text-align: center;
            padding: 15px;
            margin-bottom: 15px;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            text-transform: uppercase;
            font-weight: bold;
            box-sizing: border-box;
        }

        .input-jumbo:focus {
            border-color: #4f46e5;
            outline: none;
        }

        .form-select {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-size: 1rem;
            box-sizing: border-box;
            font-weight: 600;
            color: #475569;
        }

        .form-select:focus {
            border-color: #4f46e5;
            outline: none;
        }

        .jenis-group {
            display: flex;
            gap: 10px;
            margin-bottom: 15px;
        }

        .jenis-box {
            flex: 1;
            cursor: pointer;
        }

        .jenis-box input {
            display: none;
        }

        .box-content {
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            padding: 12px 5px;
            text-align: center;
            font-weight: 700;
            color: #64748b;
            transition: 0.2s;
            font-size: 0.95rem;
        }

        .jenis-box input:checked + .box-content {
            border-color: #4f46e5;
            background: #e0e7ff;
            color: #3730a3;
            box-shadow: 0 4px 10px rgba(79, 70, 229, 0.15);
        }

        .btn-masuk {
            width: 100%;
            padding: 15px;
            font-size: 1.1rem;
            font-weight: bold;
            background: #4f46e5;
            color: white;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn-masuk:hover {
            background: #3730a3;
        }

        .btn-keluar-raksasa {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: white;
            border: 3px solid #ef4444;
            border-radius: 15px;
            text-decoration: none;
            color: #ef4444;
            padding: 20px;
            transition: 0.3s;
        }

        .btn-keluar-raksasa:hover {
            background: #ef4444;
            color: white;
        }

        .icon-raksasa {
            font-size: 3rem;
            margin-bottom: 5px;
        }

        .text-raksasa {
            margin: 0;
        }

        .sub-raksasa {
            font-size: 0.9rem;
        }

        .header-aktivitas {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .header-aktivitas .title-primary {
            margin-bottom: 0;
        }

        .pagination {
            display: flex;
            padding-left: 0;
            list-style: none;
            gap: 4px;
            margin: 0;
        }

        .page-item .page-link,
        .page-item span.page-link {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 30px;
            height: 30px;
            padding: 0 8px;
            color: #4f46e5;
            text-decoration: none;
            background-color: white;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.85rem;
            transition: all 0.2s;
        }

        .page-item .page-link:hover {
            background-color: #e0e7ff;
            border-color: #4f46e5;
        }

        .page-item.active .page-link,
        .page-item.active span.page-link {
            z-index: 3;
            color: white;
            background-color: #4f46e5;
            border-color: #4f46e5;
        }

        .page-item.disabled .page-link,
        .page-item.disabled span.page-link {
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

    @section('page_name', 'Dashboard Petugas')

    @section('content')
    
    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert-error">
            {{ session('error') }}
        </div>
    @endif

    <div class="petugas-grid">
        
        <div class="col-form">
            
            <div class="card-panel" style="border-top: 5px solid #4f46e5;">
                <h3 class="title-primary">⬇️ Kendaraan Masuk</h3>
                <form action="{{ route('transaksi.store_masuk') }}" method="POST">
                    @csrf
                    
                    <label class="form-label">PLAT NOMOR</label>
                    <input type="text" name="plat_nomor" id="inputPlat" class="input-jumbo" placeholder="Contoh: D 1234 XY" required autofocus>

                    <label class="form-label">JENIS KENDARAAN</label>
                    <div class="jenis-group">
                        @foreach($tarifs as $index => $t)
                            <label class="jenis-box">
                                <input type="radio" name="jenis_kendaraan" value="{{ $t->jenis_kendaraan }}" required {{ $index == 0 ? 'checked' : '' }}>
                                <div class="box-content">
                                    {{ $t->jenis_kendaraan }}
                                </div>
                            </label>
                        @endforeach
                    </div>

                    <label class="form-label">PILIH AREA</label>
                    <select name="id_area" class="form-select" required>
                        <option value="">-- Pilih Area Blok --</option>
                        @foreach($areas as $a)
                            @if($a->sisa_slot <= 0)
                                <option value="" disabled>{{ $a->nama_area }} (PENUH)</option>
                            @else
                                <option value="{{ $a->id_area }}">{{ $a->nama_area }} (Sisa: {{ $a->sisa_slot }})</option>
                            @endif
                        @endforeach
                    </select>

                    <button type="submit" class="btn-masuk">SIMPAN & MASUK</button>
                </form>
            </div>

            <a href="{{ route('transaksi.keluar') }}" class="btn-keluar-raksasa">
                <div class="icon-raksasa">⬆️</div>
                <h3 class="text-raksasa">PARKIR KELUAR</h3>
                <span class="sub-raksasa">Hitung Biaya & Struk</span>
            </a>

        </div>

        <div class="card-panel panel-scroll">
            
            <div class="header-aktivitas">
                <h3 class="title-primary">📋 Aktivitas Parkir</h3>
                <div>
                    {{ $transaksis->links('pagination::bootstrap-4') }}
                </div>
            </div>

            <table class="table-responsive">
                <thead>
                    <tr>
                        <th>Plat Nomor</th>
                        <th>Area</th>
                        <th>Jam Masuk</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transaksis as $trx)
                    <tr class="{{ $trx->status == 'keluar' ? 'baris-keluar' : '' }}">
                        <td class="td-plat">{{ $trx->kendaraan->plat_nomor }}</td>
                        <td>{{ $trx->kendaraan->jenis_kendaraan }} - {{ $trx->area->nama_area }}</td>
                        <td>{{ \Carbon\Carbon::parse($trx->waktu_masuk)->format('H:i') }}</td>
                        <td>
                            @if($trx->status == 'masuk')
                                <span class="badge-masuk">Sedang Parkir</span>
                            @else
                                <span class="badge-keluar">Sudah Keluar</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="td-empty">
                            Belum ada aktivitas kendaraan di sesi ini.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

    <script>
        document.getElementById('inputPlat').addEventListener('input', function (e) {
            let value = this.value.toUpperCase().replace(/[^A-Z0-9]/g, '');
            let match = value.match(/^([A-Z]{0,1})(\d{0,4})([A-Z]{0,3})$/);
            
            if (match) {
                let formatted = match[1];
                if (match[2]) formatted += ' ' + match[2];
                if (match[3]) formatted += ' ' + match[3]; 
                this.value = formatted.trim();
            } else {
                this.value = value;
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            let savedJenis = localStorage.getItem('jenis_kendaraan_terpilih');
            
            if(savedJenis) {
                let radioToSelect = document.querySelector('input[name="jenis_kendaraan"][value="' + savedJenis + '"]');
                if(radioToSelect) {
                    radioToSelect.checked = true;
                }
            }

            let jenisRadios = document.querySelectorAll('input[name="jenis_kendaraan"]');
            jenisRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    localStorage.setItem('jenis_kendaraan_terpilih', this.value);
                });
            });
        });
    </script>
    @endsection
</body>
</html>