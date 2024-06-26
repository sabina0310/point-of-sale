@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Log Aktivitas', 'subTitle' => 'Detail Log Aktivitas'])
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-3 d-flex align-items-center">
                        <h5 id="title">Detail Log Aktivitas</h5>
                    </div>
                    <div class="card-body px-4 pt-4 pb-2">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group d-flex align-items-center">
                                        <label for="name" class="me-2 text-sm col-3">Tanggal</label>
                                        <span class="text-md "> {{ \Carbon\Carbon::parse($data->created_at)->format('d-m-Y') }} </span>
                                    </div>
                                    <div class="form-group d-flex align-items-center">
                                        <label for="purchase_unit" class="me-2 text-sm col-3">Data</label>
                                        <span class="text-md "> {{ ucwords($data->model) }} </span>
                                    </div>
                                    <div class="form-group d-flex align-items-center">
                                        <label for="purchase_unit" class="me-2 text-sm col-3">Tipe Log</label>
                                        <span class="text-md "> {{ ucwords($data->log_type) }} </span>
                                    </div>
                                    <div class="form-group d-flex align-items-center">
                                        <label for="purchase_unit" class="me-2 text-sm col-3">Pesan</label>
                                        <span class="text-md "> {{ ucwords($data->message) }} </span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group d-flex align-items-center">
                                        <label for="quantity_per_purchase_unit" class="me-2 text-sm col-3">Detail</label>
                                        <textarea disabled rows="10" class="w-100">
                                            {{ $data->data }}

                                        </textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer text-end">
                        <a href="{{ route('activity-logs') }}" type="button" class="btn btn-secondary">Back</a>
                        <button type="button" class="btn btn-primary" onclick="submitForm()">Save</button>
                    </div>  
                </div>
            </div>
        </div>
    </div>
@endsection
