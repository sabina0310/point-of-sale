@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('modal')
    @include('pages.category.partials.modal-form')
@endsection

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Kategori'])
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-3 d-flex align-items-center">
                        <h5>Kategori</h5>
                        <div class="ms-md-auto pe-md-3 d-flex">
                            <div class="input-group">
                                <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
                                <input type="text" class="form-control" placeholder="Cari berdasarkan nama" oninput="filterSearch(this.value)">
                            </div>
                        </div>
                        <button class="btn btn-primary btn-sm mb-0" onclick="openModalFormInsert()"><i class="fas fa-plus me-2"></i>Tambah</button>
                    </div>

                    <div class="card-body px-0 pt-0 pb-2">
                       <div id="table-list-category">

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
                url: "{{ route('category.filter') }}",
                type: 'GET',
                data: {
                    search: search,
                    page: page
                },
                success: function(data) {
                    $('#table-list-category').html(data);
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
        });

        $(document).on('click', '#table-data .pagination a', function(e) {
            e.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            filterData(null, page);
        });

        function openModalFormInsert(){
            $('#modal-form #modal-form-title').text("Tambah Kategori");
            $('#modal-form #id').val('');
            $('#modal-form #name').val('');
            $('#modal-form').modal('show');
        }

        function openModalFormEdit(id){
            $.ajax({
                url: "{{ url('category') }}/" + id + "/show",
                method: 'GET',
                success: function(response) {
                    if (response.success) {
                        var data = response.data;

                        $('#modal-form #modal-form-title').text("Edit Kategori");
                        $('#modal-form #id').val(id);

                        $('#modal-form #name').val(data.name);
                        $('#modal-form').modal('show');

                    } else {
                        console.error('Gagal mendapatkan data dari server');
                    }
                },
                error: function(error) {
                    console.error('Terjadi kesalahan: ', error);
                }
            });
        }

        function submitForm(){
            $.ajax({
                url: "{{ route('category') }}",
                method: 'POST',
                data: $('#category-form').serialize(),
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
                                window.location.href = '/category' // Reload the page
                        });
                            
                        // Set a timeout to delay the redirection
                        setTimeout(function() {
                            window.location.href = '/category';
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
                        title: 'Gagal!',
                        html: errorMessageHTML,
                        icon: 'error',
                        timer: 3500,
                    });
                }
            });
        }

        function deleteData(id) {
            Swal.fire({
                title: "Apakah Anda yakin ingin menghapus data ini?",
                text: "Data yang dihapus tidak dapat dipulihkan!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                    title: "Berhasil!",
                    text: "Data telah terhapus!",
                    icon: "success",
                    timer: 500
                    });
                    $('#delete-form-' + id).submit();
                }
            });
        }
    </script>
@endsection
