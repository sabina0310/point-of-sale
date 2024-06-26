 <div class="table-responsive p-0">
    <table class="table align-items-center mb-0">
            <thead>
            <tr>
                <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7" style="width: 5%">
                    No </th>
                <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7" style="width: 5%">
                    Tanggal </th>
                <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7" style="width: 10%">
                    Menu </th>
                <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7" style="width: 10%">
                    Tipe </th>
                <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7" style="width: ">
                    Pesan </th>
                <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @if (count($listActivityLogs) > 0)
                @foreach ( $listActivityLogs as $i => $data)
                    <tr>
                        <td class="align-middle text-left text-xl font-weight-bold">
                            <span class="ms-3">
                                {{ $loop->index + 1 + ($listActivityLogs->perPage() * ($listActivityLogs->currentPage() - 1)) }}
                            </span>
                        </td>
                        <td class="align-middle text-left text-xl font-weight-bold">
                            <span class="ms-3">
                                {{ \Carbon\Carbon::parse($data->created_at)->format('d-m-Y') }} 
                            </span>
                        </td>
                        <td class="align-middle text-left text-xl font-weight-bold">
                            <span class="ms-3">
                                {{ $data->model }}
                            </span>
                        </td>
                        <td class="align-middle text-left text-xl font-weight-bold">
                            <span class="ms-3">
                                {{ $data->log_type }}
                            </span>
                        </td>
                        
                        <td class="align-middle text-left text-xl font-weight-bold">
                            <span class="ms-3">
                                {{ ucwords($data->user->name) }} {{ $data->message }}
                            </span>
                        </td>
                        <td class="d-flex align-middle text-left text-xl font-weight-bold">
                            <a href="{{ route('activity-logs.detail', ['id' => $data->id]) }}" class="btn btn-link mb-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                                <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                                </svg>
                            </a>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="6" class="text-center">Tidak ada data</td>
                </tr>
            @endif
        </tbody>
    </table>

    <div class="px-3 pt-3">
        {!! $listActivityLogs->links('vendor.pagination.bootstrap-5') !!}
    </div>
</div>