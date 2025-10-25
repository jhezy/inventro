<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BarangKeluarController extends Controller
{
    // Tampilkan daftar barang keluar
    public function index()
    {
        $barangKeluar = DB::table('barang_keluar')
            ->join('commodities', 'barang_keluar.commodity_id', '=', 'commodities.id')
            ->select(
                'barang_keluar.*',
                'commodities.name as nama_barang',
                'commodities.quantity as stok_sekarang'
            )
            ->orderByDesc('barang_keluar.tanggal_keluar')
            ->get();

        $commodities = DB::table('commodities')->orderBy('name')->get();

        return view('barang-keluars.index', compact('barangKeluar', 'commodities'));
    }

    // Simpan barang keluar baru
    public function store(Request $request)
    {
        $request->validate([
            'commodity_id' => 'required|exists:commodities,id',
            'jumlah_keluar' => 'required|integer|min:1',
            'tanggal_keluar' => 'required|date',
        ]);

        $barang = DB::table('commodities')->where('id', $request->commodity_id)->first();

        if (!$barang) {
            return back()->with('error', 'Barang tidak ditemukan.');
        }

        if ($barang->quantity < $request->jumlah_keluar) {
            return back()->with('error', 'Stok barang tidak mencukupi.');
        }

        // Simpan data barang keluar
        DB::table('barang_keluar')->insert([
            'commodity_id' => $request->commodity_id,
            'jumlah_keluar' => $request->jumlah_keluar,
            'tanggal_keluar' => $request->tanggal_keluar,
            'keterangan' => $request->keterangan,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Update stok di commodities
        DB::table('commodities')
            ->where('id', $request->commodity_id)
            ->update([
                'quantity' => $barang->quantity - $request->jumlah_keluar
            ]);

        return redirect()->back()->with('success', 'Barang keluar berhasil ditambahkan dan stok diperbarui.');
    }

    // Hapus data barang keluar (dan kembalikan stok)
    public function destroy($id)
    {
        $data = DB::table('barang_keluar')->where('id', $id)->first();

        if (!$data) {
            return back()->with('error', 'Data tidak ditemukan.');
        }

        $barang = DB::table('commodities')->where('id', $data->commodity_id)->first();

        if ($barang) {
            // Kembalikan stok
            DB::table('commodities')
                ->where('id', $data->commodity_id)
                ->update([
                    'quantity' => $barang->quantity + $data->jumlah_keluar
                ]);
        }

        DB::table('barang_keluar')->where('id', $id)->delete();

        return back()->with('success', 'Data barang keluar dihapus dan stok dikembalikan.');
    }
}
