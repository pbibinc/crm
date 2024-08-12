<table id="requestByCustomerTable" class="table table-bordered dt-responsive nowrap requestByCustomerTable"
    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
    <thead style="background-color:#f0f0f0;">
        <tr>
            <th>Policy Nummber</th>
            <th>Company Name</th>
            <th>Product</th>
            <th></th>
        </tr>

    </thead>
</table>
<script>
    $(document).ready(function() {
        $('.requestByCustomerTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('get-request-by-customer-cancellation-list') }}",
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            },
            columns: [{
                    data: 'quote_number',
                    name: 'quote_number'
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
                    data: 'action',
                    name: 'action'
                }

            ],
        });
    });
</script>
