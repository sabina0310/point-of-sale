@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('modal')
    @include('pages.product.partials.modalStock')
@endsection

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Produk'])
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-5 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3 pb-0">
                        <div class="row">
                            <div class="col-8" >
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Produk</p>
                                    <h4 class="font-weight-bolder m-0">
                                        {{ $totalProduct }}
                                    </h4>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                                    <i class="fas fa-box text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer p-1 text-white text-sm">
                        @
                    </div>
                </div>
            </div>
            <div class="col-md-7 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3 pb-0">
                        <div class="row">
                            <div class="col-8" onclick="openModalStock()" style="cursor: pointer">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Produk Stok < 3</p>
                                    <h4 class="font-weight-bolder mb-0">
                                        {{ $outOfStockProduct }}
                                    </h4>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                                    <i class="fas fa-exclamation text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer px-3 py-1 ">
                    @if ($outOfStockProduct > 0)
                        <span class="text-danger font-weight-bolder text-sm ">
                            Stok akan habis, segera lakukan pembelian!
                        </span>
                        <span class="text-link font-weight-bold text-sm opacity-6">
                            Klik untuk melihat produk.
                        </span>
                    @else 
                        <span class="text-success font-weight-bolder text-sm ">
                            Stok produk aman!
                        </span>
                    @endif
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

    function getCheckStock(){
            $.ajax({
            url: "{{ route('product.check-stock') }}", // Adjust the route as per your Laravel routes
            type: 'GET',
            success: function(response) {
                if (response.success) {
                    console.log(response.data);
                    var data = response.data;

                    // Clear existing table rows
                    $('#product-table-body').empty();

                    // Check if data is not empty
                    if (data.length > 0) {
                        // Loop through the data and create table rows
                        $.each(data, function(index, product) {
                            var row = '<tr>' +
                                '<td class="align-middle text-left text-md font-weight-bold">' + (index + 1) + '</td>' +
                                '<td class="align-middle text-left text-md font-weight-bold">' + product.name + '</td>' +
                                '<td class="align-middle text-left text-md font-weight-bold">' + product.stock + '</td>' +
                                '</tr>';
                            $('#product-table-body').append(row);
                        });
                    } else {
                        // If data is empty, display a message in a table row
                        var emptyRow = '<tr><td colspan="3" class="text-center">Tidak ada produk</td></tr>';
                        $('#product-table-body').append(emptyRow);
                    }

                    $('#modal-stock').modal('show');
                }else {
                        console.error('Gagal mendapatkan data dari server');
                }
            },
            error: function(error) {
                console.error('Error fetching product data:', error);
                // Handle error scenario as needed
            }
        });
    }

    $(document).ready(function() {
        filterData();
    });

    function filterSearch(search) {
        filterData(search);
    }

    function openModalStock(){
        getCheckStock();
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