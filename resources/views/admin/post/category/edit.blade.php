@extends('layouts.admin')
@section('nav')
    <div class="navbar-nav pl-2">
        <ol class="breadcrumb p-0 m-0 bg-white">
            <li class="breadcrumb-item"><a href="{{ route('post.index') }}">Post / Category</a></li>
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
                        <h1>Update Category Post</h1>
                    </div>
                    <div class="col-sm-6 text-right">
                        <a href="{{ route('post.index') }}" class="btn btn-primary">Back</a>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            <form action="" id="form-update-category-post">
            <!-- Default box -->
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                    @csrf
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="title">Name</label>
                                    <input type="text" name="title" id="title" class="form-control"
                                        placeholder="Name" value="{{$postCategory->name}}">
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="slug">Slug</label>
                                    <input type="text" name="slug" id="slug" class="form-control"
                                    placeholder="Slug" value="{{$postCategory->slug}}" readonly >
                                        <p></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="status">Status</label>
                                        <select name="status" id="" class="form-control">
                                            <option value="0" {{ $postCategory->status == 0 ? 'selected': ''}}>Hide</option>
                                            <option value="1" {{ $postCategory->status == 1 ? 'selected': ''}}>Display</option>
                                        </select>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
                <div class="pb-5 pt-3">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('post.index') }}" class="btn btn-outline-dark ml-3">Cancel</a>
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
        $("#title").on('input',function(){
            $.ajax({
                url: '{{ route('getSlug') }}',
                data: {title: $(this).val()},
                success: function(response){
                    $("#slug").val(response.slug);
                }
            });
        });

        $("#form-update-category-post").submit(function(e) {
            e.preventDefault();
            var element = $(this);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('postCategory.update', $postCategory->id) }}",
                method: "POST",
                data: element.serializeArray(),
                typeData: 'json',
                success: function(response) {
                    if (response.errors) {
                        var error = response.errors;
                        if (error.title) {
                            $("#title").addClass('is-invalid').next('p').addClass('invalid-feedback')
                                .text(error.title)
                        } else {
                            $("#title").removeClass('is-invalid').next('p').removeClass(
                                'invalid-feedback').text('');
                        }
                        if (error.slug) {
                            $("#slug").addClass('is-invalid').next('p').addClass('invalid-feedback')
                                .text(error.slug)
                        } else {
                            $("#slug").removeClass('is-invalid').next('p').removeClass(
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
                            window.location.href = '{{ route('post.index') }}';
                        }, 1500);
                    }
                    
                }
            });
        });
    </script>
@endsection
