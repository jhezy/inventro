<x-layout>
    <x-slot name="title">Barang Keluar</x-slot>
    <x-slot name="page_heading">Daftar Barang Keluar</x-slot>

    <div class="card">
        <div class="card-body">
            @include('utilities.alert')

            <div class="d-flex justify-content-end mb-3">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                    data-bs-target="#barang_keluar_create_modal">
                    <i class="fas fa-fw fa-plus"></i> Tambah Barang Keluar
                </button>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <x-datatable>
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Tanggal</th>
                                <th scope="col">Barang</th>
                                <th scope="col">Jumlah</th>
                                <th scope="col">Keterangan</th>
                                <th scope="col">Stok Sekarang</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($barangKeluar as $item)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $item->tanggal_keluar }}</td>
                                <td>{{ $item->nama_barang }}</td>
                                <td>{{ $item->jumlah_keluar }}</td>
                                <td>{{ $item->keterangan ?? '-' }}</td>
                                <td>{{ $item->stok_sekarang }}</td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <form action="{{ route('barang_keluar.destroy', $item->id) }}" method="POST"
                                            onsubmit="return ">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger delete-button m-1">
                                                <i class="fas fa-fw fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </x-datatable>
                </div>
            </div>
        </div>
    </div>

    @push('modal')
    <!-- Modal Tambah Barang Keluar -->
    <!-- Modal -->
    <div class="modal fade" id="barang_keluar_create_modal" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="barangKeluarLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="barangKeluarLabel">Tambah Barang Keluar</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <!-- Info -->
                    <div class="d-flex align-items-center mb-2">
                        <i class="text-warning fa-solid fa-circle-info me-2"></i>
                        <p class="font-italic mb-0">
                            Kolom yang memiliki tanda merah <span class="fw-bold">wajib diisi.</span>
                        </p>
                    </div>
                    <hr>

                    <form action="{{ route('barang_keluar.store') }}" method="POST">
                        @csrf
                        <div class="row">

                            <!-- Barang -->
                            <!-- <div class="col-md-6 mb-3">
                                <label for="commodity_id" class="form-label">
                                    Pilih Barang <span class="text-danger fw-bold">*</span>
                                </label>
                                <select name="commodity_id" id="commodity_id"
                                    class="form-select @error('commodity_id', 'store') is-invalid @enderror">
                                    <option value="">-- Pilih Barang --</option>
                                    @foreach($commodities as $c)
                                    <option value="{{ $c->id }}">
                                        {{ $c->name }} (stok: {{ $c->quantity }})
                                    </option>
                                    @endforeach
                                </select>
                                @error('commodity_id', 'store')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div> -->
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="commodity_id">Pilih Barang<span
                                            class="font-weight-bold text-danger">*</span></label>
                                    <select class="form-control @error('commodity_id', 'store') is-invalid @enderror"
                                        name="commodity_id" id="commodity_id" style="width: 100%;">
                                        <option value="" selected">Pilih..</option>
                                        @foreach ($commodities as $commodity)
                                        <option value="{{ $commodity->id }}"
                                            @selected(old('commodity_id')==$commodity->id)>{{
										$commodity->name }} (stok: {{ $commodity->quantity }})
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('commodity_id', 'store')
                                    <div class="d-block invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Jumlah -->
                            <div class="col-md-3 mb-3">
                                <label for="jumlah_keluar" class="form-label">
                                    Jumlah Keluar <span class="text-danger fw-bold">*</span>
                                </label>
                                <input type="number" name="jumlah_keluar"
                                    class="form-control @error('jumlah_keluar', 'store') is-invalid @enderror"
                                    id="jumlah_keluar" min="1" placeholder="Masukkan jumlah...">
                                @error('jumlah_keluar', 'store')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Tanggal -->
                            <div class="col-md-3 mb-3">
                                <label for="tanggal_keluar" class="form-label">
                                    Tanggal Keluar <span class="text-danger fw-bold">*</span>
                                </label>
                                <input type="date" name="tanggal_keluar"
                                    class="form-control @error('tanggal_keluar', 'store') is-invalid @enderror"
                                    id="tanggal_keluar" value="{{ old('tanggal_keluar') }}">
                                @error('tanggal_keluar', 'store')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Keterangan -->
                            <div class="col-12 mb-3">
                                <label for="keterangan" class="form-label">
                                    Keterangan <span class="fst-italic text-muted">(opsional)</span>
                                </label>
                                <input type="text" name="keterangan"
                                    class="form-control @error('keterangan', 'store') is-invalid @enderror"
                                    id="keterangan" placeholder="Tuliskan keterangan (opsional)..."
                                    value="{{ old('keterangan') }}">
                                @error('keterangan', 'store')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                Tutup
                            </button>
                            <button type="submit" class="btn btn-success">
                                Tambah
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



    @endpush

</x-layout>