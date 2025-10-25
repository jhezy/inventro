<x-layout>
	<x-slot name="title">Halaman RAB</x-slot>
	<x-slot name="page_heading">Daftar RAB</x-slot>

	<div class="card shadow-sm border-0">
		<div class="card-body">
			@include('utilities.alert')

			<div class="d-flex justify-content-between align-items-center mb-3">
				<h5 class="mb-0 font-weight-bold text-secondary">Daftar Rencana Anggaran Biaya (RAB)</h5>
				@can('tambah rab')
				<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#rab_create_modal">
					<i class="fas fa-fw fa-plus"></i> Tambah RAB
				</button>
				@endcan
			</div>

			<div class="table-responsive">
				<table class="table table-bordered table-striped align-middle">
					<thead class="thead-light">
						<tr>
							<th class="text-center" style="width: 5%;">No</th>
							<th>Periode</th>
							<th>Nama Barang</th>
							<th class="text-center">Jumlah</th>
							<th class="text-right">Harga</th>
							<th class="text-right">Total</th>
							<th class="text-center">Aksi</th>
						</tr>
					</thead>
					<tbody>
						@php
						// Kelompokkan data berdasarkan tahun-bulan
						$grouped = $rabs->groupBy(function($item) {
						return $item->tahun . '-' . $item->bulan;
						});

						$no = 1;
						@endphp

						@foreach($grouped as $periode => $items)
						@php
						[$tahun, $bulan] = explode('-', $periode);
						@endphp

						@foreach($items as $index => $rab)
						<tr>
							{{-- tampilkan nomor hanya di baris pertama dari grup --}}
							@if($index == 0)
							<td rowspan="{{ $items->count() }}" class="text-center align-middle font-weight-bold">
								{{ $no }}
							</td>
							<td rowspan="{{ $items->count() }}" class="align-middle font-weight-bold">
								{{ ucfirst($rab->bulan) }} {{ $rab->tahun }}
							</td>
							@endif

							<td>{{ $rab->nama_barang }}</td>
							<td class="text-center">{{ $rab->jumlah }}</td>
							<td class="text-right">{{ number_format($rab->harga, 0, ',', '.') }}</td>
							<td class="text-right">{{ number_format($rab->jumlah * $rab->harga, 0, ',', '.') }}</td>

							<td class="text-center">
								<div class="btn-group" role="group">
									@can('detail rab')
									<a data-id="{{ $rab->id }}" class="btn btn-sm btn-info mb-3 text-white show-modal"
										data-bs-toggle="modal" data-bs-target="#show_rab" title="Detail">
										<i class="fas fa-fw fa-search"></i>
									</a>
									@endcan

									@can('ubah rab')
									<a
										data-id="{{ $rab->id }}"
										class="btn btn-sm btn-success text-white btn-edit-rab"
										title="Edit">
										<i class="fas fa-fw fa-edit"></i>
									</a>
									@endcan

									@can('hapus rab')
									<form action="{{ route('rabs.destroy', $rab->id) }}" method="POST" class="d-inline">
										@csrf
										@method('DELETE')
										<button type="submit" class="btn btn-sm btn-danger delete-button" title="Hapus">
											<i class="fas fa-fw fa-trash-alt"></i>
										</button>
									</form>
									@endcan
								</div>
							</td>

						</tr>
						@endforeach

						@php $no++; @endphp
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>

	@push('modal')
	@include('rabs.modal.create')
	@include('rabs.modal.show')
	@include('rabs.modal.edit')
	@endpush

	@push('js')
	@include('rabs._script')
	@endpush
</x-layout>