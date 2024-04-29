@extends('layouts.app')

@section('content')
    <main>
        <section class="section-5 pt-3 pb-3 mb-3 bg-white">
            <div class="container">
                <div class="light-font">
                    <ol class="breadcrumb primary-color mb-0">
                        <li class="breadcrumb-item"><a class="white-text" href="#">My Account</a></li>
                        <li class="breadcrumb-item">Settings</li>
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
                                <h2 class="h5 mb-0 pt-2 pb-2">My Orders</h2>
                            </div>

                            <div class="card-body pb-0">
                                <!-- Info -->
                                <div class="card card-sm">
                                    <div class="card-body bg-light mb-3">
                                        <div class="row">
                                            <div class="col-6 col-lg-3">
                                                <!-- Heading -->
                                                <h6 class="heading-xxxs text-muted">Order No:</h6>
                                                <!-- Text -->
                                                <p class="mb-lg-0 fs-sm fw-bold">
                                                    {{ Str::limit($order->order_code, 14) }}
                                                </p>
                                            </div>
                                            <div class="col-6 col-lg-3">
                                                <!-- Heading -->
                                                <h6 class="heading-xxxs text-muted">Shipped date:</h6>
                                                <!-- Text -->
                                                <p class="mb-lg-0 fs-sm fw-bold">
                                                    <time datetime="2019-10-01">
                                                        {{ Carbon\Carbon::parse($order->created_at)->format('H M, Y') }}
                                                    </time>
                                                </p>
                                            </div>
                                            <div class="col-6 col-lg-3">
                                                <!-- Heading -->
                                                <h6 class="heading-xxxs text-muted">Status:</h6>
                                                <!-- Text -->
                                                @if ($order->status == 1)
                                                    <p>
                                                        <span class="badge bg-info">Pending</span>
                                                    </p>
                                                @endif
                                                @if ($order->status == 2)
                                                    <p>
                                                        <span class="badge bg-primary">Shipped</span>
                                                    </p>
                                                @endif
                                                @if ($order->status == 3)
                                                    <p>
                                                        <span class="badge bg-success">Delivered</span>
                                                    </p>
                                                @endif
                                                @if ($order->status == 4)
                                                    <p>
                                                        <span class="badge bg-danger">Cancelled</span>
                                                    </p>
                                                @endif
                                            </div>
                                            <div class="col-6 col-lg-3">
                                                <!-- Heading -->
                                                <h6 class="heading-xxxs text-muted">Order Amount:</h6>
                                                <!-- Text -->
                                                <p class="mb-0 fs-sm fw-bold">
                                                    ${{ $order->grandTotal > 0 ? number_format($order->grandTotal) : number_format($order->total) }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer p-3">

                                <!-- Heading -->
                                <h6 class="mb-7 h5 mt-4">Order Items ({{ count($orderItems) }})</h6>

                                <!-- Divider -->
                                <hr class="my-3">

                                <!-- List group -->
                                <ul>
                                    @if ($orderItems->isNotEmpty())
                                        @foreach ($orderItems as $orderItem)
                                        @php
                                            $imageProduct = getProductImage($orderItem->product_id);
                                        @endphp
                                        <li class="list-group-item">
                                            <div class="row align-items-center">
                                                <div class="col-4 col-md-3 col-xl-2">
                                                    <!-- Image -->
                                                    @if (!empty($imageProduct))
                                                    <a href="{{ route('product.detail', $orderItem->product->slug) }}"><img src="{{ asset('/images/thumbnail/'.$imageProduct->image) }}" alt="..."
                                                        class="img-fluid"></a>
                                                    @else
                                                    <a href="{{ route('product.detail', $orderItem->product->slug) }}"><img src="{{ asset('/images/image-unavailable.png/') }}" alt="..."
                                                        class="img-fluid"></a>
                                                    @endif
                                                </div>
                                                <div class="col">
                                                    <!-- Title -->
                                                    <p class="mb-4 fs-sm fw-bold">
                                                        <a class="text-body" href="{{ route('product.detail', $orderItem->product->slug) }}">{{ $orderItem->name }} x
                                                            {{ $orderItem->qty }}</a> <br>
                                                        <span class="text-muted">${{ number_format($orderItem->total_item, 2,'.',',') }}</span>
                                                    </p>
                                                </div>
                                            </div>
                                        </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                        </div>

                        <div class="card card-lg mb-5 mt-3">
                            <div class="card-body">
                                <!-- Heading -->
                                <h6 class="mt-0 mb-3 h5">Order Total</h6>

                                <!-- List group -->
                                <ul>
                                    <li class="list-group-item d-flex">
                                        <span>Subtotal</span>
                                        <span class="ms-auto">${{ number_format($order->total,2,'.',',') }}</span>
                                    </li>
                                    {{-- <li class="list-group-item d-flex">
                                        <span>Tax</span>
                                        <span class="ms-auto">$0.00</span>
                                    </li> --}}
                                    <li class="list-group-item d-flex">
                                        <span>Shipping</span>
                                        <span class="ms-auto">$0</span>
                                    </li>
                                    <li class="list-group-item d-flex fs-lg fw-bold">
                                        <span>Total</span>
                                        <span class="ms-auto"> ${{ $order->grandTotal > 0 ? number_format($order->grandTotal, 2,'.',',') : number_format($order->total, 2,'.',',') }}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
