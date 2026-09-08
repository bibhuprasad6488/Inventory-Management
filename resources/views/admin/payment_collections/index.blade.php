@extends('admin.layouts.app')

@section('title', 'Payment Collection')

@section('content')

    <div class="pt-2 pb-4">
        <div>
            <h1 class="fw-bold mb-3 text-center">Payment Collection</h1>
        </div>
    </div>

    <div class="row g-4">

        {{-- Search User --}}
        <div class="col-lg-6">
            <form id="userSearchForm" class="form-horizontal">
                @csrf

                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Search User Information</h4>
                    </div>

                    <div class="card-body">

                        <div class="form-group row mb-2">

                            <div class="col-md-8 col-sm-6 col-xs-12">

                                <input type="text" name="phone" id="phone" class="form-control"
                                    placeholder="Search by phone number" required>

                                <small id="searchError" class="text-danger d-none">
                                </small>

                            </div>

                            <div class="col-md-4 col-sm-6 col-xs-12">

                                <button type="submit" id="searchBtn" class="btn btn-primary px-4">

                                    <span id="searchBtnText">
                                        Search
                                    </span>

                                    <span id="searchLoader" class="spinner-border spinner-border-sm d-none" role="status">
                                    </span>

                                </button>

                            </div>

                        </div>

                    </div>
                </div>
            </form>
        </div>


        {{-- Billing Information --}}
        <div class="col-lg-6 d-none" id="detailsSection">

            <div class="card h-100">

                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-receipt me-2"></i>
                        Billing Information
                    </h5>
                </div>

                <div class="card-body">

                    {{-- User ID hidden --}}
                    <input type="hidden" id="user_id">

                    <div class="row mb-3">
                        <div class="col-sm-5 text-muted">
                            Billing Name
                        </div>

                        <div class="col-sm-7">
                            <span id="billingName">N/A</span>
                        </div>
                    </div>


                    <div class="row mb-3">
                        <div class="col-sm-5 text-muted">
                            Email Address
                        </div>

                        <div class="col-sm-7">
                            <span id="billingEmail">N/A</span>
                        </div>
                    </div>


                    <div class="row mb-3">
                        <div class="col-sm-5 text-muted">
                            Phone Number
                        </div>

                        <div class="col-sm-7">
                            <span id="billingPhone">N/A</span>
                        </div>
                    </div>


                    <div class="row mb-3">
                        <div class="col-sm-5 text-muted">
                            Billing Address
                        </div>

                        <div class="col-sm-7">
                            <span id="billingAddress">N/A</span>
                        </div>
                    </div>


                    <div class="row mb-3">
                        <div class="col-sm-5 text-muted">
                            GST Number
                        </div>

                        <div class="col-sm-7">
                            <span id="gstNumber">N/A</span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-5 text-muted">
                            Order ID
                        </div>

                        <div class="col-sm-7">
                            <span id="orderId">-</span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-5 text-muted">
                            Order Number
                        </div>

                        <div class="col-sm-7">
                            <span id="orderNumber">-</span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-5 text-muted">
                            Order Date
                        </div>

                        <div class="col-sm-7">
                            <span id="orderDate">-</span>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-sm-5 text-muted">
                            Due Amount
                        </div>
                        <div class="col-sm-7">
                            <strong class="text-danger fs-5" id="dueAmount">₹0</strong>
                        </div>
                    </div>

                </div>
            </div>

        </div>

        {{-- Search User --}}
        <div class="col-lg-10 d-none" id="collectSection">
            <form action="" method="POST" class="form-horizontal">
                @csrf

                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Collect Payment</h4>
                    </div>

                    <div class="card-body">

                        <div class="form-group row mb-2">

                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <input type="hidden" id="form_user_id" name="user_id" value="" required readonly>
                                <input type="hidden" id="form_order_id" name="order_id" value="" required readonly>
                                <input type="hidden" id="form_due_amount" name="due_amount" value="" required readonly>
                                <input type="text" id="form_order_number" name="order_number" class="form-control"
                                    value="" required readonly>

                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <input type="number" name="received_amount" id="received_amount" class="form-control"
                                    placeholder="Enter amount" required onchange="validateDueAmount()">

                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <select name="mode_of_payment" id="mode_of_payment" class="form-control" required>
                                    <option value="" disabled selected> Mode of Payment</option>
                                    <option value="cash">Cash</option>
                                    <option value="upi">UPI</option>
                                </select>

                            </div>

                            <div class="col-md-3 col-sm-6 col-xs-12">

                                <button type="submit" class="btn btn-primary px-4">
                                    Update
                                </button>

                            </div>

                        </div>

                    </div>
                </div>

            </form>
        </div>
    </div>
