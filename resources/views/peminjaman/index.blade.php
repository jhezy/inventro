<x-layout>
    <x-slot name="title">Halaman Peminjaman Barang</x-slot>
    <x-slot name="page_heading">Daftar Peminjaman Barang</x-slot>

    <div class="card">
        <div class="card-body">
            @include('utilities.alert')

            <div class="d-flex justify-content-end mb-3">
                @can('tambah peminjaman')
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#peminjaman_create_modal">
                    <i class="fas fa-fw fa-plus"></i> Tambah Peminjaman
                </button>
                @endcan
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <x-datatable>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Kode</th>
                                <th>Peminjam</th>
                                <th>Barang yang Dipinjam</th>
                                <th>Tanggal Pinjam</th>
                                <th>Tanggal Kembali</th>
                                <th>Status</th>
                                <th>Disetujui Oleh</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($peminjaman as $p)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $p->kode_peminjaman }}</td>
                                <td>{{ $p->peminjam }}</td>
                                <td>
                                    @if(!empty($p->barang) && $p->barang->isNotEmpty())
                                    <ul class="mb-0 ps-3">
                                        @foreach($p->barang as $item)
                                        <li>{{ $item->commodity_name }} ({{ $item->jumlah }} unit)</li>
                                        @endforeach
                                    </ul>
                                    @else
                                    <span class="text-muted">Tidak ada barang</span>
                                    @endif
                                </td>

                                <td>{{ \Carbon\Carbon::parse($p->tanggal_pinjam)->format('d-m-Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($p->tanggal_kembali)->format('d-m-Y') }}</td>
                                <td>
                                    @switch($p->status)
                                    @case('pending')
                                    <span class="badge bg-warning text-white">Menunggu Persetujuan</span>
                                    @break
                                    @case('disetujui')
                                    <span class="badge bg-success text-light">Disetujui</span>
                                    @break
                                    @case('ditolak')
                                    <span class="badge bg-danger text-white">Ditolak</span>
                                    @break
                                    @case('pending pengembalian')
                                    <span class="badge bg-primary text-white">Menunggu Persetujuan Pengembalian</span>
                                    @break
                                    @case('dikembalikan')
                                    <span class="badge bg-secondary text-white">Dikembalikan</span>
                                    @break
                                    @default
                                    <span class="badge bg-secondary">Tidak Diketahui</span>
                                    @endswitch
                                </td>
                                <td>{{ $p->approved_by_name ?? '-' }}</td>

                                <td class="text-center">
                                    <div class="btn-group">

                                        {{-- APPROVE / REJECT PEMINJAMAN --}}
                                        @can('approve peminjaman')
                                        @if($p->status == 'pending')
                                        <form action="{{ route('peminjaman.approve', $p->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm" title="Setujui Peminjaman">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('peminjaman.reject', $p->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm" title="Tolak Peminjaman">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>
                                        @endif
                                        @endcan

                                        {{-- APPROVE / REJECT PENGEMBALIAN --}}
                                        @can('approve peminjaman')
                                        @if($p->status == 'pending pengembalian')
                                        <form action="{{ route('peminjaman.approve_pengembalian', $p->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm" title="Setujui Pengembalian">
                                                <i class="fas fa-check-double"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('peminjaman.reject_pengembalian', $p->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm" title="Tolak Pengembalian">
                                                <i class="fas fa-times-circle"></i>
                                            </button>
                                        </form>
                                        @endif
                                        @endcan

                                        {{-- EDIT --}}
                                        @can('ubah peminjaman')
                                        @if($p->status == 'pending')
                                        <button
                                            type="button"
                                            class="btn btn-warning btn-sm btn-edit-peminjaman"
                                            data-id="{{ $p->id }}"
                                            data-tanggal_pinjam="{{ $p->tanggal_pinjam }}"
                                            data-tanggal_kembali="{{ $p->tanggal_kembali }}"
                                            data-keterangan="{{ $p->keterangan }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        @endif
                                        @endcan

                                        {{-- KEMBALIKAN BARANG --}}
                                        @can('kembalikan peminjaman')
                                        @if($p->status == 'disetujui')
                                        <form action="{{ route('peminjaman.kembalikan', $p->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-info btn-sm" title="Ajukan Pengembalian">
                                                <i class="fas fa-undo"> kembalikan</i>
                                            </button>
                                        </form>
                                        @endif
                                        @endcan

                                        {{-- HAPUS --}}
                                        @can('hapus peminjaman')
                                        @if(in_array($p->status, ['pending', 'ditolak']))
                                        <form action="{{ route('peminjaman.destroy', $p->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm delete-button" title="Hapus">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                        @endif
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted">Belum ada data peminjaman</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </x-datatable>
                </div>
            </div>
        </div>
    </div>

    @push('modal')
    @include('peminjaman.modal.create')
    @include('peminjaman.modal.edit')
    @endpush

    @push('js')
    @include('peminjaman._script')
    @endpush
</x-layout>