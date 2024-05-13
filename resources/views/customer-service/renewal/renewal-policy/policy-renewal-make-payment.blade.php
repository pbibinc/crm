<div class="row mb-3">
    <div class="col-6">
        <div class="row">
            <div class="col-6">
                <label for="">Select User:</label>
                <div>
                    <select name="makepaymentUserProfileDropdown" id="makepaymentUserProfileDropdown" class="form-select">
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
    <table id="quotedPolicyMakePayment" class="table table-bordered dt-responsive nowrap quotedPolicyMakePayment"
        style="width:100%;">
        <thead>
            <tr style="background-color: #f0f0f0;">
                <th>Policy Number</th>
                <th>Company Name</th>
                <th>Product</th>
                <th>Previous Policy Cost</th>
                <th>Assigned To</th>
                <th>Payment Status</th>
                <th>Renewal Date</th>
            </tr>
        </thead>
    </table>
</div>

<script>
    $(document).ready(function() {
        $('.quotedPolicyMakePayment').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                url: "{{ route('renewal-make-payment-list') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: function(d) {
                    d.userProfileDropdown = $('#makepaymentUserProfileDropdown').val();
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
                    data: 'previous_policy_price',
                    name: 'previous_policy_price'
                },
                {
                    data: 'assignedTo',
                    name: 'assignedTo'
                },
                {
                    data: 'paymentStatus',
                    name: 'paymentStatus'
                },
                {
                    data: 'expiration_date',
                    name: 'expiration_date'
                },
            ]
        })

        $('#makepaymentUserProfileDropdown').on('change', function() {
            $('#quotedPolicyMakePayment').DataTable().draw();
        });
    });
</script>
