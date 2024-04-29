@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-md-12 text-center py-5">
            <h1>Thank you!</h1>
        </div>
        <div class="card-body table-responsive p-3">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th width="100">Price</th>
                        <th width="100">Qty</th>
                        <th width="100">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orderItems as $item)
                        @php
                            $imageProduct = getProductImage($item->product_id);
                        @endphp
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if ($imageProduct)
                                        <img src="{{ asset('/images/thumbnail/' . $imageProduct->image) }}" style="width:30px; margin-right: 6px">
                                    @else
                                    <img src="{{ asset('/images/image-unavailable.png') }}" style="width:30px; margin-right: 6px">
                                    @endif
                                    <span>{{ $item->productName }}</span>
                                </div>
                            </td>
                            <td>{{ $item->price }}</td>
                            <td>{{ $item->qty }}</td>
                            <td>${{ $item->total_item }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <th colspan="3" class="text-right">Subtotal:</th>
                        <td>${{ $order->total }}</td>
                    </tr>
                    {{-- <tr>
                        <th colspan="4" class="text-right">Shipping:</th>
                        <td>$5.00</td>
                    </tr> --}}
                    @if (!empty($order->coupon))
                        <tr>
                            <th colspan="3" class="text-right">Coupon:</th>
                            <td>${{ $order->coupon }}</td>
                        </tr>
                    @endif
                    <tr>
                        <th colspan="3" class="text-right">Grand Total:</th>
                        <td>${{ $order->grand_total > 0 ? $order->grand_total : $order->total }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
