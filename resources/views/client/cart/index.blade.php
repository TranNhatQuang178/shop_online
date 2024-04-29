@extends('layouts.app')
@section('content')
    <main>
        <section class="section-5 pt-3 pb-3 mb-3 bg-white">
            <div class="container">
                <div class="light-font">
                    <ol class="breadcrumb primary-color mb-0">
                        <li class="breadcrumb-item"><a class="white-text" href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a class="white-text" href="{{ route('shop.index') }}">Shop</a></li>
                        <li class="breadcrumb-item">Cart</li>
                    </ol>
                </div>
            </div>
        </section>

        @if (session()->has('email'))
            @if ($customer->cart->count() > 0)
            <section class=" section-9 pt-4">
                <div class="container">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="table-responsive">
                                <table class="table" id="cart">
                                    <thead>
                                        <tr>
                                            <th>Item</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Total</th>
                                            <th>Remove</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                            @foreach ($customer->cart as $cartCustomer)
                                                @php
                                                    $imageProduct = $cartCustomer->product->productImage->first();
                                                @endphp
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            @if (!$imageProduct == '')
                                                                <img src="{{ asset('/images/thumbnail/' . $imageProduct->image) }}"
                                                                    width="" height="">
                                                            @else
                                                                <img src="{{ asset('/images/image-unavailable.png') }}"
                                                                    width="" height="">
                                                            @endif
                                                            <h2>{{ $cartCustomer->product->name }}</h2>
                                                        </div>
                                                    </td>
                                                    <td>${{ $cartCustomer->product->price }}</td>
                                                    <td>
                                                        <div class="input-group quantity mx-auto" style="width: 100px;">
                                                            <div class="input-group-btn">
                                                                <button
                                                                    class="btn btn-sm btn-dark btn-minus p-2 pt-1 pb-1 minus"
                                                                    rowId="{{ $cartCustomer->id }}">
                                                                    <i class="fa fa-minus"></i>
                                                                </button>
                                                            </div>
                                                            <input type="text" id="qty-{{ $cartCustomer->id }}"
                                                                class="form-control form-control-sm  border-0 text-center js-qty"
                                                                value="{{ $cartCustomer->qty }}" readonly>
                                                            <div class="input-group-btn">
                                                                <button
                                                                    class="btn btn-sm btn-dark btn-plus p-2 pt-1 pb-1 plus"
                                                                    rowId="{{ $cartCustomer->id }}">
                                                                    <i class="fa fa-plus"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td id="total-{{ $cartCustomer->id }}">
                                                        ${{ number_format($cartCustomer->sub_total, 2, '.', ',') }}
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-sm btn-danger remove-cart"
                                                            data="{{ route('cart.remove', $cartCustomer->id) }}"><i
                                                                class="fa fa-times"></i></button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card cart-summery">
                                <div class="sub-title">
                                    <h2 class="bg-white">Cart Summery</h3>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex justify-content-between pb-2">
                                        <div class="js-sub-total">Subtotal</div>
                                        <div>${{ number_format($cartTotal,2,'.',',') }}</div>
                                    </div>
                                    <div class="d-flex justify-content-between pb-2">
                                        <div>Shipping</div>
                                        <div class="js-shipping">${{ $shipping }}</div>
                                    </div>
                                    <div class="d-flex justify-content-between pb-2">
                                        <div>Coupon</div>
                                        <div class="js-coupon">
                                            {{ session()->has('coupon') ? '-$' . session('coupon') : '$' . $coupon }}</div>
                                    </div>
                                    <div class="d-flex justify-content-between summery-end">
                                        <div class="js-total">Total</div>
                                        <div>
                                            {{ session()->has('grandTotal') ? '$' . session('grandTotal') : '$' . number_format($cartTotal, 2, '.',',') }}
                                        </div>
                                    </div>
                                    <div class="pt-5">
                                        <a href="{{ route('checkout') }}" class="btn-dark btn btn-block w-100">Proceed to Checkout</a>
                                    </div>
                                </div>
                            </div>
                            <form action="" method="POST" id="apply-coupon">
                                <div class="input-group apply-coupan mt-4">
                                    <input type="text" placeholder="Coupon Code" class="form-control" id="coupon"
                                        {{ session()->has('code') == true ? 'readonly' : '' }}>
                                    <button class="btn btn-dark js-btn-apply-coupon" type="submit" id="button-addon2"
                                        {{ session()->has('code') == true ? 'disabled' : '' }}>Apply Coupon</button>
                                </div>
                                <p class=""></p>
                            </form>
                            <div class="d-flex justify-content-between pb-2 align-items-center box-coupon">
                                @if (session()->has('coupon'))
                                    <div>Coupon Code: {{ session('code') }}</div>
                                    <div>
                                        <a href="" class="btn btn-sm btn-danger remove-coupon"><i
                                                class="fa fa-times"></i></a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </section>
            @else
            <h4 class="text-center py-5">Cart Is Empty!</h4>
            @endif
        @else
            @if (Cart::count() > 0)
                <section class=" section-9 pt-4">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="table-responsive">
                                    <table class="table" id="cart">
                                        <thead>
                                            <tr>
                                                <th>Item</th>
                                                <th>Price</th>
                                                <th>Quantity</th>
                                                <th>Total</th>
                                                <th>Remove</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach (Cart::content() as $cart)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            @if (!$cart->options->image == '')
                                                                <img src="{{ asset('/images/thumbnail/' . $cart->options->image->image) }}"
                                                                    width="" height="">
                                                            @else
                                                                <img src="{{ asset('/images/image-unavailable.png') }}"
                                                                    width="" height="">
                                                            @endif
                                                            <h2>{{ $cart->name }}</h2>
                                                        </div>
                                                    </td>
                                                    <td>${{ $cart->price }}</td>
                                                    <td>
                                                        <div class="input-group quantity mx-auto" style="width: 100px;">
                                                            <div class="input-group-btn">
                                                                <button
                                                                    class="btn btn-sm btn-dark btn-minus p-2 pt-1 pb-1 minus"
                                                                    rowId="{{ $cart->rowId }}">
                                                                    <i class="fa fa-minus"></i>
                                                                </button>
                                                            </div>
                                                            <input type="text" id="qty-{{ $cart->rowId }}"
                                                                class="form-control form-control-sm  border-0 text-center js-qty"
                                                                value="{{ $cart->qty }}" readonly>
                                                            <div class="input-group-btn">
                                                                <button
                                                                    class="btn btn-sm btn-dark btn-plus p-2 pt-1 pb-1 plus"
                                                                    rowId="{{ $cart->rowId }}">
                                                                    <i class="fa fa-plus"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td id="total-{{ $cart->rowId }}">
                                                        ${{ $cart->subtotal }}
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-sm btn-danger remove-cart"
                                                            data="{{ route('cart.remove', $cart->rowId) }}"><i
                                                                class="fa fa-times"></i></button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card cart-summery">
                                    <div class="sub-title">
                                        <h2 class="bg-white">Cart Summery</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between pb-2">
                                            <div class="js-sub-total">Subtotal</div>
                                            <div>${{ Cart::subtotal(2, '.', ',') }}</div>
                                        </div>
                                        <div class="d-flex justify-content-between pb-2">
                                            <div>Shipping</div>
                                            <div class="js-shipping">${{ $shipping }}</div>
                                        </div>
                                        <div class="d-flex justify-content-between pb-2">
                                            <div>Coupon</div>
                                            <div class="js-coupon">
                                                {{ session()->has('coupon') ? '-$' . session('coupon') : '$' . $coupon }}
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between summery-end">
                                            <div class="js-total">Total</div>
                                            <div>
                                                {{ session()->has('grandTotal') ? '$' . session('grandTotal') : '$' . Cart::subtotal(2, '.', ',') }}
                                            </div>
                                        </div>
                                        <div class="pt-5">
                                            <a href="{{ route('checkout') }}" class="btn-dark btn btn-block w-100">Proceed to
                                                Checkout</a>
                                        </div>
                                    </div>
                                </div>
                                <form action="" method="POST" id="apply-coupon">
                                    <div class="input-group apply-coupan mt-4">
                                        <input type="text" placeholder="Coupon Code" class="form-control"
                                            id="coupon" {{ session()->has('code') == true ? 'readonly' : '' }}>
                                        <button class="btn btn-dark js-btn-apply-coupon" type="submit"
                                            id="button-addon2"
                                            {{ session()->has('code') == true ? 'disabled' : '' }}>Apply Coupon</button>
                                    </div>
                                    <p class=""></p>
                                </form>
                                <div class="d-flex justify-content-between pb-2 align-items-center box-coupon">
                                    @if (session()->has('coupon'))
                                        <div>Coupon Code: {{ session('code') }}</div>
                                        <div>
                                            <a href="" class="btn btn-sm btn-danger remove-coupon"><i
                                                    class="fa fa-times"></i></a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                </section>
            @else
                <h4 class="text-center py-5">Cart Is Empty!</h4>
            @endif
        @endif
    </main>
