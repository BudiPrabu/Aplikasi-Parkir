    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Edit Tarif</title>
        <style>
            :root {
                --primary-indigo: #4f46e5;
                --primary-hover: #4338ca;
                --bg-slate: #f8fafc;
                --text-main: #1e293b;
                --text-muted: #64748b;
                --border-color: #e2e8f0;
            }

            .container-center {
                display: flex;
                justify-content: center;
                align-items: center;
                min-height: 80vh;
                background-color: var(--bg-slate);
                padding: 20px;
            }

            .card-form {
                background: white;
                width: 100%;
                max-width: 450px;
                padding: 40px;
                border-radius: 16px;
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            }

            .card-title {
                font-size: 1.5rem;
                font-weight: 800;
                color: var(--text-main);
                text-align: center;
                margin-bottom: 30px;
                letter-spacing: 1px;
            }

            .form-group {
                margin-bottom: 20px;
            }

            .form-group label {
                display: block;
                font-size: 0.9rem;
                font-weight: 600;
                color: var(--text-main);
                margin-bottom: 8px;
            }

            .form-control {
                width: 100%;
                padding: 12px 16px;
                border: 1.5px solid var(--border-color);
                border-radius: 10px;
                font-size: 1rem;
                color: var(--text-main);
                transition: all 0.2s ease;
                box-sizing: border-box;
            }

            .form-control:focus {
                outline: none;
                border-color: var(--primary-indigo);
                box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
            }

            .btn-primary {
                width: 100%;
                background-color: var(--primary-indigo);
                color: white;
                padding: 14px;
                border: none;
                border-radius: 10px;
                font-size: 1rem;
                font-weight: 700;
                cursor: pointer;
                transition: background 0.3s ease;
                margin-top: 10px;
            }

            .btn-primary:hover {
                background-color: var(--primary-hover);
                box-shadow: 0 4px 12px rgba(79, 70, 229, 0.2);
            }

            @media (max-width: 480px) {
                .card-form {
                    padding: 25px;
                }
            }
        </style>
    </head>
    <body>
        @extends('layouts.app')

        @section('page_name', 'Edit Tarif')

        @section('content')
        <div class="container-center">
            <div class="card-form">
                <h2 class="card-title">EDIT TARIF</h2>

                <form action="{{ route('tarif.update', $tarif->id_tarif) }}" method="POST">
                    @csrf
                    @method('PUT') <div class="form-group">
                        <label>Jenis Kendaraan</label>
                        <select name="jenis_kendaraan" class="form-control" required>
                            <option value="motor" {{ $tarif->jenis_kendaraan == 'motor' ? 'selected' : '' }}>Motor</option>
                            <option value="mobil" {{ $tarif->jenis_kendaraan == 'mobil' ? 'selected' : '' }}>Mobil</option>
                            <option value="lainnya" {{ $tarif->jenis_kendaraan == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Tarif per Jam (Rp)</label>
                        <input type="number" name="tarif_per_jam" class="form-control" 
                            value="{{ (int) $tarif->tarif_per_jam }}" required>
                    </div>

                    <button type="submit" class="btn-primary">
                        Update Tarif
                    </button>
                </form>

                <div style="margin-top: 20px; text-align: center;">
                    <a href="{{ route('tarif.index') }}" style="color: #64748b; text-decoration: none; font-size: 0.9rem;">
                        &larr; Batal dan Kembali
                    </a>
                </div>
            </div>
        </div>
        @endsection
    </body>
    </html>