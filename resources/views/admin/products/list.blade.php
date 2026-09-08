@extends('admin.layouts.app')
@section('title', 'Products')
@section('content')

    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4 ">
        <div>
            <h3 class="fw-bold mb-3 d-none">Home Page</h3>
        </div>
        <div class="ms-md-auto py-2 py-md-0">
            <a href="{{ route('admin.products.create') }}" class="btn btn-primary">Add Product</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Products</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dataTable" class="display table table-striped table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>Sl.No</th>
                                    <th>Image</th>
                                    <th>HSN</th>
                                    <th>Name</th>
                                    <th>Stock</th>
                                    <th>MRP</th>
                                    <th>Selling Price</th>
                                    <th>Created Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $p)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <img @if ($p && $p->image) src="{{ $p->image }}"
                                        @else
                                            src="{{ asset('admin/img/no-img.png') }}" @endif
                                                alt="Partner" width="80" class="circle">
                                        </td>
                                        <td>{{ $p->hsn }}</td>
                                        <td>{{ ucfirst($p->product_name) }}</td>
                                        <td>{{ $p->stock }}</td>
                                        <td>{{ '₹' . $p->mrp }}</td>
                                        <td>{{ '₹' . $p->selling_price }}</td>
                                        <td>{{ \Carbon\Carbon::parse($p->created_at)->format('d-M-Y') }}</td>
                                        <td>
                                            @if ($p->status == 1)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-danger">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.products.edit', $p->id) }}"
                                                class="btn btn-success ">Edit</a>
                                            <form action="{{ route('admin.products.destroy', $p->id) }}" method="POST"
                                                style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger"
                                                    onclick="return confirm('Are you sure you want to delete this?');">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
