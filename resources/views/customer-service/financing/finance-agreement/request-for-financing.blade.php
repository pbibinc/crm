<div class="row">
    <table id="dataTable" class="table table-bordered dt-responsive nowrap dataTable"
        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
        <thead class="" style="background-color: #f0f0f0;">
            <th>Company Name</th>
            <th>Product</th>
            <th>Policy Number</th>
            <th>Total Cost</th>
            <th>Effective Date</th>
        </thead>
    </table>
</div>

<script>
    $(document).ready(function() {
        var token = '{{ csrf_token() }}';
        $('.dataTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('financing-aggreement.product-for-financing') }}",
                type: "POST",
            },
            columns: [{
                    data: 'company_name',
                    name: 'company_name'
                },
                {
                    data: 'product',
                    name: 'product'
                },
                {
                    data: 'policy_number',
                    name: 'policy_number'
                },
                {
                    data: 'full_payment',
                    name: 'full_payment'
                },
                {
                    data: 'effective_date',
                    name: 'effective_date'
                }
            ],
        });

        $(document).on('click', '.procesFinancingRequest', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to process this financing request!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, process it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    var id = $(this).attr('id');
                    var baseUrl = "{{ url('customer-service/financing/financing-agreement') }}";
                    var token = $('meta[name="csrf-token"]').attr('content');
                    $.ajax({
                        url: `${baseUrl}/${id}`,
                        type: "PUT",
                        data: {
                            id: id,
                            status: 'Processing of PFA',
                            _token: token
                        },
                        success: function(data) {
                            if (data.success) {
                                Swal.fire(
                                    'Success!',
                                    'Financing request has been processed.',
                                    'success'
                                ).then((result) => {
                                    location.reload();
                                })
                            }
                        }
                    })

                }
            })
        });

    })
</script>
