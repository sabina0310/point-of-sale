@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Produk', 'subTitle' => 'Detail Produk'])
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-3 d-flex align-items-center">
                        <h5 id="title">Detail Produk</h5>
                    </div>
                    <div class="card-body px-4 pt-4 pb-2">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                        <div class="form-group d-flex align-items-center">
                                            <label class="me-2 text-sm col-3">Kategori</label>
                                            <span class="text-md"> {{ $category_name }}</span>
                                        </div>
                                        <div class="form-group d-flex align-items-center">
                                            <label class="me-2 text-sm col-3">Nama Produk</label>
                                            <span class="text-md"> {{ $name }}</span>
                                        </div>
                                        <div class="form-group d-flex align-items-center">
                                            <label class="me-2 text-sm col-3">Satuan Beli</label>
                                            <span class="text-md"> {{ $purchase_unit }}</span>
                                        </div>
                                        <div class="form-group d-flex align-items-center">
                                            <label class="me-2 text-sm col-3">Harga Beli </label>
                                            <span class="text-md">Rp {{ $purchase_price }}</span>
                                        </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group d-flex align-items-center">
                                            <label class="me-2 text-sm col-3">Isi Per Satuan Beli</label>
                                            <span class="text-md"> {{ $quantity_per_purchase_unit }}</span>
                                        </div>
                                        <div class="form-group d-flex align-items-center">
                                            <label class="me-2 text-sm col-3">Harga Beli Per Isi</label>
                                            <span class="text-md">Rp {{ $price_per_purchase_item }}</span>
                                        </div>
                                        <div class="form-group d-flex align-items-center">
                                            <label class="me-2 text-sm col-3">Satuan Jual</label>
                                            <span class="text-md"> {{ $sale_unit }}</span>
                                        </div>
                                        <div class="form-group d-flex align-items-center">
                                            <label class="me-2 text-sm col-3">Harga Jual </label>
                                            <span class="text-md">Rp {{ $sale_price }}</span>
                                        </div>
                                        <div class="form-group d-flex align-items-center">
                                            <label class="me-2 text-sm col-3">Laba</label>
                                            <span class="text-md">Rp {{ $sale_price - $price_per_purchase_item}}</span>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                            <a href="{{ route('product') }}" type="button" class="btn btn-secondary">Back</a>
                        </div>  
                </div>

            </div>
        </div>
    </div>
@endsection