<div class="table-responsive p-0" id="table-data">
    <table class="table align-items-center mb-0">
            <thead>
            <tr>
                <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7" style="width: 5%">
                    No </th>
                <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7" style="width: 30%">
                    Nama Produk</th>
                <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7" style="width: 15%">
                    Kategori</th>
                <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7" style="width: 10%">
                    Harga Beli</th>
                <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7" style="width: 10%">
                    Harga Jual</th>
                <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7" style="width: 10%">
                    Stok</th>
                <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @if (count($listProduct) > 0)
                @foreach ( $listProduct as $i => $data)
                    <tr>
                        <td class="align-middle text-left text-xl font-weight-bold">
                            <span class="ms-3">
                                {{ $loop->index + 1 + ($listProduct->perPage() * ($listProduct->currentPage() - 1)) }}
                            </span>
                        </td>
                        <td class="align-middle text-left text-xl font-weight-bold">
                            <span class="ms-3">
                                {{ $data->name }}
                            </span>
                        </td>
                        <td class="align-middle text-left text-xl font-weight-bold">
                            <span class="ms-3">
                                {{ $data->category_name }}
                            </span>
                        </td>
                        <td class="align-middle text-left text-xl font-weight-bold">
                            <span class="ms-3">
                                {{ $data->price_per_purchase_item }}
                            </span>
                        </td>
                        <td class="align-middle text-left text-xl font-weight-bold">
                            <span class="ms-3">
                                {{ $data->sale_price }}
                            </span>
                        </td>
                        <td class="align-middle text-left text-xl font-weight-bold">
                            <span class="ms-3">
                                {{ $data->stock }}
                            </span>
                        </td>
                        <td class="d-flex align-middle text-left text-xl font-weight-bold">
                            <a href="{{ route('product.detail', ['id' => $data->id]) }}" class="btn btn-link mb-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                                <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                                </svg>
                            </a>
                            <a href="{{ route('product.edit', ['id' => $data->id]) }}" class="btn btn-link text-secondary mb-0">
                                <i class="fa fa-edit text-xs" style="color: rgb(255, 179, 0)" aria-hidden="true" title="Edit produk"></i>
                            </a>
                            <form action="/product" method="post" id="delete-form-{{ $data->id }}"">
                                @csrf
                                @method('DELETE')
                                <input hidden type="text" name="id" value="{{ $data->id }}">
                                <button type="button" class="btn btn-link text-secondary mb-0" onclick="deleteData({{ $data->id }})">
                                    <i class="fa fa-trash text-xs" style="color: red" aria-hidden="true" title="Hapus produk"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="7" class="text-center">Tidak ada produk</td>
                </tr>
            @endif
           
        </tbody>
    </table>

    <div class="px-3 pt-3">
        {!! $listProduct->links('vendor.pagination.bootstrap-5') !!}
    </div>
</div>