@extends('admin.layouts.app')

@section('title', 'Retailer Details')

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
                <a href="{{ route('admin.retailers.edit', $retailer->id) }}" class="btn btn-primary">
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
                            <i class="fas fa-user me-2"></i>
                            Basic Information
                        </h5>
                    </div>

                    <div class="card-body">

                        {{-- <div class="row mb-3">
                            <div class="col-sm-5 text-muted">
                                Retailer ID
                            </div>
                            <div class="col-sm-7">
                                <strong>#{{ $retailer->id }}</strong>
                            </div>
                        </div> --}}

                        <div class="row mb-3">
                            <div class="col-sm-5 text-muted">
                                Billing Name
                            </div>
                            <div class="col-sm-7">
                                {{ $retailer->billing_name ?? 'N/A' }}
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-5 text-muted">
                                Email
                            </div>
                            <div class="col-sm-7">
                                {{ $retailer->email ?? 'N/A' }}
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-5 text-muted">
                                Phone
                            </div>
                            <div class="col-sm-7">
                                {{ $retailer->phone ?? 'N/A' }}
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-5 text-muted">
                                Role
                            </div>
                            <div class="col-sm-7">

                                @if ($retailer->role_id == 1)
                                    <span class="badge bg-danger">
                                        Admin
                                    </span>
                                @elseif ($retailer->role_id == 2)
                                    <span class="badge bg-primary">
                                        Retailer
                                    </span>
                                @else
                                    <span class="badge bg-secondary">
                                        Unknown
                                    </span>
                                @endif

                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-5 text-muted">
                                Status
                            </div>
                            <div class="col-sm-7">

                                @if ($retailer->status === 'active')
                                    <span class="badge bg-success">
                                        Active
                                    </span>
                                @else
                                    <span class="badge bg-danger">
                                        Inactive
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
                                {{ $retailer->billing_name ?? 'N/A' }}
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-5 text-muted">
                                Billing Address
                            </div>
                            <div class="col-sm-7">
                                {{ $retailer->billing_address ?? 'N/A' }}
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-5 text-muted">
                                GST Number
                            </div>
                            <div class="col-sm-7">
                                {{ $retailer->gst_number ?? 'N/A' }}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-5 text-muted">
                                Due Amount
                            </div>
                            <div class="col-sm-7">
                                <strong class="text-danger fs-5">
                                    ₹{{ number_format($retailer->due_amount ?? 0, 2) }}
                                </strong>
                            </div>
                        </div>

                    </div>
                </div>

            </div>


            {{-- Account Information --}}
            <div class="col-lg-6">

                <div class="card">

                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-info-circle me-2"></i>
                            Account Information
                        </h5>
                    </div>

                    <div class="card-body">

                        <div class="row mb-3">
                            <div class="col-sm-5 text-muted">
                                Email Verification
                            </div>

                            <div class="col-sm-7">

                                @if ($retailer->email_verified_at)
                                    <span class="badge bg-success">
                                        Verified
                                    </span>

                                    <small class="text-muted d-block mt-1">
                                        {{ $retailer->email_verified_at->format('d M Y, h:i A') }}
                                    </small>
                                @else
                                    <span class="badge bg-warning text-dark">
                                        Not Verified
                                    </span>
                                @endif

                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-5 text-muted">
                                Registered On
                            </div>

                            <div class="col-sm-7">
                                {{ $retailer->created_at ? $retailer->created_at->format('d M Y, h:i A') : 'N/A' }}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-5 text-muted">
                                Last Updated
                            </div>

                            <div class="col-sm-7">
                                {{ $retailer->updated_at ? $retailer->updated_at->format('d M Y, h:i A') : 'N/A' }}
                            </div>
                        </div>

                    </div>
                </div>

            </div>


            {{-- Address --}}
            <div class="col-lg-6">

                <div class="card">

                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-geo-alt me-2"></i>
                            Address
                        </h5>
                    </div>

                    <div class="card-body">

                        @if ($retailer->billing_address)
                            <p class="mb-0">
                                {{ $retailer->billing_address }}
                            </p>
                        @else
                            <p class="text-muted mb-0">
                                No billing address available.
                            </p>
                        @endif

                    </div>

                </div>

            </div>

        </div>


@endsection
