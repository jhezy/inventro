<!-- Modal -->
<div class="modal fade" id="commodity_category_create_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="commodityCategoryCreateLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="commodityCategoryCreateLabel">Tambah Data Kategori</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="d-flex align-items-center mb-2">
                    <i class="text-warning fa-solid fa-circle-info me-2"></i>
                    <p class="font-italic mb-0">
                        Kolom yang memiliki tanda merah <span class="fw-bold">wajib diisi.</span>
                    </p>
                </div>
                <hr>
                <form action="{{ route('kategori.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Kategori <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name"
                                    class="form-control @error('name', 'store') is-invalid @enderror"
                                    value="{{ old('name') }}" placeholder="Masukan nama..">
                                @error('name', 'store')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-success">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>