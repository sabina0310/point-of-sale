<div class="table-responsive p-0" id="table-data">
    <table class="table align-items-center mb-0">
        <thead>
            <tr>
                <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7" style="width: 1%">
                    No 
                </th>
                <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7" style="width: 5%">
                    Nomor Nota
                </th>
                <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7" style="width: 5%">
                    Total Belanja
                </th>
                <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7" style="width: 5%">
                    Status
                </th>
                <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7" style="width: 5%">
                    Aksi
                </th>
            </tr>
        </thead>
        <tbody>
            @if (count($listSaleHistory) > 0)
                @foreach ($listSaleHistory as $i => $data)
                    <tr>
                        <td class="align-middle text-left text-xl font-weight-bold">
                            <span class="ms-3">
                                {{ $loop->index + 1 + ($listSaleHistory->perPage() * ($listSaleHistory->currentPage() - 1)) }}
                            </span>
                        </td>
                        <td class="align-middle text-left text-xl font-weight-bold">
                            <span class="ms-3">
                                {{ $data->invoice_number }}
                            </span>
                        </td>
                        <td class="align-middle text-left text-xl font-weight-bold">
                            <span>
                            Rp {{ number_format($data->total_price, 0, ',', '.') }}
                            </span>
                        </td>
                        <td class="align-middle text-left text-xl font-weight-bold ">
                            <span class="ms-3">
                                <button class="mb-0 btn {{ $data->status == 'success' ? 'btn-success' : 'btn-danger' }} text-capitalize">
                                    {{ $data->status }}
                                </button>
                            </span>
                        </td>
                        <td class="d-flex align-middle text-left text-xl font-weight-bold">
                            @if ($data->status == 'pending')
                                {{-- <form id="edit-sale-form" action="/sale" method="">
                                    @csrf
                                    <input hidden type="text" name="invoice_number" value="{{ $data->invoice_number }}">
                                    <button class="btn btn-link text-secondary mb-0" type="submit" >
                                    <i class="fa fa-edit text-xs" style="color: rgb(255, 179, 0)" aria-hidden="true" title="Edit transaksi"></i>
                                </form> --}}
                                <a href="{{ route('sale-history.edit', ['id' => $data->id]) }}" class="btn btn-link text-secondary mb-0">
                                    <i class="fa fa-edit text-xs" style="color: rgb(255, 179, 0)" aria-hidden="true" title="Edit transaksi"></i>
                                </a>
                            @endif
                            @if ($data->status == 'success')
                            <form action="{{ route('generate-receipt') }}" method="GET" target="_blank" style="display: inline;">
                                <input type="hidden" name="invoice_number" value="{{ $data->invoice_number }}">
                                <button type="submit" class="btn btn-link text-secondary mb-0" style="border: none; background: none;">
                                    <i class="fa fa-print text-xs" style="color: darkblue" aria-hidden="true" title="Print nota transaksi"></i>
                                </button>
                            </form>
                            @endif
                            <form action="/sale-history" method="post" id="delete-form-{{ $data->id }}">
                                @csrf
                                @method('DELETE')
                                <input hidden type="text" name="id" value="{{ $data->id }}">
                                <button type="button" class="btn btn-link text-secondary mb-0" onclick="deleteData({{ $data->id }})">
                                    <i class="fa fa-trash text-xs" style="color: red" aria-hidden="true" title="Hapus transaksi"></i>
                                </button>
                            </form>
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

    <div class="px-3 pt-3">
        {!! $listSaleHistory->links('vendor.pagination.bootstrap-5') !!}
    </div>
</div>