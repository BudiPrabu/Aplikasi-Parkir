<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LogAktivitas;

class LogController extends Controller
{
    public function index()
    {
        $logs = LogAktivitas::with('user')->orderBy('waktu_aktivitas', 'desc')->paginate(10);

        return view('admin.log-aktivitas.index', compact('logs'));
    }
}