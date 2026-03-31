<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parkir Keluar</title>
    <style>
        .page-container {
            max-width: 900px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .header-flex {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .keluar-title {
            color: #ef4444;
            font-size: 2rem;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .btn-kembali {
            background: #f1f5f9;
            color: #475569;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            transition: 0.2s;
        }

        .btn-kembali:hover {
            background: #e2e8f0;
            color: #1e293b;
        }

        .search-container {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
            text-align: center;
        }

        .input-raksasa {
            width: 100%;
            font-size: 2rem;
            text-align: center;
            padding: 15px;
            border: 3px solid #e2e8f0;
            border-radius: 12px;
            text-transform: uppercase;
            font-weight: bold;
            color: #1e293b;
            box-sizing: border-box;
            transition: 0.3s;
        }

        .input-raksasa:focus {
            border-color: #ef4444;
            outline: none;
            box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.1);
        }

        .search-subtitle {
            color: #64748b;
            margin-top: 10px;
            margin-bottom: 0;
        }

        .grid-kendaraan {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 15px;
        }

        .card-plat {
            background: white;
            border: 2px solid #e2e8f0;
            padding: 20px;
            border-radius: 12px;
            cursor: pointer;
            transition: 0.2s;
            position: relative;
            overflow: hidden;
        }

        .card-plat:hover {
            border-color: #ef4444;
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(239, 68, 68, 0.15);
        }

        .plat-text {
            font-size: 1.5rem;
            font-weight: 900;
            color: #1e293b;
            margin: 0 0 10px 0;
            letter-spacing: 1px;
        }

        .detail-text {
            color: #64748b;
            font-size: 0.9rem;
            margin: 0;
            display: flex;
            justify-content: space-between;
        }

        .badge-area {
            background: #f1f5f9;
            color: #475569;
            padding: 3px 8px;
            border-radius: 6px;
            font-weight: bold;
            font-size: 0.8rem;
        }

        .empty-state {
            grid-column: 1 / -1;
            text-align: center;
            padding: 50px;
            background: white;
            border-radius: 15px;
            color: #94a3b8;
        }

        .alert-error {
            background: #fee2e2;
            color: #b91c1c;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 25px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    @extends('layouts.app')
    @section('page_name', 'Proses Parkir Keluar')
    @section('content')

    <div class="page-container">
        
        <div class="header-flex">
            <h2 class="keluar-title">
                <span style="font-size: 2.5rem;">🚘</span> CHECK-OUT
            </h2>
            <a href="{{ route('petugas.dashboard') }}" class="btn-kembali">Kembali ke Dashboard ➡️</a>
        </div>

        @if(session('error'))
            <div class="alert-error">
                ⚠️ {{ session('error') }}
            </div>
        @endif

        <div class="search-container">
            <input type="text" id="searchInput" class="input-raksasa" placeholder="CARI PLAT NOMOR DI SINI..." autofocus autocomplete="off">
            <p class="search-subtitle">Isi untuk mencari, lalu <b>klik kotak plat nomor</b> untuk menghitung biaya.</p>
        </div>

        <div class="grid-kendaraan" id="listKendaraan">
            @forelse($kendaraan_parkir as $trx)
                <div class="card-plat" data-plat="{{ $trx->kendaraan->plat_nomor }}" onclick="submitPlat('{{ $trx->kendaraan->plat_nomor }}')">
                    <h3 class="plat-text">{{ $trx->kendaraan->plat_nomor }}</h3>
                    <div class="detail-text">
                        <span>{{ $trx->kendaraan->jenis_kendaraan }}</span>
                        <span class="badge-area">{{ $trx->area->nama_area }}</span>
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <div style="font-size: 3rem; margin-bottom: 10px;">🍃</div>
                    <h3>Parkiran Kosong</h3>
                    <p>Tidak ada kendaraan yang sedang parkir saat ini.</p>
                </div>
            @endforelse
        </div>

        <form id="formCheckout" action="{{ route('transaksi.cari') }}" method="POST" style="display:none;">
            @csrf
            <input type="hidden" name="plat_nomor" id="hiddenPlat">
        </form>

    </div>

    <script>
        function submitPlat(platNomor) {
            document.getElementById('hiddenPlat').value = platNomor;
            document.getElementById('formCheckout').submit();
        }

        document.getElementById('searchInput').addEventListener('input', function (e) {
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

            let filterText = value.replace(/\s/g, '');
            let cards = document.querySelectorAll('.card-plat');

            cards.forEach(card => {
                let platText = card.getAttribute('data-plat').replace(/\s/g, ''); 
                
                if(platText.includes(filterText)) {
                    card.style.display = 'block'; 
                } else {
                    card.style.display = 'none';
                }
            });
        });
    </script>
    
    @endsection
</body>
</html>