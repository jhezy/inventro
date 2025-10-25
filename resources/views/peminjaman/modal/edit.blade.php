<div class="modal fade" id="peminjaman_edit_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form id="editPeminjamanForm" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title">Edit Peminjaman</h5>
                    <button type="button" class="close text-dark" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit_tanggal_pinjam">Tanggal Pinjam</label>
                        <input type="date" name="tanggal_pinjam" id="edit_tanggal_pinjam" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="edit_tanggal_kembali">Tanggal Kembali</label>
                        <input type="date" name="tanggal_kembali" id="edit_tanggal_kembali" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Barang yang Dipinjam</label>
                        <table class="table table-bordered" id="editBarangTable">
                            <thead>
                                <tr>
                                    <th>Barang</th>
                                    <th>Jumlah</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="editBarangBody">
                                {{-- Akan diisi lewat AJAX --}}
                            </tbody>
                        </table>
                        <button type="button" class="btn btn-sm btn-secondary" id="editAddRow">
                            <i class="fas fa-plus"></i> Tambah Barang
                        </button>
                    </div>

                    <div class="form-group">
                        <label for="edit_keterangan">Keterangan</label>
                        <textarea name="keterangan" id="edit_keterangan" rows="3" class="form-control"></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning">Simpan Perubahan</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let editRowIndex = 0;

        // Tambah baris baru
        document.getElementById('editAddRow').addEventListener('click', function() {
            const tableBody = document.getElementById('editBarangBody');
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
            <td>
                <select name="barang[${editRowIndex}][commodity_id]" class="form-control select-barang">
                    @foreach($commodities as $item)
                        <option value="{{ $item->id }}">{{ $item->name }} - {{ $item->brand }} ({{ $item->condition }})</option>
                    @endforeach
                </select>
            </td>
            <td><input type="number" name="barang[${editRowIndex}][jumlah]" class="form-control" min="1" required></td>
            <td class="text-center">
                <button type="button" class="btn btn-danger btn-sm remove-row"><i class="fas fa-trash"></i></button>
            </td>
        `;
            tableBody.appendChild(newRow);
            editRowIndex++;
        });

        // Hapus baris
        document.getElementById('editBarangBody').addEventListener('click', function(e) {
            if (e.target.closest('.remove-row')) {
                e.target.closest('tr').remove();
            }
        });

        // Load data ke modal edit via AJAX
        $('.edit-modal').on('click', function() {
            const id = $(this).data('id');
            const url = "{{ route('peminjaman.edit', ':id') }}".replace(':id', id);
            const updateUrl = "{{ route('peminjaman.update', ':id') }}".replace(':id', id);

            $.get(url, function(res) {
                $('#editPeminjamanForm').attr('action', updateUrl);
                $('#edit_tanggal_pinjam').val(res.peminjaman.tanggal_pinjam);
                $('#edit_tanggal_kembali').val(res.peminjaman.tanggal_kembali);
                $('#edit_keterangan').val(res.peminjaman.keterangan);

                const body = $('#editBarangBody');
                body.empty();

                res.barangDipinjam.forEach((item, index) => {
                    body.append(`
                    <tr>
                        <td>
                            <select name="barang[${index}][commodity_id]" class="form-control select-barang">
                                @foreach($commodities as $com)
                                    <option value="{{ $com->id }}" ${item.commodity_id == {{ $com->id }} ? 'selected' : ''}>
                                        {{ $com->name }} - {{ $com->brand }} ({{ $com->condition }})
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td><input type="number" name="barang[${index}][jumlah]" value="${item.jumlah}" class="form-control" min="1" required></td>
                        <td class="text-center">
                            <button type="button" class="btn btn-danger btn-sm remove-row"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                `);
                });

                $('#peminjaman_edit_modal').modal('show');
            });
        });
    });
</script>