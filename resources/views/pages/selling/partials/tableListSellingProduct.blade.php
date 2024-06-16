<div class="table-responsive p-0 mt-5">
    <table class="table align-items-center mb-0">
        <thead>
            <tr>
                <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7">
                    Nama Barang
                </th>
                <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7">
                    Stok
                </th>
                <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7">
                    Harga
                </th>
                <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7">
                    Jumlah
                </th>
                <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7">
                    Aksi
                </th>
            </tr>
        </thead>
        <tbody>
            @if (count($listSale) > 0)
                @foreach ( $listSale as $i => $value)
                    <tr>
                        <td class="align-middle text-left text-xl font-weight-bold">
                            <span class="ms-3">
                                {{ $value->name }}
                            </span>
                        </td>
                        <td class="align-middle text-left text-xl font-weight-bold">
                            <span class="ms-3">
                                {{ $value->stock }}
                            </span>
                        </td>
                        <td class="align-middle text-left text-xl font-weight-bold">
                            <span class="ms-3">
                                Rp {{ $value->sale_price }}
                            </span>
                        </td>
                        <td class="align-middle text-left w-5">
                            @if ($value->stock > 0)
                                <input type="number" id="quantity-{{ $value->id }}" class="form-control" value="1" min="1" max="{{ $value->stock }}" oninput="validateStock()">
                            @else
                                <input type="number" class="form-control" value="0" disabled>
                            @endif
                        </td>
                        <td class="align-middle text-left text-xl font-weight-bold">
                            @if ($value->stock > 0)
                                <button type="button" class="btn btn-success mb-0" onclick="checkoutProduct({{ $value->id }})">
                                    <i class="fas fa-cart-plus"></i>
                                </button>
                            @else
                                <button type="button" class="btn btn-link text-secondary mb-0" disabled>
                                    <i class="fas fa-cart-plus"></i>
                                </button>
                            @endif
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="5" class="text-center">Tidak ada produk</td>
                </tr>
            @endif

        </tbody>
    </table>
</div>