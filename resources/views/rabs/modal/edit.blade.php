<!-- Modal Edit RAB -->
<div class="modal fade" id="rab_edit_modal" data-backdrop="static" data-keyboard="false"
	tabindex="-1" aria-labelledby="rabEditLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="rabEditLabel">Edit Data RAB</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>

			<div class="modal-body">
				<div class="d-flex align-items-center mb-3">
					<i class="text-warning fa-solid fa-circle-info mr-2"></i>
					<p class="font-italic mb-0">
						Kolom yang memiliki tanda merah <span class="font-weight-bold">wajib diisi.</span>
					</p>
				</div>
				<hr>

				<form method="POST" id="editRabForm">
					@csrf
					@method('PUT')

					<div class="form-row">
						<div class="form-group col-md-6">
							<label for="edit_tahun">Tahun <span class="text-danger">*</span></label>
							<input type="number" name="tahun" id="edit_tahun" class="form-control"
								placeholder="contoh: 2025" required>
						</div>
						<div class="form-group col-md-6">
							<label for="edit_bulan">Bulan <span class="text-danger">*</span></label>
							<input type="text" name="bulan" id="edit_bulan" class="form-control"
								placeholder="contoh: Oktober" required>
						</div>
					</div>

					<table class="table table-bordered" id="rab-edit-table">
						<thead class="thead-light">
							<tr>
								<th>Nama Barang <span class="text-danger">*</span></th>
								<th>Jumlah <span class="text-danger">*</span></th>
								<th>Harga Satuan <span class="text-danger">*</span></th>
								<th>Total</th>
								<th style="width: 10%;">Aksi</th>
							</tr>
						</thead>
						<tbody>
							{{-- Baris barang akan dimuat dinamis via JS --}}
						</tbody>
					</table>

					<div class="d-flex justify-content-between">
						<button type="button" id="add-edit-row" class="btn btn-secondary">
							<i class="fa fa-plus"></i> Tambah Barang
						</button>
						<button type="submit" class="btn btn-success">
							<i class="fa fa-save"></i> Simpan Perubahan
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<script>
	document.addEventListener('DOMContentLoaded', function() {
		function addEditRow(data = {}) {
			const tbody = document.querySelector('#rab-edit-table tbody');
			const row = document.createElement('tr');
			row.innerHTML = `
            <td><input type="text" name="nama_barang[]" class="form-control" value="${data.nama_barang ?? ''}" required></td>
            <td><input type="number" name="jumlah[]" class="form-control jumlah" min="1" value="${data.jumlah ?? ''}" required></td>
            <td><input type="number" name="harga[]" class="form-control harga" min="0" value="${data.harga ?? ''}" required></td>
            <td><input type="text" class="form-control total" value="${data.total ? data.total.toLocaleString('id-ID') : ''}" readonly></td>
            <td><button type="button" class="btn btn-danger btn-sm remove-row">Hapus</button></td>
        `;
			tbody.appendChild(row);
		}

		// Tambah baris manual
		document.getElementById('add-edit-row').addEventListener('click', function() {
			addEditRow();
		});

		// Hapus baris
		document.addEventListener('click', function(e) {
			if (e.target.classList.contains('remove-row')) {
				e.target.closest('tr').remove();
			}
		});

		// Hitung total otomatis
		document.addEventListener('input', function(e) {
			if (e.target.classList.contains('jumlah') || e.target.classList.contains('harga')) {
				const tr = e.target.closest('tr');
				const jumlah = parseFloat(tr.querySelector('.jumlah').value) || 0;
				const harga = parseFloat(tr.querySelector('.harga').value) || 0;
				tr.querySelector('.total').value = (jumlah * harga).toLocaleString('id-ID');
			}
		});

		// Tombol edit RAB
		document.querySelectorAll('.btn-edit-rab').forEach(btn => {
			btn.addEventListener('click', function() {
				const id = this.dataset.id;
				fetch(`/rabs/${id}`)
					.then(res => res.json())
					.then(data => {
						const form = document.getElementById('editRabForm');
						form.action = `/rabs/${id}`;
						document.getElementById('edit_tahun').value = data.tahun;
						document.getElementById('edit_bulan').value = data.bulan;

						const tbody = document.querySelector('#rab-edit-table tbody');
						tbody.innerHTML = '';

						data.items.forEach(item => {
							addEditRow({
								nama_barang: item.nama_barang,
								jumlah: item.jumlah,
								harga: item.harga,
								total: item.jumlah * item.harga
							});
						});

						const modal = new bootstrap.Modal(document.getElementById('rab_edit_modal'));
						modal.show();
					})
					.catch(() => {
						alert('Gagal memuat data RAB.');
					});
			});
		});
	});
</script>