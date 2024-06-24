@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@php
    $currentTitle = Str::contains(Route::currentRouteName(), 'create') ? 'Tambah Pengguna' : 'Edit Pengguna';

@endphp

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Pengguna', 'subTitle' => $currentTitle])
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-3 d-flex align-items-center">
                        <h5 id="title">{{ $currentTitle }}</h5>
                    </div>
                <form action="" method="post" id="user-form" class="">
                        @csrf
                        <div class="card-body px-4 pt-4 pb-2">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="id" value="{{ $user->id ?? '' }}" hidden>
                                        <div class="form-group d-flex align-items-center">
                                            <label for="role" class="me-2 text-sm col-3">Role</label>
                                            <select class="form-select" name="role" aria-label="Default select example">
                                                <option value="admin" {{ auth()->user()->username == 'admin' ? 'selected' : '' }}>
                                                    Admin
                                                </option>
                                                <option value="cashier" {{ auth()->user()->username == 'cashier' ? 'selected' : '' }}>
                                                    Cashier
                                                </option>
                                            </select>
                                        </div>
                                        <div class="form-group d-flex align-items-center">
                                            <label for="name" class="me-2 text-sm col-3">Nama</label>
                                            <input required type="text" class="form-control" name="name" value="{{ $user->name ?? '' }}" placeholder="Masukkan nama">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group d-flex align-items-center">
                                            <label for="username" class="me-2 text-sm col-3">Username</label>
                                            <input required type="text" class="form-control" name="username"  value="{{ $user->username ?? '' }}" placeholder="Masukkan username">
                                        </div>
                                        <div class="form-group d-flex align-items-center">
                                            <label for="password" class="me-2 text-sm col-3">Password</label>
                                            <div>
                                                <input required type="password" name="password"  class="form-control"  value="" placeholder="Password">

                                                <span class="text-sm text-danger">Jangan diisi jika tidak ingin mengubah password!</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer text-end">
                            <a href="{{ route('user') }}" type="button" class="btn btn-secondary">Back</a>
                            <button type="button" class="btn btn-primary" onclick="submitForm()">Save</button>
                        </div>  
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function submitForm(){
            var currentRoute =  '{{ request()->url() }}';
            
            $.ajax({
                url: currentRoute,
                method: 'POST',
                data: $('#user-form').serialize(),
                success: function(response) {
                    if (response.success) {
                        console.log(response);
                        
                        // Redirect to /product after successful submission
                        Swal.fire({
                            title: "Sukses!",
                            text: response.message,
                            icon: "success",
                            timer: 3500
                        }).then(() => {
                                window.location.href = '/user' // Reload the page
                        });
                            
                        // Set a timeout to delay the redirection
                        setTimeout(function() {
                            window.location.href = '/user';
                        }, 3500); 
                        // Show success message using Swal
                    }  else {
                        console.error('Gagal mendapatkan data dari server');
                    }
                },
                error: function(error) {
                    let errorMessages = error.responseJSON.errors;
                    let errorMessageHTML = '<ul style="list-style-type: none;">';
                    
                    // Loop through each error message and create list items
                    $.each(errorMessages, function(key, value) {
                        errorMessageHTML += '<li>' + value + '</li>';
                    });

                    errorMessageHTML += '</ul>';

                    Swal.fire({
                        title: 'Error!',
                        html: errorMessageHTML,
                        icon: 'error',
                        timer: 3500,
                    });
                }
            });
        }
    </script>
@endsection