@endsection
@section('js')
    <script>
        $("#apply-coupon").submit(function(e) {
            e.preventDefault();
            var code = $("#coupon").val();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ route('cart.applyCoupon') }}',
                data: {
                    code: code
                },
                method: 'post',
                dataType: 'json',
                success: function(response) {
                    if (response.status == false) {
                        $(".js-coupon").text("$0");
                        $(".js-total").next().text("$" + response.subTotal);
                        $("#coupon").parent().next('p').addClass('text-danger').text(response.mess);
                    } else {
                        $("#coupon").parent().next('p').removeClass('text-danger').text("");
                    }
                    if (response.status == true) {
                        $(".js-coupon").text("-$" + response.coupon);
                        $(".js-total").next().text("$" + response.grandTotal);
                        $("#coupon")
                            .parent()
                            .next('p').
                        removeClass('text-danger')
                            .addClass('text-success').text('Apply coupon successful !');
                        $(".js-btn-apply-coupon").prop('disabled', true);
                        $("#coupon").prop('readonly', true)
                        setTimeout(() => {
                            $("#coupon").parent().next('p').removeClass('text-danger').addClass(
                                'text-success').text("");
                            var html = `<div>Coupon Code: ${response.code}</div>
                                <div>
                                    <a href="#" class="btn btn-sm btn-danger remove-coupon" 
                                    ><i class="fa fa-times"></i></a>
                                </div>`;
                            $(".box-coupon").html(html);
                        }, 1800);
                    }

                }
            });
        });

        $("body").on("click", ".remove-coupon", function(e) {
            e.preventDefault();
            var that = $(this);
            $.ajax({
                url: '{{ route('cart.couponDelete') }}',
                dataType: 'json',
                method: 'get',
                data: $(this),
                success: function(response) {
                    if (response.status == true) {
                        that.parent().prev().remove();
                        that.parent().remove();
                        $(".js-coupon").text("$0");
                        $(".js-total").next().text("$" + response.subTotal);
                        $(".js-btn-apply-coupon").prop('disabled', false);
                        $("#coupon").prop('readonly', false);
                    }
                }
            });
        });
        $(".minus").click(function() {
            var inpQty = $(this).parent().next();
            qtyValue = parseInt(inpQty.val());
            if (qtyValue > 1) {
                var rowId = $(this).attr('rowId');
                var newQty = $("#qty-" + rowId).val(qtyValue - 1);
                updateCart(rowId, newQty.val());
            }
        });

        $(".plus").click(function() {
            var inpQty = $(this).parent().prev();
            qtyValue = parseInt(inpQty.val());
            var rowId = $(this).attr('rowId');
            var newQty = $("#qty-" + rowId).val(qtyValue + 1);
            updateCart(rowId, newQty.val());
        });

        $(".remove-cart").click(function() {
            const urlRequest = $(this).attr('data');
            const that = $(this);
            $.ajax({
                url: urlRequest,
                method: "get",
                success: function(response) {
                    if (response.status == true) {
                        that.parents('tr').remove();
                        $(".js-sub-total").next().text("$" + response.subTotal);
                        if(response.grandTotal){
                            $(".js-total").next().text("$" + response.grandTotal);
                        }else{
                            $(".js-total").next().text("$" + response.subTotal);
                        }
                        if (response.coupon) {
                            $(".js-coupon").text("-$" + response.coupon);
                        }
                        if ($(".remove-cart").length == 0) {
                            window.location.href = '{{ route('cart.index') }}';
                        }
                    }
                },
            });
        });

        function updateCart(rowId, qty) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '{{ route('cart.update') }}',
                method: "post",
                dataType: 'json',
                data: {
                    rowId: rowId,
                    qty: qty
                },
                success: function(response) {
                    if (response.status == true) {
                        $("#total-" + rowId).text("$" + response.itemTotal);
                        $(".js-sub-total").next().text("$" + response.total);
                        $(".js-total").next().text("$" + response.total);
                    }
                    if (response.coupon != null && response.grandTotal != null) {
                        $("#total-" + rowId).text("$" + response.itemTotal);
                        $(".js-sub-total").next().text("$" + response.subTotal);
                        $(".js-coupon").text("-$" + response.coupon);
                        $(".js-total").next().text("$" + response.grandTotal);
                    }
                }
            });
        }
    </script>
@endsection
