<div class="row">
    <table id="bindingQuotedTable" class="table table-bordered dt-responsive nowrap bindingQuotedTable"
        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
        <thead class="" style="background-color: #f0f0f0;">
            <th>Company Name</th>
            <th>Product</th>
            <th>Broker</th>
            <th>Appointed By</th>
            <th>Status</th>
            <th>Action</th>
        </thead>
    </table>
</div>
<script>
    $(document).ready(function() {
        $('.bindingQuotedTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('get-quoted-binding-product') }}",
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            },
            columns: [{
                    data: 'companyName',
                    name: 'companyName'
                },
                {
                    data: 'product',
                    name: 'product'
                },
                {
                    data: 'broker',
                    name: 'broker'
                },
                {
                    data: 'appointedBy',
                    name: 'appointedBy'
                },
                {
                    data: 'statusColumn',
                    name: 'statusColumn'
                },
                {
                    data: 'action',
                    name: 'action'
                }
            ],
        });
    });
</script>
