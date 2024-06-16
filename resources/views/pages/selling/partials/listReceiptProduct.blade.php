@if(count($sale_detail) > 0)
    @foreach ($sale_detail as $product )
        <div class="col-md-12" id="product-{{ $product->id }}">
            <div class="row">
                <div class="mb-3 col-11">
                    <div class="text-md">
                        {{ $product->product_name }}
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-sm">
                            {{ $product->quantity }} {{ $product->product_unit }}
                        </span>
                        <span class="text-sm">
                            x
                        </span>
                        <span class="text-sm">
                            {{ $product->product_price }}
                        </span>
                        <span class="text-sm">
                            =
                        </span>
                        <span class="text-sm text-bold">
                            {{ $product->total_price }}
                        </span>
                    </div>
                </div>
                <div class="col-1 d-flex justify-content-center align-items-center">
                    <button type="button" class="btn btn-link text-danger btn-xs mb-0" onclick="deleteCartProduct({{ $product->id }})">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        </div>
    @endforeach
@else 
    <span class="text-sm d-flex justify-content-center"> Tidak ada transaksi
    </span>
@endif
<hr>
<div class="d-flex justify-content-between mb-2">
    <h7>Total </h7>
    <span class="font-weight-bold"> Rp
        <span id="total-amount"> 
            {{ count($sale) > 0 ? $sale['total_price'] : 0}}
        </span> 
    </span>
</div>
<div class="d-flex justify-content-between mb-2">
    <h7>Bayar </h7>
    <div class="w-50">
        <div class="input-group">
            <span class="input-group-text" style="background-color: #dadada;">Rp</span>
            <input type="number" min="0" required class="form-control ps-2" id="payment-amount" value="{{ count($sale) > 0 ? $sale['payment_amount'] : 0}}" oninput="calculateReturn(this.value)" {{ count($sale) <= 0 ? 'disabled' : '' }}>
        </div>
    </div>
</div>
<div class="d-flex justify-content-between mb-2">
    <h7>Kembali </h7>
    <span id="return-amount">
        Rp 0
    </span>
</div>

<div class="pt-0 pb-2 mt-4">
    <div class="d-flex justify-content-between">  
        <div class="d-flex flex-column">
            <button type="button" class="btn mb-2 {{ count($sale) <= 0 ? 'btn-secondary text-white' : 'btn-info' }}" onclick="newTransaction()" {{ count($sale) <= 0 ? 'disabled' : '' }}>
                <i class="fa fa-note-sticky"></i> Transaksi Baru
            </button>
            <button type="button" class="btn  mb-0 {{ count($sale) <= 0 ? 'btn-secondary text-white' : 'btn-danger' }}" onclick="cancelTransaction()" {{ count($sale) <= 0 ? 'disabled' : '' }}>
                <i class="fas fa-xmark"></i> Batal
            </button>
        </div>
        <div>
            <button type="button" class="btn  mb-0 {{ count($sale) <= 0 ? 'btn-secondary text-white' : 'btn-success' }}" onclick="submit()" {{ count($sale) <= 0 ? 'disabled' : '' }}>
                <i class="fas fa-check me-1"></i> OK
            </button>
        </div>
    </div>
</div>
