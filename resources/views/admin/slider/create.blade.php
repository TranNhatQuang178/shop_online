@extends('layouts.admin')
@section('nav')
    <div class="navbar-nav pl-2">
        <ol class="breadcrumb p-0 m-0 bg-white">
            <li class="breadcrumb-item"><a href="{{ route('slider.index') }}">Sliders</a></li>
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
                        <h1>Create Slider</h1>
                    </div>
                    <div class="col-sm-6 text-right">
                        <a href="{{ route('slider.index') }}" class="btn btn-primary">Back</a>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            <form action="" id="form-create-slider">
                @csrf
            <!-- Default box -->
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="title">Title</label>
                                    <input type="text" name="title" id="title" class="form-control"
                                        placeholder="Title" value="">
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="link">Link</label>
                                    <input type="text" name="link" id="link" class="form-control"
                                        placeholder="Link" value="">
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="desc">Media</label>
                                <input type="hidden" name="image_id" id="image_id">
                                <div id="image" class="dropzone dz-clickable">
                                    <div class="dz-message needsclick">
                                        <br>Drop files here or click to upload.<br><br>
                                    </div>
                                </div>
                                <p></p>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="desc">Description</label>
                                    <textarea name="desc" id="desc" cols="30" rows="7" class="form-control"></textarea>
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
                    $("#image_id").val(response.image_id);
                }
            }
        });
        $("#form-create-slider").submit(function(e) {
            e.preventDefault();
            var element = $(this);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('slider.store') }}",
                method: "POST",
                data: element.serializeArray(),
                typeData: 'json',
                success: function(response) {
                    if (response.errors) {
                        var error = response.errors;
                        if (error.title) {
                            $("#title").addClass('is-invalid').siblings('p').addClass('invalid-feedback')
                                .text(error.title)
                        } else {
                            $("#title").removeClass('is-invalid').siblings('p').removeClass(
                                'invalid-feedback').text('');
                        }
                        if (error.link) {
                            $("#link").addClass('is-invalid').siblings('p').addClass('invalid-feedback')
                                .text(error.link)
                        } else {
                            $("#link").removeClass('is-invalid').siblings('p').removeClass(
                                'invalid-feedback').text('');
                        }
                        if (error.desc) {
                            $("#desc").addClass('is-invalid').siblings('p').addClass('invalid-feedback')
                                .text(error.desc)
                        } else {
                            $("#desc").removeClass('is-invalid').siblings('p').removeClass(
                                'invalid-feedback').text('');
                        }
                        if (error.status) {
                            $("#status").addClass('is-invalid').siblings('p').addClass('invalid-feedback')
                                .text(error.status)
                        } else {
                            $("#status").removeClass('is-invalid').siblings('p').removeClass(
                                'invalid-feedback').text('');
                        }
                        if (error.image_id) {
                            $("#image_id").addClass('is-invalid').siblings('p').addClass('invalid-feedback')
                                .text(error.image_id)
                        } else {
                            $("#image_id").removeClass('is-invalid').siblings('p').removeClass(
                                'invalid-feedback').text('');
                        }
                    }
                    if (response.status == true) {
                        Swal.fire({
                            position: "center",
                            icon: "success",
                            title: response.mess,
                            showConfirmButton: false,
                            timer: 2000
                        });
                        setTimeout(() => {
                            window.location.href = '{{ route('slider.index') }}';
                        }, 2000);
                    }
                    
                }
            });
        });
    </script>
@endsection
