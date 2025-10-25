<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Http\Requests\StorePeminjamanRequest;
use App\Http\Requests\UpdatePeminjamanRequest;

class PeminjamanController extends Controller
{
    public function index()
    {
        // Ambil semua data peminjaman
        $peminjaman = DB::table('peminjaman')
            ->leftJoin('users', 'peminjaman.user_id', '=', 'users.id')
            ->leftJoin('users as approver', 'peminjaman.approved_by', '=', 'approver.id')
            ->select(
                'peminjaman.id',
                'peminjaman.kode_peminjaman',
                'peminjaman.tanggal_pinjam',
                'peminjaman.tanggal_kembali',
                'peminjaman.status',
                'peminjaman.keterangan',
                'users.name as peminjam',
                'approver.name as approved_by_name'
            )
            ->orderByDesc('peminjaman.created_at')
            ->get();

        // Ambil semua barang dari setiap peminjaman (grouped by peminjaman_id)
        $barangPerPeminjaman = DB::table('peminjaman_items')
            ->join('commodities', 'peminjaman_items.commodity_id', '=', 'commodities.id')
            ->select(
                'peminjaman_items.peminjaman_id',
                'commodities.name as commodity_name',
                'commodities.brand',
                'peminjaman_items.jumlah'
            )
            ->get()
            ->groupBy('peminjaman_id');

        // Masukkan data barang ke setiap record peminjaman
        foreach ($peminjaman as $p) {
            $p->barang = $barangPerPeminjaman->get($p->id, collect());
        }

        $commodities = DB::table('commodities')
            ->select('id', 'name', 'brand', 'condition')
            ->orderBy('name', 'ASC')
            ->get();

        return view('peminjaman.index', compact('peminjaman', 'commodities'));
    }




    public function create()
    {
        $commodities = DB::table('commodities')
            ->select('id', 'name', 'brand', 'condition')
            ->orderBy('name', 'ASC')
            ->get();

        return view('peminjaman.create', compact('commodities'));
    }

