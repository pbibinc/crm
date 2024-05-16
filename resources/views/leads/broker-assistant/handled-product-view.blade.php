<div class="row">
    <table id="handledProduct" class="table table-bordered dt-responsive nowrap handledProduct"
        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
        <thead class="" style="background-color: #f0f0f0;">
            <th>Company Name</th>
            <th>Product</th>
            <th>Quoted By</th>
            <th>Appointed By</th>
            <th>Broker</th>
            <th></th>
        </thead>
    </table>
</div>
<script>
    $(document).ready(function() {
        $('.handledProduct').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('get-compliance-handled-product') }}",
                type: "POST",
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
                    data: 'quotedBy',
                    name: 'quotedBy'
                },
                {
                    data: 'appointedBy',
                    name: 'appointedBy'
                },
                {
                    data: 'broker',
                    name: 'broker'
                },
                {
                    data: 'action',
                    name: 'action'
                }
            ],

        })
    });
</script>
