@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('modal')
    @include('pages.category.partials.modal-form')
@endsection

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Pengguna'])
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-3 d-flex align-items-center">
                        <h5>Pengguna</h5>
                        <div class="ms-md-auto pe-md-3 d-flex">
                            <div class="input-group">
                                <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
                                <input type="text" class="form-control" placeholder="Cari berdasarkan nama" oninput="filterSearch(this.value)">
                            </div>
                        </div>
                        <a href="{{ route('user.create') }}" class="btn btn-primary btn-sm mb-0"><i class="fas fa-plus me-2"></i>Tambah</a>
                    </div>

                    <div class="card-body px-0 pt-0 pb-2">
                       <div id="table-list-user">

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
                url: "{{ route('user.filter') }}",
                type: 'GET',
                data: {
                    search: search,
                    page: page
                },
                success: function(data) {
                    $('#table-list-user').html(data);
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

        function deleteData(id) {
            Swal.fire({
                title: "Apakah Anda yakin ingin menghapus data ini?",
                text: "Data yang dihapus tidak dapat dipulihkan!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                    title: "Berhasil!",
                    text: "Data telah terhapus!",
                    icon: "success",
                    timer: 500
                    });
                    $('#delete-form-' + id).submit();
                }
            });
        }
    </script>
@endsection
