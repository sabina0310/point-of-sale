@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('modal')
    @include('pages.product.partials.modalStock')
@endsection

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Produk'])
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-4 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8" >
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Produk</p>
                                    <h5 class="font-weight-bolder">
                                        5
                                    </h5>
                                    {{-- <p class="mb-0">
                                        <span class="text-danger text-sm font-weight-bolder">-2%</span>
                                        since last quarter
                                    </p> --}}
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                                    <i class="ni ni-paper-diploma text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                            <div>
                                <p hidden> dfd</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8" onclick="openModalStock()" style="cursor: pointer">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Produk Stok < 3</p>
                                    <h5 class="font-weight-bolder">
                                        0
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                                    <i class="ni ni-paper-diploma text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                            <div>
                                <p class="mb-0">
                                        <span class="text-danger text-sm font-weight-bolder">Stok menipis segera lakukan pembelian!</span>
                                    </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-12">
                <div class="card mb-4">
                    <div id="alert">
                        @include('components.alert')
                    </div>
                    <div class="card-header pb-3 d-flex align-items-center">
                        <h5>Produk</h5>
                        <div class="ms-md-auto pe-md-3 d-flex">
                            <div class="input-group">
                                <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
                                <input type="text" class="form-control" placeholder="Cari nama produk" oninput="filterSearch(this.value)">
                            </div>
                        </div>
                        <a href="{{ route('product.create') }}" class="btn btn-primary btn-sm mb-0"><i class="fas fa-plus me-2"></i>Tambah</a>
                    </div>

                    <div class="card-body px-0 pt-0 pb-2">
                        <div id="table-list-product">

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
            url: "{{ route('product.filter') }}",
            type: 'GET',
            data: {
                search: search,
                page: page
            },
            success: function(data) {
                $('#table-list-product').html(data);
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

    function openModalStock(){
        console.log('ya');
        $('#modal-stock #id').val('');
        $('#modal-stock #name').val('');
        $('#modal-stock').modal('show');
    }
</script>

@endsection