<table id="policyForRenewalTable" class="table table-bordered dt-responsive nowrap" style="width:100%;">
    <thead>
        <tr style="background-color: #f0f0f0;">
            <th>Policy Number</th>
            <th>Company Name</th>
            <th>Product</th>
            <th>Previous Policy Cost</th>
            <th>Renewal Date</th>
            <th></th>
        </tr>
    </thead>
</table>
<script>
    $(document).ready(function() {
        $('#policyForRenewalTable').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "{{ route('for-renewal.index') }}",
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
                    data: 'expiration_date',
                    name: 'expiration_date'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ]
        })

        $(document).on('click', '.proccessRenewal', function(e) {
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
                            status: 'Process Renewal'
                        },
                        success: function(data) {
                            Swal.fire(
                                'Processed!',
                                'Renewal has been processed.',
                                'success'
                            ).then((result) => {
                                location.reload();
                            })
                        },
                        error: function(error) {
                            Swal.fire(
                                'Error!',
                                'Renewal has not been processed.',
                                'error'
                            )
                        }
                    })
                }
            })
        })
    })
</script>
