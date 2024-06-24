<table class="table align-items-center mb-0">
            <thead>
            <tr>
                <th style="border: 1px solid black;">
                    No
                </th>
                <th style="border: 1px solid black;">
                    No Struk
                </th>
                <th style="border: 1px solid black;">
                    Tanggal
                </th>
                <th style="border: 1px solid black;">
                    Produk
                </th>
                <th style="border: 1px solid black;">
                    Jumlah
                </th>
                <th style="border: 1px solid black;">
                    Harga
                </th>
                <th style="border: 1px solid black;">
                    Total
                </th>
                <th style="border: 1px solid black;">
                    Total Belanja
                </th>
            </tr>
        </thead>
        <tbody>
            @if(count($listSaleReport) > 0)
                @foreach ($listSaleReport as $data)
                    <tr>
                        <td rowspan="{{ count($data->saleDetailsWithProduct) }}" style="border: 1px solid black; text-align: center; vertical-align: middle;">
                            {{ $loop->index + 1  }}
                        </td>
                        <td rowspan="{{ count($data->saleDetailsWithProduct) }}" style="border: 1px solid black; text-align: center; vertical-align: middle;" >
                            {{ $data->invoice_number }}
                        </td>
                        <td rowspan="{{ count($data->saleDetailsWithProduct) }}" style="border: 1px solid black; text-align: center; vertical-align: middle;">
                            {{ \Carbon\Carbon::parse($data->updated_at)->format('d-m-Y') }}
                        </td>
                        <td style="border: 1px solid black;">
                            {{ $data->saleDetailsWithProduct[0]->product->name }}
                        </td>
                        <td style="border: 1px solid black;">
                            {{ $data->saleDetailsWithProduct[0]->quantity }}
                        </td>
                        <td style="border: 1px solid black;">
                            Rp {{ number_format($data->saleDetailsWithProduct[0]->product->sale_price, 0, '.', '.') }}
                        </td>
                        <td style="border: 1px solid black;">
                            Rp {{ number_format($data->saleDetailsWithProduct[0]->total_price, 0 , '.', '.') }}
                        </td>
                        <td rowspan="{{ count($data->saleDetailsWithProduct) }}" style="border: 1px solid black; text-align: center; vertical-align: middle;">
                            Rp {{ number_format($data->total_price, 0 , '.', '.') }}
                        </td>
                    </tr>
                    @for($i=1; $i<count($data->saleDetailsWithProduct); $i++)
                        <tr>
                            <td style="border: 1px solid black;">
                            {{ $data->saleDetailsWithProduct[$i]->product->name }}
                            </td>
                            <td style="border: 1px solid black;">
                                {{ $data->saleDetailsWithProduct[$i]->quantity }}
                            </td>
                            <td style="border: 1px solid black;">
                                Rp {{ number_format($data->saleDetailsWithProduct[$i]->product->sale_price, 0, '.', '.') }}
                            </td>
                            <td style="border: 1px solid black;">
                                Rp {{ number_format($data->saleDetailsWithProduct[$i]->total_price, 0 , '.', '.') }}
                            </td>
                        </tr>
                    @endfor
                @endforeach
            @else
                <tr>
                    <td colspan="8" class="text-center">Tidak ada data</td>
                </tr>
            @endif
        </tbody>
</table>