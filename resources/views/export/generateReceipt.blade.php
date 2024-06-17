<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice</title>
    <style>
        .container {
            width: 189px;
        }
        .header {
            margin: 0;
            text-align: center;
        }
        h2, p {
            margin: 0;
        }
        .flex-container-1 {
            display: flex;
            margin-top: 10px;
        }

        .flex-container-1 > div {
            text-align : left;
        }
        .flex-container-1 .right {
            text-align : right;
            width: 109px;
        }
        .flex-container-1 .left {
            width: 80px;
        }
        .flex-container {
            display: flex;
        }

        .flex-container > div {
            flex: 1;
        }

        .flex-container-2 {
            display: flex;
            margin-top: 10px;
        }

        .flex-container-2 > div {
            text-align : left;
        }
        .flex-container-2 .right {
            text-align : right;
            width: 109px;
        }
        .flex-container-2 .left {
            width: 80px;
            margin-left: 30px
        }
        ul {
            display: contents;
        }
        ul li {
            display: block;
            font-size: 15px
        }
        hr {
            border-style: dashed;
        }
        a {
            text-decoration: none;
            text-align: center;
            padding: 10px;
            background: #00e676;
            border-radius: 5px;
            color: white;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header" style="margin-bottom: 30px;">
            <h2>Toko Pimny</h2>
            <small>Jl Karya Timur Gang 1 RT 7 RW 2, Purwantoro, Blimbig, Kota Malang, 65122
            </small>
        </div>
        <hr>
        <div class="flex-container-1">
            <div class="left">
                <ul>
                    <li>No Order</li>
                    <li>Kasir</li>
                    <li>Tanggal</li>
                </ul>
            </div>
            <div class="right">
                <ul>
                    <li> {{ $sale->invoice_number }} </li>
                    <li> Sabina </li>
                    <li> {{ date('Y-m-d : H:i:s', strtotime($sale->updated_at)) }} </li>
                </ul>
            </div>
        </div>
        <hr>
        <div class="flex-container" style="margin-bottom: 10px; text-align:right;">
            <div style="text-align: left; font-size:15px">Produk</div>
            <div style="font-size:15px">Harga/Qty</div>
            <div style="font-size:15px">Total</div>
        </div>
        @foreach ($sale->saleDetailsWithProduct  as $saleDetail)
                <div class="flex-container" style="text-align: right;">
                    <div style="text-align: left; font-size:13px"">{{ $saleDetail->quantity }} x {{ $saleDetail->product->name }}</div>
                    <div style="font-size:13px">Rp {{ number_format($saleDetail->product->sale_price) }} </div>
                    <div style="font-size:13px">Rp {{ number_format($saleDetail->total_price) }} </div>
                </div>
        @endforeach
        <hr>
        <div class="flex-container-2" style="text-align: right; margin-top: 10px;">
            <div></div>
            <div class="left">
                <ul>
                    <li>Grand Total</li>
                    <li>Pembayaran</li>
                    <li>Kembalian</li>
                </ul>
            </div>
            <div class="right">
                <ul>
                    <li>Rp {{ number_format($sale->total_price) }} </li>
                    <li>Rp {{ number_format($sale->payment_amount) }}</li>
                    <li>Rp {{ number_format($sale->payment_amount - $sale->total_price) }}</li>
                </ul>
            </div>
        </div>
        <hr>
        <div class="header" style="margin-top: 50px;">
            <h3>Terimakasih</h3>
            <p>Silahkan berkunjung kembali</p>
        </div>
    </div>
</body>
</html>