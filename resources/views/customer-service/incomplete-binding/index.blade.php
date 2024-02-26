<div class="row">
    <table id="incompleteBindingTable" class="table table-bordered dt-responsive nowrap incompleteBindingTable"
        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
        <thead>
            <th>Policy Number</th>
            <th>Product</th>
            <th>Company Name</th>
            <th>Market</th>
            <th>Requested_by</th>
            <th>Total Cost</th>
            <th>Effective Date</th>
        </thead>
    </table>
</div>

<script>
    $(document).ready(function() {
        var token = '{{ csrf_token() }}';
        $('.incompleteBindingTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('incomplete-binding-list') }}",
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
                    data: 'requested_by',
                    name: 'requested_by'
                },
                {
                    data: 'total_cost',
                    name: 'total_cost'
                },
                {
                    data: 'effective_date',
                    name: 'effective_date'
                }
            ],
            language: {
                emptyTable: "No data available in the table"
            },
            initComplete: function(settings, json) {
                if (json.recordsTotal === 0) {
                    $('.incompleteBindingTable').parent().hide();
                }
            }
        })
    })
</script>
