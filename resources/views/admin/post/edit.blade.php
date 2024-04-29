@extends('layouts.admin')
@section('nav')
    <div class="navbar-nav pl-2">
        <ol class="breadcrumb p-0 m-0 bg-white">
            <li class="breadcrumb-item"><a href="{{ route('post.index') }}">Post</a></li>
            <li class="breadcrumb-item active">Edit</li>
        </ol>
    </div>
@endsection
@section('content')
    <div class="content-wrapper">
        </form>
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid my-2">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Edit Post</h1>
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
            <!-- Default box -->
            <form action="{{ route('post.update', $post->id) }}" method="POST" id="form-post-product">
                @csrf
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="title">Title</label>
                                                <input type="text" name="title" id="title"
                                                    class="form-control @error('title') is-invalid @enderror"
                                                    placeholder="Title" value="{{ $post->title }}">
                                                @error('title')
                                                    <small class="invalid-feedback">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="slug">Slug</label>
                                                <input type="text" name="slug" id="slug"
                                                    class="form-control @error('slug') is-invalid @enderror"
                                                    value="{{ $post->slug }}" placeholder="Slug" readonly>
                                                @error('slug')
                                                    <small class="invalid-feedback">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="short_description">Short description</label>
                                                <textarea name="short_description" id="short_description" cols="20" rows="5"
                                                    class="form-control @error('short_description') is-invalid @enderror" placeholder="Short description">{{ $post->short_description }}</textarea>
                                                @error('short_description')
                                                    <small class="invalid-feedback">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="detail_description">Detail Description</label>
                                                <textarea name="detail_description" id="detail_description" cols="20" rows="20"
                                                    class="my-editor @error('detail_description') 'is-invalid' @enderror " placeholder="Detail Description">{{ $post->detail_description }}</textarea>
                                            </div>
                                            @error('detail_description')
                                                <small class="invalid-feedback">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h2 class="h4 mb-3">Media</h2>
                                    <input type="hidden" name="image" id="image_id" value="">
                                    <div id="image"
                                        class="dropzone dz-clickable @error('image') 'is-invalid'
                                 @enderror">
                                        <div
                                            class="dz-message needsclick @error('image') 'is-invalid'
                                        @enderror">
                                            <br>Drop files here or click to upload.<br><br>
                                        </div>
                                        @error('image')
                                            <small class="invalid-feedback">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="card-body">
                                    <img src="{{ asset('/images/post/'.$post->image) }}" alt="">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h2 class="h4 mb-3">Post status</h2>
                                    <div class="mb-3">
                                        <select name="status" id="status"
                                            class="form-control @error('status') is-invalid @enderror">
                                            <option value="1" {{ $post->status == 1 ? 'selected' : '' }}>Active
                                            </option>
                                            <option value="0" {{ $post->status == 0 ? 'selected' : '' }}>Block
                                            </option>
                                        </select>
                                        @error('status')
                                            <small class="invalid-feedback">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="card-body">
                                    <h2 class="h4 mb-3">Categories</h2>
                                    <div class="mb-3">
                                        <select name="category" id="category" class="form-control">
                                            <option value="">Select a category</option>
                                           @if($categories->isNotEmpty())
                                           @foreach($categories as $category)
                                           <option value="{{$category->id}}" {{ $post->cat_id == $category->id ? 'selected' : '' }}>{{$category->name}}</option>
                                           @endforeach
                                           @endif
                                        </select>
                                        @error('category')
                                            <small class="invalid-feedback">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="pb-5 pt-3">
                        <button class="btn btn-primary btn-edit">Edit</button>
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
        Dropzone.autoDiscover = false;
        const dropzone = $("#image").dropzone({
            url: '{{ route('temp') }}',
            init: function() {
                this.on('addedfile', function(file) {
                    if (this.files.length > 1) {
                        this.removeFile(this.files[0]);
                    }
                });
            },
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
        $("#title").on('input', function() {
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
    </script>
@endsection
