@extends('layouts.admin')
@section('nav')
    <div class="navbar-nav pl-2">
        <ol class="breadcrumb p-0 m-0 bg-white">
            <li class="breadcrumb-item"><a href="{{ route('category.index') }}">Categories</a></li>
            <li class="breadcrumb-item active">Create</li>
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
                        <h1>Create Category</h1>
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
            <form action="" id="form-create-category">
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
                                        placeholder="Name" value="">
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email">Slug</label>
                                    <input type="text" name="slug" id="slug" class="form-control"
                                        placeholder="Slug" ">
                                        <p></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="status">Status</label>
                                        <select name="status" id="" class="form-control">
                                            <option value="0">Hide</option>
                                            <option value="1">Display</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="featured">Featured</label>
                                        <select name="featured" id="" class="form-control">
                                            <option value="0">None</option>
                                            <option value="1">Featured</option>
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
                                <div class="row" id="category-gallery">
                                </div>
                        </div>
                    </div>
                </div>
                <div class="pb-5 pt-3">
                    <button type="submit" class="btn btn-primary">Create</button>
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
                                <a href="javasrcipt:void(0)" onclick="deleteImage(${response.image_id})" class="btn btn-danger">Delete</a>
                        </div>
                        </div>
                    </div>`;
                    $("#category-gallery").append(html);
                    this.removeFile(file);
                }
            }
        });

        function deleteImage(id) {
            $('#data-id-' + id).remove();
        }

        $("#form-create-category").submit(function(e) {
            e.preventDefault();
            var element = $(this);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('category.store') }}",
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
                            title: "Create category successfully",
                            showConfirmButton: false,
                            timer: 1500
                        });
                        setTimeout(() => {
                            window.location.href = '{{ route('category.index') }}';
                        }, 1500);
                    }
                    
                }
            });
        });
    </script>
@endsection
