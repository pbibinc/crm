@extends('admin.admin_master')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <table id="dataTable" class="table table-bordered dt-responsive nowrap dataTable"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead style="background-color: #f0f0f0;">
                                <th>Policy Number</th>
                                <th>Company Name</th>
                                <th>Product</th>
                                <th>Financing Company</th>
                                <th>Auto Pay</th>
                                <th>Media</th>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('.dataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('finance-agreement-list.get-data-table') }}",
                    type: "POST",
                },
                columns: [{
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
                        data: 'financing_company',
                        name: 'financing_company'
                    },
                    {
                        data: 'auto_pay',
                        name: 'auto_pay'
                    },
                    {
                        data: 'media',
                        name: 'media'
                    }
                ],
            });
        })
    </script>
@endsection
