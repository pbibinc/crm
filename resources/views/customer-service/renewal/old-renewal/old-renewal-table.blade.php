<table id="oldRenewalTable" class="table table-bordered dt-responsive nowrap oldRenewalTable"
    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
    <thead style="background-color:#f0f0f0;">
        <tr>
            <th>Policy No:</th>
            <th>Company Name:</th>
            <th>Expired Policy Date:</th>
            <th></th>
        </tr>
    </thead>

</table>
<script>
    $(document).ready(function() {
        $('.oldRenewalTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('get-old-renewal-policy') }}",
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                async: false,
                data: {
                    _token: "{{ csrf_token() }}"
                },
            },
            columns: [{
                    data: 'policy_no',
                    name: 'policy_no'
                },
                {
                    data: 'company_name',
                    name: 'company_name'
                },
                {
                    data: 'expired_date',
                    name: 'expired_date'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }

            ]
        });
    });
</script>
