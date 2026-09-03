@extends('admin.layouts.app')
@section('title', 'Add Stocks')
@section('content')
    <div class="row">
        <div class="col-md-10 mx-auto">
            <form action="{{ route('admin.stocks.store') }}" method="POST" enctype="multipart/form-data" id="stockForm"> @csrf
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title text-center">Add Stocks</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered align-middle" id="stockTable">
                            <thead>
                                <tr>
                                    <th width="55%">Product</th>
                                    <th width="30%">Stock Qty</th>
                                    <th width="15%" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody id="stockTableBody">
                                <tr class="stock-row">
                                    <td> <select name="p_id[]" class="form-control product-select" required>
                                            <option value="" selected disabled> Select Product </option>
                                            @foreach ($products as $p)
                                                <option value="{{ $p->id }}"> {{ ucfirst($p->product_name) }}
                                                    {{ $p->packSize?->qty }} </option>
                                            @endforeach
                                        </select> </td>
                                    <td> <input type="number" class="form-control" name="stocks[]" placeholder="Stock Qty"
                                            min="1" required> </td>
                                    <td class="text-center"> <button type="button" class="btn btn-sm btn-primary addBtn"> +
                                        </button> </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="row mt-4">
                            <div class="d-flex justify-content-center">
                                <div class="d-md-flex d-grid align-items-center gap-3"> <button type="submit"
                                        id="uploadBtn" class="btn btn-primary px-4"> Save </button> <a
                                        href="{{ route('admin.stocks.index') }}" class="btn btn-secondary px-4"> Reset </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('styles')
    <style>
        .select2-container {
            width: 100% !important;
        }

        .select2-container .select2-selection--single {
            height: 38px;
            padding: 5px 10px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 36px;
        }
    </style>
@endpush
@push('scripts')
    <script>
        $(document).ready(function() {

            function initializeSelect2(element) {
                $(element).select2({
                    placeholder: 'Search and select product',
                    allowClear: true,
                    width: '100%'
                });
            }

            initializeSelect2('.product-select');

            function updateProductOptions() {

                let selectedProducts = [];

                // Get all selected products
                $('.product-select').each(function() {

                    let value = $(this).val();

                    if (value) {
                        selectedProducts.push(value);
                    }

                });


                // Disable selected products in other dropdowns
                $('.product-select').each(function() {

                    let currentSelect = $(this);
                    let currentValue = currentSelect.val();

                    currentSelect.find('option').each(function() {

                        let option = $(this);
                        let optionValue = option.val();

                        if (!optionValue) {
                            return;
                        }

                        // Disable if selected somewhere else
                        if (
                            selectedProducts.includes(optionValue) &&
                            optionValue !== currentValue
                        ) {

                            option.prop('disabled', true);

                        } else {

                            option.prop('disabled', false);

                        }

                    });

                    // Refresh Select2
                    currentSelect.trigger('change.select2');

                });
            }



            $(document).on('change', '.product-select', function() {
                updateProductOptions();
            });
            $(document).on('click', '.addBtn', function() {

                let newRow = `
        <tr class="stock-row">

            <td>
                <select name="p_id[]"
                        class="form-control product-select"
                        required>

                    <option value="" selected disabled>
                        Select Product
                    </option>

                    @foreach ($products as $p)
                        <option value="{{ $p->id }}">
                            {{ ucfirst($p->product_name) }}
                            {{ $p->packSize?->qty }}
                        </option>
                    @endforeach

                </select>
            </td>

            <td>
                <input type="number"
                       class="form-control"
                       name="stocks[]"
                       placeholder="Stock Qty"
                       min="1"
                       required>
            </td>

            <td class="text-center">

                <button type="button"
                        class="btn btn-sm btn-danger removeBtn">
                    −
                </button>

            </td>

        </tr>
    `;

                $('#stockTableBody').append(newRow);

                // Get the newly added select
                let newSelect = $('#stockTableBody .stock-row:last .product-select');

                // Initialize Select2
                initializeSelect2(newSelect);

                // Disable products already selected in other rows
                updateProductOptions();
            });

            $(document).on('click', '.removeBtn', function() {
                $(this).closest('.stock-row').remove();
                updateProductOptions();
            });

            $('#stockForm').on('submit', function(e) {
                let valid = true;
                $('.stock-row').each(function() {
                    let product = $(this).find('.product-select').val();
                    let stock = $(this).find('input[name="stocks[]"]').val();
                    if (!product || !stock || stock <= 0) {
                        valid = false;
                        return false;
                    }
                });
                if (!valid) {
                    e.preventDefault();
                    alert('Please select a product and enter a valid stock quantity.');
                    return false;
                }
            });
        });
    </script>
@endpush
