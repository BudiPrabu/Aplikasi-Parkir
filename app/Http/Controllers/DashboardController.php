<?php

namespace App\Http\Controllers;

use App\Models\Kendaraan;
use App\Models\AreaParkir;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $total_kendaraan = Kendaraan::count();
        $total_area = AreaParkir::count();
        
        $user_aktif = User::count();
        
        $areas = AreaParkir::all();

        $kapasitas_global = 0;
        $terpakai_global = 0;

        foreach ($areas as $area) {

            $jumlah_di_lokasi = Transaksi::where('id_area', $area->id_area)
                                         ->where('status', 'masuk')
                                         ->count();
            
            $area->terisi_saat_ini = $jumlah_di_lokasi;
            $area->sisa_slot = $area->kapasitas - $jumlah_di_lokasi;

            $kapasitas_global += $area->kapasitas;
            $terpakai_global += $jumlah_di_lokasi;
        }

        return view('admin.dashboard', compact(
            'total_kendaraan', 
            'total_area', 
            'user_aktif',
            'kapasitas_global',
            'terpakai_global',
            'areas'
        ));
    }
}