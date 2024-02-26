<div class="row">
    <table id="newPolicyList" class="table table-bordered dt-responsive nowrap newPolicyList"
        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
        <thead style="background-color: #f0f0f0;">
            <th>Policy Number</th>
            <th>Product</th>
            <th>Company Name</th>
            <th>Market</th>
            <th>Carrier</th>
            <th>Effective Date</th>
            <th>Expiration Date</th>
        </thead>
        <tbody>

        </tbody>
    </table>
</div>
<script>
    $(document).ready(function() {
        var token = '{{ csrf_token() }}';
        $('.newPolicyList').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('new-policy-list') }}",
                type: "POST",

            },
            columns: [{
                    data: 'policy_number',
                    name: 'policy_number'
                },
                {
                    data: 'product',
                    name: 'product'
                },
                {
                    data: 'company_name',
                    name: 'company_name'
                },
                {
                    data: 'market',
                    name: 'market'
                },
                {
                    data: 'carrier',
                    name: 'carrier'
                },
                {
                    data: 'effective_date',
                    name: 'effective_date'
                },
                {
                    data: 'expiration_date',
                    name: 'expiration_date'
                }
            ],
            language: {
                emptyTable: "No data available in the table"
            },

        })
    })
</script>
