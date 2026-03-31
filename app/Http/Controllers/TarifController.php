<?php

namespace App\Http\Controllers;

use App\Models\Tarif;
use Illuminate\Http\Request;

class TarifController extends Controller
{
    public function index() {
        $tarifs = Tarif::all();
        return view('admin.tarif.index', compact('tarifs'));
    }

    public function create() {
        return view('admin.tarif.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis_kendaraan' => 'required',
            'tarif_per_jam' => 'required|numeric'
        ]);

        $cek_duplikat = \App\Models\Tarif::whereRaw('LOWER(jenis_kendaraan) = ?', [strtolower($request->jenis_kendaraan)])->first();

        if ($cek_duplikat) {
            return redirect()->back()->with('error', 'Gagal! Tarif untuk kendaraan "' . $request->jenis_kendaraan . '" sudah terdaftar. 
                                                                                                                       Silahkan gunakan tombol edit');
        }

        \App\Models\Tarif::create([
            'jenis_kendaraan' => strtolower($request->jenis_kendaraan),
            'tarif_per_jam' => $request->tarif_per_jam
        ]);

        \App\Models\LogAktivitas::catat('Menambahkan tarif');
        return redirect()->route('tarif.index')->with('success', 'Tarif baru berhasil ditambahkan!');
    }

    public function edit($id) {
        $tarif = Tarif::findOrFail($id);
        return view('admin.tarif.edit', compact('tarif'));
    }

    public function update(Request $request, $id) {
        $tarif = Tarif::findOrFail($id);
        $tarif->update($request->all());

        \App\Models\LogAktivitas::catat('Memperbarui harga tarif');
        return redirect()->route('tarif.index')->with('success', 'Tarif berhasil diupdate');
    }

    public function destroy($id)
    {
        try {
            $tarif = \App\Models\Tarif::findOrFail($id);
            $jenis = $tarif->jenis_kendaraan;
            
            $tarif->delete();

            \App\Models\LogAktivitas::catat('Menghapus tarif');
            return redirect()->route('tarif.index')->with('success', 'Data tarif berhasil dihapus!');
            
        } catch (\Illuminate\Database\QueryException $e) {
            if($e->getCode() == "23000"){
                return redirect()->route('tarif.index')->with('error', 'Gagal! Tarif tidak bisa dihapus
                                                               karena sudah memiliki riwayat transaksi');
            }
            
            return redirect()->route('tarif.index')->with('error', 'Terjadi kesalahan pada database.');
        }
    }
}