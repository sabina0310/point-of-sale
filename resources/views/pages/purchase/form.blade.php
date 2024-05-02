@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Pembelian', 'subTitle' => 'Tambah Pembelian'])
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
                    <form action="" id="purchase-form" method="post">
                        @csrf
                        <input type="text" class="form-control" name="id" value="{{ $purchase->id ?? '' }}" hidden>
                        <div class="card-body px-4 pt-4 pb-2">
                            <div class="form-group d-flex align-items-center">
                                <label for="category" class="me-2 text-sm col-3">Produk</label>
                                <select required class="form-select w-40" name="product_id" aria-label="Default select example" id="product-select" onchange="getProductData(this.value)">
                                    <option selected disabled>Pilih Produk</option>
                                    @foreach($product as $data_product)
                                    <option value="{{ $data_product->id }}" {{ isset($purchase) && $purchase->product_id == $data_product->id ? 'selected' : '' }}>
                                        {{ $data_product->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group d-flex align-items-center">
                                <label for="name" class="me-2 text-sm col-3">Jumlah Pembelian</label>
                                <input required type="number" class="form-control w-40" id="quantity" name="quantity" value="{{ $purchase->quantity ?? '' }}" placeholder="Masukkan jumlah pembelian" onkeyup="calculateTotalPrice(this.value)">
                            </div>
                            <div class="form-group d-flex align-items-center">
                                <label for="name" class="me-2 text-sm col-3">Total Harga Pembelian</label>
                                <input disabled type="text" id="total_price" class="form-control w-40" name="total_price" value="{{ $purchase->total_price ?? '' }}" placeholder="0">
                            </div>
                            <div class="form-group d-flex align-items-center">
                                <label for="name" class="me-2 text-sm col-3">Tanggal Pembelian</label>
                                <div class="input-group w-20">
                                    <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                                    <input required class="form-control" type="date" name="date" placeholder="Please select date" type="text">
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
//     $('.datepicker').datepicker({
//     format: 'mm/dd/yyyy',
//     startDate: '-3d'
// });
</script>
<script>
    function calculateTotalPrice(quantity) {
        var productId = $('#product-select').val(); 
        getProductData(productId, function(data) {
            var purchasePrice = data.purchase_price; 
            var totalPrice = purchasePrice * quantity;
            $('#total_price').val(totalPrice);
        });
    }

    function getProductData(productId, callback){
        var quantity = $('#quantity').val(); 
        console.log(productId);
        $.ajax({
            url: "{{ url('purchase') }}/" + productId + "/product",
            type: 'GET',
            success: function(response) {
                if (response.success) {
                var data = response.data;
                    
                if (quantity && quantity !== '' && !isNaN(quantity)) {
                    var purchasePrice = data.purchase_price; 
                    var totalPrice = purchasePrice * quantity;
                    $('#total_price').val(totalPrice);
                }
                
                callback(data);
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
<script>
   document.getElementById('purchase-form').addEventListener('submit', function(event) {
    // Re-enable the input field just before the form is submitted
    document.getElementById('total_price').removeAttribute('disabled');
});
</script>

@endsection