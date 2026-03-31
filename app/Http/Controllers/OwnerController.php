<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use Carbon\Carbon;

class OwnerController extends Controller
{
    public function index(Request $request)
    {
        // set default tangal
        $start_date = $request->start_date ?? Carbon::now()->startOfMonth()->format('Y-m-d');
        $end_date = $request->end_date ?? Carbon::now()->format('Y-m-d');

        // narik data transaksi
        $query = Transaksi::with(['kendaraan', 'area'])
                          ->where('status', 'keluar');

        // filter tanggal
        if ($start_date && $end_date) {
            $query->whereDate('waktu_keluar', '>=', $start_date)
                  ->whereDate('waktu_keluar', '<=', $end_date);
        }

        $transaksis = $query->orderBy('waktu_keluar', 'desc')->get();

        // Rumus hitung total buat kotak
        $total_pendapatan = $transaksis->sum('biaya_total');
        $total_kendaraan = $transaksis->count();

        return view('owner.dashboard', compact('transaksis', 'total_pendapatan', 'total_kendaraan', 'start_date', 'end_date'));
    }
}