<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RabController extends Controller
{
    public function index()
    {
        $rabs = DB::table('rabs')->orderBy('tahun', 'desc')->orderBy('bulan', 'desc')->get();

        return view('rabs.index', compact('rabs'));
    }

    public function create()
    {
        return view('rabs.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tahun' => 'required|digits:4',
            'bulan' => 'required|string',
            'nama_barang' => 'required|array',
            'nama_barang.*' => 'required|string|max:255',
            'jumlah' => 'required|array',
            'jumlah.*' => 'required|integer|min:1',
            'harga' => 'required|array',
            'harga.*' => 'required|numeric|min:0',
        ]);

        $data = [];
        foreach ($validated['nama_barang'] as $i => $nama) {
            $data[] = [
                'tahun' => $validated['tahun'],
                'bulan' => $validated['bulan'],
                'nama_barang' => $nama,
                'jumlah' => $validated['jumlah'][$i],
                'harga' => $validated['harga'][$i],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('rabs')->insert($data);

        return redirect()->route('rabs.index')->with('success', 'Data RAB berhasil ditambahkan!');
    }

    public function show($id)
    {
        $rab = DB::table('rabs')->where('id', $id)->first();

        if (!$rab) {
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
        }

        $items = DB::table('rabs')->where('tahun', $rab->tahun)->where('bulan', $rab->bulan)->get();

        return response()->json([
            'id' => $rab->id,
            'tahun' => $rab->tahun,
            'bulan' => $rab->bulan,
            'items' => $items->map(function ($item) {
                return [
                    'nama_barang' => $item->nama_barang,
                    'jumlah' => $item->jumlah,
                    'harga' => $item->harga,
                ];
            }),
        ]);
    }

    // ====== EDIT & UPDATE ======
    public function edit($id)
    {
        $rab = DB::table('rabs')->where('id', $id)->first();
        if (!$rab) {
            return redirect()->route('rabs.index')->with('error', 'Data tidak ditemukan');
        }

        $items = DB::table('rabs')->where('tahun', $rab->tahun)->where('bulan', $rab->bulan)->get();

        return view('rabs.edit', compact('rab', 'items'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'tahun' => 'required|digits:4',
            'bulan' => 'required|string',
            'nama_barang' => 'required|array',
            'nama_barang.*' => 'required|string|max:255',
            'jumlah' => 'required|array',
            'jumlah.*' => 'required|integer|min:1',
            'harga' => 'required|array',
            'harga.*' => 'required|numeric|min:0',
        ]);

        // Ambil data RAB lama
        $rabLama = DB::table('rabs')->where('id', $id)->first();
        if (!$rabLama) {
            return redirect()->route('rabs.index')->with('error', 'Data tidak ditemukan');
        }

        // Hapus semua barang lama di RAB ini (tahun+bulan sama)
        DB::table('rabs')->where('tahun', $rabLama->tahun)->where('bulan', $rabLama->bulan)->delete();

        // Masukkan barang baru
        $data = [];
        foreach ($validated['nama_barang'] as $i => $nama) {
            $data[] = [
                'tahun' => $validated['tahun'],
                'bulan' => $validated['bulan'],
                'nama_barang' => $nama,
                'jumlah' => $validated['jumlah'][$i],
                'harga' => $validated['harga'][$i],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        DB::table('rabs')->insert($data);

        return redirect()->route('rabs.index')->with('success', 'Data RAB berhasil diupdate!');
    }

    public function destroy($id)
    {
        $rab = DB::table('rabs')->where('id', $id)->first();
        if ($rab) {
            DB::table('rabs')->where('tahun', $rab->tahun)->where('bulan', $rab->bulan)->delete();
        }

        return redirect()->route('rabs.index')->with('success', 'Data RAB berhasil dihapus!');
    }
}
