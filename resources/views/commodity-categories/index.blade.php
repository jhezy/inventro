<x-layout>
    <x-slot name="title">Halaman Daftar Kategori</x-slot>
    <x-slot name="page_heading">Daftar Kategori</x-slot>

    <div class="card">
        <div class="card-body">
            @include('utilities.alert')
            <div class="d-flex justify-content-end mb-3">
                <div class="btn-group">
                    @can('tambah kategori')
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#commodity_category_create_modal">
                        <i class="fas fa-fw fa-plus"></i> Tambah Data
                    </button>
                    @endcan
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <x-datatable>
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($commodityCategories as $category)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $category->name }}</td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        @can('detail kategori')
                                        <button type="button" class="btn btn-sm btn-info text-white show-modal m-1"
                                            data-bs-toggle="modal" data-bs-target="#show_commodity_category"
                                            data-id="{{ $category->id }}" title="Lihat Detail">
                                            <i class="fas fa-fw fa-search"></i>
                                        </button>
                                        @endcan

                                        @can('ubah kategori')
                                        <button type="button" class="btn btn-sm btn-success text-white edit-modal m-1"
                                            data-bs-toggle="modal" data-bs-target="#commodity_category_edit_modal"
                                            data-id="{{ $category->id }}" title="Ubah Data">
                                            <i class="fas fa-fw fa-edit"></i>
                                        </button>
                                        @endcan

                                        @can('hapus kategori')
                                        <form action="{{ route('kategori.destroy', $category->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger delete-button m-1">
                                                <i class="fas fa-fw fa-trash-alt"></i>
                                            </button>
                                        </form>
                                        @endcan
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
    @include('commodity-categories.modal.create')
    @include('commodity-categories.modal.show')
    @include('commodity-categories.modal.edit')
    @endpush

    @push('js')
    @include('commodity-categories._script')
    @endpush
</x-layout>