<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ParkirApp - @yield('page_name')</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc; /* Warna background abu-abu terang */
            color: #1e293b;
        }

        /* =========================================
           TOP HEADER (Logo, Judul Halaman, Profil)
           ========================================= */
        .top-header {
            background-color: #ffffff;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 30px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 30px;
        }

        /* =========================================
           LOGO BARU (Konsisten dengan Halaman Login)
           ========================================= */
        .app-logo-new {
            font-size: 1.25rem;
            font-weight: 700;
            color: #1e293b; /* Warna teks gelap */
            display: flex;
            align-items: center;
            letter-spacing: 0.5px;
        }

        .app-logo-new .highlight {
            color: #4f46e5; /* Warna indigo pekat yang sama */
            font-weight: 700;
        }

        .page-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: #334155;
            text-transform: uppercase;
            border-left: 2px solid #e2e8f0;
            padding-left: 30px;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .user-badge {
            display: flex;
            align-items: center;
            gap: 10px;
            background: #f1f5f9;
            padding: 6px 15px;
            border-radius: 30px;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .role-tag {
            background: #4f46e5;
            color: white;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 0.7rem;
            text-transform: uppercase;
        }

        .btn-logout {
            background: #ef4444;
            color: white;
            border: none;
            padding: 8px 18px;
            border-radius: 20px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            font-size: 0.9rem;
            transition: 0.3s;
        }

        .btn-logout:hover {
            background: #dc2626;
        }

        /* =========================================
           TOP NAVIGATION (HANYA UNTUK ADMIN)
           ========================================= */
        .admin-nav-container {
            background-color: #ffffff;
            padding: 10px 30px;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            gap: 10px;
            overflow-x: auto;
        }

        .nav-item {
            text-decoration: none;
            color: #64748b;
            font-weight: 600;
            font-size: 0.95rem;
            padding: 10px 20px;
            border-radius: 8px;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 8px;
            white-space: nowrap;
        }

        .nav-item:hover {
            background-color: #f1f5f9;
            color: #4f46e5;
        }

        /* HIGHLIGHT AKTIF */
        .nav-item.active {
            background-color: #4f46e5;
            color: #ffffff;
            box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.2);
        }

        /* =========================================
           MAIN CONTENT AREA
           ========================================= */
        .main-wrapper {
            padding: 30px;
            max-width: 1400px;
            margin: 0 auto;
        }
    </style>
</head>
<body>

    <header class="top-header">
        <div class="header-left">
            <div class="app-logo-new">
                Sistem <span class="highlight">Parkir</span>
            </div>
            <div class="page-title">
                @yield('page_name')
            </div>
        </div>

        <div class="header-right">
            @auth
            <div class="user-badge">
                {{ Auth::user()->nama_lengkap ?? Auth::user()->username }}
                <span class="role-tag">{{ Auth::user()->role }}</span>
            </div>
            
            <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                @csrf
                <button type="submit" class="btn-logout">Logout</button>
            </form>
            @endauth
        </div>
    </header>

    @if(Auth::check() && Auth::user()->role == 'admin')
    <nav class="admin-nav-container">
        
        <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            📊 Dashboard
        </a>

        <a href="{{ route('user.index') }}" class="nav-item {{ request()->routeIs('user.*') ? 'active' : '' }}">
            👥 Manage User
        </a>

        <a href="{{ route('tarif.index') }}" class="nav-item {{ request()->routeIs('tarif.*') ? 'active' : '' }}">
            💰 Tarif Parkir
        </a>

        <a href="{{ route('area.index') }}" class="nav-item {{ request()->routeIs('area.*') ? 'active' : '' }}">
            📍 Area Parkir
        </a>

        <a href="{{ route('kendaraan.index') }}" class="nav-item {{ request()->routeIs('kendaraan.*') ? 'active' : '' }}">
            🚗 Kendaraan
        </a>

        <a href="{{ route('log-aktivitas.index') }}" class="nav-item {{ request()->routeIs('log-aktivitas.*') ? 'active' : '' }}">
            📜 Log Aktivitas
        </a>

    </nav>
    @endif

    <main class="main-wrapper">
        @yield('content')
    </main>

</body>
</html>