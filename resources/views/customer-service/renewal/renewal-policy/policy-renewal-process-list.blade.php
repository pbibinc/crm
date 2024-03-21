<table id="quotedPolicyForRenewal" class="table table-bordered dt-responsive nowrap" style="width:100%;">
    <thead>
        <tr style="background-color: #f0f0f0;">
            <th>Policy Number</th>
            <th>Company Name</th>
            <th>Product</th>
            <th>Previous Policy Cost</th>
            <th>Renewal Date</th>
        </tr>
    </thead>
</table>
<script>
    $(document).ready(function() {
        $('#quotedPolicyForRenewal').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                url: "{{ route('process-quoted-policy-renewal') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: "POST"
            },
            "columns": [{
                    data: 'policy_no',
                    name: 'policy_no'
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
        })
    });
</script>
