<x-layout>
    <x-slot name="title">Approval Peminjaman Barang</x-slot>
    <x-slot name="page_heading">Persetujuan Peminjaman Barang</x-slot>

    <div class="card">
        <div class="card-body">
            @include('utilities.alert')

            <div class="table-responsive">
                <x-datatable>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Kode</th>
                            <th>Peminjam</th>
                            <th>Tanggal Pinjam</th>
                            <th>Tanggal Kembali</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($peminjaman as $p)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $p->kode_peminjaman }}</td>
                            <td>{{ $p->peminjam }}</td>
                            <td>{{ \Carbon\Carbon::parse($p->tanggal_pinjam)->format('d-m-Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($p->tanggal_kembali)->format('d-m-Y') }}</td>
                            <td>{{ $p->keterangan ?? '-' }}</td>
                            <td>
                                <form action="{{ route('peminjaman.approve', $p->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm">
                                        <i class="fas fa-check"></i> Setujui
                                    </button>
                                </form>

                                <!-- Tombol Tolak buka modal -->
                                <button type="button"
                                    class="btn btn-danger btn-sm"
                                    data-bs-toggle="modal"
                                    data-bs-target="#rejectModal"
                                    data-id="{{ $p->id }}">
                                    <i class="fas fa-times"></i> Tolak
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">Tidak ada peminjaman yang menunggu persetujuan</td>
                        </tr>
                        @endforelse
                    </tbody>
                </x-datatable>
            </div>
        </div>
    </div>

    {{-- Modal Penolakan --}}
    <div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" id="rejectForm">
                @csrf
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title" id="rejectModalLabel">Tolak Peminjaman</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Alasan Penolakan</label>
                            <textarea name="alasan" class="form-control" rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Tolak</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('js')
    <script>
        const rejectModal = document.getElementById('rejectModal');
        rejectModal.addEventListener('show.bs.modal', event => {
            const button = event.relatedTarget;
            const id = button.getAttribute('data-id');
            const form = document.getElementById('rejectForm');
            form.action = `/peminjaman/${id}/reject`;
        });
    </script>
    @endpush
</x-layout>