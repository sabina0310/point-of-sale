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
                                <input type="date" class="form-control" value="" id="start-date-report" onchange="filterDateReport()" placeholder="Tanggal Mulai">
                            </div>
                            <span class="mx-2"> - </span>
                            <div class="w-20">
                                <input type="date" class="form-control" value="" id="end-date-report" onchange="filterDateReport()">
                            </div>
                        </div>
                        <div class="d-flex justify-content-center mt-3">
                            <button type="button" class="btn btn-primary btn-sm mb-0 w-12 me-2" onclick="showAll()">Show All</button>
                            {{-- <form action="{{ route('report-sale.export-excel') }}" method="GET" target="_blank" style="display: inline;">
                            </form> --}}
                            <button type="button" class="btn btn-primary btn-sm mb-0 w-12 me-2" onclick="exportExcel()"><i class="fas fa-file-excel me-2"></i>Excel</button>
                            
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
        function filterData(startDate = null, endDate = null) {
            console.log(startDate);
            console.log(endDate);

        $.ajax({
            url: "{{ route('report-sale.filter') }}",
            type: 'GET',
            data: {
                startDate: startDate,
                endDate: endDate
            },
            success: function(data) {
                $('#table-list-sale-report').html(data);
            },
            error: function(error) {
                console.log(error);
            }
        });
    }

    $(document).ready(function() {
        filterData();
    });

    function filterDateReport(){
        var startDateReport = $('#start-date-report').val();
        var endDateReport = $('#end-date-report').val();
        console.log(startDateReport);
        console.log(endDateReport);

        filterData(startDateReport, endDateReport)
    }

    function showAll(){
        var startDateReport = $('#start-date-report').val('');
        var endDateReport = $('#end-date-report').val('');
        filterData();
    }

    function exportExcel(){
        let startDate = document.getElementById('start-date-report').value;
        let endDate = document.getElementById('end-date-report').value;
        
        let baseUrl = "{{ asset('/') }}";

        let generateReceiptRoute = 'report-sale/export-excel';

        let csrfToken = "{{ csrf_token() }}";

        // Construct the complete URL with parameters
        let url = `${baseUrl}${generateReceiptRoute}?_token=${csrfToken}&startDate=${startDate}&endDate=${endDate}`;
        
        window.open(url, '_blank');
    
    }

    </script>
@endsection