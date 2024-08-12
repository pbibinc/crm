<table id="requestForCancellationTable" class="table table-bordered dt-responsive nowrap requestForCancellationTable"
    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
    <thead style="background-color:#f0f0f0;">
        <tr>
            <th>Policy Number</th>
            <th>Company Name</th>
            <th>Product</th>
            <th>Cancellation Type</th>
            <th>Status</th>
            <th></th>
        </tr>
    </thead>
</table>
<script>
    $(document).ready(function() {
        $('.requestForCancellationTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('get-request-for-cancellation-list') }}",
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
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
                    data: 'cancellation_type',
                    name: 'cancellation_type'
                },
                {
                    data: 'request_status',
                    name: 'request_status'
                },
                {
                    data: 'action',
                    name: 'action'
                }

            ],
        });
    });
</script>
