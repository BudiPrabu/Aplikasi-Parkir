<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // 1. Cek apakah user sudah login atau belum
        if (!Auth::check()) {
            return redirect('/login');
        }

        // 2. Cek apakah role user SAMA dengan role yang diizinkan di web.php
        if (strtolower(Auth::user()->role) !== strtolower($role)) {
            // Kalau rolenya beda, tendang tampilkan error 403 (Tidak ada akses)
            abort(403, 'Akses Ditolak! Anda tidak memiliki izin ke halaman ini.');
        }

        return $next($request);
    }
}