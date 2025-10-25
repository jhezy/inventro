<div class="modal fade" id="commodity_acquisition_edit_modal" data-bs-backdrop="static" data-bs-keyboard="false"
	tabindex="-1" aria-labelledby="commodityAcquisitionEditLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="commodityAcquisitionEditLabel">Ubah Data Perolehan</h5>
				<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form method="POST" id="commodityAcquisitionEditForm">
					@csrf
					@method('PUT')
					<div class="row">
						<div class="col-lg-12">
							<div class="form-group">
								<label for="name">Nama Perolehan</label>
								<input type="text" name="name" class="form-control" id="name" placeholder="Masukan nama..">
							</div>
						</div>

						<div class="col-lg-12">
							<div class="form-group">
								<label for="description">Deskripsi Perolehan</label>
								<textarea name="description" class="form-control" id="description" style="height: 100px;"
									placeholder="Masukan deskripsi (opsional).."></textarea>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
						<button type="submit" class="btn btn-success">Ubah</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>