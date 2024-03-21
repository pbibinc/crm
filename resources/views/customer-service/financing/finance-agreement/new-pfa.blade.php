<div class="row">
    <table id="newPfaTable" class="table table-bordered dt-responsive nowrap newPfaTable"
        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
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
        $('.newPfaTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('financing-aggrement.new-financing-agreement') }}",
                type: "POST",
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
