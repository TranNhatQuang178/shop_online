@extends('layouts.app')

@section('content')
    <main>
        <section class="section-5 pt-3 pb-3 mb-3 bg-white">
            <div class="container">
                <div class="light-font">
                    <ol class="breadcrumb primary-color mb-0">
                        <li class="breadcrumb-item"><a class="white-text" href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a class="white-text" href="{{ route('shop.index') }}">Shop</a></li>
                        <li class="breadcrumb-item">Checkout</li>
                    </ol>
                </div>
            </div>
        </section>
        <form action="" method="POST" id="js-form-checkout">
            <section class="section-9 pt-4">
                <div class="container">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="sub-title">
                                <h2>Shipping Address</h2>
                            </div>
                            <div class="card shadow-lg border-0">
                                <div class="card-body checkout-form">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <input type="text" name="full_name" id="full_name" class="form-control"
                                                    placeholder="Full Name"
                                                    value="{{ session()->has('is_login') ? $customer->name : '' }}" {{ session()->has('is_login') ? 'readonly' : '' }}>
                                                    <p></p>
                                            </div>
                                        </div>
    
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <input type="text" name="email" id="email" class="form-control"
                                                    placeholder="Email"
                                                    value="{{ session()->has('is_login') ? $customer->email : '' }}" {{ session()->has('is_login') ? 'readonly' : '' }}>
                                                    <p></p>
                                            </div>
                                        </div>
    
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <select name="country" id="country" class="form-control">
                                                    <option value="">Select a Country</option>
                                                    @if ($countries->isNotEmpty())
                                                        @foreach ($countries as $country)
                                                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                <p></p>
                                            </div>
                                        </div>
    
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <textarea name="address" id="address" cols="30" rows="3" placeholder="Address" class="form-control">{{ session()->has('is_login') ? $customer->address : '' }}</textarea>
                                                <p></p>
                                            </div>
                                            
                                        </div>
    
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <input type="text" name="appartment" id="appartment" class="form-control"
                                                    placeholder="Apartment, suite, unit, etc. (optional)">
                                                    <p></p>
                                            </div>
                                        </div>
    
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <input type="text" name="city" id="city" class="form-control"
                                                    placeholder="City">
                                                    <p></p>
                                            </div>
                                        </div>
    
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <input type="text" name="state" id="state" class="form-control"
                                                    placeholder="State">
                                                    <p></p>
                                            </div>
                                        </div>
    
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <input type="text" name="zip" id="zip" class="form-control"
                                                    placeholder="Zip">
                                                    <p></p>
                                            </div>
                                        </div>
    
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <input type="text" name="phone" id="phone" class="form-control"
                                                    placeholder="Mobile No." value="{{ session('is_login') ? $customer->phone : ''}}" {{ session()->has('is_login') ? 'readonly' : '' }}>
                                                    <p></p>
                                            </div>
                                        </div>
    
    
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <textarea name="order_notes" id="order_notes" cols="30" rows="2" placeholder="Order Notes (optional)"
                                                    class="form-control"></textarea>
                                                    <p></p>
                                            </div>
                                        </div>
    
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="sub-title">
                                <h2>Order Summery</h3>
                            </div>
                            <div class="card cart-summery">
                                <div class="card-body">
                                    @if (session('is_login'))
                                        @foreach ($customer->cart as $item)
                                            <div class="d-flex justify-content-between pb-2">
                                                <div class="h6">{{ $item->product->name }} X {{ $item->qty }}</div>
                                                <div class="h6">${{ $item->sub_total }}</div>
                                            </div>
                                        @endforeach
                                        <div class="d-flex justify-content-between summery-end">
                                            <div class="h6"><strong>Subtotal</strong></div>
                                            <div class="h6"><strong>${{ number_format($cartTotal, 2, '.', ',') }}</strong>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between mt-2">
                                            <div class="h6"><strong>Shipping</strong></div>
                                            <div class="h6"><strong>${{ $shipping }}</strong></div>
                                        </div>
                                        <div class="d-flex justify-content-between mt-2">
                                            <div class="h6"><strong>Coupon</strong></div>
                                            <div class="h6">
                                                <strong>{{ session()->has('coupon') ? '-$'. session('coupon') : '$'. $coupon }}</strong>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between mt-2 summery-end">
                                            <div class="h5"><strong>Total</strong></div>
                                            <div class="h5">
                                                <strong>${{ session()->has('grandTotal') ? session('grandTotal') : number_format($cartTotal,2,'.',',') }}</strong>
                                            </div>
                                        </div>
                                    @else
                                        @if (Cart::count() > 0)
                                            @foreach (Cart::content() as $item)
                                                <div class="d-flex justify-content-between pb-2">
                                                    <div class="h6">{{ $item->name }} X {{ $item->qty }}
                                                    </div>
                                                    <div class="h6">${{ $item->subtotal }}</div>
                                                </div>
                                            @endforeach
                                            <div class="d-flex justify-content-between summery-end">
                                                <div class="h6"><strong>Subtotal</strong></div>
                                                <div class="h6">
                                                    <strong>${{ Cart::subtotal(2, '.', ',') }}</strong>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-between mt-2">
                                                <div class="h6"><strong>Shipping</strong></div>
                                                <div class="h6"><strong>${{ $shipping }}</strong></div>
                                            </div>
                                            <div class="d-flex justify-content-between mt-2">
                                                <div class="h6"><strong>Coupon</strong></div>
                                                <div class="h6">
                                                    <strong>-${{ session()->has('coupon') ? session('coupon') : $coupon }}</strong>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-between mt-2 summery-end">
                                                <div class="h5"><strong>Total</strong></div>
                                                <div class="h5">
                                                    <strong>${{ session()->has('grandTotal') ? session('grandTotal') : Cart::total(2, '.', ',') }}</strong>
                                                </div>
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            </div>
    
                            <div class="card payment-form ">
                                <h3 class="card-title h5 mb-3">Select Payment Method</h3>
                                <div class="">
                                    <input type="radio" checked name="payment" id="payment_cod" value="payment_cod">
                                    <label for="payment_cod" class="mb-2">Cod</label><br>
                                    <input type="radio" name="payment" id="payment_stripe"
                                   class="" value="payment_stripe">
                                    <label for="payment_stripe" class="mb-2">Stripe</label>
                                </div>
                                <div class="card-body p-0 d-none" id="js-form-payment">
                                        <div class="mb-3">
                                            <label for="card_number" class="mb-2">Card Number</label>
                                            <input type="text" name="card_number" id="card_number"
                                                placeholder="Valid Card Number" class="form-control">
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="expiry_date" class="mb-2">Expiry Date</label>
                                                <input type="text" name="expiry_date" id="expiry_date" placeholder="MM/YYYY"
                                                    class="form-control">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="expiry_date" class="mb-2">CVV Code</label>
                                                <input type="text" name="expiry_date" id="expiry_date" placeholder="123"
                                                    class="form-control">
                                            </div>
                                    </div>
                                </div>
                                <div class="pt-4">
                                    <button type="submit" class="btn-dark btn btn-block w-100">Pay Now</button>
                                </div>
                            </div>
    
    
                            <!-- CREDIT CARD FORM ENDS HERE -->
    
                        </div>
                    </div>
                </div>
            </section>
        </form>
    </main>
