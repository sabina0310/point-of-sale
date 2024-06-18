@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Dashboard'])
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-4 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Transaksi Hari Ini</p>
                                    <h5 class="font-weight-bolder">
                                        {{ $todaysTransaction }}
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                                    <i class="fas fa-cash-register text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Penjualan hari ini </p>
                                    <h5 class="font-weight-bolder">
                                        Rp {{ number_format($todaysSale, 0, '.', '.') }}
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                                    <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Laba Hari Ini</p>
                                    <h5 class="font-weight-bolder">
                                        Rp {{ number_format($todaysProfit, 0, '.', '.') }}
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle">
                                    <i class="fas fa-wallet text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            {{-- <div class="col-xl-3 col-sm-6">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Sales</p>
                                    <h5 class="font-weight-bolder">
                                        $103,430
                                    </h5>
                                    <p class="mb-0">
                                        <span class="text-success text-sm font-weight-bolder">+5%</span> than last month
                                    </p>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
                                    <i class="ni ni-cart text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card z-index-2 h-100">
                    <div class="card-header pb-0 pt-3 bg-transparent">
                        <h6 class="text-capitalize">Transaksi Bulan Ini</h6>
                        <div class="input-group input-daterange d-flex justify-content-center">
                            <div class="w-35">
                                <input type="month" class="form-control" value="" id="start-date-transaction" onchange="filterDateTransaction()">
                            </div>
                            <span class="mx-2"> - </span>
                            <div class="w-35">
                                <input type="month" class="form-control" value="" id="end-date-transaction" onchange="filterDateTransaction()">
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-3">
                        <div class="chart">
                            <canvas id="chart-line-transaction" class="chart-canvas-transaction" height="300"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 ">
                <div class="card z-index-2 h-100">
                    <div class="card-header pb-0 pt-3 bg-transparent">
                        <h6 class="text-capitalize">Penjualan Bulan Ini</h6>
                        <div class="input-group input-daterange d-flex justify-content-center">
                            <div class="w-35">
                                <input type="month" class="form-control" value="" id="start-date-sale" onchange="filterDateSale(this.value)">
                            </div>
                            <span class="mx-2"> - </span>
                            <div class="w-35">
                                <input type="month" class="form-control" value="" id="end-date-sale" onchange="filterDateSale(this.value)">
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-3">
                        <div class="chart">
                            <canvas id="chart-line-sale" class="chart-canvas-sale" height="300"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        {{-- <div class="row mt-4">
            <div class="col-lg-7 mb-lg-0 mb-4">
                <div class="card ">
                    <div class="card-header pb-0 p-3">
                        <div class="d-flex justify-content-between">
                            <h6 class="mb-2">Sales by Country</h6>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-items-center ">
                            <tbody>
                                <tr>
                                    <td class="w-30">
                                        <div class="d-flex px-2 py-1 align-items-center">
                                            <div>
                                                <img src="./img/icons/flags/US.png" alt="Country flag">
                                            </div>
                                            <div class="ms-4">
                                                <p class="text-xs font-weight-bold mb-0">Country:</p>
                                                <h6 class="text-sm mb-0">United States</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">Sales:</p>
                                            <h6 class="text-sm mb-0">2500</h6>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">Value:</p>
                                            <h6 class="text-sm mb-0">$230,900</h6>
                                        </div>
                                    </td>
                                    <td class="align-middle text-sm">
                                        <div class="col text-center">
                                            <p class="text-xs font-weight-bold mb-0">Bounce:</p>
                                            <h6 class="text-sm mb-0">29.9%</h6>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="w-30">
                                        <div class="d-flex px-2 py-1 align-items-center">
                                            <div>
                                                <img src="./img/icons/flags/DE.png" alt="Country flag">
                                            </div>
                                            <div class="ms-4">
                                                <p class="text-xs font-weight-bold mb-0">Country:</p>
                                                <h6 class="text-sm mb-0">Germany</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">Sales:</p>
                                            <h6 class="text-sm mb-0">3.900</h6>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">Value:</p>
                                            <h6 class="text-sm mb-0">$440,000</h6>
                                        </div>
                                    </td>
                                    <td class="align-middle text-sm">
                                        <div class="col text-center">
                                            <p class="text-xs font-weight-bold mb-0">Bounce:</p>
                                            <h6 class="text-sm mb-0">40.22%</h6>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="w-30">
                                        <div class="d-flex px-2 py-1 align-items-center">
                                            <div>
                                                <img src="./img/icons/flags/GB.png" alt="Country flag">
                                            </div>
                                            <div class="ms-4">
                                                <p class="text-xs font-weight-bold mb-0">Country:</p>
                                                <h6 class="text-sm mb-0">Great Britain</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">Sales:</p>
                                            <h6 class="text-sm mb-0">1.400</h6>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">Value:</p>
                                            <h6 class="text-sm mb-0">$190,700</h6>
                                        </div>
                                    </td>
                                    <td class="align-middle text-sm">
                                        <div class="col text-center">
                                            <p class="text-xs font-weight-bold mb-0">Bounce:</p>
                                            <h6 class="text-sm mb-0">23.44%</h6>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="w-30">
                                        <div class="d-flex px-2 py-1 align-items-center">
                                            <div>
                                                <img src="./img/icons/flags/BR.png" alt="Country flag">
                                            </div>
                                            <div class="ms-4">
                                                <p class="text-xs font-weight-bold mb-0">Country:</p>
                                                <h6 class="text-sm mb-0">Brasil</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">Sales:</p>
                                            <h6 class="text-sm mb-0">562</h6>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">Value:</p>
                                            <h6 class="text-sm mb-0">$143,960</h6>
                                        </div>
                                    </td>
                                    <td class="align-middle text-sm">
                                        <div class="col text-center">
                                            <p class="text-xs font-weight-bold mb-0">Bounce:</p>
                                            <h6 class="text-sm mb-0">32.14%</h6>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="card">
                    <div class="card-header pb-0 p-3">
                        <h6 class="mb-0">Categories</h6>
                    </div>
                    <div class="card-body p-3">
                        <ul class="list-group">
                            <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                <div class="d-flex align-items-center">
                                    <div class="icon icon-shape icon-sm me-3 bg-gradient-dark shadow text-center">
                                        <i class="ni ni-mobile-button text-white opacity-10"></i>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <h6 class="mb-1 text-dark text-sm">Devices</h6>
                                        <span class="text-xs">250 in stock, <span class="font-weight-bold">346+
                                                sold</span></span>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <button
                                        class="btn btn-link btn-icon-only btn-rounded btn-sm text-dark icon-move-right my-auto"><i
                                            class="ni ni-bold-right" aria-hidden="true"></i></button>
                                </div>
                            </li>
                            <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                <div class="d-flex align-items-center">
                                    <div class="icon icon-shape icon-sm me-3 bg-gradient-dark shadow text-center">
                                        <i class="ni ni-tag text-white opacity-10"></i>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <h6 class="mb-1 text-dark text-sm">Tickets</h6>
                                        <span class="text-xs">123 closed, <span class="font-weight-bold">15
                                                open</span></span>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <button
                                        class="btn btn-link btn-icon-only btn-rounded btn-sm text-dark icon-move-right my-auto"><i
                                            class="ni ni-bold-right" aria-hidden="true"></i></button>
                                </div>
                            </li>
                            <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                <div class="d-flex align-items-center">
                                    <div class="icon icon-shape icon-sm me-3 bg-gradient-dark shadow text-center">
                                        <i class="ni ni-box-2 text-white opacity-10"></i>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <h6 class="mb-1 text-dark text-sm">Error logs</h6>
                                        <span class="text-xs">1 is active, <span class="font-weight-bold">40
                                                closed</span></span>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <button
                                        class="btn btn-link btn-icon-only btn-rounded btn-sm text-dark icon-move-right my-auto"><i
                                            class="ni ni-bold-right" aria-hidden="true"></i></button>
                                </div>
                            </li>
                            <li class="list-group-item border-0 d-flex justify-content-between ps-0 border-radius-lg">
                                <div class="d-flex align-items-center">
                                    <div class="icon icon-shape icon-sm me-3 bg-gradient-dark shadow text-center">
                                        <i class="ni ni-satisfied text-white opacity-10"></i>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <h6 class="mb-1 text-dark text-sm">Happy users</h6>
                                        <span class="text-xs font-weight-bold">+ 430</span>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <button
                                        class="btn btn-link btn-icon-only btn-rounded btn-sm text-dark icon-move-right my-auto"><i
                                            class="ni ni-bold-right" aria-hidden="true"></i></button>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div> --}}
        @include('layouts.footers.auth.footer')
    </div>
