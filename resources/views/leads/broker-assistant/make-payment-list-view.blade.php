<div class="row">
    <table id="makePayment" class="table table-bordered dt-responsive nowrap makePayment"
        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
        <thead class="" style="background-color: #f0f0f0;">
            <th>Company Name</th>
            <th>Product</th>
            <th>Quoted By</th>
            <th>Appointed By</th>
            <th>Broker</th>
            <th>Status</th>
            <th>Action</th>
        </thead>
        <tbody>

        </tbody>
    </table>
</div>
<script>
    $(document).ready(function() {
        $('.makePayment').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('get-compliance-make-payment-list') }}",
                type: "POST",

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
                {
                    data: 'broker',
                    name: 'broker'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'action',
                    name: 'action'
                }
            ],
            order: [
                [4, 'desc']
            ],
        });

        $(document).on('click', '.companyName', function(e) {
            e.preventDefault();
            var id = $(this).attr('id');
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to change the status to 'Bound'?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            }).then((result) => {
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

            });
        });

        $(document).on('click', '.viewButton', function(e) {
            e.preventDefault();
            var id = $(this).attr('id');
            $.ajax({
                url: "{{ route('quoted-product-profile') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: "POST",
                data: {
                    id: id
                },
                success: function(data) {
                    window.location.href =
                        `{{ url('quoatation/broker-profile-view/${data.leadId}/${data.generalInformationId}/${data.productId}') }}`;
                }
            })
        });

        // $(document).on('click', '.processButton', function(e) {
        //     var id = $(this).attr('id');
        //     Swal.fire({
        //         title: 'Are you sure?',
        //         text: "You want to process this Quotation?",
        //         icon: 'warning',
        //         showCancelButton: true,
        //         confirmButtonColor: '#3085d6',
        //         cancelButtonColor: '#d33',
        //         confirmButtonText: 'Yes'
        //     }).then((result) => {
        //         if (result.isConfirmed) {
        //             $.ajax({
        //                 url: "{{ route('change-quotation-status') }}",
        //                 headers: {
        //                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
        //                         'content')
        //                 },
        //                 method: "POST",
        //                 data: {
        //                     id: id,
        //                     status: 3,
        //                 },
        //                 success: function() {
        //                     Swal.fire({
        //                         title: 'Success',
        //                         text: 'has been saved',
        //                         icon: 'success'
        //                     }).then((result) => {
        //                         if (result.isConfirmed) {
        //                             location.reload();
        //                         }
        //                     });
        //                 },
        //                 error: function() {
        //                     Swal.fire({
        //                         title: 'Error',
        //                         text: 'Something went wrong',
        //                         icon: 'error'
        //                     });
        //                 }
        //             })
        //         }
        //     });
        // });



    });
</script>
