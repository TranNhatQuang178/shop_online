@extends('layouts.admin')
@section('nav')
<ol class="breadcrumb p-0 m-0 bg-white">
    <li class="breadcrumb-item"><a href="{{ route('pages.index') }}">Pages</a></li>
    <li class="breadcrumb-item active">Edit</li>
</ol>
@endsection
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">					
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Page</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('pages.index') }}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            <form action="{{ route('page.update', $page->id) }}" method="post">
                @csrf
            <div class="card">
                    <div class="card-body">								
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="title">Title</label>
                                    <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" placeholder="Title" value="{{ $page->title }}">	
                                    @error('title')
                                    <small class="invalid-feedback">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="slug">Slug</label>
                                    <input type="text" name="slug" id="slug" class="form-control @error('slug') is-invalid @enderror" placeholder="Slug" value="{{ $page->slug }}">	
                                    @error('slug')
                                    <small class="invalid-feedback">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>	
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status">Page status</label>
                                    <select name="status" id="status" class="form-control @error('status') is-invalid @enderror">
                                        <option value="1" {{ $page->status == 1 ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ $page->status == 0 ? 'selected' : '' }}>Block</option>
                                    </select>
                                    @error('status')
                                    <small class="invalid-feedback">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="content">Content</label>
                                    <textarea name="content" id="content" class="my-editor form-control  @error('content') is-invalid @enderror" cols="30" rows="10">{{ $page->content }}</textarea>
                                    @error('content')
                                    <small class="invalid-feedback">{{ $message }}</small>
                                    @enderror
                                </div>								
                            </div>                                    
                        </div>
                    </div>	
            </div>
            <div class="pb-5 pt-3">
                <button class="btn btn-primary">Edit</button>
                <a href="{{ route('pages.index') }}" class="btn btn-outline-dark ml-3">Cancel</a>
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
        $("#title").change(function(){
            var title = $(this).val();
            $.ajax({
                url: '{{ route('getSlug') }}',
                data: {title: title },
                success: function(reponse){
                    $("#slug").val(reponse.slug);
                },
            });
        });
    </script>
@endsection