@endsection

@push('js')
    <script src="./assets/js/plugins/chartjs.min.js"></script>
    <script>

        function chartTransaction(startDate, endDate){

            var ctx1 = document.getElementById("chart-line-transaction").getContext("2d");
    
            var gradientStroke1 = ctx1.createLinearGradient(0, 230, 0, 50);
    
            gradientStroke1.addColorStop(1, 'rgba(251, 99, 64, 0.2)');
            gradientStroke1.addColorStop(0.2, 'rgba(251, 99, 64, 0.0)');
            gradientStroke1.addColorStop(0, 'rgba(251, 99, 64, 0)');

            $.ajax({
                url: "{{  route('dashboard.chart-transaction') }}",
                type: 'GET',
                data: {
                    startDate: startDate,
                    endDate: endDate
                },
                success: function(response) {
                    if (response.success) {
                        console.log(response.data);
                        let dates = response.data.map(item=> item.date);
                        let total_transactions = response.data.map(item=> item.total_transaction)
                        console.log(dates);

                        if (window.generateChartTransaction) {
                            window.generateChartTransaction.destroy();
                        }

                        window.generateChartTransaction = new Chart(ctx1, {
                            type: "line",
                            data: {
                                labels: dates,
                                datasets: [{
                                    label: "Total Transaksi",
                                    tension: 0.4,
                                    borderWidth: 0,
                                    pointRadius: 0,
                                    borderColor: "#fb6340",
                                    backgroundColor: gradientStroke1,
                                    borderWidth: 3,
                                    fill: true,
                                    data: total_transactions,
                                    maxBarThickness: 6
                
                                }],
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: {
                                        display: true,
                                    }
                                },
                                interaction: {
                                    intersect: false,
                                    mode: 'index',
                                },
                                scales: {
                                    y: {
                                        grid: {
                                            drawBorder: false,
                                            display: true,
                                            drawOnChartArea: true,
                                            drawTicks: false,
                                            borderDash: [5, 5]
                                        },
                                        ticks: {
                                            display: true,
                                            padding: 10,
                                            color: '#fbfbfb',
                                            font: {
                                                size: 11,
                                                family: "Open Sans",
                                                style: 'normal',
                                                lineHeight: 2
                                            },
                                        }
                                    },
                                    x: {
                                        grid: {
                                            drawBorder: false,
                                            display: false,
                                            drawOnChartArea: false,
                                            drawTicks: false,
                                            borderDash: [5, 5]
                                        },
                                        ticks: {
                                            display: true,
                                            color: '#ccc',
                                            padding: 20,
                                            font: {
                                                size: 11,
                                                family: "Open Sans",
                                                style: 'normal',
                                                lineHeight: 2
                                            },
                                        }
                                    },
                                },
                            },
                        });
                    }
                },
                error: function(error){
                    console.log(error);
                }
            });
        }
        
        function chartSale(startDate, endDate){
            let generateChartTransaction;
            var ctx1 = document.getElementById("chart-line-sale").getContext("2d");
    
            var gradientStroke1 = ctx1.createLinearGradient(0, 230, 0, 50);
    
            gradientStroke1.addColorStop(1, 'rgba(251, 99, 64, 0.2)');
            gradientStroke1.addColorStop(0.2, 'rgba(251, 99, 64, 0.0)');
            gradientStroke1.addColorStop(0, 'rgba(251, 99, 64, 0)');
            $.ajax({
                url: "{{  route('dashboard.chart-sale') }}",
                type: 'GET',
                data: {
                    startDate: startDate,
                    endDate: endDate
                },
                success: function(response) {
                    if (response.success) {
                        console.log(response.data);
                        let dates = response.data.map(item=> item.date);
                        let total_sales = response.data.map(item=> item.total_sale)
                        console.log(dates);

                        if (window.generateChartSale) {
                            window.generateChartSale.destroy();
                        }

                        window.generateChartSale = new Chart(ctx1, {
                            type: "line",
                            data: {
                                labels: dates,
                                datasets: [{
                                    label: "Total Penjualan",
                                    tension: 0.4,
                                    borderWidth: 0,
                                    pointRadius: 0,
                                    borderColor: "#fb6340",
                                    backgroundColor: gradientStroke1,
                                    borderWidth: 3,
                                    fill: true,
                                    data: total_sales,
                                    maxBarThickness: 6
                
                                }],
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: {
                                        display: true,
                                    }
                                },
                                interaction: {
                                    intersect: false,
                                    mode: 'index',
                                },
                                scales: {
                                    y: {
                                        grid: {
                                            drawBorder: false,
                                            display: true,
                                            drawOnChartArea: true,
                                            drawTicks: false,
                                            borderDash: [5, 5]
                                        },
                                        ticks: {
                                            display: true,
                                            padding: 10,
                                            color: '#fbfbfb',
                                            font: {
                                                size: 11,
                                                family: "Open Sans",
                                                style: 'normal',
                                                lineHeight: 2
                                            },
                                        }
                                    },
                                    x: {
                                        grid: {
                                            drawBorder: false,
                                            display: false,
                                            drawOnChartArea: false,
                                            drawTicks: false,
                                            borderDash: [5, 5]
                                        },
                                        ticks: {
                                            display: true,
                                            color: '#ccc',
                                            padding: 20,
                                            font: {
                                                size: 11,
                                                family: "Open Sans",
                                                style: 'normal',
                                                lineHeight: 2
                                            },
                                        }
                                    },
                                },
                            },
                        });
                    }
                },
                error: function(error){
                    console.log(error);
                }
            });

            

        }

        function getDateTransaction(){
            // Get the current date
            let currentDate = new Date();

            // Set the value of the input to January of the current year
            let year = currentDate.getFullYear();
            currentStartDateTransaction = `${year}-01`; // Format: YYYY-MM
            currentEndDateTransaction = `${year}-12`; // Format: YYYY-MM

            $('#start-date-transaction').val(currentStartDateTransaction);
            $('#end-date-transaction').val(currentEndDateTransaction);
            // console.log(endDate);
        }

        function filterDateTransaction(){
            var startDateTransaction = $('#start-date-transaction').val();
            var endDateTransaction = $('#end-date-transaction').val();

            chartTransaction(startDateTransaction, endDateTransaction)
        }

        function getDateSale(){
            // Get the current date
            let currentDate = new Date();

            // Set the value of the input to January of the current year
            let year = currentDate.getFullYear();
            currentStartDateSale = `${year}-01`; // Format: YYYY-MM
            currentEndDateSale = `${year}-12`; // Format: YYYY-MM

            $('#start-date-sale').val(currentStartDateSale);
            $('#end-date-sale').val(currentEndDateSale);
            // console.log(endDate);
        }

        function filterDateSale(date){
            var startDateSale = $('#start-date-sale').val();
            var endDateSale = $('#end-date-sale').val();

            chartSale(startDateSale, endDateSale)
        }
        

        $(document).ready(function(){
            getDateTransaction();
            getDateSale();
            chartTransaction(currentStartDateTransaction, currentEndDateTransaction);
            chartSale(currentStartDateSale, currentEndDateSale);

        });
    </script>
@endpush
