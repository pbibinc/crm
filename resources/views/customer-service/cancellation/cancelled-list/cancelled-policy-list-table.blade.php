<table id="cancelPolicyTable" class="table table-bordered dt-responsive nowrap cancelPolicyTable"
    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
    <thead>
        <tr>
            <th>Old Policy Number</th>
            <th>Company Name</th>
            <th>Product</th>
            <th>Cancellation Type</th>
            <th>Cancelled By</th>
            <th>Cancelled Date</th>
            <th></th>
        </tr>
    </thead>
</table>

<script>
    $(document).ready(function() {
        $('#cancelPolicyTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('cancellation-policy.get-cancelled-policy') }}", // Fixed URL syntax
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
                    data: 'cancelled_by',
                    name: 'cancelled_by'
                },
                {
                    data: 'cancelled_date',
                    name: 'cancelled_date'
                },
                {
                    data: 'action',
                    name: 'action'
                }
            ],
        });
    })
</script>
