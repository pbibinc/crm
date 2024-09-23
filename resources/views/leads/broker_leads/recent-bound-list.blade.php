<div class="row">
    <table id="recentBoundProduct" class="table table-bordered dt-responsive nowrap recentBoundProduct"
        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
        <thead class="" style="background-color: #f0f0f0;">
            <th>Company Name</th>
            <th>Product</th>
            <th>Bound Date</th>
            <th>Action</th>
        </thead>
        <tbody>

        </tbody>
    </table>
</div>
<script>
    $(document).ready(function() {
        $('.recentBoundProduct').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('get-recent-bound-product') }}",
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
                    data: 'boundDate',
                    name: 'boundDate'
                },
                {
                    data: 'action',
                    name: 'action'
                }
            ],
            order: [
                [2, 'asc']
            ]
        });
    });
</script>
