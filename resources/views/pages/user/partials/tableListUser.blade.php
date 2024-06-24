 <div class="table-responsive p-0" id="table-data">
    <table class="table align-items-center mb-0">
            <thead>
            <tr>
                <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7" style="width: 5%">
                    No </th>
                <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7" style="width: 25%">
                    Nama </th>
                <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7" style="width: ">
                    Username </th>
                <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7" style="width: ">
                    Role </th>
                <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @if (count($listUser) > 0)
                @foreach ( $listUser as $i => $data)
                    <tr>
                        <td class="align-middle text-left text-xl font-weight-bold">
                            <span class="ms-3">
                                {{ $loop->index + 1 + ($listUser->perPage() * ($listUser->currentPage() - 1)) }}
                            </span>
                        </td>
                        <td class="align-middle text-left text-md font-weight-bold">
                            <span class="ms-3">
                                {{ $data->name }}
                            </span>
                        </td>
                        <td class="align-middle text-left text-md font-weight-bold">
                            <span class="ms-3">
                                {{ $data->username }}
                            </span>
                        </td>
                        <td class="align-middle text-left text-md font-weight-bold">
                            <span class="ms-3">
                                {{ $data->role}}
                            </span>
                        </td>
                        <td class="d-flex align-middle text-left text-md font-weight-bold">
                            <a href="{{ route('user.edit', ['id' => $data->id]) }}" class="btn btn-link text-secondary mb-0">
                                <i class="fa fa-edit text-xs" style="color: rgb(255, 179, 0)" aria-hidden="true" title="Edit pengguna"></i>
                            </a>
                            <form action="/user" method="post"  id="delete-form-{{ $data->id }}"">
                                @csrf
                                @method('DELETE')
                                <input hidden type="text" name="id" value="{{ $data->id }}">
                                <button type="button" class="btn btn-link text-secondary mb-0" onclick="deleteData({{ $data->id }})">
                                    <i class="fa fa-trash text-xs" style="color: red" aria-hidden="true" title="Hapus pengguna"></i>
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
        {!! $listUser->links('vendor.pagination.bootstrap-5') !!}
    </div>
</div>