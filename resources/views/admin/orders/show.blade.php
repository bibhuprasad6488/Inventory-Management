@extends('admin.layouts.app')

@section('title', 'Order Details')

@section('content')

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4 d-none">
        <div>
            <h4 class="mb-1">Retailer Details</h4>
            <p class="text-muted mb-0">
                View complete customer information
            </p>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('admin.retailers.edit', $order->id) }}" class="btn btn-primary">
                <i class="fas fa-pencil me-1"></i>
                Edit
            </a>

            <a href="{{ route('admin.retailers.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i>
                Back
            </a>
        </div>
    </div>


    <div class="row g-4">

        {{-- Basic Information --}}
        <div class="col-lg-6">

            <div class="card h-100">

                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-receipt me-2"></i>
                        Order Information
                    </h5>
                </div>

                <div class="card-body">

                    {{-- <div class="row mb-3">
                            <div class="col-sm-5 text-muted">
                                Retailer ID
                            </div>
                            <div class="col-sm-7">
                                <strong>#{{ $order->id }}</strong>
                            </div>
                        </div> --}}

                    <div class="row mb-3">
                        <div class="col-sm-5 text-muted">
                            Order Number
                        </div>
                        <div class="col-sm-7">
                            <strong>
                                {{ $order->order_number ?? 'N/A' }}
                            </strong>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-5 text-muted">
                            Amount
                        </div>
                        <div class="col-sm-7">
                            {{ '₹' . $order->amount }}
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-5 text-muted">
                            Order Date
                        </div>
                        <div class="col-sm-7">
                            {{ \Carbon\Carbon::parse($order->order_date)->format('d-M-Y') }}
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-5 text-muted">
                            Mode of Payment
                        </div>
                        <div class="col-sm-7">

                            @if ($order->mode_of_payment == 'credit')
                                <span class="badge bg-primary">
                                    Credit
                                </span>
                            @elseif ($order->mode_of_payment == 'cash')
                                <span class="badge bg-primary">
                                    Cash
                                </span>
                            @endif

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-5 text-muted">
                            Status
                        </div>
                        <div class="col-sm-7">

                            @if ($order->status === 'pending')
                                <span class="badge bg-warning">
                                    Pending
                                </span>
                            @elseif ($order->status === 'approved')
                                <span class="badge bg-success">
                                    Approved
                                </span>
                            @else
                                <span class="badge bg-danger">
                                    Cancelled
                                </span>
                            @endif

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
                        Billing Information
                    </h5>
                </div>

                <div class="card-body">

                    <div class="row mb-3">
                        <div class="col-sm-5 text-muted">
                            Billing Name
                        </div>
                        <div class="col-sm-7">
                            {{ $order->retailer->billing_name ?? 'N/A' }}
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-5 text-muted">
                            Email Address
                        </div>
                        <div class="col-sm-7">
                            {{ $order->retailer->email ?? 'N/A' }}
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-5 text-muted">
                            Phone Number
                        </div>
                        <div class="col-sm-7">
                            {{ $order->retailer->phone ?? 'N/A' }}
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-5 text-muted">
                            Billing Address
                        </div>
                        <div class="col-sm-7">
                            {{ $order->retailer->billing_address ?? 'N/A' }}
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-5 text-muted">
                            GST Number
                        </div>
                        <div class="col-sm-7">
                            {{ $order->retailer->gst_number ?? 'N/A' }}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-5 text-muted">
                            Due Amount
                        </div>
                        <div class="col-sm-7">
                            <strong class="text-danger fs-5">
                                ₹{{ $order->retailer->due_amount }}
                            </strong>
                        </div>
                    </div>

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
                        <table class="table table-bordered table-striped">
                            <thead>
                                <th>Product Name</th>
                                <th>Pack Size</th>
                                <th>Quantity</th>
                                <th>Price</th>
                            </thead>
                            <tbody>
                                @foreach ($order->orderDetails as $product)
                                    <tr>
                                        <td>{{ $product->product_name }}</td>
                                        <td>{{ $product->pack_size }}</td>
                                        <td>{{ $product->qty }}</td>
                                        <td>₹{{ $product->qty * $product->cost_price }}</td>
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
