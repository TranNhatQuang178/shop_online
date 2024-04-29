@extends('layouts.app')
@section('content')
    <style>
        .image_post {
            max-width: 100%;
        }
    </style>
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active">News</li>
                </ol>
            </div>
        </div>
    </section>
    <div class="container">
        <div class="row">
            <div class="col-md-3 sidebar">
                <div class="sub-title">
                    Categories News
                </div>
            @if($categoriesPost->isNotEmpty())
            <div class="card">
                    <div class="card-body">
                        @foreach($categoriesPost as $category)
                        <div class="navbar-nav">
                            <a href="{{ route('news.index', $category->slug) }}" class="nav-item nav-link text-dark">{{$category->name}}</a>
                        </div>
                        @endforeach
                    </div>
                </div>
            @endif
            </div>
            <div class="col-md-9">
                <div class="row pb-3">
                @if ($posts->isNotempty())
                    @foreach ($posts as $post)
                        <div class="card">
                            <div class="row py-3">
                                <div class="col-md-3">
                                    <a href="{{ route('news.detail',[ $post->category->slug, $post->slug]) }}"><img class="image_post" src="{{ asset('/images/post/' . $post->image) }}"
                                            alt=""></a>
                                </div>
                                <div class="col-md-6">
                                    <a href="{{ route('news.detail',[ $post->category->slug, $post->slug]) }}" class="text-dark">
                                        <h4 class="text-start">{{ $post->title }}</h4>
                                        <span class="fw-bold">Author:</span>
                                        <span>{{ $post->user->name }}</span><br>
                                        <span class="fw-bold">Created_at:</span>
                                        <span>{{ Carbon\Carbon::parse($post->created_at)->format('h-m-Y') }}</span>
                                        <p class="text-start">{{ $post->short_description }}</p>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
                </div>
            </div>
        </div>
    </div>
@endsection
