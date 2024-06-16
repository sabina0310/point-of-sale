@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Laporan Penjualan'])

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div id="alert">
                        @include('components.alert')
                    </div>
                    <div class="card-header pb-3 d-flex align-items-center">
                        <h5>Laporan Penjualan</h5>
                        {{-- <div class="ms-md-auto pe-md-3 d-flex w-30">
                            <div class="input-group">
                                <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
                                <input type="text" class="form-control" placeholder="Cari berdasarkan nama produk" oninput="filterSearch(this.value)">
                            </div>
                        </div> --}}
                        {{-- <a href="{{ route('purchase.create') }}" class="btn btn-primary btn-sm mb-0" onclick="openModalFormInsert()"><i class="fas fa-plus me-2"></i>Tambah</a> --}}
                    </div>

                    <div class="card-body px-0 pt-0 pb-2">
                        <div id="table-list-sale-report"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>''
@endsection

@section('script')
    <script>
        function filterData(search = null, page = null) {
            console.log('tes');
        $.ajax({
            url: "{{ route('report-sale.filter') }}",
            type: 'GET',
            data: {
                search: search,
                page: page
            },
            success: function(data) {
                $('#table-list-sale-report').html(data);
                console.log(data);
            },
            error: function(error) {
                console.log(error);
            }
        });
    }

    $(document).ready(function() {
        filterData();
    });

    </script>
@endsection