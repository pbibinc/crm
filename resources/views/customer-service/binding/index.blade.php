@extends('admin.admin_master')
@section('admin')
    <div class="page-content pt-6">
        <div class="container-fluid">
            <div class="row">
                <div class="col-6">
                    <div class="card"
                        style="box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05); border-radius: 10px; overflow: hidden;">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Products For Binding</h4>
                            <table id="getConfimedProductTable"
                                class="table table-bordered dt-responsive nowrap getConfimedProductTable"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <th>Product</th>
                                    <th>Company Name</th>
                                    <th>Requested By</th>
                                    <th>Actions</th>
                                    {{-- <th>Sent Out Date</th>
                                <th></th> --}}
                                </thead>
                                <tbody>

                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
            @include('customer-service.policy-form.general-liabilities-policy-form')
            @include('customer-service.policy-form.commercial-auto-policy-form')
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('.getConfimedProductTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('binding') }}",
                columns: [{
                        data: 'product',
                        name: 'product'
                    },
                    {
                        data: 'company_name',
                        name: 'company_name'
                    },
                    {
                        data: 'requestedBy',
                        name: 'requestedBy'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    }
                    // {data: 'status', name: 'status'},
                    // {data: 'sent_out_date', name: 'sent_out_date'},
                    // {data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                language: {
                    emptyTable: "No data available in the table"
                },
                initComplete: function(settings, json) {
                    if (json.recordsTotal === 0) {
                        // Handle the case when there's no data (e.g., show a message)
                        console.log("No data available.");
                    }
                }
            });
        });
        $(document).on('click', '.bindButton', function(e) {
            e.preventDefault();
            var id = $(this).attr('id');
            var product = $(this).attr('data-product');
            var company_name = $(this).attr('data-companyname');
            $('#insuredInput').val(company_name);
            $('#hiddenInputId').val(id);
            $()
            if (product == 'General Liabilities') {
                $('#generalLiabilitiesPolicyForm').modal('show');
            }
            if (product == 'Commercial Auto') {
                $('#commercialAutoPolicyForm').modal('show');
            }

        });
    </script>
@endsection
