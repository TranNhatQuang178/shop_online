@extends('layouts.app')
@section('content')
<section class="section-5 pt-3 pb-3 mb-3 bg-white">
    <div class="container">
        <div class="light-font">
            <ol class="breadcrumb primary-color mb-0">
                <li class="breadcrumb-item"><a class="white-text" href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a class="white-text" href="{{ route('news.index') }}">News</a></li>
                <li class="breadcrumb-item active">{{ Str::of($post->title)->limit(10) }}</li>
            </ol>
        </div>
    </div>
</section>
    <div class="container">
        <div class="row py-3">
            <div class="card">
                <div class="card-body">
                    <h4 class="text-start">{{ $post->title }}</h4>
                    <span class="fw-bold">{{ $post->user->name }} </span> /
                    <span>{{ Carbon\Carbon::parse($post->create_at)->format('d-m-Y H:m') }} </span>
                </div>
                <div class="card-body">
                    {!! $post->detail_description !!}
                </div>
            </div>
        </div>
    </div>
@endsection