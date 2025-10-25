<script>
	$(document).on('click', '.btn-edit-rab', function() {
		const id = $(this).data('id');
		const tahun = $(this).data('tahun');
		const bulan = $(this).data('bulan');
		const nama_barang = $(this).data('nama_barang');
		const jumlah = $(this).data('jumlah');
		const harga = $(this).data('harga');

		console.log('Data diterima:', {
			id,
			tahun,
			bulan,
			nama_barang,
			jumlah,
			harga
		}); // Debug

		$('#edit_tahun').val(tahun);
		$('#edit_bulan').val(bulan);
		$('#edit_nama_barang').val(nama_barang);
		$('#edit_jumlah').val(jumlah);
		$('#edit_harga').val(harga);

		$('#editRabForm').attr('action', `/rabs/${id}`);
		$('#rab_edit_modal').modal('show');
	});


	$(document).ready(function() {
		$(".show-modal").click(function() {
			const id = $(this).data("id");
			let url = "{{ route('api.rab.show', ':paramID') }}".replace(
				":paramID",
				id
			);
			$.ajax({
				url: url,
				header: {
					"Content-Type": "application/json",
				},
				success: (res) => {
					$("#show_rab #tahun").val(res.data.tahun);
					$("#show_rab #bulan").val(res.data.bulan);
					$("#show_rab #nama_barang").val(res.data.nama_barang);
					$("#show_rab #jumlah").val(res.data.jumlah);
					$("#show_rab #harga").val(res.data.harga);

				},
				error: (err) => {
					alert("error occured, check console");
					console.log(err);
				},
			});
		});

		$(".edit-modal").on("click", function() {
			const id = $(this).data("id");
			let url = "{{ route('api.rab.show', ':paramID') }}".replace(
				":paramID",
				id
			);

			let updateURL = "{{ route('rab.update', ':paramID') }}".replace(
				":paramID",
				id
			);

			$.ajax({
				url: url,
				method: "GET",
				header: {
					"Content-Type": "application/json",
				},
				success: (res) => {
					$("#rab_edit_modal form #tahun").val(res.data.tahun);
					$("#rab_edit_modal form #bulan").val(res.data.bulan);
					$("#rab_edit_modal form #nama_barang").val(res.data.nama_barang);
					$("#rab_edit_modal form #jumlah").val(res.data.jumlah);
					$("#rab_edit_modal form #harga").val(res.data.harga);
					$("#rab_edit_modal form").attr("action", updateURL);
				},
				error: (err) => {
					alert("error occured, check console");
					console.log(err);
				},
			});
		});
	});
</script>