@extends('layouts.admin')
@section('content')
    <div class="content-wrapper">
        </form>
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid my-2">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Update Product</h1>
                    </div>
                    <div class="col-sm-6 text-right">
                        <a href="{{ route('product.index') }}" class="btn btn-primary">Back</a>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            <!-- Default box -->
            <form action="{{ route('product.update', $product->id) }}" method="post" id="form-create-product">
                @csrf
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="title">Title</label>
                                                <input type="text" name="title" id="title"
                                                    class="form-control @error('title') is-invalid @enderror"
                                                    placeholder="Title" value="{{ $product->name }}">
                                                @error('title')
                                                    <small class="invalid-feedback">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="slug">Slug</label>
                                                <input type="text" name="slug" id="slug"
                                                    class="form-control @error('slug') is-invalid @enderror"
                                                    value="{{ $product->slug }}" placeholder="Slug" readonly>
                                                @error('slug')
                                                    <small class="invalid-feedback">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="description">Description</label>
                                                <textarea name="description" id="description" cols="30" rows="10" class="my-editor" placeholder="Description">{{ $product->description }}</textarea>
                                                @error('description')
                                                    <small class="invalid-feedback">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="short_description">Short description</label>
                                                <textarea name="short_description" id="short_description" cols="30" rows="10" class="my-editor"
                                                    placeholder="Short description">{{ old('description') }}</textarea>
                                                @error('description')
                                                    <small class="invalid-feedback">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="shipping_returns">Shipping Returns</label>
                                                <textarea name="shipping_returns" id="shipping_returns" cols="30" rows="10" class="my-editor"
                                                    placeholder="Shipping returns">{{ old('description') }}</textarea>
                                                @error('description')
                                                    <small class="invalid-feedback">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h2 class="h4 mb-3">Media</h2>
                                    <div id="image" class="dropzone dz-clickable">
                                        <div class="dz-message needsclick">
                                            <br>Drop files here or click to upload.<br><br>
                                        </div>
                                        <p class="name-image"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="product-gallery">
                                @if ($product->productImage->isNotEmpty())
                                    @foreach ($product->productImage as $image)
                                        <div class="col-md-4" id="data-id-{{ $image->id }}">
                                            <div class="card">
                                                {{-- <input type='hidden' name='image_array[]' value='{{ $image->id }}' id="image-update"/> --}}
                                                <img src="{{ asset('images/thumbnail/' . $image->image) }}"
                                                    class="card-img-top" alt="...">
                                                <div class="card-body">
                                                    <a href="#" data="{{ route('temp.delete', $image->id) }}"
                                                        class="btn btn-danger image-delete">Delete</a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h2 class="h4 mb-3">Pricing</h2>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="price">Price</label>
                                                <input type="text" name="price" id="price"
                                                    class="form-control @error('price') is-invalid @enderror"
                                                    placeholder="Price" value="{{ $product->price }}">
                                                @error('price')
                                                    <small class="invalid-feedback">{{ $message }}</small>
                                                @enderror

                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="compare_price">Compare at Price</label>
                                                <input type="text" name="compare_price" id="compare_price"
                                                    class="form-control" placeholder="Compare Price"
                                                    value="{{ $product->compare_price }}">
                                                <p class="text-muted mt-3">
                                                    To show a reduced price, move the product’s original price into Compare
                                                    at
                                                    price. Enter a lower value into Price.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h2 class="h4 mb-3">Inventory</h2>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="sku">SKU (Stock Keeping Unit)</label>
                                                <input type="text" name="sku" id="sku"
                                                    class="form-control @error('sku') is-invalid @enderror"
                                                    placeholder="sku" value="{{ $product->sku }}">
                                                @error('sku')
                                                    <small class="invalid-feedback">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="barcode">Barcode</label>
                                                <input type="text" name="barcode" id="barcode" class="form-control"
                                                    placeholder="Barcode" value="{{ $product->barcode }}">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox" id="track_qty"
                                                        name="track_qty" checked>
                                                    <label for="track_qty" class="custom-control-label">Track
                                                        Quantity</label>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <input type="number" min="0" name="qty" id="qty"
                                                    class="form-control @error('qty') is-invalid @enderror"
                                                    placeholder="Qty" value="{{ $product->track_qty }}">
                                                @error('qty')
                                                    <small class="invalid-feedback">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h2 class="h4 mb-3">Related products</h2>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <select multiple name="related_products[]" id="select2"
                                                    class="form-control">
                                                    @if ($relatedProducts->isNotEmpty())
                                                        @foreach ($relatedProducts as $product)
                                                            <option selected value="{{ $product->id }}">{{ $product->name }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h2 class="h4 mb-3">Product status</h2>
                                    <div class="mb-3">
                                        <select name="status" id="status"
                                            class="form-control @error('status') is-invalid @enderror">
                                            <option value="1" {{ $product->status == 1 ? 'selected' : '' }}>Active
                                            </option>
                                            <option value="0" {{ $product->status == 0 ? 'selected' : '' }}>Block
                                            </option>
                                        </select>
                                        @error('status')
                                            <small class="invalid-feedback">{{ $message }}</small>
                                        @enderror

                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <h2 class="h4  mb-3">Product category</h2>
                                    <div class="mb-3">
                                        <label for="category">Category</label>
                                        <select name="category" id="category"
                                            class="form-control @error('category') is-invalid @enderror">
                                            <option value="">Select a Category</option>
                                            @if ($categories->isNotEmpty())
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}"
                                                        {{ $product->cat_id == $category->id ? 'selected' : '' }}>
                                                        {{ $category->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        @error('category')
                                            <small class="invalid-feedback">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="category">Sub category</label>
                                        <select name="sub_category" id="sub_category"
                                            class="form-control @error('sub_category') is-invalid @enderror">
                                            <option value="">Select a SubCategory</option>
                                            @foreach ($categories as $category)
                                                @if ($category->children->isNotEmpty())
                                                    @foreach ($category->children as $categoryChildren)
                                                        <option value="{{ $categoryChildren->id }}"
                                                            {{ $categoryChildren->id == $product->subcat_id ? 'selected' : '' }}>
                                                            {{ $categoryChildren->name }}</option>
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        </select>
                                        @error('sub_category')
                                            <small class="invalid-feedback">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h2 class="h4 mb-3">Product brand</h2>
                                    <div class="mb-3">
                                        <select name="brand" id="brand"
                                            class="form-control @error('brand') is-invalid @enderror">
                                            <option value="">Select a Brand</option>
                                            @if ($brands->isNotEmpty())
                                                @foreach ($brands as $brand)
                                                    <option value="{{ $brand->id }}"
                                                        {{ $product->brand_id == $brand->id ? 'selected' : '' }}>
                                                        {{ $brand->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        @error('brand')
                                            <small class="invalid-feedback">{{ $message }}</small>
                                        @enderror

                                    </div>
                                </div>
                            </div>
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h2 class="h4 mb-3">Featured product</h2>
                                    <div class="mb-3">
                                        <select name="featured" id="featured" class="form-control">
                                            <option value="0" {{ $product->status == 0 ? 'selected' : '' }}>No
                                            </option>
                                            <option value="1" {{ $product->status == 1 ? 'selected' : '' }}>Yes
                                            </option>
                                        </select>
                                        @error('featured')
                                            <small class="invalid-feedback">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pb-5 pt-3">
                        <button class="btn btn-primary btn-create">Update</button>
                        <a href="{{ route('product.index') }}" class="btn btn-outline-dark ml-3">Cancel</a>
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
        $('#select2').select2({
            ajax: {
                url: '{{ route('product.getProducts') }}',
                dataType: 'json',
                tags: true,
                multiple: true,
                minimumInputLength: 3,
                processResults: function(data) {
                    return {
                        results: data.tags
                    };
                }
            }
        });
        Dropzone.autoDiscover = false;
        const dropzone = $("#image").dropzone({
            url: '{{ route('temp') }}',
            maxFiles: 4,
            paramName: 'image',
            addRemoveLinks: true,
            acceptedFiles: "image/jpeg,image/png,image/gif",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(file, response) {
                if (response.status == 200) {
                    var html = `
                    <div class="col-md-4" id="data-id-${response.image_id}">
                        <div class="card">
                            <input type='hidden' name='image_array[]' value='${response.image_id}'/>
                            <img src="${response.pathImg}" class="card-img-top" alt="...">
                        <div class="card-body">
                                <a href="javasrcipt:void(0)" onclick="deleteImageTemp(${response.image_id})" class="btn btn-danger image-delete">Delete</a>
                        </div>
                        </div>
                    </div>`;
                    $("#product-gallery").append(html);
                    this.removeFile(file);
                }

            }
        });

        function deleteImageTemp(id) {
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
                    const srcImage = $("#data-id-" + id).children().find('img').attr('src');
                    $.ajax({
                        url: '{{ route('temp.delete-temp') }}',
                        data: {
                            srcImage: srcImage,
                            id: id
                        },
                        method: 'get',
                        dataType: 'json',
                        success: function(response) {
                            if (response.status == 200) {
                                // $("#data-id-" + id).remove();
                                alert(response.id + response.srcImage)
                            }

                        }
                    });
                }
            });
        }
        $(".image-delete").click(function(e) {
            e.preventDefault();
            let urlRequest = $(this).attr('data');
            let element = $(this);
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
                    $.ajax({
                        url: urlRequest,
                        method: 'get',
                        success: function(response) {
                            $("#data-id-" + response.id).remove();
                            Swal.fire({
                                title: "Deleted!",
                                text: "Your file has been deleted.",
                                icon: "success"
                            });
                        }
                    });

                }
            });

        });

        $("#title").on('input', function() {
            var data = $(this);
            $.ajax({
                url: '{{ route('getSlug') }}',
                data: data,
                method: 'get',
                success: function(response) {
                    $("#slug").val(response.slug);
                }
            });
        });
        $("#category").change(function() {
            var category_id = $(this).val();
            data = {
                category_id: category_id
            };
            $.ajax({
                url: '{{ route('product.getSubCategory') }}',
                data: data,
                method: 'get',
                success: function(response) {
                    if (response.subCategory) {
                        $("#sub_category").find('option').not(":first").remove();
                        $.each(response.subCategory, function(key, value) {
                            $("#sub_category").append(
                                `<option value='${value.id}'>${value.name}</option>`
                            );
                        });
                    }
                    if (response.null == null && response.status == 500) {
                        $("#sub_category").find('option').not(":first").remove();
                    }
                }

            });
        });
    </script>
@endsection
