@extends('admin.admin_master')
@section('admin')
    <div class="page-content pt-6">
        <div class="container-fluid">
            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <table id="bound-list-data-table"
                            class="table table-bordered dt-responsive nowrap bound-list-data-table"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead style="background-color: #f0f0f0;">
                                <th>Effective Date</th>
                                <th>Policy Number</th>
                                <th>Company Name</th>
                                <th>Product</th>
                                <th>Market</th>
                                <th>Insurer</th>
                                <th>Total Cost</th>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#bound-list-data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                            'content')
                    },
                    url: "{{ route('policy-list') }}",
                    data: {
                        _token: "{{ csrf_token() }}",
                    }
                },
                columns: [{
                        data: 'effective_date',
                        name: 'effective_date'
                    },
                    {
                        data: 'policy_number',
                        name: 'policy_number'
                    },
                    {
                        data: 'company_name',
                        name: 'company_name'
                    },
                    {
                        data: 'product',
                        name: 'product'
                    },
                    {
                        data: 'market',
                        name: 'market'
                    },
                    {
                        data: 'carrier',
                        name: 'carrier'
                    },
                    {
                        data: 'total_cost',
                        name: 'total_cost'
                    }
                ],
                // "order": [
                //     [0, "desc"]
                // ]
            })
        });
    </script>
@endsection