@endsection


@push('scripts')
    <script>
        $(document).ready(function() {

            $('#userSearchForm').on('submit', function(e) {
                e.preventDefault();
                let phone = $('#phone').val().trim();
                $('#searchError')
                    .addClass('d-none')
                    .text('');

                if (!phone) {

                    $('#searchError')
                        .removeClass('d-none')
                        .text('Please enter phone number.');

                    return;
                }


                // Loading
                $('#searchBtn').prop('disabled', true);

                $('#searchBtnText').text('Searching...');

                $('#searchLoader').removeClass('d-none');


                $.ajax({

                    url: "{{ route('admin.retailers.search') }}",

                    type: "POST",

                    data: {

                        _token: "{{ csrf_token() }}",

                        phone: phone

                    },


                    success: function(response) {
                        if (!response.success) {
                            $('#searchError')
                                .removeClass('d-none')
                                .text(response.message || 'User not found.');

                            return;
                        }

                        let user = response.user;

                        $('#user_id').val(user.id ?? '');
                        $('#form_user_id').val(user.id ?? '');

                        $('#billingName').text(user.name ?? 'N/A');

                        $('#billingEmail').text(user.email ?? 'N/A');

                        $('#billingPhone').text(user.phone ?? 'N/A');

                        $('#billingAddress').text(user.billing_address ?? 'N/A');

                        $('#gstNumber').text(user.gst_number ?? 'N/A');
                        $('#dueAmount').text('₹' + (user.due_amount ?? 0));
                        $('#form_due_amount').val(user.due_amount ?? 0);


                        /*
                        |--------------------------------------------------------------------------
                        | Last Order
                        |--------------------------------------------------------------------------
                        */

                        let order = response.last_order;
                        if (user.due_amount > 0) {
                            $('#collectSection').removeClass('d-none');
                        } else {
                            $('#collectSection').addClass('d-none');
                        }

                        if (order) {

                            $('#detailsSection').removeClass('d-none');
                            $('#orderId').text(order.id ?? '-');
                            $('#form_order_id').val(order.id ?? '');
                            $('#orderNumber').text(order.order_number ?? '-');
                            $('#form_order_number').val(order.order_number ?? '');
                            $('#orderDate').text(order.created_at ?? '-');

                            // $('#orderStatus')
                            //     .text(order.status ?? '-');


                            /*
                            |--------------------------------------------------------------------------
                            | Due Amount
                            |--------------------------------------------------------------------------
                            */

                            // $('#dueAmount')
                            //     .text('₹' + (order.due_amount ?? 0));

                        } else {

                            $('#detailsSection').addClass('d-none');

                            $('#dueAmount').text('₹0');
                        }

                    },


                    error: function(xhr) {

                        let message = 'Something went wrong. Please try again.';

                        if (xhr.status === 404) {

                            message =
                                xhr.responseJSON?.message ||
                                'User not found.';

                        }

                        if (xhr.status === 422) {

                            message =
                                xhr.responseJSON?.message ||
                                'Please enter a valid phone number.';

                        }


                        $('#searchError')
                            .removeClass('d-none')
                            .text(message);

                    },


                    complete: function() {

                        $('#searchBtn').prop('disabled', false);

                        $('#searchBtnText').text('Search');

                        $('#searchLoader').addClass('d-none');

                    }

                });

            });

        });


        function validateDueAmount() {
            let dueAmount = parseFloat($('#form_due_amount').val());
            let receivedAmount = parseFloat($('#received_amount').val());

            if (receivedAmount > dueAmount) {
                alert('Received amount cannot be greater than due amount.');
                $('#received_amount').val('');
            }
        }
    </script>
@endpush
