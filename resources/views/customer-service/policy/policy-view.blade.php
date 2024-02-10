<div class="card">
    <div class="card-body">
        <table id="dataTable" class="table table-bordered dt-responsive nowrap bound-list-data-table"
            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
            <thead>
                <th>Policy Number</th>
                <th>Product</th>
                <th>Insurer</th>
                <th>Carrier</th>
                <th>Effective Date</th>
                <th>Expiration Date</th>
            </thead>
        </table>
    </div>
</div>
<script>
    $(document).ready(function() {
        var id = {{ $id }};
        $('#dataTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                        'content')
                },
                url: "{{ route('get-policy-list') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id
                }
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
                    data: 'insurer',
                    name: 'insurer'
                },
                {
                    data: 'carrier',
                    name: 'carrier'
                },
                {
                    data: 'effective_date',
                    name: 'effective_date'
                },
                {
                    data: 'expiration_date',
                    name: 'expiration_date'
                }
            ]
        })
    })
</script>
