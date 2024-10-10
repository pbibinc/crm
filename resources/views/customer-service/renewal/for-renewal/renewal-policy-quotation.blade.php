<table id="dataTable" class="table table-bordered dt-responsive nowrap" style="width: 100%;">
    <thead>
        <tr style="background-color: #f0f0f0;">
            <th>Policy Number</th>
            <th>Company Name</th>
            <th>Product</th>
            <th>Previous Policy Price</th>
            <th>Renewal Date</th>
            <th></th>
        </tr>
    </thead>
</table>

<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                url: "{{ route('renewal.get-renewal-for-quote') }}",
                data: {
                    _token: "{{ csrf_token() }}"
                },
                type: 'POST'
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
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ]
        });
    });
</script>
