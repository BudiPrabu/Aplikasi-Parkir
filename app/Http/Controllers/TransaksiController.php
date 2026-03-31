<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Kendaraan;
use App\Models\AreaParkir;
use App\Models\Tarif;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{
    public function dashboard()
    {
        $areas = AreaParkir::all();
        
        foreach($areas as $area) {
            $terisi = Transaksi::where('id_area', $area->id_area)
                               ->where('status', 'masuk')
                               ->count();
            $area->sisa_slot = $area->kapasitas - $terisi;
        }

        $tarifs = Tarif::select('jenis_kendaraan')->distinct()->get();

        if (!session()->has('petugas_login_time')) {
            session(['petugas_login_time' => \Carbon\Carbon::now()]);
        }

        $transaksis = Transaksi::with(['kendaraan', 'area'])
            ->where('status', 'masuk')
            ->orWhere(function($query) {
                $query->where('status', 'keluar')
                      ->where('waktu_keluar', '>=', session('petugas_login_time'));
            })
            ->orderBy('waktu_masuk', 'desc')
            ->paginate(12);
        
        return view('petugas.dashboard', compact('areas', 'tarifs', 'transaksis'));
    }

    public function storeMasuk(Request $request)
    {
        $request->validate([
            'plat_nomor' => 'required',
            'id_area' => 'required',
            'jenis_kendaraan' => 'required'
        ]);

        $plat_input = strtoupper($request->plat_nomor);
        $kendaraan_cek = Kendaraan::where('plat_nomor', $plat_input)->first();
        if ($kendaraan_cek) {
            $sedang_parkir = Transaksi::where('id_kendaraan', $kendaraan_cek->id_kendaraan)
                                      ->where('status', 'masuk')
                                      ->first();
            if ($sedang_parkir) {
                return back()->with('error', 'GAGAL: Kendaraan dengan plat ' . $plat_input . ' masih berada di dalam area parkir!');
            }
        }

        $area = AreaParkir::findOrFail($request->id_area);
        $tarif = Tarif::where('jenis_kendaraan', $request->jenis_kendaraan)->first();
        if(!$tarif) {
            return back()->with('error', 'Tarif untuk jenis ' . $request->jenis_kendaraan . ' belum dibuat Admin!');
        }
        
        $terpakai = Transaksi::where('id_area', $area->id_area)
                             ->where('status', 'masuk')
                             ->count();
                             
        if ($terpakai >= $area->kapasitas) {
            return back()->with('error', 'Gagal! Kapasitas Area ' . $area->nama_area . ' sudah penuh!');
        }

        $kendaraan = Kendaraan::firstOrCreate(
            ['plat_nomor' => strtoupper($request->plat_nomor)],
            ['jenis_kendaraan' => $request->jenis_kendaraan, 
            'warna' => '-',
            'pemilik' => 'umum',
            'id_user' => Auth::user()->id_user]
        );

        Transaksi::create([
            'id_kendaraan' => $kendaraan->id_kendaraan,
            'id_user' => Auth::user()->id_user,
            'id_area' => $area->id_area,
            'id_tarif' => $tarif->id_tarif,
            'waktu_masuk' => Carbon::now(),
            'status' => 'masuk',
            'biaya_total' => 0
        ]);
        
        \App\Models\LogAktivitas::catat('Mencatat kendaraan masuk: ' . strtoupper($request->plat_nomor));
        return redirect()->route('petugas.dashboard')->with('success', 'Berhasil! Kendaraan masuk ke Area ' . $area->nama_area);
    }

    public function indexKeluar()
    {
        $kendaraan_parkir = Transaksi::with(['kendaraan', 'area'])->where('status', 'masuk')->get();
        
        return view('petugas.parkir_keluar', compact('kendaraan_parkir'));
    }

    public function cariKendaraan(Request $request)
    {
        $plat_input = strtoupper($request->plat_nomor);

        $transaksi = Transaksi::whereHas('kendaraan', function($q) use ($plat_input) {
                $q->where('plat_nomor', $plat_input);
            })->where('status', 'masuk')->first();

        return redirect()->route('transaksi.halaman_bayar', $transaksi->id_parkir);
    }

    public function halamanBayar($id)
    {
        $transaksi = Transaksi::with(['kendaraan', 'tarif', 'area'])->findOrFail($id);

        $waktu_masuk = \Carbon\Carbon::parse($transaksi->waktu_masuk);
        $waktu_keluar = \Carbon\Carbon::now();
        
        $menit = $waktu_masuk->diffInMinutes($waktu_keluar);
        $durasi = (int) ceil($menit / 60); 

        if ($durasi < 1) {
            $durasi = 1; 
        }

        $jenis = $transaksi->kendaraan->jenis_kendaraan;
        $tarif_live = Tarif::where('jenis_kendaraan', $jenis)->first();
    
        $harga_per_jam = $tarif_live ? ($tarif_live->harga_per_jam ?? $tarif_live->tarif_per_jam 
                                        ?? $tarif_live->tarif ?? $tarif_live->harga ?? 0) : 0;

        $biaya = $durasi * $harga_per_jam;

        return view('petugas.parkir_bayar', compact('transaksi', 'durasi', 'biaya', 'waktu_keluar',
                                                 'waktu_masuk', 'harga_per_jam'));
    }

    public function simpanKeluar(Request $request, $id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->update([
            'waktu_keluar' => $request->waktu_keluar,
            'durasi_jam' => $request->durasi,
            'biaya_total' => $request->biaya,
            'status' => 'keluar'
        ]);

        \App\Models\LogAktivitas::catat('Menyelesaikan pembayaran parkir: ' . $transaksi->kendaraan->plat_nomor);
        return redirect()->route('transaksi.struk', $transaksi->id_parkir);
    }

    public function cetakStruk($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        return view('petugas.struk_parkir', compact('transaksi'));
    }
}