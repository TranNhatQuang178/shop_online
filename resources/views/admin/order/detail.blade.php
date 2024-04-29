@extends('layouts.admin')

@section('nav')
    <div class="navbar-nav pl-2">
        <ol class="breadcrumb p-0 m-0 bg-white">
            <li class="breadcrumb-item"><a href="{{ route('order.index') }}">Orders</a></li>
            <li class="breadcrumb-item active">Order Detail</li>
        </ol>
    </div>
@endsection
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid my-2">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Order: {{ $order->order_code }}</h1>
                    </div>
                    <div class="col-sm-6 text-right">
                        <a href="{{ route('order.index') }}" class="btn btn-primary">Back</a>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            <!-- Default box -->
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-9">
                        <div class="card">
                            <div class="card-header pt-3">
                                <div class="row invoice-info">
                                    <div class="col-sm-4 invoice-col">
                                        <h1 class="h5 mb-3">Shipping Address</h1>
                                        <address>
                                            Name: <strong>{{ $order->fullname }}</strong><br>
                                            Address: {{ $order->address }}<br>
                                            {{ $country->name }}, {{ $order->state }} {{ $order->zip }}<br>
                                            Phone: {{ $order->mobile }}<br>
                                            Email: {{ $order->email }}
                                        </address>
                                    </div>



                                    <div class="col-sm-4 invoice-col">
                                        {{-- <b>Invoice #007612</b><br> --}}
                                        {{-- <br> --}}
                                        <b>Order ID:</b> {{ $order->id }}<br>
                                        <b>Total:</b>
                                        {{ $order->grand_total > 0 ? $order->grand_total : $order->total }}<br>
                                        <b>Status:</b>
                                        @if ($order->status === 1)
                                            <span class="text-secondary">Pending</span>
                                        @elseif ($order->status === 2)
                                            <span class="text-primary">Shipped</span>
                                        @elseif ($order->status === 3)
                                            <span class="text-success">Delivered</span>
                                        @else
                                            <span class="text-danger">Cancelled</span>
                                        @endif
                                        <br>
                                    </div>
                                </div>
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
                                            <tr>
                                                <td>{{ $item->productName }}</td>
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
                                            <th colspan="3" class="text-right">Shipping:</th>
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
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Order Status</h2>
                                <form action="" method="POST" name="form_update_status" id="form_update_status">
                                    <div class="mb-3">
                                        <select name="status" id="status" class="form-control">
                                            <option {{ $order->status == 1 ? 'selected' : '' }} value="1">Pending
                                            </option>
                                            <option value="2" {{ $order->status == 2 ? 'selected' : '' }}>Shipped
                                            </option>
                                            <option value="3" {{ $order->status == 3 ? 'selected' : '' }}>Delivered
                                            </option>
                                            <option value="4" {{ $order->status == 4 ? 'selected' : '' }}>Cancelled
                                            </option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card">
                            <form action="" id="form-send-mail">
                                <div class="card-body">
                                    <h2 class="h4 mb-3">Send Inovice Email</h2>
                                    <div class="mb-3">
                                        <select name="status" id="status" class="form-control">
                                            <option value="customer">Customer</option>
                                            <option value="admin">Admin</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <button class="btn btn-primary" name="btn_send-mail">Send</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card -->
        </section>
        <!-- /.content -->
    </div>
@endsection

@section('js')
    <script>
        $("#form_update_status").submit(function(e) {
            e.preventDefault();
            var data = $(this).serialize();
            $.ajax({
                url: '{{ route('order.updateStatus', $order->id) }}',
                method: 'post',
                data: data,
                dataType: 'json',
                success: function(response) {
                    if (response.status == true) {
                        let timeout = 1500;
                        Swal.fire({
                            position: "center",
                            icon: "success",
                            title: response.mess,
                            showConfirmButton: false,
                            timer: timeout
                        });
                        setTimeout(() => {
                            window.location.href = '{{ url()->current() }}';
                        }, timeout);
                    }
                }
            });
        });
        $("#form-send-mail").submit(function(e) {
            e.preventDefault();
            let timerInterval;
            Swal.fire({
                title: "Please wait a moment!",
                html: "Close in <b></b> milliseconds.",
                timer: 2000,
                timerProgressBar: true,
                didOpen: () => {
                    Swal.showLoading();
                    const timer = Swal.getPopup().querySelector("b");
                    timerInterval = setInterval(() => {
                        timer.textContent = `${Swal.getTimerLeft()}`;
                    }, 100);
                },
                willClose: () => {
                    clearInterval(timerInterval);
                }
            })
            $("button[name='btn_send-mail']").prop('disabled', true);
            var data = $(this).serialize();
            $.ajax({
                url: '{{ route('order.sendMail', $order->id) }}',
                method: 'post',
                data: data,
                dataType: 'json',
                success: function(response) {
                    if (response.status == true) {
                        $("button[name='btn_send-mail']").prop('disabled', false);
                        let timeout = 1500;
                        Swal.fire({
                            position: "center",
                            icon: "success",
                            title: response.mess,
                            showConfirmButton: false,
                            timer: timeout
                        });
                        setTimeout(() => {
                            window.location.href = '{{ url()->current() }}';
                        }, timeout);
                    }
                }
            });
        });
    </script>
@endsection
