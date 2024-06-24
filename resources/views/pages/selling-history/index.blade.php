@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Riwayat Penjualan'])
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-3 d-flex align-items-center">
                        <h5>Riwayat Penjualan</h5>
                        <div class="ms-md-auto pe-md-3 d-flex">
                            <div class="input-group">
                                <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
                                <input type="text" class="form-control" placeholder="Cari nama produk" oninput="filterSearch(this.value)">
                            </div>
                        </div>
                    </div>

                    <div class="card-body px-0 pt-0 pb-2">
                        <div id="table-list-sale-history">

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
            url: "{{ route('sale-history.filter') }}",
            type: 'GET',
            data: {
                search: search,
                page: page,

            },
            success: function(data) {
                $('#table-list-sale-history').html(data);
            },
            error: function(error) {
                console.log(error);
            }
        });
    }

    function filterSearch(search) {
        filterData(search, null);
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