@extends('layouts.admin')
@section('nav')
    <div class="navbar-nav pl-2">
        <ol class="breadcrumb p-0 m-0 bg-white">
            <li class="breadcrumb-item"><a href="">Products</a></li>
            <li class="breadcrumb-item active">List</li>
        </ol>
    </div>
@endsection
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid my-2">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Products</h1>
                    </div>
                    <div class="col-sm-6 text-right">
                        <a href="{{ route('product.create') }}" class="btn btn-primary">New Product</a>
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
                                <form action="" method="GET">
                                    <div class="input-group input-group" style="width: 250px;">
                                        <input type="text" name="keyword" class="form-control float-right"
                                            placeholder="Search" value="{{ request()->keyword }}">

                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-default">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <form action="" method="POST" id="form-action">
                                <button type="button" class="btn btn-light" name="btn_rest"
                                    onclick="window.location.href='{{ route('product.index') }}'">Reset</button>
                                <button name="btn_deleteAll" class="btn btn-danger">Delete Product</button>
                        </div>
                        
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" name="checkall" value=""></th>
                                        <th width="60">ID</th>
                                        <th width="80"></th>
                                        <th>Product</th>
                                        <th>Price</th>
                                        <th>Qty</th>
                                        <th>SKU</th>
                                        <th width="100">Status</th>
                                        <th width="100">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($products->isNotEmpty())
                                        @foreach ($products as $product)
                                            @php
                                                $productImage = $product->productImage->first();
                                            @endphp
                                            <tr>
                                                <td><input type="checkbox" name="list_check[]" value="{{ $product->id }}"
                                                        id="data-{{ $product->id }}">
                                                </td>
                                                <td>{{ $product->id }}</td>
                                                <td>
                                                    @if (!empty($productImage))
                                                        <img src="{{ asset('images/thumbnail/' . $productImage->image) }}"
                                                            class="img-thumbnail" width="50">
                                                    @endif
                                                </td>
                                                <td><a href="{{ route('product.detail', $product->slug) }}" target="_blank">{{ $product->name }}</a></td>
                                                <td>${{ $product->price }}</td>
                                                <td>{{ $product->track_qty }} left in Stock</td>
                                                <td>{{ $product->sku }} </td>
                                                <td>
                                                    @if ($product->status == 0)
                                                        <svg class="text-danger h-6 w-6" xmlns="http://www.w3.org/2000/svg"
                                                            fill="none" viewBox="0 0 24 24" stroke-width="2"
                                                            stroke="currentColor" aria-hidden="true">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z">
                                                            </path>
                                                        </svg>
                                                    @else
                                                        <svg class="text-success-500 h-6 w-6 text-success"
                                                            xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                            aria-hidden="true">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        </svg>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('product.edit', $product->id) }}">
                                                        <svg class="filament-link-icon w-4 h-4 mr-1"
                                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                            fill="currentColor" aria-hidden="true">
                                                            <path
                                                                d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z">
                                                            </path>
                                                        </svg>
                                                    </a>
                                                    <a href="#" data="{{ route('product.destroy', $product->id) }}"
                                                        class="text-danger w-4 h-4 mr-1 btn-destroy">
                                                        <svg wire:loading.remove.delay="" wire:target=""
                                                            class="filament-link-icon w-4 h-4 mr-1"
                                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                            fill="currentColor" aria-hidden="true">
                                                            <path ath fill-rule="evenodd"
                                                                d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                                clip-rule="evenodd"></path>
                                                        </svg>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="100%">Không tồn tại bản ghi nào</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                </form>

                <div class="card-footer clearfix">
                    {{ $products->links() }}
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
        $(".btn-destroy").click(function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: 'Do you want to delete this product?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    const urlRequest = $(this).attr('data');
                    const that = $(this);
                    $.ajax({
                        url: urlRequest,
                        method: 'get',
                        typeData: 'json',
                        success: function(response) {
                            if(response.status == 200){
                                that.parents('tr').remove();
                                Swal.fire({
                                    position: "center",
                                    icon: "success",
                                    title: "Product Remove Successfully !",
                                    showConfirmButton: false,
                                    timer: 2000
                                });
                            }
                        },
                    });
                }
            });
        });

        $("#form-action").submit(function(e) {
            e.preventDefault();
            $("button[name='btn_rest']").disable;
            Swal.fire({
                title: 'Are you sure?',
                text: 'Do you want to delete this product?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    const ids = $("input[type='checkbox']:checked");
                    let idsArray = [];
                    $.each(ids, function(key, value) {
                        return idsArray.push(value.value);
                    });
                    $.ajax({
                        url: '{{ route('product.action') }}',
                        data: {
                            idsArray: idsArray
                        },
                        method: 'POST',
                        typeData: 'json',
                        success: function(response) {
                            if (response.status == 200) {
                                $.each(response.ids, function(key, value) {
                                    $("#data-" + value).parents('tr').remove();
                                });
                                Swal.fire({
                                    position: "center",
                                    icon: "success",
                                    title: response.mess,
                                    showConfirmButton: false,
                                    timer: 2000
                                });
                            }
                            if(response.status == 302){
                                Swal.fire({
                                    position: "center",
                                    icon: "error",
                                    title: response.mess,
                                    showConfirmButton: false,
                                    timer: 2000
                                });
                            }
                        },
                    });
                }
            });
        });
    </script>
@endsection
