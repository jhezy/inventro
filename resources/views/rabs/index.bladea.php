<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Rencana Anggaran Biaya (RAB)') }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-6xl mx-auto">
        <a href="{{ route('rabs.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg">+ Tambah RAB</a>

        <table class="table-auto w-full mt-6 border-collapse border border-gray-300 text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border p-2">Tahun</th>
                    <th class="border p-2">Bulan</th>
                    <th class="border p-2">Nama Barang</th>
                    <th class="border p-2">Jumlah</th>
                    <th class="border p-2">Harga</th>
                    <th class="border p-2">Total</th>
                    <th class="border p-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rabs as $rab)
                <tr>
                    <td class="border p-2 text-center">{{ $rab->tahun }}</td>
                    <td class="border p-2 text-center">{{ ucfirst($rab->bulan) }}</td>
                    <td class="border p-2">{{ $rab->nama_barang }}</td>
                    <td class="border p-2 text-right">{{ $rab->jumlah }}</td>
                    <td class="border p-2 text-right">Rp {{ number_format($rab->harga, 0, ',', '.') }}</td>
                    <td class="border p-2 text-right">Rp {{ number_format($rab->jumlah * $rab->harga, 0, ',', '.') }}</td>
                    <td class="border p-2 text-center">
                        <form action="{{ route('rabs.destroy', $rab->id) }}" method="POST" onsubmit="return confirm('Hapus data ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="bg-red-500 text-white px-3 py-1 rounded">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>