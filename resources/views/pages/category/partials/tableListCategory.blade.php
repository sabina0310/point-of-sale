 <div class="table-responsive p-0" id="table-data">
    <table class="table align-items-center mb-0">
            <thead>
            <tr>
                <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7" style="width: 5%">
                    No </th>
                <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7" style="width: 75%">
                    Nama Kategori</th>
                <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @if (count($listCategory) > 0)
                @foreach ( $listCategory as $i => $data)
                    <tr>
                        <td class="align-middle text-left text-xl font-weight-bold">
                            <span class="ms-3">
                                {{ $loop->index + 1 + ($listCategory->perPage() * ($listCategory->currentPage() - 1)) }}
                            </span>
                        </td>
                        <td class="align-middle text-left text-xl font-weight-bold">
                            <span class="ms-3">
                                {{ $data->name }}
                            </span>
                        </td>
                        <td class="d-flex align-middle text-left text-xl font-weight-bold">
                            <button class="btn btn-link text-secondary mb-0" onclick="openModalFormEdit({{ $data->id }})">
                                <i class="fa fa-edit text-xs" style="color: rgb(255, 179, 0)" aria-hidden="true" title="Edit kategori"></i>
                            </button>
                            <form action="/category" method="post" id="delete-form-{{ $data->id }}"">
                                @csrf
                                @method('DELETE')
                                <input hidden type="text" name="id" value="{{ $data->id }}">
                                <button type="button" class="btn btn-link text-secondary mb-0" onclick="deleteData({{ $data->id }})">
                                    <i class="fa fa-trash text-xs" style="color: red" aria-hidden="true" title="Hapus kategori"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="2" class="text-center">Tidak ada data</td>
                </tr>
            @endif
        </tbody>
    </table>

    <div class="px-3 pt-3">
        {!! $listCategory->links('vendor.pagination.bootstrap-5') !!}
    </div>
</div>