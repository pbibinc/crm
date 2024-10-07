<div class="row">
    <table id="getConfimedProductTable" class="table table-bordered dt-responsive nowrap getConfimedProductTable"
        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
        <thead class="" style="background-color: #f0f0f0;">
            <th>Policy Number</th>
            <th>Product</th>
            <th>Company Name</th>
            <th>Requested By</th>
            <th>Type</th>
            <th>Total Cost</th>
            <th>Effective Date</th>
            <th>Action</th>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>


<script>
    $(document).ready(function() {
        var token = '{{ csrf_token() }}';
        $('.getConfimedProductTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('request-to-bind') }}",
                type: "POST",
            },
            columns: [{
                    data: 'policy_number',
                    name: 'policy_number'
                },
                {
                    data: 'product',
                    name: 'product'
                },
                {
                    data: 'company_name',
                    name: 'company_name'
                },
                {
                    data: 'requested_by',
                    name: 'requested_by'
                },
                {
                    data: 'bindingType',
                    name: 'bindingType'
                },
                {
                    data: 'total_cost',
                    name: 'total_cost'
                },
                {
                    data: 'effective_date',
                    name: 'effective_date'
                },
                {
                    data: 'action',
                    name: 'action'
                }
            ],
            language: {
                emptyTable: "No data available in the table"
            },
            initComplete: function(settings, json) {
                if (json.recordsTotal === 0) {
                    // Handle the case when there's no data (e.g., show a message)
                    console.log("No data available.");
                }
            }
        });

        $(document).on('click', '.viewRequestToBind', function(e) {
            e.preventDefault();
            var id = $(this).attr('id');
            var productStatus = $(this).data('status');
            var status = 12;
            switch (productStatus) {
                case 17:
                    status = 19;
                    break;
                case 18:
                    status = 19;
                    break;
                case 6:
                    status = 12;
                    break;
                case 15:
                    status = 12;
                    break;
                case 24:
                    status = 25;
                    break;
                case 28:
                    status = 25;
                    break;
                default:
                    status = 12;
                    break;
            }
            Swal.fire({
                title: 'Process This Binding?',
                text: "You want to send a request to bind?",
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Send it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // $.ajax({
                    //     url: "{{ route('save-bound-information') }}",
                    //     headers: {
                    //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    //     },
                    //     method: "POST",
                    //     data: {
                    //         id: id,
                    //         productStatus: productStatus
                    //     },
                    //     success: function() {

                    //     },
                    //     error: function() {
                    //         Swal.fire({
                    //             title: 'Error',
                    //             text: 'Something went wrong',
                    //             icon: 'error'
                    //         });
                    //     }
                    // })
                    $.ajax({
                        url: "{{ route('change-quotation-status') }}",
                        headers: {
                            'X-CSRF-TOKEN': $(
                                'meta[name="csrf-token"]').attr(
                                'content')
                        },
                        method: "POST",
                        data: {
                            status: status,
                            id: id
                        },
                        success: function() {
                            Swal.fire({
                                title: 'Success',
                                text: 'has been saved',
                                icon: 'success'
                            }).then((result) => {
                                location.reload();
                            });
                        },
                        error: function() {
                            Swal.fire({
                                title: 'Error',
                                text: 'Something went wrong',
                                icon: 'error'
                            });
                        }
                    })
                }
            });
        });

    });
</script>
