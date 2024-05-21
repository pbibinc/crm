<table id="handledPolicyTable" class="table table-bordered dt-responsive nowrap" style="width:100%;">
    <thead>
        <tr style="background-color: #f0f0f0;">
            <th>Policy Number</th>
            <th>Company Name</th>
            <th>Product</th>
            <th>Status</th>
            <th>Handled By</th>
        </tr>
    </thead>
</table>
<script>
    $(document).ready(function() {
        $('#handledPolicyTable').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                url: "{{ route('renewal-handled-policy') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
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
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'handledBy',
                    name: 'handledBy'
                },
            ]
        });

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
        });
    });
</script>
