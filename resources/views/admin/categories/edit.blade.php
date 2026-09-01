@extends('admin.layouts.app')
@section('title', 'Add Categorry')
@section('content')

    <div class="row">
        <div class="col-md-6 mx-auto">
            <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data"
                id="catUploadForm">
                @csrf
                @method('PUT')
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Add Categorry</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group row  mb-2">
                            <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                Parent Category
                            </label>
                            <div class="col-md-8 col-sm-6 col-xs-12">
                                <select name="parent_category" id="parent_category" class="form-control">
                                    <option value="">Select Parent Category</option>
                                    @foreach ($pCategories as $c)
                                        <option value="{{ $c->id }}"
                                            {{ $category->parent_category == $c->id ? 'selected' : '' }}>
                                            {{ ucfirst($c->title) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row  mb-2">
                            <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                Title
                            </label>
                            <div class="col-md-8 col-sm-6 col-xs-12">
                                <input type="text" name="title" id="title" class="form-control"
                                    value="{{ $category->title }}" placeholder="Title" required>
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
                                <div class="drop-area" data-input="img_path" data-preview="catImgPreview"
                                    data-default="{{ $category->img_path }}">
                                    <p>Drag & Drop Image Here or Click to Select</p>
                                    <input type="file" id="img_path" name="img_path" hidden
                                        accept=".jpg,.jpeg,.png,.webp">

                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <img src="" id="catImgPreview" width="100">
                            </div>
                        </div>


                        <div class="form-group row  mb-2">
                            <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                Status
                            </label>
                            <div class="col-md-8 col-sm-6 col-xs-12">
                                <select name="status" id="status" class="form-control">
                                    <option value="1" {{ $category->status == 1 ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ $category->status == 0 ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <label class=" col-form-label"></label>
                            <div class="d-flex justify-content-center">
                                <div class="d-md-flex d-grid align-items-center gap-3">
                                    <button type="submit" id="uploadBtn" class="btn btn-primary px-4"
                                        name="submit2">Update</button>
                                    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary px-4">Back</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
