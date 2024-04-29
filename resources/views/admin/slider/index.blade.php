@extends('layouts.admin')
@section('nav')
    <div class="navbar-nav pl-2">
        <ol class="breadcrumb p-0 m-0 bg-white">
            <li class="breadcrumb-item"><a href="{{ route('slider.index') }}">Sliders</a></li>
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
                        <h1>Sliders</h1>
                    </div>
                    <div class="col-sm-6 text-right">
                        <a href="{{ route('slider.create') }}" class="btn btn-primary">New Slider</a>
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
                                    <input type="search" name="keyword" class="form-control float-right"
                                        placeholder="Search">
    
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                            </div>
                            <form action="" id="form-action-sliders">
                            <button type="button" class="btn btn-light" name="btn_rest"
                            onclick="window.location.href='{{ route('slider.index') }}'">Reset</button>
                            <button name="btn_deleted" class="btn btn-danger">Delete Sliders</button>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th width="100"><input type="checkbox" name="checkall" value=""></th>
                                    <th width="60">ID</th>
                                    <th>Title</th>
                                    <th>Link</th>
                                    <th width="100">Status</th>
                                    <th width="100">Action</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($sliders as $slider)
                                        <tr>
                                            <td><input type="checkbox" value="{{ $slider->id }}" id="data-id-{{ $slider->id }}"></td>
                                            <td>{{ $slider->id }}</td>
                                            <td>{{ $slider->title }}</td>
                                            <td>{{ $slider->link }}</td>
                                            <td>
                                                @if ($slider->status == 0)
                                                    <svg class="text-danger h-6 w-6" xmlns="http://www.w3.org/2000/svg"
                                                        fill="none" viewBox="0 0 24 24" stroke-width="2"
                                                        stroke="currentColor" aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z">
                                                        </path>
                                                    </svg>
                                                @else
                                                    <svg class="text-success-500 h-6 w-6 text-success"
                                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                        stroke-width="2" stroke="currentColor" aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('slider.edit', $slider->id) }}">
                                                    <svg class="filament-link-icon w-4 h-4 mr-1"
                                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                        fill="currentColor" aria-hidden="true">
                                                        <path
                                                            d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z">
                                                        </path>
                                                    </svg>
                                                </a>
                                                <a href="#" data={{ route('slider.delete', $slider->id) }}
                                                    class="text-danger w-4 h-4 mr-1 slider-delete">
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
                                @empty
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer clearfix">
                        {{ $sliders->links() }}
                    </div>
                </div>
            </div>
            </form>
            <!-- /.card -->
        </section>
        <!-- /.content -->
    </div>
@endsection
@section('js')
    <script>
        $("#form-action-sliders").submit(function(e){
            e.preventDefault();
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    const ids = $("input[type='checkbox']:checked");
                    const idArray = [];
                    $.each(ids, function (key, value){
                        return idArray.push(value.value);
                    });
                    $.ajax({
                        url: '{{ route('slider.deletes') }}',
                        method: 'POST',
                        data: {idArray: idArray},
                        typeData: 'json',
                        success: function(response) {
                            if (response.status == true) {
                                $.each(response.ids, function(key, value){
                                    $("#data-id-"+value).parents('tr').remove();
                                });
                                Swal.fire({
                                    title: "Deleted!",
                                    text: "Your sliders has been deleted.",
                                    icon: "success"
                                });
                            }
                            if (response.status == false) {
                                Swal.fire({
                                    icon: "error",
                                    title: "Sliders not found",
                                    text: "Something went wrong!",
                                });
                            }
                        }
                    });

                }
            });
        });
        $(".slider-delete").click(function(e) {
            e.preventDefault();
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    var urlRequest = $(this).attr('data');
                    var that = $(this);
                    $.ajax({
                        url: urlRequest,
                        method: 'get',
                        typeData: 'json',
                        success: function(response) {
                            if (response.status == true) {
                                that.parents('tr').remove();
                                Swal.fire({
                                    title: "Deleted!",
                                    text: response.mess,
                                    icon: "success"
                                });
                                if($(".slider-delete").length <= 0){
                                    window.location.href = '{{ route('slider.index') }}'
                                }
                            }
                            if (response.status == false) {
                                Swal.fire({
                                    icon: "error",
                                    title: response.mess,
                                    text: "Something went wrong!",
                                });
                            }
                        }
                    });

                }
            });

        });
    </script>
@endsection
