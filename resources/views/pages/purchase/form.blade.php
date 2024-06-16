@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@php
    $currentTitle = Str::contains(Route::currentRouteName(), 'create') ? 'Tambah Pembelian' : 'Edit Pembelian';
    $isCreateRoute = Str::contains(Route::currentRouteName(), 'create');
    $currentDate = date('Y-m-d');

@endphp

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Pembelian', 'subTitle' => $currentTitle])
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div id="alert">
                    @include('components.alert')
                </div>
                    <div class="card-header pb-3 d-flex align-items-center">
                        <h5 id="title">{{ $currentTitle }}</h5>
                    </div>
                    <form action="" id="purchase-form" method="post">
                        @csrf
                        <input type="text" class="form-control" name="id" value="{{ $purchase->id ?? '' }}" hidden>
                        <div class="card-body px-4 pt-4 pb-2">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group d-flex align-items-center">
                                            <label for="category" class="me-2 text-sm col-3">Produk</label>
                                            <select required class="form-select w-40" name="product_id" aria-label="Default select example" id="product-select" onchange="getProductData(this.value)" {{ $isCreateRoute ? '' : 'disabled' }}>
                                                <option selected disabled>Pilih Produk</option>
                                                @foreach($product as $data_product)
                                                <option value="{{ $data_product->id }}" {{ isset($purchase) && $purchase->product_id == $data_product->id ? 'selected' : '' }}>
                                                    {{ $data_product->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group d-flex align-items-center">
                                            <label for="purchase_unit" class="me-2 text-sm col-3">Satuan Beli</label>
                                            <input required type="text" class="form-control" name="purchase_unit" id="purchase-unit" value="{{ isset($purchase) && $purchase_product->purchase_unit ? $purchase_product->purchase_unit : '' }}"   placeholder="pcs, box, renteng" disabled>
                                        </div>
                                        <div class="form-group d-flex align-items-center">
                                            <label for="purchase_price" class="me-2 text-sm col-3">Harga Beli</label>
                                            <input required type="number" class="form-control" name="purchase_price" id="purchase-price" value="{{ isset($purchase) && $purchase_product->purchase_price ? $purchase_product->purchase_price : '' }}" placeholder="0" disabled>
                                        </div>
                                        <div class="form-group d-flex align-items-center">
                                            <label for="quantity_per_purchase_unit" class="me-2 text-sm col-3">Isi Per Satuan Beli</label>
                                            <input required type="number" class="form-control" name="quantity_per_purchase_unit" id="quantity-per-purchase-unit" value="{{ isset($purchase) && $purchase_product->quantity_per_purchase_unit ? $purchase_product->quantity_per_purchase_unit : '' }}"  placeholder="0" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group d-flex align-items-center">
                                            <label for="name" class="me-2 text-sm col-3">Jumlah Pembelian</label>
                                            <input required type="number" class="form-control" id="purchase-quantity" name="purchase_quantity" value="{{ $purchase->purchase_quantity ?? '' }}" placeholder="Masukkan jumlah pembelian" oninput="calculateTotalPrice(this.value)">
                                        </div>
                                        <div class="form-group d-flex align-items-center">
                                            <label for="stock" class="me-2 text-sm col-3">Stok Jual</label>
                                            <input type="text" class="form-control" name="purchase_stock" id="purchase-stock" value="{{ $purchase->purchase_stock ?? 0 }}" placeholder="0" disabled>
                                        </div>
                                        <div class="form-group d-flex align-items-center">
                                            <label for="name" class="me-2 text-sm col-3">Total Harga Pembelian</label>
                                            <input disabled type="text" id="total-price" class="form-control" name="total_price" value="{{ $purchase->total_price ?? '' }}" placeholder="0">
                                        </div>
                                        <div class="form-group d-flex align-items-center">
                                            <label for="name" class="me-2 text-sm col-3">Tanggal Pembelian</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                                                <input required class="form-control" type="date" name="date" placeholder="Please select date" value="{{ $purchase->date ?? $currentDate }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            
                        </div>
                        <div class="card-footer text-end">
                            <a href="javascript:history.back()" type="button" class="btn btn-secondary">Back</a>
                            <button type="button" class="btn btn-primary" onclick="submitForm()">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script>

    function submitForm(){
        $('#total-price').prop('disabled', false);
        $('#purchase-stock').prop('disabled', false);
        
        $('#purchase-form').submit();
    }

    function calculateTotalPrice(quantity) {
        var productId = $('#product-select').val(); 

        getProductData(productId);
    }

    function getProductData(productId){
        var quantity = $('#purchase-quantity').val(); 
        console.log(productId);
        $.ajax({
            url: "{{ url('purchase') }}/" + productId + "/product",
            type: 'GET',
            success: function(response) {
                if (response.success) {
                    var data = response.data;
                    console.log(data);
                    $('#purchase-unit').val(data.purchase_unit);
                    $('#purchase-price').val(data.purchase_price);
                    $('#quantity-per-purchase-unit').val(data.quantity_per_purchase_unit);

                if (quantity != 0 || quantity !== '' || !isNaN(quantity)) {
                    var purchasePrice = data.purchase_price; 
                    var quantityPerPurchaseUnit = data.quantity_per_purchase_unit;
                    var totalPrice = purchasePrice * quantity;
                    var sellingStock = quantityPerPurchaseUnit * quantity;
                    $('#total-price').val(totalPrice);
                    $('#purchase-stock').val(sellingStock);

                }else{
                    $('#total-price').val(0);
                    $('#purchase-stock').val(0);
                }

                // callback(data);
                } else {
                    console.error('Gagal mendapatkan data dari server');
                }
            },
            error: function(error) {
                console.error('Terjadi kesalahan: ', error);
            }
        });
    }
</script>

@endsection