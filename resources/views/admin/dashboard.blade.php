@extends('admin.layouts.app')
@section('title', 'Dashboard')
@section('content')
    <style>
        .new-orders {
            animation: blink 1s infinite;
            color: #ff0000;
        }

        @keyframes blink {

            0%,
            50% {
                opacity: 1;
            }

            51%,
            100% {
                opacity: 0;
            }
        }
    </style>
    <h1>Welcome, {{ auth()->user()->billing_name }}</h1>
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
        {{-- <div>
            <h3 class="fw-bold mb-3">Dashboard</h3>
            <a href="{{ route('admin.orders.index') }}" class="{{ $latestOrders > 0 ? 'new-orders' : 'd-none' }} fs-2">
                You have {{ $latestOrders }} New Orders
            </a>
        </div> --}}
        {{-- <div class="ms-md-auto py-2 py-md-0">
            <a href="#" class="btn btn-label-info btn-round me-2">Manage</a>
            <a href="#" class="btn btn-primary btn-round">Add Customer</a>
        </div> --}}
    </div>
    <div class="row">
        <div class="col-sm-12 text-center mb-4">
            <h2 class="fw-bold fs-3">Total Order Amount</h2>
            <h3 class="fw-bold fs-4">
                ₹{{ number_format($totalOrderAmount, 2) }}
            </h3>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <a href="{{ route('admin.retailers.index') }}">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-primary bubble-shadow-small">
                                    <i class="fas fa-users"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Retailers</p>
                                    <h4 class="card-title">{{ count($retailers) }}</h4>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <a href="{{ route('admin.categories.index') }}">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-info bubble-shadow-small">
                                    <i class="fas fa-crosshairs"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Categories</p>
                                    <h4 class="card-title">{{ count($categories) }}</h4>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <a href="{{ route('admin.products.index') }}">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-secondary bubble-shadow-small">
                                    <i class="fas fa-crosshairs"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Products</p>
                                    <h4 class="card-title">{{ count($products) }}</h4>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <a href="{{ route('admin.orders.index') }}">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-success bubble-shadow-small">
                                    <i class="fas fa-luggage-cart"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">New Order </p>
                                    <h4 class="card-title">{{ $latestOrders }}</h4>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

@endsection
