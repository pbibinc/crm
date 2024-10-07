<div class="row">
    <table id="warmProductTable" class="table table-bordered dt-responsive nowrap warmProductTable"
        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
        <thead class="" style="background-color: #f0f0f0;">
            <th>Company Name</th>
            <th>Product</th>
            <th>Call Back</th>
            <th>Action</th>
        </thead>
        <tbody>

        </tbody>
    </table>
</div>
<script>
    $(document).ready(function() {
        $('.warmProductTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('get-warm-product') }}",
                type: "POST",
                "_token": "{{ csrf_token() }}",
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
                    data: 'callBack',
                    name: 'callBack'
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
    })
</script>
