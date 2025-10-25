<div id="filter-accordion">
	<div class="accordion mb-3">
		<div class="accordion-header" role="button" data-bs-toggle="collapse" data-bs-target="#panel-body-1" aria-expanded="false">
			<h4>Menu filter (klik atau sentuh untuk membuka atau menutup menu filter)</h4>
		</div>
		<div class="accordion-body collapse" id="panel-body-1" data-bs-parent="#filter-accordion">
			<form action="" method="GET">
				{{ $slot }}
				<div class="d-flex">
					<button type="submit" class="btn btn-primary mr-1 flex-fill">Cari</button>
					<a href="{{ $resetFilterURL }}" class="btn btn-warning" role="button">Reset Filter</a>
				</div>
			</form>
		</div>
	</div>
</div>