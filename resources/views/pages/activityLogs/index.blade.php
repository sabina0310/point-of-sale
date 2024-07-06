@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('modal')
    @include('pages.category.partials.modal-form')
@endsection

@php
    $options = [
    'category' => 'Kategori',
    'product' => 'Produk',
    'user' => 'Pengguna',
    'purchase' => 'Pembelian',
    'sale' => 'Penjualan'

];
@endphp

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Log Aktivitas'])
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-3 d-flex align-items-center">
                        <h5>Log Aktivitas</h5>
                        <div class="ms-md-auto pe-md-3 d-flex">
                            <div class="form-group d-flex align-items-center w-100">
                                <label for="category" class="me-2 text-sm ">Filter Data</label>
                                <select required class="form-select " name="product_id" aria-label="Default select example" id="product-select" onchange="filterSearch(this.value)">
                                    <option selected value="">
                                        Semua
                                    </option>
                                    @foreach ( $options as $value => $text )    
                                    <option value="{{ $value }}">
                                        {{ $text }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        {{-- <button class="btn btn-primary btn-sm mb-0" onclick="openModalFormInsert()"><i class="fas fa-plus me-2"></i>Tambah</button> --}}
                    </div>

                    <div class="card-body px-0 pt-0 pb-2">
                       <div id="table-list-activity-logs">

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
                url: "{{ route('activity-logs.filter') }}",
                type: 'GET',
                data: {
                    search: search,
                    page: page
                },
                success: function(data) {
                    $('#table-list-activity-logs').html(data);
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }

        function filterSearch(search) {
            console.log(search);
            filterData(search);
        }

        $(document).ready(function() {
            filterData();
        });

        $(document).on('click', '#table-data .pagination a', function(e) {
            e.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            filterData(null, page);
        });
    </script>
    
@endsection