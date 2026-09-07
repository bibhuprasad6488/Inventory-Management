@extends('admin.layouts.app')
@section('title', 'Stocks')
@section('content')


    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Stocks</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dataTable1" class="display table table-striped table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>Sl.No</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Stock</th>
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
                                        <td>{{ ucfirst($p->product_name). ' '. $p->packSize->qty }}</td>
                                        <td>{{ $p->stock }}</td>
                                        <td>
                                            <a href="{{ route('admin.stocks.show', $p->id) }}"
                                                class="btn btn-info ">View Details</a>

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
@push('scripts')
<script>
    window.addEventListener('DOMContentLoaded', event => {
            const datatablesSimple = document.getElementById('dataTable1');

            if (datatablesSimple) {

                let tableKey = 'datatable_page_' + window.location.pathname;

                // // Clear saved page on manual browser refresh
                // if (performance.navigation.type === 1) {
                //     sessionStorage.removeItem(tableKey);
                // }


                const table = new simpleDatatables.DataTable(datatablesSimple, {
                    perPage: 50,
                    perPageSelect: [5, 10, 25, 50, 100]
                });


                // Restore page after update
                let savedPage = sessionStorage.getItem(tableKey);

                if (savedPage) {
                    setTimeout(() => {
                        table.page(parseInt(savedPage));

                        // keep it for next edit
                    }, 200);
                }


                // Track current page
                table.on('datatable.page', function(page) {
                    sessionStorage.setItem(tableKey, page);
                });


                // Clear when leaving this listing normally
                document.querySelectorAll('a').forEach(link => {

                    link.addEventListener('click', function() {

                        let target = this.href;

                        if (!target.includes(window.location.pathname)) {
                            sessionStorage.removeItem(tableKey);
                        }

                    });

                });

            }
        });
</script>
@endpush
