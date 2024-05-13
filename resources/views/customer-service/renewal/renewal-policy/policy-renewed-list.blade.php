<div class="row mb-3">
    <div class="col-6">
        <div class="row">
            <div class="col-6">
                <label for="">Select User:</label>
                <div>
                    <select name="renewalNewRenewedPolicyUserProdfileDropdown"
                        id="renewalNewRenewedPolicyUserProdfileDropdown" class="form-select">
                        <option value="">Select User</option>
                        @foreach ($userProfiles as $userProfile)
                            <option value="{{ $userProfile->id }}">{{ $userProfile->fullAmericanName() }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="col-6">

        </div>
    </div>
</div>
<div class="row">
    <table id="newRenewedPolicy" class="table table-bordered dt-responsive nowrap newRenewedPolicy" style="width:100%;">
        <thead>
            <tr style="background-color: #f0f0f0;">
                <th>Policy Number</th>
                <th>Company Name</th>
                <th>Product</th>
                <th>Assigned To</th>
            </tr>
        </thead>
    </table>
</div>
<script>
    $(document).ready(function() {
        $('.newRenewedPolicy').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                url: "{{ route('new-renewed-policy') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: function(d) {
                    d.userProfileDropdown = $(
                            '#renewalNewRenewedPolicyUserProdfileDropdown')
                        .val();
                },
                method: "POST"
            },
            "columns": [{
                    data: 'policy_no',
                    name: 'policy_no'
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
                    data: 'assignedTo',
                    name: 'assignedTo'
                }
            ]
        })
    })
</script>
