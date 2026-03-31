<?php

namespace App\Http\Controllers;

use App\Models\Kendaraan;
use App\Models\AreaParkir;
use App\Models\Tarif;    
use App\Models\Transaksi;
use Illuminate\Http\Request;

class KendaraanController extends Controller
{
    public function index()
    {
        $id_kendaraan_parkir = \App\Models\Transaksi::where('status', 'masuk')
                                                    ->pluck('id_kendaraan');

        $kendaraan_parkir = \App\Models\Kendaraan::whereIn('id_kendaraan', $id_kendaraan_parkir)
                            ->orderBy('id_kendaraan', 'desc')
                            ->paginate(5, ['*'], 'parkir_page');

        $kendaraan_keluar = \App\Models\Kendaraan::whereNotIn('id_kendaraan', $id_kendaraan_parkir)
                            ->orderBy('id_kendaraan', 'desc')
                            ->paginate(3, ['*'], 'keluar_page');

        return view('admin.kendaraan.index', compact('kendaraan_parkir', 'kendaraan_keluar'));
    }


    public function edit($id)
    {
        $kendaraan = \App\Models\Kendaraan::findOrFail($id);
        $areas = \App\Models\AreaParkir::all();
        $jenis_tarif = \App\Models\Tarif::all();

        $transaksi_aktif = \App\Models\Transaksi::where('id_kendaraan', $id)
                                                ->where('status', 'masuk')
                                                ->first();
        
        $current_area_id = $transaksi_aktif ? $transaksi_aktif->id_area : null;

        foreach($areas as $area) {
            $jumlah_parkir_asli = \App\Models\Transaksi::where('id_area', $area->id_area)
                                                       ->where('status', 'masuk')
                                                       ->count();
         
            $area->sisa_slot_asli = $area->kapasitas - $jumlah_parkir_asli;
        }

        return view('admin.kendaraan.edit', compact('kendaraan', 'areas', 'current_area_id', 'jenis_tarif'));
    }

    public function update(Request $request, $id)
    {
        $kendaraan = \App\Models\Kendaraan::findOrFail($id);
        $kendaraan->update([
            'plat_nomor' => strtoupper($request->plat_nomor),
            'jenis_kendaraan' => $request->jenis_kendaraan,
            'warna' => $request->warna,
            'pemilik' => $request->pemilik,
        ]);

        $transaksi_aktif = \App\Models\Transaksi::where('id_kendaraan', $id)
                                                ->where('status', 'masuk')
                                                ->first();

        if ($transaksi_aktif && $request->id_area && $transaksi_aktif->id_area != $request->id_area) {
            
            \App\Models\AreaParkir::where('id_area', $transaksi_aktif->id_area)->decrement('terisi');
            \App\Models\AreaParkir::where('id_area', $request->id_area)->increment('terisi');
            $transaksi_aktif->update(['id_area' => $request->id_area]);
        }

        \App\Models\LogAktivitas::catat('Mengedit data kendaraan plat: ' . $kendaraan->plat_nomor);
        return redirect()->route('kendaraan.index')->with('success', 'Data kendaraan dan area berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $kendaraan = Kendaraan::findOrFail($id);

        try {
            $kendaraan->delete();

            \App\Models\LogAktivitas::catat('Menghapus data kendaraan');
            return redirect()->route('kendaraan.index')->with('success', 'Data kendaraan berhasil dihapus.');
            
        } catch (\Illuminate\Database\QueryException $e) {
            if($e->getCode() == "23000") {
                return redirect()->route('kendaraan.index')->with('error', 'GAGAL : Kendaraan ini masih memiliki riwayat transaksi parkir!');
            }
            return redirect()->route('kendaraan.index')->with('error', 'Terjadi kesalahan pada database.');
        }
    }
}