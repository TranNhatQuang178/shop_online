@extends('layouts.admin')
@section('nav')
    <div class="navbar-nav pl-2">
        <ol class="breadcrumb p-0 m-0 bg-white">
            <li class="breadcrumb-item"><a href="{{ route('order.index') }}">Orders</a></li>
            <li class="breadcrumb-item active">List</li>
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
                        <h1>Orders</h1>
                    </div>
                    <div class="col-sm-6 text-right">
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            <!-- Default box -->
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <div class="card-tools">
                            <form action="">
                                <div class="input-group input-group" style="width: 250px;">
                                    <input type="text" name="keyword" class="form-control float-right"
                                        placeholder="Search">
    
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>Orders #</th>
                                    <th>Customer</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Status</th>
                                    <th>Total</th>
                                    <th>Date Purchased</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($orders->isNotEmpty())
                                    @foreach ($orders as $order)
                                        <tr>
                                            <td><a href="{{ route('order.detail', $order->id) }}">{{ $order->order_code }}</a></td>
                                            <td>{{ $order->fullname }}</td>
                                            <td>{{ $order->email }}</td>
                                            <td>{{ $order->mobile }}</td>
                                            @if ($order->status === 1)
                                            <td>
                                                <span class="badge bg-light">Pending</span>
                                            </td>
                                            @elseif ($order->status === 2)
                                            <td>
                                                <span class="badge bg-primary">Shipped</span>
                                            </td>
                                            @elseif ($order->status === 3)
                                            <td>
                                                <span class="badge bg-success">Delivered</span>
                                            </td>
                                            @else
                                            <td>
                                                <span class="badge bg-dark">Cancelled</span>
                                            </td>
                                            @endif  
                                            <td>${{ $order->grand_total > 0 ? $order->grand_total : $order->total }}</td>
                                            <td>{{ Carbon\Carbon::parse($order->created_at)->format("Y/m/d") }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer clearfix">
                        <ul class="pagination pagination m-0 float-right">
                            <li class="page-item"><a class="page-link" href="#">«</a></li>
                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#">»</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /.card -->
        </section>
        <!-- /.content -->
    </div>
@endsection
