<table id="forRewriteTable" class="table table-bordered dt-responsive nowrap forRewriteTable"
    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
    <thead style="background-color:#f0f0f0;">
        <tr>
            <th>Old Policy</th>
            <th>Company Name</th>
            <th>Product</th>
            <th>Origin</th>
            <th></th>
        </tr>
    </thead>
</table>
<script>
    $(document).ready(function() {
        $('.forRewriteTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('rewrite-policy.get-for-rewrite-policy') }}",
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    "_token": "{{ csrf_token() }}"
                }
            },
            columns: [{
                    data: 'policy_link',
                    name: 'policy_link'
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
                    data: 'recovery_origin',
                    name: 'recovery_origin'
                },
                {
                    data: 'action',
                    name: 'action'
                }
            ],
        });
    });
</script>
