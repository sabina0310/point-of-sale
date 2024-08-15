@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@php
    $currentTitle = Str::contains(Route::currentRouteName(), 'create') ? 'Tambah Produk' : 'Edit Produk';

@endphp

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Produk', 'subTitle' => $currentTitle])
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-3 d-flex align-items-center">
                        <h5 id="title">{{ $currentTitle }}</h5>
                    </div>
                    <form action="" method="post" id="product-form" class="">
                        @csrf
                        <div class="card-body px-4 pt-4 pb-2">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group d-flex align-items-center">
                                            <label for="category" class="me-2 text-sm col-3">Kategori</label>
                                            <select class="form-select" name="category_id" aria-label="Default select example">
                                                <option selected disabled>Pilih Kategori</option>
                                                @foreach($category as $data_cat)
                                                <option value="{{ $data_cat->id }}" {{ isset($product) && $product->category_id == $data_cat->id ? 'selected' : '' }}>
                                                    {{ $data_cat->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <input type="text" class="form-control" name="id" value="{{ $product->id ?? '' }}" hidden>
                                        <div class="form-group d-flex align-items-center">
                                            <label for="name" class="me-2 text-sm col-3">Nama Produk</label>
                                            <input required type="text" class="form-control" name="name" value="{{ $product->name ?? '' }}" placeholder="Masukkan nama produk">
                                        </div>
                                        <div class="form-group d-flex align-items-center">
                                            <label for="purchase_unit" class="me-2 text-sm col-3">Satuan Beli</label>
                                            <input required type="text" class="form-control" name="purchase_unit" value="{{ $product->purchase_unit ?? '' }}" placeholder="Masukkan satuan (cth: pcs, box, renteng)">
                                        </div>
                                        <div class="form-group d-flex align-items-center">
                                            <label for="purchase_price" class="me-2 text-sm col-3">Harga Beli</label>
                                            <input required type="text" class="form-control" id="purchase-price" name="purchase_price" value="{{ isset($product) ? $product->purchase_price: '' }}" placeholder="Masukkan harga beli" oninput="onPurchasePrice(this)">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group d-flex align-items-center">
                                            <label for="quantity_per_purchase_unit" class="me-2 text-sm col-3">Isi Per Satuan Beli</label>
                                            <input required type="number" class="form-control" name="quantity_per_purchase_unit" id="quantity-per-purchase-unit" value="{{ $product->quantity_per_purchase_unit ?? '' }}" placeholder="Masukkan isi per satuan" oninput="calculatePricePerPurchaseItem()">
                                        </div>
                                        <div class="form-group d-flex align-items-center">
                                            <label for="price_per_purchase_item" class="me-2 text-sm col-3">Harga Beli Per Isi</label>
                                            <input required type="number" name="price_per_purchase_item" disabled id="price-per-purchase-item" class="form-control"  value="{{ $product->price_per_purchase_item ?? '' }}" placeholder="0" >
                                            
                                        </div>
                                        <div class="form-group d-flex align-items-center">
                                            <label for="sale_unit" class="me-2 text-sm col-3">Satuan Jual</label>
                                            <input required type="text" class="form-control" name="sale_unit" value="{{ $product->sale_unit ?? '' }}" placeholder="Masukkan satuan jual (cth: pcs, box, renteng)">
                                        </div>
                                        <div class="form-group d-flex align-items-center">
                                            <label for="sale_price" class="me-2 text-sm col-3">Harga Jual</label>
                                            <input required type="text" class="form-control" id="sale-price" name="sale_price" value="{{ $product->sale_price ?? '' }}" placeholder="Masukkan harga jual" oninput="onSalePrice(this)">
                                        </div>
                                        <div class="form-group d-flex align-items-center">
                                            <label for="profit" class="me-2 text-sm col-3">Laba</label>
                                            <input disabled type="text" class="form-control" id="profit" value="{{ isset($product) ? $product->sale_price - $product->price_per_purchase_item : '' }}" placeholder="0" oninput="formattedPrice(this)">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer text-end">
                            <a href="{{ route('product') }}" type="button" class="btn btn-secondary">Back</a>
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
            $('#price-per-purchase-item').prop('disabled', false);
            var currentRoute =  '{{ request()->url() }}';
            
            $.ajax({
                url: currentRoute,
                method: 'POST',
                data: $('#product-form').serialize(),
                success: function(response) {
                    if (response.success) {
                        console.log(response);
                        
                        // Redirect to /product after successful submission
                        Swal.fire({
                            title: "Sukses!",
                            text: response.message,
                            icon: "success",
                            timer: 3500
                        }).then(() => {
                                window.location.href = '/product' // Reload the page
                        });
                            
                        // Set a timeout to delay the redirection
                        setTimeout(function() {
                            window.location.href = '/product';
                        }, 3500); 
                        // Show success message using Swal
                    }  else {
                        console.error('Gagal mendapatkan data dari server');
                    }
                },
                error: function(error) {
                    $('#price-per-purchase-item').prop('disabled', true);

                    let errorMessages = error.responseJSON.errors;
                    let errorMessageHTML = '<ul style="list-style-type: none;">';
                    
                    // Loop through each error message and create list items
                    $.each(errorMessages, function(key, value) {
                        errorMessageHTML += '<li>' + value + '</li>';
                    });

                    errorMessageHTML += '</ul>';

                    Swal.fire({
                        title: 'Gagal!',
                        html: errorMessageHTML,
                        icon: 'error',
                        timer: 3500,
                    });
                }
            });
        }

        function calculatePricePerPurchaseItem(){
            var purchase_price = $('#purchase-price').val(); 
            var quantity_per_purchase_unit = $('#quantity-per-purchase-unit').val(); 

            var value = purchase_price / quantity_per_purchase_unit ;
            $('#price-per-purchase-item').val(value); 

            calculateProfit();   
        }

        function calculateProfit(){
            var price_per_purchase_item = $('#price-per-purchase-item').val(); 
            var sale_price = $('#sale-price').val(); 
            console.log(price_per_purchase_item);
            console.log(sale_price);

            var value = sale_price - price_per_purchase_item ;
            $('#profit').val(value);  
        }

        function formattedPrice(input) {
            // Remove non-numeric characters from the input
            const value = input.value.replace(/\D/g, '');
            
            // Format the number with periods every three digits
            // const formattedValue = value.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            
            // Update the input field value with the formatted value
            input.value = value;
        }

        function onPurchasePrice(input){
            formattedPrice(input);
            calculatePricePerPurchaseItem();
        }
        function onSalePrice(input){
            formattedPrice(input);
            calculateProfit();
        }


       
    </script>

@endsection