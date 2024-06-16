@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Pembelian'])
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div id="alert">
                        @include('components.alert')
                    </div>
                    <div class="card-header pb-3 d-flex align-items-center">
                        <h5>Pembelian</h5>
                        <div class="ms-md-auto pe-md-3 d-flex w-30">
                            <div class="input-group">
                                <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
                                <input type="text" class="form-control" placeholder="Cari berdasarkan nama produk" oninput="filterSearch(this.value)">
                            </div>
                        </div>
                        <a href="{{ route('purchase.create') }}" class="btn btn-primary btn-sm mb-0" onclick="openModalFormInsert()"><i class="fas fa-plus me-2"></i>Tambah</a>
                    </div>

                    <div class="card-body px-0 pt-0 pb-2">
                        <div id="table-list-purchase"></div>
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
                url: "{{ route('purchase.filter') }}",
                type: 'GET',
                data: {
                    search: search,
                    page: page
                },
                success: function(data) {
                    $('#table-list-purchase').html(data);
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }

        $(document).ready(function() {
            filterData();
        });

        function filterSearch(search) {
            filterData(search);
        }

        $(document).on('click', '#table-data .pagination a', function(e) {
            e.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            filterData(null, page);
        });

        function deleteData(id) {
        Swal.fire({
        title: 'Apakah Anda yakin ingin menghapus data ini?',
        text: 'Data ini tidak bisa dipulihkan setelah dihapus!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes',
        cancelButtonText: 'No',
        dangerMode: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#delete-form-' + id).submit();
                }
            });
        }

    </script>
@endsection