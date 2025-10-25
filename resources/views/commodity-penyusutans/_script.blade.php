<script>
	$(document).ready(function() {

		// ========================
		// 🔹 Inisialisasi TomSelect
		// ========================
		const selectors = [
			"#commodity_create_modal form #commodity_location_id",
			"#filter-accordion form #commodity_location_id",
			"#filter-accordion form #year_of_purchase",
			"#filter-accordion form #material",
			"#filter-accordion form #brand",
		];

		selectors.forEach((selector) => {
			if ($(selector).length) new TomSelect(selector);
		});

		let commodityLocationInput = null;
		if ($("#commodity_edit_modal form #commodity_location_id").length) {
			commodityLocationInput = new TomSelect("#commodity_edit_modal form #commodity_location_id");
		}


		// ========================
		// 🔹 SHOW MODAL
		// ========================
		$(".show-modal").click(function() {
			const id = $(this).data("id");
			const url = "{{ route('api.barang.show', ':paramID') }}".replace(":paramID", id);

			$.ajax({
				url,
				method: "GET",
				headers: {
					"Content-Type": "application/json"
				},
				success: (res) => {
					const data = res.data;

					$("#show_commodity #item_code").val(data.item_code);
					$("#show_commodity #name").val(data.name);
					$("#show_commodity #commodity_location_id").val(data.commodity_location.name);
					$("#show_commodity #commodity_category_id").val(data.commodity_category.name);
					$("#show_commodity #material").val(data.material);
					$("#show_commodity #brand").val(data.brand);
					$("#show_commodity #year_of_purchase").val(data.year_of_purchase);
					$("#show_commodity #condition").val(data.condition_name);
					$("#show_commodity #commodity_acquisition_id").val(data.commodity_acquisition.name);
					$("#show_commodity #note").val(data.note);
					$("#show_commodity #quantity").val(data.quantity);
					$("#show_commodity #price").val(data.price_formatted);
					$("#show_commodity #price_per_item").val(data.price_per_item_formatted);
					$("#show_commodity #nomor_seri").val(data.nomor_seri);
					$("#show_commodity #ukuran").val(data.ukuran);
					$("#show_commodity #warna").val(data.warna);
					$("#show_commodity #pengguna").val(data.pengguna);
					$("#show_commodity #masa").val(data.masa + " tahun");
					$("#show_commodity #residu").val(data.residu);

					// ✅ Hitung PENYUSUTAN dan PENYUSUTAN PER TAHUN
					let price = data.price_per_item_formatted || 0;
					let residu = data.residu_formatted || data.residu || 0;
					let masa = parseFloat(data.masa) || 0;

					// Konversi string ke angka murni
					let priceNum = parseFloat(String(price).replace(/[^0-9.-]/g, "")) || 0;
					let residuNum = parseFloat(String(residu).replace(/[^0-9.-]/g, "")) || 0;

					// Hitung penyusutan total
					let penyusutan = priceNum - residuNum;

					// Hitung penyusutan per tahun (jika masa > 0)
					let penyusutanPerTahun = masa > 0 ? (penyusutan / masa) : 0;

					// Format angka ke format lokal
					let penyusutanFormatted = penyusutan.toLocaleString("id-ID", {
						minimumFractionDigits: 0,
						maximumFractionDigits: 2,
					});
					let penyusutanPerTahunFormatted = penyusutanPerTahun.toLocaleString("id-ID", {
						minimumFractionDigits: 0,
						maximumFractionDigits: 2,
					});

					// Masukkan ke form
					$("#show_commodity #penyusutan").val(penyusutanFormatted);
					$("#show_commodity #penyusutan_per_tahun").val(penyusutanPerTahunFormatted);
				},
				error: (err) => {
					alert("Terjadi kesalahan saat memuat data barang.");
					console.error(err);
				},
			});
		});


		// ========================
		// 🔹 EDIT MODAL
		// ========================
		$(".edit-modal").on("click", function() {
			const id = $(this).data("id");
			const url = "{{ route('api.barang.show', ':paramID') }}".replace(":paramID", id);
			const updateURL = "{{ route('barang.update', ':paramID') }}".replace(":paramID", id);

			$.ajax({
				url,
				method: "GET",
				headers: {
					"Content-Type": "application/json"
				},
				success: (res) => {
					const data = res.data;

					$("#commodity_edit_modal form #item_code").val(data.item_code);
					$("#commodity_edit_modal form #name").val(data.name);
					$("#commodity_edit_modal form #material").val(data.material);
					$("#commodity_edit_modal form #brand").val(data.brand);
					$("#commodity_edit_modal form #year_of_purchase").val(data.year_of_purchase);
					$("#commodity_edit_modal form #condition").val(data.condition);
					$("#commodity_edit_modal form #commodity_acquisition_id").val(data.commodity_acquisition.id);
					$("#commodity_edit_modal form #commodity_category_id").val(data.commodity_category.id);
					$("#commodity_edit_modal form #note").val(data.note);
					$("#commodity_edit_modal form #quantity").val(data.quantity);
					$("#commodity_edit_modal form #price").val(data.price);
					$("#commodity_edit_modal form #price_per_item").val(data.price_per_item);
					$("#commodity_edit_modal form #nomor_seri").val(data.nomor_seri);
					$("#commodity_edit_modal form #ukuran").val(data.ukuran);
					$("#commodity_edit_modal form #warna").val(data.warna);
					$("#commodity_edit_modal form #pengguna").val(data.pengguna);
					$("#commodity_edit_modal form #masa").val(data.masa);
					$("#commodity_edit_modal form #residu").val(data.residu);

					if (data.commodity_location) {
						commodityLocationInput?.setValue(data.commodity_location.id);
					}

					$("#commodity_edit_modal form").attr("action", updateURL);
				},
				error: (err) => {
					alert("Terjadi kesalahan saat memuat data untuk edit.");
					console.error(err);
				},
			});
		});


		// ========================
		// 🔹 QR CODE MODAL
		// ========================
		$(".qr-modal-button").on("click", function() {
			const id = $(this).data("id");

			$("#qr_code_container").html('<span class="text-muted">Memuat QR Code...</span>');
			$("#qr_code_modal .modal-title").text("Memuat QR Code");
			$("#download_qr_link").addClass("disabled").attr("href", "#");

			const url = "{{ route('api.barang.generate-qrcode', ':paramID') }}".replace(":paramID", id);

			$.ajax({
				url,
				method: "GET",
				headers: {
					"Content-Type": "application/json"
				},
				success: (res) => {
					const data = res.data;

					$("#qr_code_modal .modal-title").text("QR Code untuk " + data.name);
					$("#download_qr_link")
						.removeClass("disabled")
						.attr("href", data.qr_code_uri)
						.attr("download", data.filename);

					$("#qr_code_container").html(
						`<img src="${data.qr_code_uri}" alt="QR Code" class="d-inline-block">`
					);
				},
				error: (err) => {
					$("#qr_code_container").html('<span class="text-danger">Gagal memuat QR Code.</span>');
					console.error(err);
				},
			});
		});
	});
</script>