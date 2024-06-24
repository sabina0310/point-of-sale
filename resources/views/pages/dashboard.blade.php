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
                            type: "bar",
                            data: {
                                labels: dates,
                                datasets: [{
                                    label: "Total Transaksi",
                                    tension: 0.4,
                                    pointRadius: 0,
                                    borderColor: "#fb6340",
                                    backgroundColor: gradientStroke1,
                                    borderWidth: 1,
                                    fill: true,
                                    data: total_transactions,
                                    maxBarThickness: 10
                
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
                                        beginAtZero: true,
                                        grid: {
                                            drawBorder: true,
                                            display: true,
                                            drawOnChartArea: true,
                                            drawTicks: true,
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
                                            stepSize: 10,
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
                            type: "bar",
                            data: {
                                labels: dates,
                                datasets: [{
                                    label: "Total Penjualan",
                                    tension: 0.4,
                                    pointRadius: 0,
                                    borderColor: "#fb6340",
                                    backgroundColor: gradientStroke1,
                                    borderWidth: 1,
                                    fill: true,
                                    data: total_sales,
                                    maxBarThickness: 10
                
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
                                        beginAtZero: true,
                                        grid: {
                                            drawBorder: true,
                                            display: true,
                                            drawOnChartArea: true,
                                            drawTicks: true,
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
                                            stepSize: 10000

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
