<div class="modal fade" id="peminjaman_create_modal" tabindex="-1" aria-labelledby="peminjamanCreateLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('peminjaman.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header  ">
                    <h5 class="modal-title" id="peminjamanCreateLabel">Tambah Peminjaman</h5>
                    <!-- Bootstrap 5 close button -->
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="tanggal_pinjam" class="form-label">Tanggal Pinjam</label>
                            <input type="date" name="tanggal_pinjam" id="tanggal_pinjam" class="form-control" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="tanggal_kembali" class="form-label">Tanggal Kembali</label>
                            <input type="date" name="tanggal_kembali" id="tanggal_kembali" class="form-control" required>
                        </div>
                    </div>


                    <div class="mb-3">
                        <label class="form-label">Barang yang Dipinjam</label>
                        <table class="table table-bordered" id="barangTable">
                            <thead>
                                <tr>
                                    <th>Barang</th>
                                    <th>Jumlah</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <select name="barang[0][commodity_id]" class="form-control select-barang">
                                            @foreach($commodities as $item)
                                            <option value="{{ $item->id }}">
                                                {{ $item->name }} - {{ $item->brand }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" name="barang[0][jumlah]" class="form-control" min="1" required>
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-danger btn-sm remove-row">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <button type="button" class="btn btn-sm btn-secondary" id="addRow">
                            <i class="fas fa-plus"></i> Tambah Barang
                        </button>
                    </div>

                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea name="keterangan" id="keterangan" rows="3" class="form-control"></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <!-- Bootstrap 5 dismiss attribute -->
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Ajukan</button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let rowIndex = 1;
        const addRowBtn = document.getElementById('addRow');
        const barangTable = document.querySelector('#barangTable tbody');

        addRowBtn.addEventListener('click', function() {
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
            <td>
                <select name="barang[${rowIndex}][commodity_id]" class="form-control select-barang">
                    @foreach($commodities as $item)
                        <option value="{{ $item->id }}">{{ $item->name }} - {{ $item->brand }} ({{ $item->condition }})</option>
                    @endforeach
                </select>
            </td>
            <td><input type="number" name="barang[${rowIndex}][jumlah]" class="form-control" min="1" required></td>
            <td class="text-center">
                <button type="button" class="btn btn-danger btn-sm remove-row"><i class="fas fa-trash"></i></button>
            </td>
        `;
            barangTable.appendChild(newRow);
            rowIndex++;
        });

        // Delegated delete
        document.querySelector('#barangTable').addEventListener('click', function(e) {
            const btn = e.target.closest('.remove-row');
            if (btn) btn.closest('tr').remove();
        });
    });
</script>
@endpush