    public function store(StorePeminjamanRequest $request)
    {
        // Cek stok tiap barang
        if (!empty($request->barang)) {
            foreach ($request->barang as $item) {
                $commodityId = $item['commodity_id'];
                $jumlahDiminta = $item['jumlah'];

                // Ambil total stok commodity
                $commodity = DB::table('commodities')->where('id', $commodityId)->first();
                if (!$commodity) {
                    return back()->with('error', 'Commodity tidak ditemukan.');
                }

                // Hitung jumlah yang sedang dipinjam (pending + disetujui)
                $totalDipinjam = DB::table('peminjaman_items')
                    ->join('peminjaman', 'peminjaman_items.peminjaman_id', '=', 'peminjaman.id')
                    ->where('peminjaman_items.commodity_id', $commodityId)
                    ->whereIn('peminjaman.status', ['pending', 'disetujui', 'pending pengembalian'])
                    ->sum('peminjaman_items.jumlah');

                // Cek jika melebihi stok
                if (($totalDipinjam + $jumlahDiminta) > $commodity->quantity) {
                    return back()->with('error', 'Jumlah peminjaman untuk ' . $commodity->name . ' melebihi stok tersedia (' . $commodity->quantity . ').');
                }
            }
        }

        // Jika lolos validasi, lanjut simpan peminjaman
        $kode = 'PMJ-' . date('Ymd') . '-' . strtoupper(Str::random(4));

        $peminjaman_id = DB::table('peminjaman')->insertGetId([
            'kode_peminjaman' => $kode,
            'user_id' => Auth::id(),
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_kembali' => $request->tanggal_kembali,
            'status' => 'pending',
            'keterangan' => $request->keterangan,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        foreach ($request->barang as $item) {
            DB::table('peminjaman_items')->insert([
                'peminjaman_id' => $peminjaman_id,
                'commodity_id' => $item['commodity_id'],
                'jumlah' => $item['jumlah'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Kirim notifikasi ke admin & kepsek
        $users = DB::table('users')->get();
        foreach ($users as $user) {
            DB::table('notifications')->insert([
                'user_id' => $user->id,
                'title' => 'Pengajuan Peminjaman Baru',
                'message' => 'Ada pengajuan peminjaman baru oleh ' . Auth::user()->name,
                'link' => route('peminjaman.index'),
                'is_read' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil diajukan.');
    }


    public function edit($id)
    {
        $peminjaman = DB::table('peminjaman')->where('id', $id)->first();

        if (!$peminjaman) {
            return redirect()->route('peminjaman.index')->with('error', 'Data tidak ditemukan.');
        }

        $barangDipinjam = DB::table('peminjaman_items')
            ->join('commodities', 'peminjaman_items.commodity_id', '=', 'commodities.id')
            ->where('peminjaman_items.peminjaman_id', $id)
            ->select('peminjaman_items.*', 'commodities.name', 'commodities.brand', 'commodities.condition')
            ->get();

        $commodities = DB::table('commodities')
            ->select('id', 'name', 'brand', 'condition')
            ->orderBy('name', 'ASC')
            ->get();

        return view('peminjaman.edit', compact('peminjaman', 'barangDipinjam', 'commodities'));
    }

    public function update(UpdatePeminjamanRequest $request, $id)
    {
        $peminjaman = DB::table('peminjaman')->where('id', $id)->first();
        if (!$peminjaman) {
            return redirect()->route('peminjaman.index')->with('error', 'Data tidak ditemukan.');
        }

        DB::table('peminjaman')->where('id', $id)->update([
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_kembali' => $request->tanggal_kembali,
            'keterangan' => $request->keterangan,
            'updated_at' => now(),
        ]);

        DB::table('peminjaman_items')->where('peminjaman_id', $id)->delete();

        if (!empty($request->barang)) {
            foreach ($request->barang as $item) {
                DB::table('peminjaman_items')->insert([
                    'peminjaman_id' => $id,
                    'commodity_id' => $item['commodity_id'],
                    'jumlah' => $item['jumlah'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        return redirect()->route('peminjaman.index')->with('success', 'Data peminjaman berhasil diperbarui.');
    }

    public function approve($id)
    {
        $peminjaman = DB::table('peminjaman')->where('id', $id)->first();
        if (!$peminjaman) {
            return back()->with('error', 'Peminjaman tidak ditemukan.');
        }

        if ($peminjaman->status === 'pending') {
            DB::table('peminjaman')->where('id', $id)->update([
                'status' => 'disetujui',
                'approved_by' => Auth::id(),
                'updated_at' => now(),
            ]);
            return back()->with('success', 'Peminjaman disetujui.');
        }

        if ($peminjaman->status === 'pending pengembalian') {
            DB::table('peminjaman')->where('id', $id)->update([
                'status' => 'dikembalikan',
                'approved_by' => Auth::id(),
                'updated_at' => now(),
            ]);

            DB::table('peminjaman_items')
                ->where('peminjaman_id', $id)
                ->update([
                    'dikembalikan' => true,
                    'tanggal_pengembalian' => now(),
                    'updated_at' => now(),
                ]);

            return back()->with('success', 'Pengembalian disetujui.');
        }


        return back()->with('info', 'Status peminjaman sudah final.');
    }

    public function reject(Request $request, $id)
    {
        $peminjaman = DB::table('peminjaman')->where('id', $id)->first();
        if (!$peminjaman) {
            return back()->with('error', 'Data tidak ditemukan.');
        }

        if ($peminjaman->status === 'pending') {
            DB::table('peminjaman')->where('id', $id)->update([
                'status' => 'ditolak',
                'approved_by' => Auth::id(),
                'alasan_penolakan' => $request->alasan,
                'updated_at' => now(),
            ]);
            return back()->with('warning', 'Peminjaman ditolak.');
        }

        if ($peminjaman->status === 'pending pengembalian') {
            DB::table('peminjaman')->where('id', $id)->update([
                'status' => 'pengembalian ditolak',
                'approved_by' => Auth::id(),
                'alasan_penolakan' => $request->alasan,
                'updated_at' => now(),
            ]);
            return back()->with('warning', 'Pengembalian ditolak.');
        }

        return back()->with('info', 'Tidak ada aksi yang bisa dilakukan.');
    }

    public function show($id)
    {
        $peminjaman = DB::table('peminjaman')
            ->leftJoin('users', 'peminjaman.user_id', '=', 'users.id')
            ->leftJoin('users as approver', 'peminjaman.approved_by', '=', 'approver.id')
            ->select('peminjaman.*', 'users.name as peminjam', 'approver.name as approved_by_name')
            ->where('peminjaman.id', $id)
            ->first();

        if (!$peminjaman) {
            return redirect()->route('peminjaman.index')->with('error', 'Data tidak ditemukan.');
        }

        $items = DB::table('peminjaman_items')
            ->join('commodities', 'peminjaman_items.commodity_id', '=', 'commodities.id')
            ->where('peminjaman_items.peminjaman_id', $id)
            ->select('peminjaman_items.*', 'commodities.name as commodity_name', 'commodities.brand')
            ->get();

        return view('peminjaman.show', compact('peminjaman', 'items'));
    }

    public function approve_pengembalian($id)
    {
        $peminjaman = DB::table('peminjaman')->where('id', $id)->first();

        if (!$peminjaman || $peminjaman->status !== 'pending pengembalian') {
            return back()->with('error', 'Data pengembalian tidak valid atau sudah diproses.');
        }

        DB::table('peminjaman')->where('id', $id)->update([
            'status' => 'dikembalikan',
            'approved_by' => Auth::id(),
            'updated_at' => now(),
        ]);

        // Update item agar ditandai sudah dikembalikan
        DB::table('peminjaman_items')
            ->where('peminjaman_id', $id)
            ->update([
                'dikembalikan' => true,
                'tanggal_pengembalian' => now(),
                'updated_at' => now(),
            ]);

        return back()->with('success', 'Pengembalian barang disetujui.');
    }

    public function reject_pengembalian(Request $request, $id)
    {
        $peminjaman = DB::table('peminjaman')->where('id', $id)->first();

        if (!$peminjaman || $peminjaman->status !== 'pending pengembalian') {
            return back()->with('error', 'Data pengembalian tidak valid atau sudah diproses.');
        }

        DB::table('peminjaman')->where('id', $id)->update([
            'status' => 'disetujui', // kembali ke status sebelumnya
            'approved_by' => Auth::id(),
            'alasan_penolakan' => $request->alasan ?? 'Pengembalian ditolak oleh admin',
            'updated_at' => now(),
        ]);

        return back()->with('warning', 'Pengembalian barang ditolak.');
    }


    public function kembalikan($id)
    {
        $peminjaman = DB::table('peminjaman')->where('id', $id)->first();

        if (!$peminjaman || $peminjaman->status !== 'disetujui') {
            return back()->with('error', 'Peminjaman belum disetujui atau tidak valid.');
        }

        // Update status menjadi pending pengembalian
        DB::table('peminjaman')->where('id', $id)->update([
            'status' => 'pending pengembalian',
            'updated_at' => now(),
        ]);

        // Kirim notifikasi ke admin & kepsek
        $users = DB::table('users')->get();

        foreach ($users as $user) {
            DB::table('notifications')->insert([
                'user_id' => $user->id,
                'title' => 'Pengajuan Pengembalian Barang',
                'message' => 'User ' . Auth::user()->name . ' mengajukan pengembalian barang.',
                'link' => route('peminjaman.index'),
                'is_read' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return back()->with('success', 'Permintaan pengembalian dikirim untuk disetujui.');
    }


    public function destroy($id)
    {
        $peminjaman = DB::table('peminjaman')->where('id', $id)->first();

        if (!$peminjaman) {
            return back()->with('error', 'Data peminjaman tidak ditemukan.');
        }

        // Hapus semua item terkait
        DB::table('peminjaman_items')->where('peminjaman_id', $id)->delete();

        // Hapus data utama
        DB::table('peminjaman')->where('id', $id)->delete();

        return back()->with('success', 'Data peminjaman berhasil dihapus.');
    }
}
