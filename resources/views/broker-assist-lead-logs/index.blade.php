@extends('admin.admin_master')
@section('admin')
    <div class="page-content pt-6">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card"
                        style="box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05); border-radius: 10px; overflow: hidden;">
                        <div class="card-body">
                            <table id="leadsLogTable" class="table table-bordered dt-responsive nowrap leadsLogTable"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead class="" style="background-color: #f0f0f0;">
                                    <th>Company Name</th>
                                    <th>Product</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('.leadsLogTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('get-broker-assist-log-leads-list') }}",
                    type: "POST",
                    "_token": "{{ csrf_token() }}",
                },
                columns: [{
                        data: 'companyName',
                        name: 'companyName'
                    },
                    {
                        data: 'product',
                        name: 'product'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    }
                ],
                order: [
                    [2, 'asc']
                ]
            });
        });
    </script>
@endsection
