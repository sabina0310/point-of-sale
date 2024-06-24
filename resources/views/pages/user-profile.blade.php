@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Your Profile'])
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <div class="d-flex align-items-center">
                            <p class="mb-0">Profil Pengguna</p>
                        </div>
                    </div>
                    <form role="form" id="profile-form" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Nama</label>
                                        <input class="form-control" type="text" name="name" value="{{ auth()->user()->name }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Role</label>
                                        <select class="form-select" name="role" disabled aria-label="Default select example">
                                            <option value="admin" {{ auth()->user()->username == 'admin' ? 'selected' : '' }}>
                                                Admin
                                            </option>
                                            <option value="cashier" {{ auth()->user()->username == 'cashier' ? 'selected' : '' }}>
                                                Cashier
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Username</label>
                                        <input class="form-control" type="text" name="username"  value="{{ auth()->user()->username }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Password</label>
                                        <input class="form-control" type="text" name="password" value="">
                                        <span class="text-sm text-danger">Jangan diisi jika tidak ingin mengubah password!</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <button type="button" type="button" onclick="submitForm()" class="btn btn-primary btn-sm ms-auto">Simpan</button>
                        </div> 
                    </form>
                </div>
            </div>
        </div>
        @include('layouts.footers.auth.footer')
    </div>
@endsection

@section('script')
    <script>
        function submitForm(){
            $.ajax({
                url: "{{ route('profile') }}",
                method: 'POST',
                data: $('#profile-form').serialize(),
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
                                window.location.href = '/profile' // Reload the page
                        });
                            
                        // Set a timeout to delay the redirection
                        setTimeout(function() {
                            window.location.href = '/profile';
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
