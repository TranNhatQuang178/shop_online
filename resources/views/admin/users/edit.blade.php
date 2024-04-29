@extends('layouts.admin')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid my-2">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Edit User</h1>
                    </div>
                    <div class="col-sm-6 text-right">
                        <a href="{{ route('user') }}" class="btn btn-primary">Back</a>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            <!-- Default box -->
            <div class="container-fluid">
                <form action="" id="form-update-user">
                    @csrf
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name">Name</label>
                                        <input type="text" name="name" id="name" class="form-control" value="{{ $user->name }}"
                                            placeholder="Name">
                                        <p></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="email">Email</label>
                                        <input type="text" name="email" id="email" class="form-control"
                                            placeholder="Email" readonly value="{{ $user->email }}">
                                        <p></p>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="phone">Phone</label>
                                        <input type="phone" name="phone" id="phone" class="form-control"
                                            placeholder="Phone" value="{{ $user->phone }}">
                                        <p></p>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="phone">Address</label>
                                        <textarea name="address" id="address" class="form-control" cols="30" rows="5">{{ $user->address }}</textarea>
                                        <p></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="pb-5 pt-3">
                        <button class="btn btn-primary">Update</button>
                        <a href="{{ route('user') }}" class="btn btn-outline-dark ml-3">Cancel</a>
                    </div>
                </form>
            </div>
            <!-- /.card -->
        </section>
        <!-- /.content -->
    </div>
@endsection
@section('js')
    <script>
        $("#form-update-user").submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: '{{ route('user.update', $user->id) }}',   
                data: $(this).serializeArray(),
                method: "POST",
                typeData: 'Json',
                success: function(response) {

                    if (response.errors) {
                        var errors = response.errors;
                        if (errors.name) {
                            $("#name").addClass('is-invalid').next().addClass('invalid-feedback').text(
                                errors.name);
                        } else {
                            $("#name").removeClass('is-invalid').next().removeClass('invalid').text('');
                        }
                        if (errors.phone) {
                            $("#phone").addClass('is-invalid').next().addClass('invalid-feedback').text(
                                errors.phone);
                        } else {
                            $("#phone").removeClass('is-invalid').next().removeClass('invalid-feedback')
                                .text('');
                        }
                        if (errors.address) {
                            $("#address").addClass('is-invalid').next().addClass('invalid-feedback')
                                .text(errors.address);
                        } else {
                            $("#address").removeClass('is-invalid').next().removeClass(
                                'invalid-feedback').text('');
                        }
                    }
                    if (response.status == 200) {
                        Swal.fire({
                            position: "center",
                            icon: "success",
                            title: "Edit user successfully",
                            showConfirmButton: false,
                            timer: 1500
                        });

                        setTimeout(() => {
                            window.location.href = '{{ route('user') }}';
                        }, 1500);
                    }

                }
            });
        })
    </script>
@endsection
