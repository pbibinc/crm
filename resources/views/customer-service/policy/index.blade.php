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
                            <thead>
                                <th>Effective Date</th>
                                <th>Policy Number</th>
                                <th>Company Name</th>
                                <th>Product</th>
                                <th>Payment Mode</th>
                                <th>Insurer</th>
                                <th>Status</th>
                                <th>Action</th>
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
                ajax: "{{ route('bound-list') }}",
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
                        data: 'payment_mode',
                        name: 'payment_mode'
                    },
                    {
                        data: 'carrier',
                        name: 'carrier'
                    },
                    // {
                    //     data: 'requestedBy',
                    //     name: 'requestedBy'
                    // },
                    {
                        data: 'bind_status',
                        name: 'bind_status'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    }
                ],
                // "order": [
                //     [0, "desc"]
                // ]
            })
        });
    </script>
@endsection
