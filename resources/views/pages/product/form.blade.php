@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Produk', 'subTitle' => 'Tambah Produk'])
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div id="alert">
                    @include('components.alert')
                </div>
                    <div class="card-header pb-3 d-flex align-items-center">
                        <h5 id="title">Tambah Produk</h5>
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
                                            <input required type="number" class="form-control" id="purchase_price" name="purchase_price" value="{{ $product->purchase_price ?? '' }}" placeholder="Masukkan harga beli">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group d-flex align-items-center">
                                            <label for="quantity_per_purchase_unit" class="me-2 text-sm col-3">Isi Per Satuan Beli</label>
                                            <input required type="number" class="form-control" name="quantity_per_purchase_unit" value="{{ $product->quantity_per_purchase_unit ?? '' }}" placeholder="Masukkan isi per satuan" onkeyup="getPricePerPurchaseItem(this.value)">
                                        </div>
                                        <div class="form-group d-flex align-items-center">
                                            <label for="price_per_purchase_item" class="me-2 text-sm col-3">Harga Beli Per Isi</label>
                                            <input required type="number" disabled id="price_per_purchase_item" class="form-control" name="price_per_purchase_item" value="{{ $product->price_per_purchase_item ?? '' }}" placeholder="Masukkan harga beli per isi" >
                                        </div>
                                        <div class="form-group d-flex align-items-center">
                                            <label for="selling_unit" class="me-2 text-sm col-3">Satuan Jual</label>
                                            <input required type="text" class="form-control" name="selling_unit" value="{{ $product->selling_unit ?? '' }}" placeholder="Masukkan satuan jual (cth: pcs, box, renteng)">
                                        </div>
                                        <div class="form-group d-flex align-items-center">
                                            <label for="selling_price" class="me-2 text-sm col-3">Harga Jual</label>
                                            <input required type="text" class="form-control" name="selling_price" value="{{ $product->selling_price ?? '' }}" placeholder="Masukkan harga jual">
                                        </div>
                                        {{-- <div class="form-group d-flex align-items-center">
                                            <label for="stock" class="me-2 text-sm col-3">Stok</label>
                                            <input type="text" class="form-control" name="stock" value="{{ $product->stock ?? '' }}" placeholder="Masukkan stok">
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer text-end">
                            <a href="javascript:history.back()" type="button" class="btn btn-secondary">Back</a>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>  

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function getPricePerPurchaseItem(data){
            console.log(data);
            var purchase_price = $('#purchase_price').val(); 
            
            var value = purchase_price / data ;
            $('#price_per_purchase_item').val(value);



        }
    </script>

    <script>
        document.getElementById('product-form').addEventListener('submit', function(event) {
            // Re-enable the input field just before the form is submitted
            document.getElementById('price_per_purchase_item').removeAttribute('disabled');
        });
    </script>

@endsection