@extends('layouts.admin')
@section('nav')
    <div class="navbar-nav pl-2">
        <ol class="breadcrumb p-0 m-0 bg-white">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Change Password</a></li>
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
                        <h1>Change Password</h1>
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
            <form action="" id="form-change-password">
                @csrf
                <!-- Default box -->
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="current_password">Current Password</label>
                                        <input type="password" name="current_password" id="current_password" class="form-control"
                                            placeholder="Crrent Password (Update {{ Carbon\Carbon::parse($user->updated_at)->format("Y/m/d") }})">
                                        <p></p>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="new_password">New Password</label>
                                        <input type="password" name="new_password" id="new_password" class="form-control"
                                            placeholder="New Password" >
                                        <p></p>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="confirm_password">Confirm Password</label>
                                        <input type="password" name="confirm_password" id="confirm_password"
                                            class="form-control" placeholder="Confirm Password">
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
        $("#form-change-password").submit(function(e) {
            e.preventDefault();
            var element = $(this);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ route('settings.updatePassword', $user->id) }}',
                method: "POST",
                data: element.serializeArray(),
                typeData: 'json',
                success: function(response) {
                    if (response.errors && response.status === false) {
                        var error = response.errors;
                        if (error.current_password) {
                            $("#current_password").addClass('is-invalid').next('p').addClass('invalid-feedback')
                                .text(error.current_password)
                        } else {
                            $("#current_password").removeClass('is-invalid').next('p').removeClass(
                                'invalid-feedback').text('');
                        }
                        if (error.new_password) {
                            $("#new_password").addClass('is-invalid').next('p').addClass('invalid-feedback')
                                .text(error.new_password)
                        } else {
                            $("#new_password").removeClass('is-invalid').next('p').removeClass(
                                'invalid-feedback').text('');
                        }
                        if (error.confirm_password) {
                            $("#confirm_password").addClass('is-invalid').next('p').addClass('invalid-feedback')
                                .text(error.confirm_password)
                        } else {
                            $("#confirm_password").removeClass('is-invalid').next('p').removeClass(
                                'invalid-feedback').text('');
                        }
                    }
                    if (response.status == true) {
                        Swal.fire({
                            position: "center",
                            icon: "success",
                            title: response.mess,
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
