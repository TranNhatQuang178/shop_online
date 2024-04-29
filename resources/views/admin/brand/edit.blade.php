@extends('layouts.admin')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid my-2">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Edit Brand</h1>
                    </div>
                    <div class="col-sm-6 text-right">
                        <a href="{{ route('brand.index') }}" class="btn btn-primary">Back</a>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            <!-- Default box -->
            <form action="" id="form-edit-brand">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name">Name</label>
                                        <input type="text" name="title" id="title" class="form-control"
                                            placeholder="Name" value="{{ $brand->name }}">
                                            <p></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="email">Slug</label>
                                        <input type="text" name="slug" id="slug" class="form-control"
                                            placeholder="Slug"  value="{{ $brand->name }}" readonly>
                                            <p></p>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="status">Status</label>
                                        <select name="status" id="" class="form-control">
                                            <option value="1" {{ $brand->status == 1 ? 'selected' : '' }}>Display</option>
                                            <option value="0" {{ $brand->status == 0 ? 'selected' : '' }}>Hide</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="pb-5 pt-3">
                        <button class="btn btn-primary">Edit</button>
                        <a href="{{ route('brand.index') }}" class="btn btn-outline-dark ml-3">Cancel</a>
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
        $("#title").on('keyup', function() {
            var data = $(this);
            $.ajax({
                url: '{{ route('getSlug') }}',
                data: data,
                method: 'get',
                success: function(response) {
                    $("#slug").val(response.slug);
                }
            });
        });

        $("#form-edit-brand").submit(function(e){
            e.preventDefault();
            const data = $(this).serializeArray();
            $.ajax({
                url: '{{ route('brand.update' , $brand->id) }}',
                data: data,
                method: "POST",
                dataType: "json",
                success: function(response){
                    if(response.status == 200){
                        let timeout =  2000;
                        Swal.fire({
                                    position: "center",
                                    icon: "success",
                                    title: response.mess,
                                    showConfirmButton: false,
                                    timer: timeout
                                });
                                setTimeout(() => {
                                    window.location.href = '{{ route('brand.index') }}';
                                }, timeout);
                    }

                    if(response.status == 500){
                        let error = response.errors
                        $.each(error, function(key, value){
                            $("#"+key).addClass('is-invalid').next('p').addClass('invalid-feedback').text(value);
                        });
                    }
                },
                error: function(){

                }
            });
        });
    </script>
@endsection
