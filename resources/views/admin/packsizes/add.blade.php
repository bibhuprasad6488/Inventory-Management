@extends('admin.layouts.app')
@section('title', 'Add Pack Size')
@section('content')

    <div class="row">
        <div class="col-md-6 mx-auto">
            <form action="{{ route('admin.pack-sizes.store') }}" method="POST" enctype="multipart/form-data"
                id="catUploadForm">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Add Pack Size</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group row  mb-2">
                            <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                Quantity
                            </label>
                            <div class="col-md-8 col-sm-6 col-xs-12">
                                <input type="text" name="qty" id="qty" class="form-control" value=""
                                    placeholder="Quantity" required>
                            </div>
                        </div>
                        <div class="form-group row  mb-2">
                            <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                Status
                            </label>
                            <div class="col-md-8 col-sm-6 col-xs-12">
                                <select name="status" id="status" class="form-control">
                                    <option value="1" selected>Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <label class=" col-form-label"></label>
                            <div class="d-flex justify-content-center">
                                <div class="d-md-flex d-grid align-items-center gap-3">
                                    <button type="submit" id="uploadBtn" class="btn btn-primary px-4"
                                        name="submit2">Save</button>
                                    <a href="{{ route('admin.pack-sizes.index') }}" class="btn btn-secondary px-4">Back</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
