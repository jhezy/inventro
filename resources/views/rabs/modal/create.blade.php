<!-- Modal -->
<div class="modal fade" id="rab_create_modal" data-bs-backdrop="static" data-bs-keyboard="false"
	tabindex="-1" aria-labelledby="rabCreateLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="rabCreateLabel">Tambah Data RAB</h5>
				<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
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

				<form action="{{ route('rabs.store') }}" method="POST" id="rabForm">
					@csrf

					<div class="form-row">
						<div class="form-group col-md-6">
							<label for="tahun">Tahun <span class="text-danger">*</span></label>
							<input type="number" name="tahun" id="tahun" class="form-control" placeholder="contoh: 2025" required>
						</div>
						<div class="form-group col-md-6">
							<label for="bulan">Bulan <span class="text-danger">*</span></label>
							<input type="text" name="bulan" id="bulan" class="form-control" placeholder="contoh: Oktober" required>
						</div>
					</div>

					<table class="table table-bordered" id="rab-table">
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
							<tr>
								<td><input type="text" name="nama_barang[]" class="form-control" required></td>
								<td><input type="number" name="jumlah[]" class="form-control jumlah" min="1" required></td>
								<td><input type="number" name="harga[]" class="form-control harga" min="0" required></td>
								<td><input type="text" class="form-control total" readonly></td>
								<td><button type="button" class="btn btn-danger btn-sm remove-row">Hapus</button></td>
							</tr>
						</tbody>
					</table>

					<div class="d-flex justify-content-between">
						<button type="button" id="add-row" class="btn btn-secondary">
							<i class="fa fa-plus"></i> Tambah Barang
						</button>
						<button type="submit" class="btn btn-primary">
							<i class="fa fa-save"></i> Simpan
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<script>
	document.addEventListener('DOMContentLoaded', function() {
		// Tambah baris baru
		document.getElementById('add-row').addEventListener('click', function() {
			const row = `
			<tr>
				<td><input type="text" name="nama_barang[]" class="form-control" required></td>
				<td><input type="number" name="jumlah[]" class="form-control jumlah" min="1" required></td>
				<td><input type="number" name="harga[]" class="form-control harga" min="0" required></td>
				<td><input type="text" class="form-control total" readonly></td>
				<td><button type="button" class="btn btn-danger btn-sm remove-row">Hapus</button></td>
			</tr>
		`;
			document.querySelector('#rab-table tbody').insertAdjacentHTML('beforeend', row);
		});

		// Hapus baris
		document.addEventListener('click', function(e) {
			if (e.target.classList.contains('remove-row')) {
				e.target.closest('tr').remove();
				hitungTotalSemua();
			}
		});

		// Hitung total harga per baris otomatis
		document.addEventListener('input', function(e) {
			if (e.target.classList.contains('jumlah') || e.target.classList.contains('harga')) {
				const tr = e.target.closest('tr');
				const jumlah = parseFloat(tr.querySelector('.jumlah').value) || 0;
				const harga = parseFloat(tr.querySelector('.harga').value) || 0;
				tr.querySelector('.total').value = (jumlah * harga).toLocaleString('id-ID');
			}
		});
	});
</script>