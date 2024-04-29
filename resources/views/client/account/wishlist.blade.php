@extends('layouts.app')
@section('content')
    <main>
        <section class="section-5 pt-3 pb-3 mb-3 bg-white">
            <div class="container">
                <div class="light-font">
                    <ol class="breadcrumb primary-color mb-0">
                        <li class="breadcrumb-item"><a class="white-text" href="#">My Account</a></li>
                        <li class="breadcrumb-item">Wishlist</li>
                    </ol>
                </div>
            </div>
        </section>

        <section class=" section-11 ">
            <div class="container  mt-5">
                <div class="row">
                    <div class="col-md-3">
                        @include('inc.account-panel')
                    </div>
                    <div class="col-md-9">
                        <div class="card">
                            <div class="card-header">
                                <h2 class="h5 mb-0 pt-2 pb-2">Wishlist</h2>
                            </div>
                            <div class="card-body p-4">
                                @if ($wishList->isNotEmpty())
                                    @foreach ($wishList as $item)
                                    @php
                                        $imageProduct = getProductImage($item->product_id);
                                    @endphp
                                    <div class="d-sm-flex justify-content-between mt-lg-4 mb-4 pb-3 pb-sm-2 border-bottom">
                                        <div class="d-block d-sm-flex align-items-start text-center text-sm-start">
                                            @if (!empty($imageProduct))
                                            <a
                                            class="d-block flex-shrink-0 mx-auto me-sm-4" href="{{ route('product.detail', $item->slug) }}"
                                            style="width: 10rem;"><img src="{{ asset('images/thumbnail/'.$imageProduct->image) }}"
                                                alt="Product">
                                            </a>
                                            @else
                                            <a
                                            class="d-block flex-shrink-0 mx-auto me-sm-4" href="{{ route('product.detail', $item->slug) }}"
                                            style="width: 10rem;"><img src="{{ asset('images/image-unavailable.png/') }}"
                                                alt="Product">
                                            </a>
                                            @endif
                                            <div class="pt-2">
                                                <h3 class="product-title fs-base mb-2"><a href="{{ route('product.detail', $item->slug) }}">{{ $item->name }}</a></h3>
                                                <div class="fs-lg text-accent pt-2">${{ number_format($item->price,2,'.',',') }}</div>
                                            </div>
                                        </div>
                                        <div class="pt-2 ps-sm-3 mx-auto mx-sm-0 text-center">
                                            <button class="btn btn-outline-danger btn-sm wishlist-remove" type="button" data="{{ route('account.wishlistRemove', $item->id) }}"><i
                                                    class="fas fa-trash-alt me-2"></i>Remove
                                            </button>
                                        </div>
                                    </div>
                                    @endforeach                                    
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
@section('js')
    <script>
        $(".wishlist-remove").click(function(){
            let urlRequest = $(this).attr('data');
            let that = $(this);
            $.ajax({
                url: urlRequest,
                success: function(response){
                    if(response.status == true){
                        that.parent().parent().remove()
                    }
                }
            });
        });
    </script>
@endsection