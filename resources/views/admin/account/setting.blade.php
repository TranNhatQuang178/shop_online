@extends('layouts.admin')
@section('nav')
    <div class="navbar-nav pl-2">
        <ol class="breadcrumb p-0 m-0 bg-white">
            <li class="breadcrumb-item"><a href="{{ route('category.index') }}">Settings</a></li>
        </ol>
    </div>
@endsection
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid my-2">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Settings</h1>
                    </div>
                    <div class="col-sm-6 text-right">
                        <a href="{{ route('dashboard') }}" class="btn btn-primary">Back</a>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            <form action="" id="form-update-account">
                @csrf
                <!-- Default box -->
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name">Name</label>
                                        <input type="text" name="name" id="name" class="form-control"
                                            placeholder="Name" value="{{ Auth::user()->name }}">
                                        <p></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="email">email</label>
                                        <input type="text" name="email" id="email" class="form-control"
                                            placeholder="Email" value="{{ Auth::user()->email }}">
                                        <p></p>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="phone">Phone</label>
                                        <input type="text" name="phone" id="phone"
                                            class="form-control" placeholder="Phone" value="{{ Auth::user()->phone }}">
                                        <p></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="address">Address</label>
                                        <textarea type="text" name="address" id="address"
                                            class="form-control" placeholder="Address">{{ Auth::user()->address }}</textarea>
                                        <p></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="pb-5 pt-3">
                        <button type="submit" class="btn btn-primary">Edit</button>
                        <a href="{{ route('dashboard') }}" class="btn btn-outline-dark ml-3">Cancel</a>
                    </div>
                </div>
            </form>

            <!-- /.card -->
        </section>
        <!-- /.content -->
    </div>
@endsection
@section('js')
    <script>
        $("#form-update-account").submit(function(e) {
            e.preventDefault();
            var element = $(this);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ route('settings.updateAccount', Auth::user()->id) }}',
                method: "POST",
                data: element.serializeArray(),
                typeData: 'json',
                success: function(response) {
                    if (response.errors && response.status === false) {
                        var error = response.errors;
                        if (error.name) {
                            $("#name").addClass('is-invalid').next('p').addClass('invalid-feedback')
                                .text(error.name)
                        } else {
                            $("#name").removeClass('is-invalid').next('p').removeClass(
                                'invalid-feedback').text('');
                        }
                        if (error.email) {
                            $("#email").addClass('is-invalid').next('p').addClass('invalid-feedback')
                                .text(error.email)
                        } else {
                            $("#email").removeClass('is-invalid').next('p').removeClass(
                                'invalid-feedback').text('');
                        }
                        if (error.phone) {
                            $("#phone").addClass('is-invalid').next('p').addClass('invalid-feedback')
                                .text(error.phone)
                        } else {
                            $("#phone").removeClass('is-invalid').next('p').removeClass(
                                'invalid-feedback').text('');
                        }
                        if (error.address) {
                            $("#address").addClass('is-invalid').next('p').addClass('invalid-feedback')
                                .text(error.address)
                        } else {
                            $("#address").removeClass('is-invalid').next('p').removeClass(
                                'invalid-feedback').text('');
                        }
                    }
                    if (response.status == true) {
                        Swal.fire({
                            position: "center",
                            icon: "success",
                            title: "Account update successfully!",
                            showConfirmButton: false,
                            timer: 1500
                        });
                        setTimeout(() => {
                            window.location.href = '{{ url()->current() }}';
                        }, 1500);
                    }

                }
            });
        });
    </script>
@endsection
