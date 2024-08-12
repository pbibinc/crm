@extends('admin.admin_master')
@section('admin')
    <div class="page-content pt-6">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="card"
                            style="box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05); border-radius: 10px; overflow: hidden;">

                            <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#pendingCancellationRequest"
                                        role="tab">
                                        <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                        <span class="d-none d-sm-block">Pending Cancellation Request</span>
                                    </a>
                                </li>
                                {{-- <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#requestByCustomer" role="tab">
                                        <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                        <span class="d-none d-sm-block">Requested By Customer</span>
                                    </a>
                                </li> --}}
                            </ul>

                            <div class="tab-content p-3 text-muted">
                                <div class="tab-pane active" id="pendingCancellationRequest" role="tabpanel">
                                    @include('customer-service.cancellation.request-for-cancellation.pending-cancellation-table')
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('customer-service.cancellation.request-for-cancellation.request-for-cancellation-confirmation')
    <script>
        $(document).ready(function() {

            $(document).on('click', '.requestForApproval', function(e) {
                var id = $(this).attr('id');
                var id = $(this).attr('id');
                $.ajax({
                    url: "{{ route('get-request-for-approval-data') }}",
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        id: id
                    },
                    success: function(response) {
                        if (response.status == 'success') {
                            $('#carrier').text(response.data.carrier);
                            $('#companyName').text(response.lead.company_name);
                            $('#insuredName').text(response.generalInformation.firstname +
                                ' ' +
                                response.generalInformation.lastname);
                            $('#policyType').text(response.product.product);
                            $('#address').text(response.generalInformation.address);
                            $('#policyTerm').text(response.paymentTerm);
                            $('#cancellationTypeDescription').text(response.cancellationReport
                                .type_of_cancellation);
                            $('#typeOfCancellation').val(response.cancellationReport
                                .type_of_cancellation)
                            $('#cancellationDescription').val(response.cancellationReport
                                .agent_remarks);
                            $('#poliydetailId').val(id);
                            $('#cancellationDate').val(response.cancellationEndorsement
                                .cancellation_date);
                            cancellationEndorsement(response.cancellationEndorsementMedia)
                            $('#requestForCancellationConfirmationModal').modal('show');
                        } else {
                            swal.fire({
                                title: 'Error',
                                text: response.message,
                                icon: 'error',
                                confirmButtonText: 'Ok'
                            });
                        }
                    }
                });
            });

        });
    </script>
@endsection
