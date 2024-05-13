<div class="row mb-3">
    <div class="col-6">
        <div class="row">
            <div class="col-6">
                <label for="">Select User:</label>
                <div>
                    <select name="userProfileDropdown" id="userProfileDropdown" class="form-select">
                        <option value="">Select User</option>
                        @foreach ($userProfiles as $userProfile)
                            <option value="{{ $userProfile->id }}">{{ $userProfile->fullAmericanName() }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6">

    </div>
</div>
<div class="row">
    <table id="policyForRenewalTable" class="table table-bordered dt-responsive nowrap policyForRenewalTable"
        style="width:100%;">
        <thead>
            <tr style="background-color: #f0f0f0;">
                <th>Policy Number</th>
                <th>Company Name</th>
                <th>Product</th>
                <th>Previous Policy Cost</th>
                <th>Assigned To:</th>
                <th>Renewal Date</th>
            </tr>
        </thead>
    </table>
</div>

<script>
    $(document).ready(function() {
        $('.policyForRenewalTable').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                url: "{{ route('policy-quoted-for-renewal-list') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: function(d) {
                    d.userProfileDropdown = $('#userProfileDropdown').val();
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
                    data: 'expiration_date',
                    name: 'expiration_date'
                },
            ]
        })
        $('#userProfileDropdown').on('change', function() {
            $('#policyForRenewalTable').DataTable().draw();
        })
        $(document).on('click', '.renewalPolicyButton', function(e) {
            e.preventDefault();
            var id = $(this).attr('id');
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to process this renewal!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, process it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('customer-service/change-policy-status') }}/" + id,
                        method: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            id: id,
                            status: 'Process Quoted Renewal'
                        },
                        success: function(data) {
                            location.reload();
                        }
                    });
                }
            })
        })
    });
</script>
