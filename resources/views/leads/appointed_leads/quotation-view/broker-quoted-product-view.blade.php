<div class="row">
    <table id="brokerQuotedTable" class="table table-bordered dt-responsive nowrap brokerQuotedTable"
        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
        <thead class="" style="background-color: #f0f0f0;">
            <th>Company Name</th>
            <th>Product</th>
            <th>Broker</th>
            <th>Appointed By</th>
            <th>Status</th>
            <th>Action</th>
        </thead>
        <tbody>

        </tbody>
    </table>
</div>
<script>
    $(document).ready(function() {
        $('.brokerQuotedTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('get-product-quoted') }}",
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

        $(document).on('click', '.viewButton', function() {
            var id = $(this).attr('id');
            window.location.href = `lead-profile-view/${id}`
        });
    })
</script>
