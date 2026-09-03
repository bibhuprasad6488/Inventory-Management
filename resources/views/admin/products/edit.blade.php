@extends('admin.layouts.app')
@section('title', 'Edit Product')
@section('content')

    <div class="row">
        <div class="col-md-8 mx-auto">
            <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" id="catUploadForm">
                @csrf
                @method('PUT')
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title text-center">Edit Product</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group row  mb-2">
                            <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                Category
                            </label>
                            <div class="col-md-8 col-sm-6 col-xs-12">
                                <select name="category_id" id="category_id" class="form-control" required>
                                    <option value="" selected disabled>Select Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                            {{ ucfirst($category->title) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row  mb-2">
                            <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                Product Name
                            </label>
                            <div class="col-md-8 col-sm-6 col-xs-12">
                                <input type="text" name="product_name" id="product_name" class="form-control"
                                    value="{{ $product->product_name }}" placeholder="Product Name" required>
                            </div>
                        </div>
                        <div class="form-group row  mb-2">
                            <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                HSN
                            </label>
                            <div class="col-md-8 col-sm-6 col-xs-12">
                                <input type="text" name="hsn" id="hsn" class="form-control"
                                    value="{{ $product->hsn }}" placeholder="HSN" required>
                            </div>
                        </div>
                        <div class="form-group row  mb-2">
                            <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                Size
                            </label>
                            <div class="col-md-8 col-sm-6 col-xs-12">
                                <select name="pack_size" id="pack_size" class="form-control" required>
                                    <option value="" selected disabled>Select Size</option>
                                    @foreach ($packSizes as $pack)
                                        <option value="{{ $pack->id }}"
                                            {{ $product->pack_size == $pack->id ? 'selected' : '' }}>
                                            {{ ucfirst($pack->qty) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row  mb-2">
                            <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                MRP
                            </label>
                            <div class="col-md-8 col-sm-6 col-xs-12">
                                <input type="text" name="mrp" id="mrp" class="form-control"
                                    value="{{ $product->mrp }}" placeholder="MRP" required>
                            </div>
                        </div>
                        <div class="form-group row  mb-2">
                            <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                Cost Price
                            </label>
                            <div class="col-md-8 col-sm-6 col-xs-12">
                                <input type="text" name="cost_price" id="cost_price" class="form-control"
                                    value="{{ $product->cost_price }}" placeholder="Cost price" required>
                            </div>
                        </div>
                        <div class="form-group row  mb-2">
                            <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                Selling Price
                            </label>
                            <div class="col-md-8 col-sm-6 col-xs-12">
                                <input type="text" name="selling_price" id="selling_price" class="form-control"
                                    value="{{ $product->selling_price }}" placeholder="Selling price" required>
                            </div>
                        </div>
                        <div class="form-group row  mb-2">
                            <div class="col-md-12 d-flex justify-content-center">
                                @error('img_path')
                                    <span class="text-danger" id="success-alert">{{ $message }}</span>
                                @enderror
                            </div>
                            <label for="Img" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                Image
                            </label>

                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="drop-area" data-input="image" data-preview="pImgPreview"
                                    data-default="{{ $product->image }}">
                                    <p>Drag & Drop Image Here or Click to Select</p>
                                    <input type="file" id="image" name="image" hidden
                                        accept=".jpg,.jpeg,.png,.webp">

                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <img src="" id="pImgPreview" width="100">
                            </div>
                        </div>

                        <div class="form-group row  mb-2">
                            <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                Description
                            </label>
                            <div class="col-md-8 col-sm-6 col-xs-12">
                                <textarea name="description" id="description" rows="10" class="form-control">{{ $product->description }}</textarea>
                            </div>
                        </div>

                        <div class="form-group row  mb-2">
                            <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                Status
                            </label>
                            <div class="col-md-8 col-sm-6 col-xs-12">
                                <select name="status" id="status" class="form-control">
                                    <option value="1" {{ $product->status == 1 ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ $product->status == 0 ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <label class=" col-form-label"></label>
                            <div class="d-flex justify-content-center">
                                <div class="d-md-flex d-grid align-items-center gap-3">
                                    <button type="submit" id="uploadBtn" class="btn btn-primary px-4"
                                        name="submit2">Update</button>
                                    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary px-4">Back</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
