@extends('admin.admin_master')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <table id="requestCertTable" class="table table-bordered dt-responsive nowrap requestCertTable"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>Company Name</th>
                                    <th>Requested Date</th>
                                    <th>Cert Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('.requestCertTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                            'content')
                    },
                    url: "{{ route('get-request-for-cert') }}",
                    method: 'POST',
                    async: false,
                    data: {
                        _token: "{{ csrf_token() }}",
                    }
                },
                columns: [{
                        data: 'company_name',
                        name: 'company_name'
                    },
                    {
                        data: 'formatted_requested_data',
                        name: 'formatted_requested_data'
                    },
                    {
                        data: 'cert_status',
                        name: 'cert_status'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    }
                ],
                "order": [
                    [2, "desc"]
                ]
            });

            function approvedCert(id) {
                console.log("Approving Cert ID:", id); // Debug log
                $.ajax({
                    url: "{{ route('approved-cert') }}",
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        id: id,
                    },
                    success: function(data) {
                        console.log("Response:", data);
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            text: 'Approved Cert is being emailed to insured',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.reload();
                            }
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error("Error:", error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Something went wrong while approving the certificate. Please try again.',
                        });
                    }
                });
            };

            $(document).on('click', '.approvedButton', function() {
                var id = $(this).attr('id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to approve this certificate!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, approve it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        approvedCert(id);
                    }
                })
            });

        });
    </script>
@endsection
