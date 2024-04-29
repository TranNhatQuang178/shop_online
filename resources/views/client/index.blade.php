@extends('layouts.app')
@section('content')
<main>
    @if ($sliders->isNotEmpty())
    <section class="section-1">
        <div id="carouselExampleIndicators" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="false">
            <div class="carousel-inner">
                @foreach ($sliders as $key => $slider)
                <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                    <picture>
                        <source media="(max-width: 799px)" srcset="{{ asset('/images/sliders/max/'.$slider->image) }}" />
                        <source media="(min-width: 800px)" srcset="{{ asset('/images/sliders/min/'.$slider->image) }}" />
                        <img src="{{ asset('/images/sliders/'.$slider->image) }}" alt="" />
                    </picture>
                    <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                        <div class="p-3">
                            <h1 class="display-4 text-white mb-3">{{ $slider->title }}</h1>
                            <p class="mx-md-5 px-5">{{ $slider->desc }}</p>
                            <a class="btn btn-outline-light py-2 px-4 mt-3" href="{{ $slider->link }}">Shop Now</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </section>
    @endif
    <section class="section-2">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="box shadow-lg">
                        <div class="fa icon fa-check text-primary m-0 mr-3"></div>
                        <h2 class="font-weight-semi-bold m-0">Quality Product</h5>
                    </div>                    
                </div>
                <div class="col-lg-3 ">
                    <div class="box shadow-lg">
                        <div class="fa icon fa-shipping-fast text-primary m-0 mr-3"></div>
                        <h2 class="font-weight-semi-bold m-0">Free Shipping</h2>
                    </div>                    
                </div>
                <div class="col-lg-3">
                    <div class="box shadow-lg">
                        <div class="fa icon fa-exchange-alt text-primary m-0 mr-3"></div>
                        <h2 class="font-weight-semi-bold m-0">14-Day Return</h2>
                    </div>                    
                </div>
                <div class="col-lg-3 ">
                    <div class="box shadow-lg">
                        <div class="fa icon fa-phone-volume text-primary m-0 mr-3"></div>
                        <h2 class="font-weight-semi-bold m-0">24/7 Support</h5>
                    </div>                    
                </div>
            </div>
        </div>
    </section>
    <section class="section-3">
        <div class="container">
            <div class="section-title">
                <h2>Categories</h2>
            </div>           
            <div class="row pb-3">
                @if ($categoriesShow->isNotEmpty())
                    @foreach ($categoriesShow as $category)
                    <div class="col-lg-3">
                        <div class="cat-card">
                            <div class="left">
                                <img src="{{ asset('/images/thumbnail_category/'.$category->thumbnail) }}" alt="" class="img-fluid">
                            </div>
                            <div class="right">
                                <div class="cat-data">
                                    <h2>{{ $category->name }}</h2>
                                    <p>{{ $category->products->count() }} products</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @endif
            </div>
        </div>
    </section>
    
    <section class="section-4 pt-5">
        <div class="container">
            <div class="section-title">
                <h2>Featured Products</h2>
            </div>    
            <div class="row pb-3">
                @if ($featuredProducts->isNotEmpty())
                    @foreach ($featuredProducts as $product)
                    @php
                        $productImage = $product->productImage->first();
                    @endphp
                    <div class="col-md-3">
                        <div class="card product-card">
                            <div class="product-image position-relative">
                                @if (!empty($productImage))
                                    <a href="{{ route('product.detail', $product->slug) }}" class="product-img"><img class="card-img-top" src="{{ asset('/images/thumbnail/'.$productImage->image) }}" alt=""></a>
                                @else
                                <a href="{{ route('product.detail', $product->slug) }}" class="product-img"><img class="card-img-top" src="{{ asset('/images/image-unavailable.png') }}" alt=""></a>
                               @endif
                                <a class="whishlist" href="javascript:void(0)" onclick="(addWishList({{ $product->id }}))"><i class="far fa-heart"></i></a>                            
    
                                <div class="product-action">
                                    <a class="btn btn-dark" href="javasrcipt:void(0)" onclick="addToCart({{ $product->id }})">
                                        <i class="fa fa-shopping-cart"></i> Add To Cart
                                    </a>                            
                                </div>
                            </div>                        
                            <div class="card-body text-center mt-3">
                                <a class="h6 link" href="product.php">{{ $product->name }}</a>
                                <div class="price mt-2">
                                    <span class="h5"><strong>${{ $product->price }}</strong></span>
                                    <span class="h6 text-underline"><del>$120</del></span>
                                </div>
                            </div>                        
                        </div>                                               
                    </div>    
                    @endforeach
                @endif
            </div>
        </div>
    </section>

    <section class="section-4 pt-5">
        <div class="container">
            <div class="section-title">
                <h2>Latest Produsts</h2>
            </div>    
            <div class="row pb-3">
                @if ($latestProducts->isNotEmpty())
                    @foreach ($latestProducts as $product)
                    @php
                        $imageProduct = $product->productImage->first();
                    @endphp
                    <div class="col-md-3">
                        <div class="card product-card">
                            <div class="product-image position-relative">
                               @if (!empty($imageProduct))
                                    <a href="{{ route('product.detail', $product->slug) }}" class="product-img"><img class="card-img-top" src="{{ asset('/images/thumbnail/'.$imageProduct->image) }}" alt=""></a>
                                @else
                                <a href="{{ route('product.detail', $product->slug) }}" class="product-img"><img class="card-img-top" src="{{ asset('/images/image-unavailable.png') }}" alt=""></a>
                               @endif
                                <a class="whishlist" href="javasrcipt:void(0)" onclick="(addWishList({{ $product->id }}))"><i class="far fa-heart"></i></a>                            
                                <div class="product-action">
                                    <a class="btn btn-dark" href="javasrcipt:void(0)" onclick="addToCart({{ $product->id }})">
                                        <i class="fa fa-shopping-cart"></i> Add To Cart
                                    </a>                            
                                </div>
                            </div>                        
                            <div class="card-body text-center mt-3">
                                <a class="h6 link" href="product.php">{{ $product->name }}</a>
                                <div class="price mt-2">
                                    <span class="h5"><strong>${{ $product->price }}</strong></span>
                                    <span class="h6 text-underline"><del>$120</del></span>
                                </div>
                            </div>                        
                        </div>                                               
                    </div> 
                    @endforeach
                @endif
            </div>
        </div>
    </section>
</main>
@endsection