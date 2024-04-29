@extends('layouts.admin')
@section('nav')
    <div class="navbar-nav pl-2">
        <ol class="breadcrumb p-0 m-0 bg-white">
            <li class="breadcrumb-item"><a href="{{ route('category.index') }}">Categories</a></li>
            <li class="breadcrumb-item active">Edit</li>
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
                        <h1>Edit Category</h1>
                    </div>
                    <div class="col-sm-6 text-right">
                        <a href="{{ route('category.index') }}" class="btn btn-primary">Back</a>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            <form action="" id="form-update-category">
                <!-- Default box -->
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="name">Category</label>
                                        <select name="category" id="category" class="form-control">
                                            <option value="0">Parent Category</option>
                                            {!! $htmlOption !!}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name">Name</label>
                                        <input type="text" name="name" id="name" class="form-control"
                                            placeholder="Name" value="{{ $category->name }}">
                                        <p></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="email">Slug</label>
                                        <input type="text" name="slug" id="slug" class="form-control"
                                            placeholder="Slug" value="{{ $category->slug }}">
                                        <p></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="status">Status</label>
                                        <select name="status" id="" class="form-control">
                                            <option value="0" {{ $category->status == 0 ? 'selected' : '' }}>Hide
                                            </option>
                                            <option value="1" {{ $category->status == 1 ? 'selected' : '' }}>Display
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="featured">Featured</label>
                                        <select name="featured" id="" class="form-control">
                                            <option value="0"
                                                {{ $category->featured_category == 0 ? 'selected' : '' }}>
                                                None</option>
                                            <option value="1"
                                                {{ $category->featured_category == 1 ? 'selected' : '' }}>
                                                Featured</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <h2 class="h4 mb-3">Media</h2>
                                    <div id="image" class="dropzone dz-clickable">
                                        <div class="dz-message needsclick">
                                            <br>Drop files here or click to upload.<br><br>
                                        </div>
                                        <p class="name-image"></p>
                                    </div>
                                </div>
                                @if ($category->thumbnail)
                                    <div class="col-md-4" id="category-gallery">
                                        <div class="" id="data-id-{{ $category->id }}">
                                            <div class="card">
                                                <img src="{{ asset('/images/thumbnail_category/' . $category->thumbnail) }}"
                                                    class="card-img-top" alt="...">
                                                <div class="card-body">
                                                    <a href="#"
                                                        data="{{ route('category.deleteImage', $category->id) }}"
                                                        class="btn btn-danger delete-image">Delete</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="col-md-3" id="category-gallery">
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="pb-5 pt-3">
                        <button type="submit" class="btn btn-primary">Edit</button>
                        <a href="{{ route('category.index') }}" class="btn btn-outline-dark ml-3">Cancel</a>
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
        Dropzone.autoDiscover = false;
        const dropzone = $("#image").dropzone({
            init: function() {
                this.on('addedfile', function(file) {
                    if (this.files.length > 1) {
                        this.removeFile(this.files[0]);
                    }
                });
            },
            url: '{{ route('temp') }}',
            maxFiles: 1,
            paramName: 'image',
            addRemoveLinks: true,
            acceptedFiles: "image/jpeg,image/png,image/gif",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(file, response) {
                if (response.status == 200) {
                    var html = `
                    <div class="col-md-12" id="data-id-${response.image_id}">
                        <div class="card">
                            <input type='hidden' name='image_id' value='${response.image_id}'/>
                            <img src="${response.pathImg}" class="card-img-top" alt="...">
                        <div class="card-body">
                                <a href="#" onclick="deleteImage(${response.image_id})" class="btn btn-danger">Delete</a>
                        </div>
                        </div>
                    </div>`;
                    $("#category-gallery").append(html);
                    this.removeFile(file);
                }
            }
        });

        $(".delete-image").click(function(e) {
            e.preventDefault();
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    const urlRequest = $(this).attr('data');
                    const srcImage = $(this).parents('.card').children().find('img').attr('src');
                    $.ajax({
                        url: urlRequest,
                        data: {
                            srcImage: srcImage
                        },
                        method: 'get',
                        dataType: 'json',
                        success: function(response) {
                            if (response.status == 200) {
                                $("#data-id-" + response.id).remove();
                                Swal.fire({
                                    position: "center",
                                    icon: "success",
                                    title: response.mess,
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                            }
                        }
                    });
                }
            });
        });

        function createSlug(text) {
            return text.toLowerCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "").replace(/[^\w\s-]/g, "").replace(
                /\s+/g, "-").replace(/-+/g, "-");
        }

        const titleInput = document.getElementById('name');
        const slugOutput = document.getElementById('slug');

        titleInput.addEventListener('keyup', function() {
            const title = titleInput.value;
            const slugValue = slugOutput.value;
            const slug = createSlug(title);
            slugValue.textContent = slug;
            document.getElementById('slug').value = slug;
        });

        $("#form-update-category").submit(function(e) {
            e.preventDefault();
            var element = $(this);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('category.update', $category->id) }}",
                method: "POST",
                data: element.serializeArray(),
                typeData: 'json',
                success: function(response) {
                    if (response.errors) {
                        var error = response.errors;
                        if (error.name) {
                            $("#name").addClass('is-invalid').next('p').addClass('invalid-feedback')
                                .text(error.name)
                        } else {
                            $("#name").removeClass('is-invalid').next('p').removeClass(
                                'invalid-feedback').text('');
                        }
                    }
                    if (response.status == 200) {
                        Swal.fire({
                            position: "center",
                            icon: "success",
                            title: "Edit category successfully",
                            showConfirmButton: false,
                            timer: 1500
                        });
                        setTimeout(() => {
                            window.location.href = '{{ route('category.index') }}';
                        }, 1500);
                    }
                    if (response.status == 422) {
                        Swal.fire({
                            position: "center",
                            icon: "error",
                            title: response.mess,
                            showConfirmButton: true,
                            confirmButtonText: "Got it",
                            timer: false,
                        });
                    }
                }
            });
        });
    </script>
@endsection
