@extends('admin.admin_master')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <table id="paymentArchieved" class="table table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Type</th>
                                        <th>Product</th>
                                        <th>Policy Number</th>
                                        <th>Invoice Number</th>
                                        <th>Charged By</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#paymentArchieved').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                            'content')
                    },
                    url: "{{ route('payment-archive.get-payment-information') }}",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: {{ $id }}
                    },
                    type: "POST",
                },
                columns: [{
                        data: 'payment_type',
                        name: 'payment_type'
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
                        data: 'invoice_number',
                        name: 'invoice_number'
                    },
                    {
                        data: 'charged_by',
                        name: 'charged_by'
                    },
                    {
                        data: 'charged_date',
                        name: 'charged_date'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    }
                ]
            });

            $(document).on('click', '.restorePaymentInformation', function() {
                var id = $(this).attr('id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to restore this payment information?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('payment-archive.restore') }}",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                    'content')
                            },
                            data: {
                                id: id
                            },
                            type: "POST",
                            success: function(data) {
                                if (data.success) {
                                    Swal.fire(
                                        'Restored!',
                                        'Payment information has been restored.',
                                        'success'
                                    );
                                    $('#paymentArchieved').DataTable().ajax.reload();
                                }
                            }
                        });
                    }
                });

            });

        });
    </script>
@endsection
