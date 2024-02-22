@extends('admin.admin_master')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="card"
                    style=" box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05); border-radius: 10px; overflow: hidden;">
                    <div class="card-body">
                        <table id="dataTable" class="table table-bordered dt-responsive nowrap" style="width: 100%;">
                            <thead>
                                <tr style="background-color: #f0f0f0;">
                                    <th>Policy Number</th>
                                    <th>Company Name</th>
                                    <th>Product</th>
                                    <th>Previous Policy Price</th>
                                    <th>Renewal Date</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "{{ route('for-renewal.index') }}",
                "columns": [{
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
                        data: 'previous_policy_price',
                        name: 'previous_policy_price'
                    },
                    {
                        data: 'expiration_date',
                        name: 'expiration_date'
                    },

                ]
            });
        });
    </script>
@endsection
