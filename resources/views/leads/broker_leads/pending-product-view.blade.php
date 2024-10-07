<div class="row">
    <table id="pendingProduct" class="table table-bordered dt-responsive nowrap pendingProduct"
        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
        <thead class="" style="background-color: #f0f0f0;">
            <th>Company Name</th>
            <th>Product</th>
            <th>Quoted By</th>
            <th>Appointed By</th>
        </thead>
        <tbody>

        </tbody>
    </table>
</div>
<script>
    $(document).ready(function() {
        $('.pendingProduct').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('get-broker-pending-product') }}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                },
            },
            columns: [{
                    data: 'companyName',
                    name: 'companyName'
                },
                {
                    data: 'product',
                    name: 'product'
                },
                {
                    data: 'quotedBy',
                    name: 'quotedBy'
                },
                {
                    data: 'appointedBy',
                    name: 'appointedBy'
                },
            ],
        });

        $(document).on('click', '.companyPendingName', function(e) {
            e.preventDefault();
            var id = $(this).attr('id');
            Swal.fire({
                title: 'Are you sure?',
                text: "Sending this to Broker?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('change-quotation-status') }}",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                'content')
                        },
                        method: "POST",
                        data: {
                            id: id,
                            status: 22,
                        },
                        success: function() {
                            Swal.fire({
                                title: 'Success',
                                text: 'has been saved',
                                icon: 'success'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload();
                                }
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
