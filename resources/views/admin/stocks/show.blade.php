@extends('admin.layouts.app')

@section('title', 'Stock Report')

@section('content')

    <style>
        .datatable-table>tbody>tr>td.brdr {
            border: 1px solid #fff !important;
            color: #fff;
        }
    </style>
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
                            <strong class="btn btn-primary fs-2">
                                {{ $product->stock ?? 'N/A' }}
                            </strong>
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
                        History
                    </h5>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dataTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">Sl No.</th>
                                    <th class="text-center">Transaction Type</th>
                                    <th class="text-center">Qty</th>
                                    <th class="text-center">Reference</th>
                                    <th class="text-center">Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($stockRecords as $sr)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td class="{{ $sr->trans_type == 'credit' ? 'bg-success' : 'bg-danger brdr' }} text-center">
                                            {{ ucfirst($sr->trans_type) }}</td>
                                        <td class="text-center">{{ $sr->qty }}</td>
                                        <td class="text-center">{{ $sr->refrence }}</td>
                                        <td class="text-center">{{ \Carbon\Carbon::parse($sr->created_at)->format('d-M-Y') }}</td>
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
