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
                    <div class="card-header pb-3">
                        <h5>Laporan Penjualan</h5>
                        <div class="input-group input-daterange d-flex justify-content-center ">
                            <div class="w-20">
                                <input type="month" class="form-control" value="" id="start-date-transaction" onchange="filterDateTransaction(this.value)">
                            </div>
                            <span class="mx-2"> - </span>
                            <div class="w-20">
                                <input type="month" class="form-control" value="" id="end-date-transaction" onchange="filterDateTransaction(this.value)">
                            </div>
                        </div>
                        <div class="d-flex justify-content-center mt-3">
                            <a href="{{ route('purchase.create') }}" class="btn btn-primary btn-sm mb-0 w-12" onclick="openModalFormInsert()"><i class="fas fa-file-pdf me-2"></i>PDF</a>
                        </div>
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