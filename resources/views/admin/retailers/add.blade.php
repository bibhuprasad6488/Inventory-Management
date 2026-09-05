@extends('admin.layouts.app')
@section('title', 'Add Retailer')
@section('content')

    <div class="row">
        <div class="col-md-8 mx-auto">
            <form action="{{ route('admin.retailers.store') }}" method="POST" enctype="multipart/form-data" id="catUploadForm">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title text-center">Add Retailer</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group row  mb-2">
                            <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                Billing Name
                            </label>
                            <div class="col-md-8 col-sm-6 col-xs-12">
                                <input type="hidden" name="role_id" value="2">
                                <input type="text" name="billing_name" id="billing_name" class="form-control"
                                    value="{{ old('billing_name') }}" placeholder="Billing Name" required>
                            </div>
                        </div>
                        <div class="form-group row  mb-2">
                            <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                Email Address
                            </label>
                            <div class="col-md-8 col-sm-6 col-xs-12">
                                <input type="email" name="email" id="email" class="form-control"
                                    value="{{ old('email') }}" placeholder="Email Address" required>
                            </div>
                        </div>
                        <div class="form-group row  mb-2">
                            <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                Phone Number
                            </label>
                            <div class="col-md-8 col-sm-6 col-xs-12">
                                <input type="text" name="phone" id="phone" class="form-control"
                                    value="{{ old('phone') }}" placeholder="Phone Number" required>
                            </div>
                        </div>
                        <div class="form-group row  mb-2">
                            <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                GST Number
                            </label>
                            <div class="col-md-8 col-sm-6 col-xs-12">
                                <input type="text" name="gst_number" id="gst_number" class="form-control"
                                    value="{{ old('gst_number') }}" placeholder="GST Number" required>
                            </div>
                        </div>

                        <div class="form-group row  mb-2">
                            <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                Billing Address
                            </label>
                            <div class="col-md-8 col-sm-6 col-xs-12">
                                <textarea name="billing_address" id="billing_address" rows="3" class="form-control" placeholder="Billing Address">{{ old('billing_address') }}</textarea>
                            </div>
                        </div>

                        <div class="form-group row  mb-2">
                            <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                Password
                            </label>
                            <div class="col-md-8 col-sm-6 col-xs-12">
                                <input type="password" name="password" id="new_password" class="form-control"
                                    placeholder="Password" required>
                            </div>
                        </div>
                        <div class="form-group row  mb-2">
                            <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                Confirm Password
                            </label>
                            <div class="col-md-8 col-sm-6 col-xs-12">
                                <input type="password" name="confirm_password" id="confirm_password" class="form-control"
                                    placeholder="Confirm password" required>

                                <div class="form-grou my-2">
                                    <label class="form-check-label" for="showPasswords">
                                        <input class="form-check-input" type="checkbox" id="showPasswords">
                                        Show passwords
                                    </label>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="form-group row  mb-2">
                            <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                Status
                            </label>
                            <div class="col-md-8 col-sm-6 col-xs-12">
                                <select name="status" id="status" class="form-control">
                                    <option value="active" selected>Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                        </div> --}}
                        <div class="row">
                            <label class=" col-form-label"></label>
                            <div class="d-flex justify-content-center">
                                <div class="d-md-flex d-grid align-items-center gap-3">
                                    <button type="submit" id="uploadBtn" class="btn btn-primary px-4"
                                        name="submit2">Save</button>
                                    <a href="{{ route('admin.retailers.index') }}" class="btn btn-secondary px-4">Back</a>
                                </div>
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
        document.getElementById('showPasswords').addEventListener('change', function() {

            const passwordFields = document.querySelectorAll(
                '#current_password, #new_password, #confirm_password'
            );

            passwordFields.forEach(function(field) {

                field.type = this.checked ? 'text' : 'password';

            }, this);

        });
    </script>
    <script>
        $(document).ready(function() {
            initializeSelect2('.add-cat, .add-size');
        })
    </script>
@endpush
