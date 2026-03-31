<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log Aktivitas - Admin</title>
    <style>
        :root {
            --indigo-primary: #4f46e5;
            --indigo-light: #e0e7ff;
            --slate-bg: #f8fafc;
            --text-dark: #1e293b;
            --text-muted: #64748b;
        }

        .container-log {
            padding: 30px;
            max-width: 1100px;
            margin: 0 auto;
        }

        .card-log {
            background: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .card-title {
            color: var(--indigo-primary);
            font-size: 1.5rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 25px;
            margin-top: 0;
        }

        .table-log {
            width: 100%;
            border-collapse: collapse;
        }

        .table-log th {
            text-align: left;
            padding: 15px;
            background-color: var(--slate-bg);
            color: var(--text-dark);
            font-size: 0.95rem;
            border-bottom: 2px solid #e2e8f0;
        }

        .table-log td {
            padding: 15px;
            border-bottom: 1px solid #f1f5f9;
            color: var(--text-dark);
            vertical-align: top;
        }

        .table-log tr:hover {
            background-color: #f8fafc;
        }

        .badge-role {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 700;
            background: var(--indigo-light);
            color: var(--indigo-primary);
            text-transform: capitalize;
            margin-top: 5px;
        }

        .text-waktu {
            color: var(--text-muted);
            font-size: 0.85rem;
            font-weight: 500;
        }

        .text-aktivitas {
            font-weight: 500;
            color: #334155;
        }

        .pagination-container {
            margin-top: 30px;
            display: flex;
            justify-content: center;
        }

        .pagination {
            display: flex;
            padding-left: 0;
            list-style: none;
            gap: 8px;
            margin: 0;
        }

        .page-item .page-link, .page-item span.page-link {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 38px;
            height: 38px;
            padding: 0 12px;
            color: var(--indigo-primary);
            text-decoration: none;
            background-color: white;
            border: 1px solid #e2e8f0;
            border-radius: 8px; 
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.2s;
        }

        .page-item .page-link:hover {
            background-color: var(--indigo-light);
            border-color: var(--indigo-primary);
        }

        .page-item.active .page-link, .page-item.active span.page-link {
            z-index: 3;
            color: white;
            background-color: var(--indigo-primary);
            border-color: var(--indigo-primary);
        }

        .page-item.disabled .page-link, .page-item.disabled span.page-link {
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
    @section('page_name', 'LOG AKTIVITAS')
    @section('content')

    <div class="container-log">
        <div class="card-log">
            <h2 class="card-title">📜 Riwayat Log Aktivitas</h2>

            <table class="table-log">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th width="20%">Waktu Kejadian</th>
                        <th width="25%">Pengguna</th>
                        <th width="50%">Aktivitas yang Dilakukan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $index => $log)
                    <tr>
                        <td>{{ $logs->firstItem() + $index }}</td>
                        
                        <td class="text-waktu">
                            {{ \Carbon\Carbon::parse($log->waktu_aktivitas)->format('d M Y, H:i:s') }}
                        </td>
                        
                        <td>
                            <strong>{{ $log->user->nama_lengkap ?? 'User Tidak Ditemukan' }}</strong><br>
                            <span class="badge-role">{{ $log->user->role ?? '-' }}</span>
                        </td>
                        
                        <td class="text-aktivitas">
                            {{ $log->aktivitas }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" style="text-align: center; padding: 40px; color: #64748b;">
                            Belum ada riwayat aktivitas yang tercatat dalam sistem.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="pagination-container">
                {{ $logs->links('pagination::bootstrap-4') }}
            </div>

        </div>
    </div>

    @endsection
</body>
</html>