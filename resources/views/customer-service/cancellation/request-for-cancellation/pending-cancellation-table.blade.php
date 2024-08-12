<table id="pendingCancellationTable" class="table table-bordered dt-responsive nowrap pendingCancellationTable"
    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
    <thead style="background-color:#f0f0f0;">
        <tr>
            <th>Policy Number</th>
            <th>Company Name</th>
            <th>Product</th>
            <th>Cancellation Type</th>
            <th>Requested By</th>
            <th>Status</th>
            <th>Requested Date</th>
            <th></th>
        </tr>
    </thead>
</table>
<script>
    $(document).ready(function() {
        $('.pendingCancellationTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('request-pending-cancellation') }}",
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
                    data: 'requested_by',
                    name: 'requested_by'
                },
                {
                    data: 'request_status',
                    name: 'request_status'
                },
                {
                    data: 'requested_date',
                    name: 'requested_date'
                },
                {
                    data: 'action',
                    name: 'action'
                }
            ],
            order: [
                [5, 'desc']
            ]
        });
    });
</script>
