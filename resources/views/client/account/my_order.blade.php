@extends('layouts.app')
@section('content')
    <main>
        <section class="section-5 pt-3 pb-3 mb-3 bg-white">
            <div class="container">
                <div class="light-font">
                    <ol class="breadcrumb primary-color mb-0">
                        <li class="breadcrumb-item"><a class="white-text" href="#">My Account</a></li>
                        <li class="breadcrumb-item">My Orders</li>
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
                            <div class="card-body p-4">
                                <div class="table-responsive">
                                    @if ($orders->isNotEmpty())
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Orders #</th>
                                                    <th>Date Purchased</th>
                                                    <th>Status</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($orders as $order)
                                                    <tr>
                                                        <td>
                                                            <a
                                                                href="{{ route('account.myOrderDetail', $order->id) }}">{{ $order->order_code }}</a>
                                                        </td>
                                                        <td>{{ Carbon\Carbon::parse($order->created_at)->format('H M, Y') }}
                                                        </td>
                                                        @if ($order->status == 1)
                                                            <td>
                                                                <span class="badge bg-info">Pending</span>
                                                            </td>
                                                        @endif
                                                        @if ($order->status == 2)
                                                            <td>
                                                                <span class="badge bg-primary">Shipped</span>
                                                            </td>
                                                        @endif
                                                        @if ($order->status == 3)
                                                            <td>
                                                                <span class="badge bg-success">Delivered</span>
                                                            </td>
                                                        @endif
                                                        @if ($order->status == 4)
                                                            <td>
                                                                <span class="badge bg-danger">Cancelled</span>
                                                            </td>
                                                        @endif
                                                        <td>${{ $order->grand_total > 0 ? $order->grand_total : $order->total }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @else
                                        <h4 class="text-center">My Orders Is Empty!</h4>
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
