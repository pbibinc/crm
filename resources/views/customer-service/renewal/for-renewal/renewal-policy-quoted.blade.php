<table id="renewalPolicyQuotedTable" class="table table-bordered dt-responsive nowrap renewalPolicyQuotedTable"
    style="width: 100%;">
    <thead>
        <tr style="background-color: #f0f0f0;">
            <th>Policy Number</th>
            <th>Company Name</th>
            <th>Product</th>
            <th>Previous Policy Price</th>
            <th>Renewal Date</th>
        </tr>
    </thead>
</table>
<script>
    $(document).ready(function() {
        $('.renewalPolicyQuotedTable').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                url: "{{ route('renewal.get-quoted-renewal') }}",
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}"
                }
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
                    data: 'expiration_date',
                    name: 'expiration_date'
                },
            ]
        });

        $(document).on('click', '.renewalReminder', function(e) {
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
                            status: 'Renewal Quote'
                        },
                        success: function(data) {
                            Swal.fire(
                                'Success!',
                                'Renewal Processed Successfully.',
                                'success'
                            ).then((result) => {
                                location.reload();
                            })
                        }
                    });
                }
            });
        });

    })
</script>
