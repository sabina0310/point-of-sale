<div class="table-responsive p-0" id="table-data">
    <table class="table align-items-center mb-0">
            <thead>
            <tr>
                <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7" style="width: 5%">
                    No </th>
                <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7" style="width: 20%">
                    No Struk </th>
                <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7" style="width: 30%">
                    Tanggal </th>
                <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7" style="width: ">
                    Produk </th>
                <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7" style="width: ">
                    Jumlah </th>
                <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7" style="width: ">
                    Harga </th>
                <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7" style="width: ">
                    Total </th>
                <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7" style="width: ">
                    Total Belanja </th>
                <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @if(count($listSaleReport) > 0)
                @foreach ( $listSaleReport as $data )
                    <tr>
                        <td rowspan="{{ count($data->saleDetailsWithProduct) }}" class="align-middle text-left text-md font-weight-bold">
                            {{ $loop->index + 1  }}
                        </td>
                        <td rowspan="{{ count($data->saleDetailsWithProduct) }}" class="align-middle text-left text-md font-weight-bold">
                            {{ $data->invoice_number }}
                        </td>
                        <td rowspan="{{ count($data->saleDetailsWithProduct) }}" class="align-middle text-left text-md font-weight-bold">
                            {{ \Carbon\Carbon::parse($data->updated_at)->format('d-m-Y') }}

                        </td>
                        <td class="align-middle text-left text-md font-weight-bold">
                            {{ $data->saleDetailsWithProduct[0]->product->name }}
                        </td>
                        <td class="align-middle text-left text-md font-weight-bold">
                            {{ $data->saleDetailsWithProduct[0]->quantity }}
                        </td>
                        <td class="align-middle text-left text-md font-weight-bold">
                            Rp {{ number_format($data->saleDetailsWithProduct[0]->product->sale_price, 0, '.', '.') }}
                        </td>
                        <td class="align-middle text-left text-md font-weight-bold">
                            Rp {{ number_format($data->saleDetailsWithProduct[0]->total_price, 0 , '.', '.') }}
                        </td>
                        <td rowspan="{{ count($data->saleDetailsWithProduct) }}" class="align-middle text-left text-md font-weight-bold">
                            Rp {{ number_format($data->total_price, 0 , '.', '.') }}

                        </td>
                        <td rowspan="{{ count($data->saleDetailsWithProduct) }}" class="align-middle text-left text-md font-weight-bold">
                            
                        </td>
                    </tr>  
                    @for($i=1; $i<count($data->saleDetailsWithProduct); $i++)
                        <tr>
                            <td class="align-middle text-left text-md font-weight-bold">
                            {{ $data->saleDetailsWithProduct[$i]->product->name }}
                            </td>
                            <td class="align-middle text-left text-md font-weight-bold">
                                {{ $data->saleDetailsWithProduct[$i]->quantity }}
                            </td>
                            <td class="align-middle text-left text-md font-weight-bold">
                                Rp {{ number_format($data->saleDetailsWithProduct[$i]->product->sale_price, 0, '.', '.') }}
                            </td>
                            <td class="align-middle text-left text-md font-weight-bold">
                                Rp {{ number_format($data->saleDetailsWithProduct[$i]->total_price, 0 , '.', '.') }}
                            </td>
                        </tr>
                    @endfor
                @endforeach
            @else
            @endif
            
        </tbody>
    </table>
</div>