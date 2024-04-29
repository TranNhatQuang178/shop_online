@extends('layouts.admin')
@section('nav')
    <div class="navbar-nav pl-2">
        <ol class="breadcrumb p-0 m-0 bg-white">
            <li class="breadcrumb-item"><a href="{{ route('discount.index') }}">Discount</a></li>
            <li class="breadcrumb-item active">Update</li>
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
                        <h1>Update Discount</h1>
                    </div>
                    <div class="col-sm-6 text-right">
                        <a href="{{ route('discount.index') }}" class="btn btn-primary">Back</a>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            <form action="" id="form-update-discount">
                @csrf
                <!-- Default box -->
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="code">Code</label>
                                        <input type="text" name="code" id="code" class="form-control"
                                            placeholder="Code" value="{{ $discountCode->code }}">
                                        <p></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name">Name</label>
                                        <input type="text" name="name" id="name" class="form-control"
                                            placeholder="Name" value="{{ $discountCode->name }}">
                                        <p></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="max-uses">Max Uses</label>
                                        <input type="number" min="1" value="{{ $discountCode->max_uses }}" name="max_uses" id="max-uses" class="form-control"
                                            placeholder="Max Uses">
                                        <p></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="max_uses_user">Max Uses User</label>
                                        <input type="number"  min="1" value="{{ $discountCode->max_uses_user }}" name="max_uses_user" id="max_uses_user" class="form-control"
                                            placeholder="Max Uses User">
                                        <p></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="type">Type</label>
                                        <select name="type" id="type" class="form-control">
                                            <option value="percent" {{ ($discountCode->type == 'percent') ? 'selected' : '' }}>Precent</option>
                                            <option value="fixed" {{ $discountCode->type == 'fixed' ? 'selected' : '' }}>Fixed</option>
                                        </select>
                                        <p></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="discount_amount">Discount Amount</label>
                                        <input type="text" name="discount_amount" id="discount_amount" class="form-control" value="{{ $discountCode->discount_amount }}">
                                        <p></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="min_amount">Min Amount</label>
                                        <input type="text" name="min_amount" id="min_amount" class="form-control" value="{{ $discountCode->min_amount }}">
                                        <p></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="status">Status</label>
                                        <select name="status" id="" class="form-control">
                                            <option value="1" {{ ($discountCode->status == 1) ? 'selected' : '' }}>Active</option>
                                            <option value="0" {{ ($discountCode->status == 0) ? 'selected' : '' }}>No active</option>
                                        </select>
                                        <p></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="start_at">Start At</label>
                                        <input autocomplete="off" type="text" name="start_at" id="start_at" class="form-control" value="{{ $discountCode->starts_at }}"> 
                                        <p></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="expires_at">Expires At</label>
                                        <input autocomplete="off" type="text" name="expires_at" id="expires_at" class="form-control" value="{{ $discountCode->expires_at }}">
                                        <p></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="description">Description</label>
                                       <textarea name="description" style="resize:none" id="description" cols="20" rows="5" placeholder="Description" class="form-control">{{ $discountCode->description }}</textarea>
                                        <p></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="pb-5 pt-3">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ route('discount.index') }}" class="btn btn-outline-dark ml-3">Cancel</a>
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
        $(document).ready(function(){
            $('#start_at').datetimepicker({
                // options here
                format:'Y-m-d H:i:s',
            });
            $('#expires_at').datetimepicker({
                // options here
                format:'Y-m-d H:i:s',
            });
        });
        $("#form-update-discount").submit(function(e) {
            e.preventDefault();
            var element = $(this);
            $("button[type='submit']").prop('disabled', true);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('discount.update', $discountCode->id) }}",
                method: "POST",
                data: element.serializeArray(),
                typeData: 'json',
                success: function(response) {
                    $("button[type='submit']").prop('disabled', false);
                    if (response.errors) {
                        var error = response.errors;
                        if (error['start_at']) {
                            $("#start_at").addClass('is-invalid').next('p').addClass('invalid-feedback')
                                .text(error['start_at'])
                        } else {
                            $("#start_at").removeClass('is-invalid').next('p').removeClass(
                                'invalid-feedback').text('');
                        }

                        if (error.expires_at) {
                            $("#expires_at").addClass('is-invalid').next('p').addClass('invalid-feedback')
                                .text(error.expires_at) 
                        } else {
                            $("#expires_at").removeClass('is-invalid').next('p').removeClass(
                                'invalid-feedback').text('');
                        }
                        $.each(response.errors, function(key, value){
                            $("#"+key).addClass('is-invalid').next('p').addClass('invalid-feedback').text(value);
                        });
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
                            window.location.href = '{{ route('discount.index') }}';
                        }, 1500);
                    }

                }
            });
        });
    </script>
@endsection
