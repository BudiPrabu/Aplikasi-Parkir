<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AreaParkir; 
use App\Models\Kendaraan;
use App\Models\Transaksi;

class AreaParkirController extends Controller
{
    public function index()
    {
        $areas = AreaParkir::all();

       foreach ($areas as $area) {
            $jumlah_terisi = Transaksi::where('id_area', $area->id_area)
                                      ->where('status', 'masuk')
                                      ->count();
            $area->terisi_saat_ini = $jumlah_terisi;
        }
        return view('admin.area.index', compact('areas'));
    }

    public function create() {
        return view('admin.area.create');
    }

    public function store(Request $request) {
        $request->validate([
            'nama_area' => 'required|max:50',
            'kapasitas' => 'required|numeric|min:1',
        ]);

        AreaParkir::create([
            'nama_area' => $request->nama_area,
            'kapasitas' => $request->kapasitas,
            'terisi' => 0 
        ]);

        \App\Models\LogAktivitas::catat('Menambah area parkir: ' . $request->nama_area);
        return redirect()->route('area.index')->with('success', 'Area parkir berhasil ditambahkan');
    }

    public function edit($id) {
        $area = AreaParkir::findOrFail($id);
        $jumlah_terisi = Transaksi::where('id_area', $area->id_area)
                                  ->where('status', 'masuk')
                                  ->count();
        $area->terisi_saat_ini = $jumlah_terisi;

        return view('admin.area.edit', compact('area'));
    }

    public function update(Request $request, $id) {
        $area = AreaParkir::findOrFail($id);
        $area->update($request->all());

        \App\Models\LogAktivitas::catat('Mengupdate area parkir: ' . $request->nama_area);
        return redirect()->route('area.index')->with('success', 'Area parkir berhasil diupdate');
    }

    public function destroy($id)
    {
        try {
            $area = \App\Models\AreaParkir::findOrFail($id);
            $nama_area = $area->nama_area;
            
            $area->delete();

            \App\Models\LogAktivitas::catat('Menghapus area parkir');
            return redirect()->route('area.index')->with('success', 'Data area parkir berhasil dihapus!');
            
        } catch (\Illuminate\Database\QueryException $e) {
            if($e->getCode() == "23000"){
                return redirect()->route('area.index')->with('error', 'Gagal! Area ini tidak bisa dihapus karena memiliki riwayat transaksi');
            }
            
            return redirect()->route('area.index')->with('error', 'Terjadi kesalahan pada database saat menghapus area.');
        }
    }
}
