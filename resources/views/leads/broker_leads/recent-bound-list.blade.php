<div class="row">
    <table id="recentBoundProduct" class="table table-bordered dt-responsive nowrap recentBoundProduct"
        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
        <thead class="" style="background-color: #f0f0f0;">
            <th>Company Name</th>
            <th>Product</th>
            <th>Bound Date</th>
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
                data: {
                    "_token": "{{ csrf_token() }}",
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
                    data: 'boundDate',
                    name: 'boundDate'
                },

            ],
            order: [
                [2, 'asc']
            ]
        });
    });
</script>
