<script>
    $(document).ready(function() {
        $('#peminjamanTable').DataTable({
            responsive: true,
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data",
                zeroRecords: "Tidak ada data ditemukan",
                info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                infoEmpty: "Tidak ada data",
            }
        });

        let rowIdx = 1;

        $('#addRow').click(function() {
            let newRow = `
            <tr>
                <td>
                    <select name="barang[${rowIdx}][commodity_id]" class="form-control select-barang">
                        @foreach($commodities as $item)
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                </td>
                <td><input type="number" name="barang[${rowIdx}][jumlah]" class="form-control" min="1" required></td>
                <td class="text-center">
                    <button type="button" class="btn btn-danger btn-sm remove-row">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
        `;
            $('#barangTable tbody').append(newRow);
            rowIdx++;
        });

        $(document).on('click', '.remove-row', function() {
            $(this).closest('tr').remove();
        });
    });
</script>