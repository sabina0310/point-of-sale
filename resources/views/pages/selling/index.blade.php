@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Penjualan'])
   <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="row">
                    <div class="col-md-8">
                        <div class="card mb-4 ">
                            <div id="alert">
                                @include('components.alert')
                            </div>
                            <div class="card-header pb-3 d-flex align-items-center">
                                <h5> Penjualan </h5>
                            </div>
                            <div class="card-body px-5 pt-0 pb-2" >
                                <div class="col-md-12">
                                    <div class="row">
                                        <div>
                                            <div class="pe-5 d-flex">
                                                <div class="input-group w-75">
                                                    <div class="me-3 d-flex align-items-center">
                                                        Cari Barang : 
                                                    </div>
                                                    <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
                                                    <input type="text" class="form-control" placeholder="Masukkan Nama / Kode Barang" oninput="filterSearch(this.value)">
                                                </div>
                                            </div>
                                            <div id="table-list-sale-product">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card mb-4 ">
                            <div class="">
                                <div class=" card-header pb-3 d-flex align-items-center d-flex justify-content-between">
                                    <h6>
                                        NOTA INVOICE
                                    </h6>
                                    <div class="font-weight-bold" id="invoice-number">
                                        {{ $invoice_number }}
                                    </div>
                                    {{-- <div class="font-weight-bold" id="invoice-number">
                                      
                                    </div> --}}
                                </div>
                                <div class="card-body px-3 pt-0 pb-2 mt-4">
                                    <div id="list-receipt-product">

                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div> 
            </div>
        </div>
   </div>
@endsection

@section('script')
    <script>
        function filterData(search = null) {
            $.ajax({
                url: "{{ route('sale.filter') }}",
                type: 'GET',
                data: {
                    search: search
                },
                success: function(data) {
                    $('#table-list-sale-product').html(data);
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }

        function receiptProduct() {
            var invoiceNumber = $('#invoice-number').text().trim();

            $.ajax({
                url: "{{ route('sale.receipt') }}",
                type: 'GET',
                data: {
                    invoice_number: invoiceNumber
                },
                success: function(data) {
                        $('#list-receipt-product').html(data);
                    
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
            receiptProduct();
            // generateInvoice();
        });

        function calculateReturn(value) {
            var totalAmount = $('#total-amount').text()
            var paymentValue = parseInt(value) || 0; // Get the value from the input and convert to integer
            var returnValue = paymentValue - totalAmount; // Calculate change
            
            // Display the change or a 0 if negative
            $('#return-amount').text(`Rp ${returnValue}`);
        };

        function checkoutProduct(productId){
            var invoiceNumber = $('#invoice-number').text().trim();
            var quantity = $('#quantity-' + productId).val();
            console.log(invoiceNumber);

            $.ajax({
                url: "{{ route('sale.submit-product') }}" ,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}', // Include the CSRF token for security
                    invoice_number: invoiceNumber,
                    product_id: productId,
                    quantity: quantity
                },
                success: function(response) {
                    if (response.success) {
                        receiptProduct();
                    } else {
                        Swal.fire({
                            title: response.message,
                            icon: "error"
                        });
                    }
                },
                error: function(error) {
                    console.error('Terjadi kesalahan: ', error);
                }
            });
        }

        function generateInvoice() {
            $.ajax({
                url: "{{ route('sale.generate') }}",
                method: 'GET',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    console.log(response.data);
                    // Remove the row from the DOM
                    $('#invoice-number').text(response.data);

                    // Optionally, you can show a success message or perform other actions here
                },
                error: function(error) {
                    console.error('An error occurred:', error);
                }
            });
        }   

        function deleteCartProduct(id) {
            console.log(id);
            $.ajax({
                url: "{{ route('sale.delete-cart-product') }}",
                method: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: id
                },
                success: function(response) {
                   if(response.reload){
                        window.location.href = "/sale"
                    } else{
                          receiptProduct();
                    }

                    // Optionally, you can show a success message or perform other actions here
                },
                error: function(error) {
                    console.error('An error occurred:', error);
                }
            });
        }   

        function submit(){
            var invoiceNumber = $('#invoice-number').text().trim();
            var totalAmount = $('#total-amount').text().trim();
            var paymentAmount = $('#payment-amount').val();
            console.log(totalAmount);
            console.log(paymentAmount);


            if (paymentAmount == 0 || paymentAmount == '') {
                Swal.fire({
                    title: "Error!",
                    text: "Masukkan jumlah pembayaran!",
                    icon: "error"
                });
                return;
            }

            if (paymentAmount < totalAmount) {
                Swal.fire({
                    title: "Error!",
                    text: "Jumlah pembayaran kurang!",
                    icon: "error"
                });
                return;
            }

            Swal.fire({
            title: "Apakah Anda ingin mencetak nota untuk transaksi ini?",
            text: "Transaksi akan diproses",
            icon: "warning",
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            denyButtonColor: "#d33",
            cancelButtonColor: "#6e7881",
            confirmButtonText: "Ya",
            denyButtonText: "Tidak",
            cancelButtonText: "Batal"
            }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('sale.submit') }}" ,
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}', // Include the CSRF token for security
                        invoice_number: invoiceNumber,
                        payment_amount: paymentAmount
                    },
                    success: function(response) {
                        if (response.success) {
                        } else {
                            console.error('Gagal mendapatkan data dari server');
                        }
                    },
                    error: function(error) {
                        console.error('Terjadi kesalahan: ', error);
                    }
                });
            } else if (result.isDenied)  {
                $.ajax({
                    url: "{{ route('sale.submit') }}" ,
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}', // Include the CSRF token for security
                        invoice_number: invoiceNumber,
                        payment_amount: paymentAmount
                    },
                    success: function(response) {
                        if (response.success) {
                            
                            Swal.fire({
                            title: "Transaksi Berhasil!",
                            text: "Transaksi telah berhasil diproses",
                            icon: "success"
                            }).then(() => {
                                window.location.href = '/sale' // Reload the page
                            });
                        } else {
                            console.error('Gagal mendapatkan data dari server');
                        }
                    },
                    error: function(error) {
                        console.error('Terjadi kesalahan: ', error);
                    }
                });
            }
            });
        }

        function newTransaction(){
            Swal.fire({
                title: "Apakah Anda ingin membuat transaksi baru?",
                text: "Transaksi ini akan tersimpan dengan status pending!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya",
                cancelButtonText: "Tidak"
                }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                    title: "Berhasil membuat transaksi baru!",
                    text: "",
                    icon: "success"
                    }).then(() => {
                        window.location.href = '/sale' // Reload the page
                    });
                }
                });
        }

        function cancelTransaction(id){
            var invoiceNumber = $('#invoice-number').text().trim();

            Swal.fire({
                title: "Apakah Anda ingin membatalkan transaksi?",
                text: "Transaksi ini akan terhapus!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya",
                cancelButtonText: "Tidak"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                        url: "{{ route('sale.cancel') }}" ,
                        method: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}', // Include the CSRF token for security
                            invoice_number: invoiceNumber
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                title: "Transaksi Berhasil Dibatalkan",
                                text: "Data transaksi terhapus",
                                icon: "success"
                                }).then(() => {
                                    window.location.href = '/sale' // Reload the page
                                });
                            }  else {
                                console.error('Gagal mendapatkan data dari server');
                            }
                        },
                        error: function(error) {
                            console.error('Terjadi kesalahan: ', error);
                        }
                    });
                    }
                });
        }

        function validateStock(){
            console.log('ya');
        }
    </script>
@endsection