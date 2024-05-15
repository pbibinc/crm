<div class="row">
    <table id="bindingDataTable" class="table table-bordered dt-responsive nowrap bindingDataTable"
        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
        <thead class="" style="background-color: #f0f0f0;">
            <th>Company Name</th>
            <th>Product</th>
            <th>Appointed By</th>
            <th>Quoted By</th>
            <th>Broker</th>
            <th>Status</th>
            <th>Action</th>
        </thead>
        <tbody>

        </tbody>
    </table>
</div>
<script>
    $(document).ready(function() {
        $('.bindingDataTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('get-compliance-binding-list') }}",
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
                    data: 'appointedBy',
                    name: 'appointedBy'
                },
                {
                    data: 'quotedBy',
                    name: 'quotedBy'
                },
                {
                    data: 'broker',
                    name: 'broker'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'action',
                    name: 'action'
                }
            ],
        });
    });
</script>
