<div class="row">
    <table id="financingTable" class="table table-bordered table-sm dt-responsive nowrap financingTable"
        style="font-size: 13px; width: 100%;">
        <thead style="background-color: #f0f0f0;">
            <th>Policy Number</th>
            <th>Company Name</th>
            <th>Product</th>
            <th>Financing Company</th>
            <th>Auto Pay</th>
            <th>Media</th>
        </thead>
    </table>
</div>
<script>
    $(document).ready(function() {
        var id = {{ $leadId }}
        $('.financingTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('get-customers-financing-agreement') }}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": id
                }
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
                    data: 'auto_pay',
                    name: 'auto_pay'
                },
                {
                    data: 'media',
                    name: 'media'
                }
            ],
        });
    })
</script>
