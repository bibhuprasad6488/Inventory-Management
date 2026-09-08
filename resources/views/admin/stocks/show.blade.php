@extends('admin.layouts.app')

@section('title', 'Stock Report')

@section('content')

    <div class=" pt-2 pb-4 ">
        <div>
            <h1 class="fw-bold mb-3 text-center">Stock Report</h1>
        </div>
    </div>
    <div class="row g-4">

        {{-- Basic Information --}}
        <div class="col-lg-6">

            <div class="card h-100">

                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-receipt me-2"></i>
                        Product Information
                    </h5>
                </div>

                <div class="card-body">

                    <div class="row mb-3">
                        <div class="col-sm-5 text-muted">
                            Product Name
                        </div>
                        <div class="col-sm-7">
                            <strong>
                                {{ $product->product_name . ' (' . $product->packSize->qty . ')' ?? 'N/A' }}
                            </strong>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-5 text-muted">
                            HSN Code
                        </div>
                        <div class="col-sm-7">
                            <strong>
                                {{ $product->hsn ?? 'N/A' }}
                            </strong>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-5 text-muted">
                            Category
                        </div>
                        <div class="col-sm-7">
                            {{ $product->category->title ?? 'N/A' }}
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-5 text-muted">
                            Stock
                        </div>
                        <div class="col-sm-7">
                            {{ $product->stock ?? 'N/A' }}
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-5 text-muted">
                            MRP
                        </div>
                        <div class="col-sm-7">
                            {{ '₹' . $product->mrp ?? 'N/A' }}
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-5 text-muted">
                            Selling Price
                        </div>
                        <div class="col-sm-7">
                            {{ '₹' . $product->selling_price ?? 'N/A' }}
                        </div>
                    </div>

                </div>
            </div>

        </div>


        {{-- Billing Information --}}
        <div class="col-lg-6">

            <div class="card h-100">

                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-receipt me-2"></i>
                        Product Image
                    </h5>
                </div>

                <div class="card-body">
                    <img src="{{ $product->image }}" alt="{{ $product->product_name }}" class="img-fluid" width="200">
                </div>
            </div>

        </div>



        {{-- Account Information --}}
        <div class="col-lg-12">

            <div class="card">

                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        Order Details
                    </h5>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dataTable" class="table table-bordered table-striped">
                            <thead>
                                <th>User</th>
                                <th>Ordered Qty</th>
                                <th>Date</th>
                                <th>Order Number</th>
                                <th>Status</th>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                    <tr>
                                        <td>{{ $order->user_name }}</td>
                                        <td>{{ $order->ordered_qty }}</td>
                                        <td>{{ $order->order_date }}</td>
                                        <td class="font-bold"><a href="{{ route('admin.orders.show', $order->id) }}"
                                                class="text-primary ">{{ '#' . $order->order_number }}</a>
                                        </td>
                                        <td>{{ ucfirst($order->status) }}</td>
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
