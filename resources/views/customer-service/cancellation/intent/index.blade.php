@extends('admin.admin_master')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">
            <div class="card" style="box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05); border-radius: 10px; overflow: hidden;">
                <div class="card-body">
                    <table id="dataTable" class="table table-bordered dt-responsive nowrap dataTable"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead style="background-color:#f0f0f0;">
                            <th>Policy Nummber</th>
                            <th>Company Name</th>
                            <th>Product</th>
                            <th>Financing Company</th>
                            <th>Reinstated Start Date</th>
                            <th>Reinstated End Date</th>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('intent.get-intent-list') }}",
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                },
                columns: [{
                        data: 'quote_number',
                        name: 'quote_number'
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
                        data: 'intent_start_date',
                        name: 'intent_start_date'
                    },
                    {
                        data: 'intent_end_date',
                        name: 'intent_end_date'
                    }
                ],
            });
        })
    </script>
@endsection
