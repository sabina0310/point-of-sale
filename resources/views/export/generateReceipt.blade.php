<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice</title>
    <style>
        @page { 
            width: 13cm;
            margin: 0px; 
            scale: 100%}
        body {  
            
        }
        .container {
            width: 13cm;
            padding: 0;
            margin-left: 5px; 
            font-size: 24px; /* Adjust font size as needed */
        }
        .header {
            margin-bottom: 10px;
            text-align: center;
        }
        .header h2 {
            margin: 0;
        }
        .header small {
            display: block;
            font-size: 11px;
        }
        .content {
            margin-bottom: 10px;
        }
        table {
            width: 100%;
        }
        table th, table td {
            padding: 5px;
        }
        table th {
            text-align: left;
        }
        .table-1 td {
            text-align: right ;
        }
        .table-2 th {
            padding-left: 65px ;
        }
        .table-2 td {
            text-align: right ;
        }
        hr {
            border-style: dashed;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2 style="margin: 0;">Toko Pimny</h2>
            <h4 style="margin: 0; font-weight: 400">Jl Karya Timur Gang 1 RT 7 RW 2, Purwantoro, Blimbig, Kota Malang, 65122</h4>
        </div>
        <hr>
        <div class="content">
            <table class="table-1">
                <tr>
                    <th>No Order</th>
                    <td>{{ $sale->invoice_number }}</td>
                </tr>
                <tr>
                    <th>Kasir</th>
                    <td>Sabina</td>
                </tr>
                <tr>
                    <th>Tanggal</th>
                    <td>{{ date('Y-m-d : H:i:s', strtotime($sale->updated_at)) }}</td>
                </tr>
            </table>
        </div>
        <hr>
        <div class="content">
            <table>
                <tr>
                    <th style="width: 40%; ">Produk</th>
                    <th style="width: 30%; ">Harga</th>
                    <th style="width: 30%; ">Total</th>
                </tr>
                @foreach ($sale->saleDetailsWithProduct as $saleDetail)
                <tr>
                    <td style="">{{ $saleDetail->quantity }} x {{ $saleDetail->product->name }}</td>
                    <td style="">Rp {{ number_format($saleDetail->product->sale_price,'0', '.','.') }}</td>
                    <td style="">Rp {{ number_format($saleDetail->total_price,'0', '.','.') }}</td>
                </tr>
                @endforeach
            </table>
        </div>
        <hr>
        <div class="content">
            <table class="table-2">
                <tr>
                    <th>Grand Total</th>
                    <td>Rp {{ number_format($sale->total_price,'0', '.','.') }}</td>
                </tr>
                <tr>
                    <th>Pembayaran</th>
                    <td>Rp {{ number_format($sale->payment_amount,'0', '.','.') }}</td>
                </tr>
                <tr>
                    <th>Kembalian</th>
                    <td>Rp {{ number_format($sale->payment_amount - $sale->total_price,'0', '.','.') }}</td>
                </tr>
            </table>
        </div>
        <hr>
        <div class="header" style="margin-top: 10px; text-align: center;">
            <h3>Terimakasih</h3>
            <p>Silahkan berkunjung kembali</p>
        </div>
    </div>
</body>
</html>
