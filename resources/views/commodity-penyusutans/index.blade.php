<x-layout>
	<x-slot name="title">Halaman Daftar Barang</x-slot>
	<!-- <x-slot name="page_heading">Penyusutan Barang</x-slot> -->


	<div class="card">
		<div class="card-body">
			<x-filter>
				<div class="row">
					<div class="col-md-2">
						<div class="form-group">
							<label for="commodity_location_id">Lokasi Barang:</label>
							<select name="commodity_location_id" placeholder="lokasi barang.."
								id="commodity_location_id" @class([ 'form-control' , 'is-valid'=>
								request()->filled('commodity_location_id')
								])
								>
								<option value="">Pilih lokasi barang..</option>
								@foreach ($commodity_locations as $commodity_location)
								<option value="{{ $commodity_location->id }}"
									@selected(request('commodity_location_id')==$commodity_location->id)>{{
									$commodity_location->name
									}}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							<label for="commodity_acquisition_id">Asal Perolehan:</label>
							<select name="commodity_acquisition_id" id="commodity_acquisition_id" @class([ 'form-control'
								, 'is-valid'=> request()->filled('commodity_acquisition_id')
								])
								>
								<option value="">Pilih asal perolehan..</option>
								@foreach ($commodity_acquisitions as $commodity_acquisition)
								<option value="{{ $commodity_acquisition->id }}"
									@selected(request('commodity_acquisition_id')==$commodity_acquisition->id)>{{
									$commodity_acquisition->name }}
								</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							<label for="condition">Kondisi:</label>
							<select name="condition" id="condition" @class([ 'form-control' , 'is-valid'=>
								request()->filled('condition')
								])
								>
								<option value="">Pilih kondisi..</option>
								<option value="1" @selected(request('condition')==1)>Baik</option>
								<option value="2" @selected(request('condition')==2)>Kurang Baik</option>
								<option value="3" @selected(request('condition')==3)>Rusak Berat</option>
							</select>
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							<label for="year_of_purchase">Tahun Pembelian:</label>
							<select name="year_of_purchase" placeholder="tahun pembelian.." id="year_of_purchase"
								@class([ 'form-control' , 'is-valid'=>
								request()->filled('year_of_purchase')
								])
								>
								<option value="">Pilih tahun pembelian..</option>
								@foreach ($year_of_purchases as $year_of_purchase)
								<option value="{{ $year_of_purchase }}" @selected(request('year_of_purchase')==$year_of_purchase)>{{
									$year_of_purchase }}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							<label for="commodity_category_id">Kategori :</label>
							<select name="commodity_category_id" placeholder="kategori.."
								id="commodity_category_id" @class([ 'form-control' , 'is-valid'=>
								request()->filled('commodity_category_id')
								])
								>
								<option value="">Pilih lokasi barang..</option>
								@foreach ($commodity_categories as $commodity_category)
								<option value="{{ $commodity_category->id }}"
									@selected(request('commodity_category_id')==$commodity_category->id)>{{
									$commodity_category->name
									}}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							<label for="brand">Merk:</label>
							<select name="brand" id="brand" placeholder="Pilih merek.." @class([ 'form-control'
								, 'is-valid'=> request()->filled('brand')
								])
								>
								<option value="">Pilih merk..</option>
								@foreach ($commodity_brands as $brand)
								<option value="{{ $brand }}" @selected(request('brand')==$brand)>{{
									$brand }}</option>
								@endforeach
							</select>
						</div>
					</div>
				</div>

				<div class="row">

				</div>

				<div class="row">

				</div>

				<x-slot name="resetFilterURL">{{ route('barang.index') }}</x-slot>
			</x-filter>

			<div class="row">
				<div class="col-lg-12">
					<x-datatable>
						<thead>
							<tr>
								<th scope="col">No</th>
								<th scope="col">Kode Barang</th>
								<th scope="col">Nama Barang</th>
								<th scope="col">Merek Barang</th>

								<th scope="col">Tahun</th>
								<th scope="col">Harga</th>
								<th scope="col">Penyusutan</th>
								<th scope="col">Penyusutan /tahun</th>

								<th scope="col">Jumlah</th>
								<th scope="col">Keadaan</th>


							</tr>
						</thead>
						<tbody>
							@foreach($commodities as $commodity)
							<tr>
								<th scope="row">{{ $loop->iteration }}</th>
								<td class="text-center align-middle">
									<div class="d-flex flex-column align-items-center">
										<span class="badge badge-primary ">
											{{ $commodity->item_code }}
										</span>
									</div>
								</td>

								<td>{{ Str::limit($commodity->name, 55, '...') }}</td>
								<td>{{ $commodity->brand }}</td>

								<td class="text-center align-middle">
									<div class="d-flex flex-column align-items-center">
										<span class="badge badge-secondary text-dark ">
											{{ $commodity->commodity_acquisition->name }}
											{{ $commodity->year_of_purchase }}
										</span>

									</div>
								</td>
								<td>Rp. {{ $commodity->price_per_item}}</td>
								<td>Rp. {{ $commodity->penyusutan_formatted}}</td>
								<td>Rp. {{ $commodity->penyusutan_per_tahun_formatted}}</td>

								<td>{{ $commodity->quantity}}</td>




								@if($commodity->condition === 1)
								<td>
									<span class="badge badge-pill badge-success" title="Baik">
										<i class="fas fa-fw fa-check-circle"></i>
										Baik
									</span>
								</td>
								@elseif($commodity->condition === 2)
								<td>
									<span class="badge badge-pill badge-warning" title="Kurang Baik">
										<i class="fa fa-fw fa-exclamation-circle"></i>
										Kurang Baik
									</span>
								</td>
								@else
								<td>
									<span class="badge badge-pill badge-danger" title="Rusak Berat">
										<i class="fa fa-fw fa-times-circle"></i>
										Rusak Berat</span>
								</td>
								@endif
								<!-- <td>{{ $commodity->pengguna}}</td> -->


							</tr>
							@endforeach
						</tbody>
					</x-datatable>
				</div>
			</div>
		</div>
	</div>

	@push('modal')
	@include('commodities.modal.show')
	@include('commodities.modal.create')
	@include('commodities.modal.edit')
	@include('commodities.modal.import')
	@include('commodities.modal.export')
	@include('commodities.modal.qrcode')
	@endpush

	@push('js')
	@include('commodities._script')
	@endpush
</x-layout>