@endsection
@section('js')
    <script>

        $("#js-form-checkout").submit(function(e){
            e.preventDefault();
            let element = $(this);

            $.ajax({
                url: '{{ route('checkout.processCheckout') }}',
                data: element.serializeArray(),
                method: 'post',
                dataType: 'json',
                success: function(response){
                    if(response.status == false){
                        if(response.errors){
                        var errors =  response.errors;
                            if(errors.fullname){
                            $("#fullname").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors.fullname);
                             }else{
                            $("#fullname").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                        }
                        if(errors.email){
                            $("#email").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors.email);
                        }else{
                            $("#email").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                        }
                        if(errors.country){
                            $("#country").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors.country);
                        }else{
                            $("#country").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                        }
                        if(errors.address){
                            $("#address").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors.address);
                        }else{
                            $("#address").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                        }
                        if(errors.city){
                            $("#city").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors.city);
                        }else{
                            $("#city").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                        }

                        if(errors.state){
                            $("#state").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors.state);
                        }else{
                            $("#state").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                        }

                        if(errors.zip){
                            $("#zip").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors.zip);
                        }else{
                            $("#zip").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                        }

                        if(errors.phone){
                            $("#phone").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors.phone);
                        }else{
                            $("#phone").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                        }
                    }
                    }else{
                        window.location.href = "{{ url('/checkout-success/') }}/" + response.orderId
                    }
                }
            });
        });
        $("#payment_cod").click(function(){
            if($(this).is(':checked')){
                $("#js-form-payment").addClass('d-none');
            }
        });

        $("#payment_stripe").click(function(){
            if($(this).is(':checked')){
                $("#js-form-payment").removeClass('d-none');
            }
        });
    </script>
@endsection
