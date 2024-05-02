@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('modal')
    @include('pages.category.partials.modal-form')
@endsection

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Produk'])
<div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div id="alert">
                        @include('components.alert')
                    </div>
                    <div class="card-header pb-3 d-flex align-items-center">
                        <h5>Produk</h5>
                        <div class="ms-md-auto pe-md-3 d-flex">
                            <div class="input-group">
                                <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
                                <input type="text" class="form-control" placeholder="Type here...">
                            </div>
                        </div>
                        <a href="{{ route('product.create') }}" class="btn btn-primary btn-sm mb-0"><i class="fas fa-plus me-2"></i>Tambah</a>
                    </div>

                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                 <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7" style="width: 5%">
                                            No </th>
                                        <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7" style="width: 30%">
                                            Nama Produk</th>
                                        <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7" style="width: 15%">
                                            Kategori</th>
                                        <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7" style="width: 10%">
                                            Harga Beli</th>
                                        <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7" style="width: 10%">
                                            Harga Jual</th>
                                        <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7" style="width: 10%">
                                            Stok</th>
                                        <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ( $listProduct as $i => $data)
                                        <tr>
                                            <td class="align-middle text-left text-xl font-weight-bold">
                                                <span class="ms-3">
                                                    {{ $loop->index + 1 + ($listProduct->perPage() * ($listProduct->currentPage() - 1)) }}
                                                </span>
                                            </td>
                                            <td class="align-middle text-left text-xl font-weight-bold">
                                                <span class="ms-3">
                                                    {{ $data->name }}
                                                </span>
                                            </td>
                                            <td class="align-middle text-left text-xl font-weight-bold">
                                                <span class="ms-3">
                                                    {{ $data->category_name }}
                                                </span>
                                            </td>
                                            <td class="align-middle text-left text-xl font-weight-bold">
                                                <span class="ms-3">
                                                    {{ $data->price_per_purchase_item }}
                                                </span>
                                            </td>
                                            <td class="align-middle text-left text-xl font-weight-bold">
                                                <span class="ms-3">
                                                    {{ $data->selling_price }}
                                                </span>
                                            </td>
                                            <td class="align-middle text-left text-xl font-weight-bold">
                                                <span class="ms-3">
                                                    {{ $data->stock }}
                                                </span>
                                            </td>
                                            <td class="d-flex align-middle text-left text-xl font-weight-bold">
                                                <a href="{{ route('product.edit', ['id' => $data->id]) }}" class="btn btn-link text-secondary mb-0">
                                                    <i class="fa fa-edit text-xs" aria-hidden="true"></i>
                                                </a>

                                                <form action="/product" method="post" id="delete-form-{{ $data->id }}"">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input hidden type="text" name="id" value="{{ $data->id }}">
                                                    <button type="button" class="btn btn-link text-secondary mb-0" onclick="deleteData({{ $data->id }})">
                                                        <i class="fa fa-trash text-xs" aria-hidden="true"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <div class="px-3 pt-3">
                                {!! $listProduct->links('vendor.pagination.bootstrap-5') !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script>
    function deleteData(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: 'Once deleted, you will not be able to recover this data!',
                icon: 'warning',
                buttons: {
                    cancel: 'Cancel',
                    confirm: 'Delete'
                },
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    $('#delete-form-' + id).submit();
                }
            });
        }
</script>

@endsection