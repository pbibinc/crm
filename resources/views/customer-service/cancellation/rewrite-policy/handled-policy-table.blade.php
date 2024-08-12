<table id="handledPolicy" class="table table-bordered dt-responsive nowrap handledPolicy"
    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
    <thead style="background-color:#f0f0f0;">
        <tr>
            <th>Policy Number</th>
            <th>Company Name</th>
            <th>Product</th>
            <th>Bound Date</th>
            <th></th>
        </tr>
    </thead>
</table>
<script>
    $(document).ready(function() {
        $('.handledPolicy').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('handled-rewrite-policy') }}",
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
                    data: 'formatted_bound_date',
                    name: 'formatted_bound_date'
                },
                {
                    data: 'action',
                    name: 'action'
                }
            ],
        });
    });
</script>
