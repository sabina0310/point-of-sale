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
                                <input type="text" class="form-control" placeholder="Cari berdasarkan nama" oninput="filterSearch(this.value)">
                            </div>
                        </div>
                        <button class="btn btn-primary btn-sm mb-0" onclick="openModalFormInsert()"><i class="fas fa-plus me-2"></i>Tambah</button>
                    </div>

                    <div class="card-body px-0 pt-0 pb-2">
                       <div id="table-list-category">

                       </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function filterData(search = null, page = null) {
            $.ajax({
                url: "{{ route('category.filter') }}",
                type: 'GET',
                data: {
                    search: search,
                    page: page
                },
                success: function(data) {
                    $('#table-list-category').html(data);
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }

        function filterSearch(search) {
            filterData(search);
        }

        $(document).ready(function() {
            filterData();
        });

        $(document).on('click', '#table-data .pagination a', function(e) {
            e.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            filterData(null, page);
        });

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
