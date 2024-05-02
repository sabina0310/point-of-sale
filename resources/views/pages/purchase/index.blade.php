@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Pembelian'])
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div id="alert">
                        @include('components.alert')
                    </div>
                    <div class="card-header pb-3 d-flex align-items-center">
                        <h5>Pembelian</h5>
                        <div class="ms-md-auto pe-md-3 d-flex">
                            <div class="input-group">
                                <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
                                <input type="text" class="form-control" placeholder="Type here...">
                            </div>
                        </div>
                        <a href="{{ route('purchase.create') }}" class="btn btn-primary btn-sm mb-0" onclick="openModalFormInsert()"><i class="fas fa-plus me-2"></i>Tambah</a>
                    </div>

                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                 <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7" style="width: 5%">
                                            No </th>
                                        <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7" style="width: 20%">
                                            Tanggal </th>
                                        <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7" style="width: 30%">
                                            Nama Produk </th>
                                        <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7" style="width: ">
                                            Jumlah </th>
                                        <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7" style="width: ">
                                            Total Harga </th>
                                        {{-- <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7">Aksi</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ( $listPurchase as $i => $value)
                                        <tr>
                                            <td class="align-middle text-left text-xl font-weight-bold">
                                                <span class="ms-3">
                                                    {{ $loop->index + 1 + ($listPurchase->perPage() * ($listPurchase->currentPage() - 1)) }}
                                                </span>
                                            </td>
                                            <td class="align-middle text-left text-xl font-weight-bold">
                                                <span class="ms-3">
                                                   {{ $value->date }}
                                                </span>
                                            </td>
                                            <td class="align-middle text-left text-xl font-weight-bold">
                                                <span class="ms-3">
                                                    {{ $value->product_name }}
                                                </span>
                                            </td>
                                            <td class="align-middle text-left text-xl font-weight-bold">
                                                <span class="ms-3">
                                                    {{ $value->quantity }}
                                                </span>
                                            </td>
                                            <td class="align-middle text-left text-xl font-weight-bold">
                                                <span class="ms-3">
                                                    {{ $value->total_price }}
                                                </span>
                                            </td>
                                            {{-- <td class="d-flex align-middle text-left text-xl font-weight-bold">
                                                <button class="btn btn-link text-secondary mb-0" onclick="openModalFormEdit({{ $value->id }})">
                                                    <i class="fa fa-edit text-xs" aria-hidden="true"></i>
                                                </button>
                                                <form action="/category" method="post" id="delete-form-{{ $value->id }}"">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input hidden type="text" name="id" value="{{ $value->id }}">
                                                    <button type="button" class="btn btn-link text-secondary mb-0" onclick="deleteData({{ $value->id }})">
                                                        <i class="fa fa-trash text-xs" aria-hidden="true"></i>
                                                    </button>
                                                </form>
                                            </td> --}}
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <div class="px-3 pt-3">
                                {!! $listPurchase->links('vendor.pagination.bootstrap-5') !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection