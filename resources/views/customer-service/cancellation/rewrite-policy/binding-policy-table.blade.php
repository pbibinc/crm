<table id="bindingTable" class="table table-bordered dt-responsive nowrap bindingTable"
    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
    <thead style="background-color:#f0f0f0;">
        <tr>
            <th>Old Policy</th>
            <th>Company Name</th>
            <th>Product</th>
            <th>Cancellation Type</th>
            <th>Cancelled Date</th>
            <th></th>
        </tr>
    </thead>
</table>
<script>
    $(document).ready(function() {
        $('.bindingTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('get-rewrite-binding-policy') }}",
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
                    data: 'policy_status',
                    name: 'policy_status'
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
