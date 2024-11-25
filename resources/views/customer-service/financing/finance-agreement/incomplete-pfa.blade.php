<div class="row">
    <table id="incompletePfaTable" class="table table-bordered dt-responsive nowrap incompletePfaTable"
        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
        <thead style="background-color: #f0f0f0;">
            <th>Company Name</th>
            <th>Product</th>
            <th>Policy Number</th>
            <th>Total Cost</th>
            <th>Effective Date</th>
            <th>Action</th>
        </thead>
    </table>
</div>
<script>
    $(document).ready(function() {
        $('.incompletePfaTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('get-incomplete-pfa') }}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}"
                }
            },
            columns: [{
                    data: 'company_name',
                    name: 'company_name'
                },
                {
                    data: 'product',
                    name: 'product'
                },
                {
                    data: 'policy_number',
                    name: 'policy_number'
                },
                {
                    data: 'full_payment',
                    name: 'full_payment'
                },
                {
                    data: 'effective_date',
                    name: 'effective_date'
                },
                {
                    data: 'action',
                    name: 'action'
                }
            ],
        });
    })
</script>
