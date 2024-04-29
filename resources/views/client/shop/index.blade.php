@extends('layouts.app')
@section('content')
    <main>
        <section class="section-5 pt-3 pb-3 mb-3 bg-white">
            <div class="container">
                <div class="light-font">
                    <ol class="breadcrumb primary-color mb-0">
                        <li class="breadcrumb-item"><a class="white-text" href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Shop</li>
                    </ol>
                </div>
            </div>
        </section>
        <section class="section-6 pt-5">
            <div class="container">
                <div class="row">
                    <div class="col-md-3 sidebar">
                        <div class="sub-title">
                            <h2>Categories</h3>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="accordion accordion-flush" id="accordionExample">
                                    @if ($categories->isNotEmpty())
                                        @foreach ($categories as $key => $category)
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="headingOne">
                                                    <button class="accordion-button collapsed {{ $selectedCategory == $category->id ? 'text-primary' : ''}}" type="button"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#collapseOne-{{ $key }}"
                                                        aria-expanded="false"
                                                        aria-controls="collapseOne-{{ $key }}">
                                                        {{ $category->name }}
                                                    </button>
                                                </h2>
                                                @if ($category->children->isNotEmpty())
                                                    <div id="collapseOne-{{ $key }}"
                                                        class="accordion-collapse collapse {{ $selectedCategory == $category->id ? 'show' : '' }}" aria-labelledby="headingOne"
                                                        data-bs-parent="#accordionExample" style="">
                                                        <div class="accordion-body">
                                                            <div class="navbar-nav">
                                                                @foreach ($category->children as $subCategory)
                                                                    <a href="{{ route('shop.index', [$category->slug, $subCategory->slug]) }}"
                                                                        class="nav-item nav-link {{ $selectedSubCategory == $subCategory->id ? 'text-primary' : '' }}">{{ $subCategory->name }}</a>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    @endif

                                </div>
                            </div>
                        </div>

                        <div class="sub-title mt-5">
                            <h2>Brand</h3>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                @if ($brands->isNotEmpty())
                                    @foreach ($brands as $brand)
                                        <div class="form-check mb-2">
                                            <input class="form-check-input brand-label"
                                                {{ in_array($brand->id, $brandArray) ? 'checked' : '' }} type="checkbox"
                                                name="brand[]" value="{{ $brand->id }}" id="brand-{{ $brand->id }}">
                                            <label class="form-check-label" for="brand-{{ $brand->id }}">
                                                {{ $brand->name }}
                                            </label>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>

                        <div class="sub-title mt-5">
                            <h2>Price</h3>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <div class="form-check mb-2">
                                    <input class="form-check-input price-label" name="price" type="checkbox" value="0-100"
                                        id="price-0-100" {{ request()->price == "0-100" ? 'checked' : '' }}>
                                    <label class="form-check-label" for="price-0-100">
                                        $0-$100
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input price-label" type="checkbox" value="100-200"
                                        id="price-100-200" {{ request()->price == "100-200" ? 'checked' : '' }}>
                                    <label class="form-check-label" for="price-100-200">
                                        $100-$200
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input price-label" type="checkbox" value="200-500"
                                        id="price-200-500" {{ request()->price == "200-500" ? 'checked' : '' }}>
                                    <label class="form-check-label" for="price-200-500"> 
                                        $200-$500
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input price-label" type="checkbox" value="500"
                                        id="price-500" {{ request()->price == "500" ? 'checked' : '' }}>
                                    <label class="form-check-label" for="price-500">
                                        $500+
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="row pb-3">
                            <div class="col-12 pb-1">
                                <div class="d-flex align-items-center justify-content-end mb-4">
                                    <div class="ml-2">
                                        <div class="btn-group">
                                            <select name="sort" id="sort" class="form-control">
                                                <option value="">Sort</option>
                                                <option value="latest" {{ request()->sort == 'latest' ? 'selected' : '' }}>Latest</option>
                                                <option value="price_hight" {{ request()->sort == 'price_hight' ? 'selected' : '' }}>Price Hight</option>
                                                <option value="price_low" {{ request()->sort == 'price_low' ? 'selected' : '' }}>Price Low</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if ($products->isNotEmpty())
                                @foreach ($products as $product)
                                    @php
                                        $productImage = $product->productImage->first();
                                    @endphp
                                    <div class="col-md-4">
                                        <div class="card product-card">
                                            <div class="product-image position-relative">
                                                <a href="{{ route('product.detail', $product->slug) }}" class="product-img">
                                                    @if ($product->productImage->isNotEmpty())
                                                        <img class="card-img-top"
                                                            src="{{ asset('/images/thumbnail/' . $productImage->image) }}"
                                                            alt="">
                                                    @else
                                                        <img class="card-img-top"
                                                            src="{{ asset('/images/image-unavailable.png') }}"
                                                            alt="">
                                                    @endif
                                                </a>
                                                <a class="whishlist" href="javascript:void(0)" onclick="(addWishList({{ $product->id }}))"><i class="far fa-heart"></i></a>

                                                <div class="product-action">
                                                    <a class="btn btn-dark" href="javasrcipt:void(0)" onclick="addToCart({{ $product->id }})">
                                                        <i class="fa fa-shopping-cart"></i> Add To Cart
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="card-body text-center mt-3">
                                                <a class="h6 link" href="{{ route('product.detail', $product->slug) }}">{{ $product->name }}</a>
                                                <div class="price mt-2">
                                                    <span class="h5"><strong>${{ $product->price }}</strong></span>
                                                    <span class="h6 text-underline"><del>$120</del></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                            <div class="col-md-12 pt-5">
                                {{ $products->withQueryString()->links() }}
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
        $(".brand-label").change(function() {
            applyFillters();
        });

        $(".price-label").change(function() {
            applyFillters($(this).val());
        });
        $("#sort").change(function(){
            applyFillters();
        });

        function applyFillters(price = '') {
            var brand = [];
            // var price = [];
            $(".brand-label").each(function() {
                if ($(this).is(":checked")) {
                    brand.push($(this).val());
                }
            });
                var url = '{{ url()->current() }}?';
                if (brand.length > 0) {
                    url += "&brand=" + brand.toString();
                }

                if(price.length > 0){
                    url += "&price=" + price.toString();
                }
                if($("#sort").val() != ""){
                    url += "&sort=" + $("#sort").val().toString();
                }
                window.location.href = url;
        }
    </script>
@endsection
