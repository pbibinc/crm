<table id="dataTable" class="table table-bordered dt-responsive nowrap dataTable"
    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
    <thead style="background-color:#f0f0f0;">
        <tr>
            <th>Policy Nummber</th>
            <th>Company Name</th>
            <th>Product</th>
            <th>Financing Company</th>
            <th>Reinstated Eligibile Date</th>
            <th></th>
        </tr>

    </thead>
</table>
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('intent.get-intent-list') }}",
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            },
            columns: [{
                    data: 'policy_number',
                    name: 'policy_number'
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
                    data: 'financing_company',
                    name: 'financing_company'
                },
                {
                    data: 'intent_end_date',
                    name: 'intent_end_date'
                },
                {
                    data: 'action',
                    name: 'action'
                }
            ],
        });
    })
</script>
