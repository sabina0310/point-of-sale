@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('modal')
    @include('pages.category.partials.modal-form')

@endsection

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Kategori'])
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div id="alert">
                    @include('components.alert')
                </div>
                    <div class="card-header pb-3 d-flex align-items-center">
                        <h5>Kategori</h5>
                        <div class="ms-md-auto pe-md-3 d-flex">
                            <div class="input-group">
                                <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
                                <input type="text" class="form-control" placeholder="Type here...">
                            </div>
                        </div>
                        <button class="btn btn-primary btn-sm mb-0" onclick="openModalFormInsert()"><i class="fas fa-plus me-2"></i>Tambah</button>
                    </div>

                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
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
                                    @foreach ( $listCategory as $i => $value)
                                        <tr>
                                            <td class="align-middle text-left text-xl font-weight-bold">
                                                <span class="ms-3">
                                                    {{ $loop->index + 1 + ($listCategory->perPage() * ($listCategory->currentPage() - 1)) }}
                                                </span>
                                            </td>
                                            <td class="align-middle text-left text-xl font-weight-bold">
                                                <span class="ms-3">
                                                    {{ $value->name }}
                                                </span>
                                            </td>
                                            <td class="d-flex align-middle text-left text-xl font-weight-bold">
                                                <button class="btn btn-link text-secondary mb-0" onclick="openModalFormEdit({{ $value->id }})">
                                                    <i class="fa fa-edit text-xs" aria-hidden="true"></i>
                                                </button>
                                                <form action="/category" method="post" id="delete-form-{{ $value->id }}"">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input hidden type="text" name="id" value="{{ $value->id }}">
                                                    <button type="button" class="btn btn-link text-secondary mb-0" onclick="deleteData({{ $value->id }})">
                                                        <i class="fa fa-trash text-xs" aria-hidden="true"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <div class="px-3 pt-3">
                                {!! $listCategory->links('vendor.pagination.bootstrap-5') !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function openModalFormInsert(){
            $('#modal-form #modal-form-title').text("Tambah Kategori");
            $('#modal-form #id').val('');
            $('#modal-form #name').val('');
            $('#modal-form').modal('show');
        }

        function openModalFormEdit(id){
            $.ajax({
                url: "{{ url('category') }}/" + id + "/show",
                method: 'GET',
                success: function(response) {
                    if (response.success) {
                        var data = response.data;

                        $('#modal-form #modal-form-title').text("Edit Kategori");
                        $('#modal-form #id').val(id);

                        $('#modal-form #name').val(data.name);
                        $('#modal-form').modal('show');

                    } else {
                        console.error('Gagal mendapatkan data dari server');
                    }
                },
                error: function(error) {
                    console.error('Terjadi kesalahan: ', error);
                }
            });
        }

        function deleteData(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'Once deleted, you will not be able to recover this data!',
            icon: 'warning',
            buttons: {
                cancel: 'Cancel',
                confirm: 'Delete'
            },
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                $('#delete-form-' + id).submit();
            }
        });
    }

        

        
    </script>
@endsection
