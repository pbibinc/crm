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
                                    <a class="nav-link active" data-bs-toggle="tab" href="#intentPolicy" role="tab">
                                        <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                        <span class="d-none d-sm-block">Intent Poicy</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#requestByCustomer" role="tab">
                                        <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                        <span class="d-none d-sm-block">Requested By Customer</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#requestForCancellation" role="tab">
                                        <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                        <span class="d-none d-sm-block">For Cancellation</span>
                                    </a>
                                </li>
                            </ul>

                            <div class="tab-content p-3 text-muted">
                                <div class="tab-pane active" id="intentPolicy" role="tabpanel">
                                    @include('customer-service.cancellation.intent.intent-policy-table')
                                </div>
                                <div class="tab-pane" id="requestByCustomer" role="tabpanel">
                                    @include('customer-service.cancellation.request-by-customer-table')
                                </div>
                                <div class="tab-pane" id="requestForCancellation" role="tabpanel">
                                    @include('customer-service.cancellation.request-for-cancellation-table')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('customer-service.policy.cancellation-report-modal')
    @include('customer-service.cancellation.cancellation-request-for-approval-form')
    @include('customer-service.cancellation.cancel-policy-modal')

    <script>
        Dropzone.autoDiscover = false;
        var cancellationRequestDropzone;
        var cancelPolicyDropzone;
        $(document).ready(function() {
            $(document).on('click', '.cancelButton', function(e) {
                e.preventDefault();
                var id = $(this).attr('id');
                $.ajax({
                    url: "/cancellation/cancellation-report/" + id + '/edit',
                    type: "GET",
                    data: {
                        id: id
                    },
                    success: function(response) {
                        if (response.status == 'success') {
                            if (response.data.policyDetail.status == 'Intent') {
                                $('#isIntent').prop('checked', true);
                                $('#intent').val('1');
                                $('input[name="reinstatedEligibilityDate"]').attr('hidden',
                                    false);
                                $('#reinstatedEligibilityDateLabel').attr('hidden', false);
                            } else {
                                $('#isIntent').prop('checked', false);
                                $('#intent').val('0');
                                $('input[name="reinstatedEligibilityDate"]').attr('hidden',
                                    true);
                                $('#reinstatedEligibilityDateLabel').attr('hidden', true);
                            }
                            $('#typeOfCancellationDropdown').val(response.data
                                .cancellationReport
                                .type_of_cancellation);
                            $('#reinstatedDate').val(response.data.cancellationReport
                                .reinstated_date);
                            $('#reinstatedEligibilityDate').val(response.data.cancellationReport
                                .reinstated_eligibility_date);
                            $('#agentRemakrs').val(response.data.cancellationReport
                                .agent_remarks);
                            $('#recoveryAction').val(response.data.cancellationReport
                                .recovery_action);
                            $('#cancelleationPolicyId').val(response.data.cancellationReport
                                .policy_details_id);
                            $('#action').val('edit');
                            $('#requestForCancellationCheckBoxDiv').attr('hidden', false);
                            $('#policyCancellationModal').modal('show');
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

            cancellationRequestDropzone = new Dropzone("#cancellationRequestDropzone", {
                url: "#",
                autoProcessQueue: false, // Prevent automatic upload
                clickable: true, // Allow opening file dialog on click
                maxFiles: 1,
                addRemoveLinks: true,
                init: function() {
                    var myDropzone = this;
                    $('#submitCancellationRequest').click(function(e) {
                        e.preventDefault();

                        var formData = new FormData($('#cancellationRequestForm')[0]);

                        myDropzone.files.forEach(function(file) {
                            formData.append('file', file);
                        });

                        formData.append('poliydetailId', $('#poliydetailId').val());
                        formData.append('typeOfCancellation', $('#typeOfCancellation').val());
                        formData.append('cancellationDescription', $('#cancellationDescription')
                            .val());
                        formData.append('cancellationDate', $('#cancellationDate').val());

                        var action = $('#action').val();
                        var cancellationId = $('#cancellationEndorsementId').val();
                        var url = action == 'edit' ?
                            `{{ route('cancellation-endorsement.update', ':id') }}` :
                            "{{ route('cancellation-endorsement.store') }}";
                        if (action == 'edit') {
                            url = url.replace(':id', cancellationId);
                            formData.append('_method', 'PUT');
                        }

                        $.ajax({
                            url: url,
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                    'content')
                            },
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function(response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: response.message,
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.reload();
                                    }
                                });
                            },
                            error: function(xhr, status, error) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Something went wrong!',
                                });
                            }
                        });
                    });

                    this.on('addedfile', function(file) {
                        file.previewElement.addEventListener("click", function() {
                            var url = "{{ env('APP_FORM_LINK') }}";
                            var fileUrl = url + file.url;
                            Swal.fire({
                                title: 'File Options',
                                text: 'Choose an action for the file',
                                showDenyButton: true,
                                confirmButtonText: `Download`,
                                denyButtonText: `View`,
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    var downloadLink = document.createElement(
                                        "a");
                                    downloadLink.href = fileUrl;
                                    downloadLink.download = file.name;
                                    document.body.appendChild(downloadLink);
                                    downloadLink.click();
                                    document.body.removeChild(downloadLink);
                                } else if (result.isDenied) {
                                    window.open(fileUrl, '_blank');
                                }
                            });
                        });
                    });
                }
            });

            cancelPolicyDropzone = new Dropzone('#cancelPolicyDropzone', {
                url: "#",
                autoProcessQueue: false, // Prevent automatic upload
                clickable: true, // Allow opening file dialog on click
                maxFiles: 1,
                addRemoveLinks: true,
                init: function() {
                    this.on('addedfile', function(file) {
                        file.previewElement.addEventListener("click", function() {
                            var url = "{{ env('APP_FORM_LINK') }}";
                            var fileUrl = url + file.url;
                            Swal.fire({
                                title: 'File Options',
                                text: 'Choose an action for the file',
                                showDenyButton: true,
                                confirmButtonText: `Download`,
                                denyButtonText: `View`,
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    var downloadLink = document.createElement(
                                        "a");
                                    downloadLink.href = fileUrl;
                                    downloadLink.download = file.name;
                                    document.body.appendChild(downloadLink);
                                    downloadLink.click();
                                    document.body.removeChild(downloadLink);
                                } else if (result.isDenied) {
                                    window.open(fileUrl, '_blank');
                                }
                            });
                        });
                    });
                }
            });

            function addExistingCancellationEndorsementFile(file) {
                var mockFile = {
                    id: file.id,
                    name: file.basename,
                    size: parseInt(file.size),
                    type: file.type,
                    status: Dropzone.ADDED,
                    url: file.filepath // URL to the file's location
                };
                cancellationRequestDropzone.emit("addedfile", mockFile);
                cancellationRequestDropzone.emit("complete", mockFile);
                cancelPolicyDropzone.emit("addedfile", mockFile);
                cancelPolicyDropzone.emit("complete", mockFile);
            }

            $(document).on('click', '.requestForApproval', function() {
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
                            $('#cancellationDescription').val(response.description);
                            $('#poliydetailId').val(id);
                            $('#cancellatioRequestInformationModal').modal('show');
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

            $(document).on('click', '.requestForApprovalEdit', function() {
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
                            $('#cancellationDescription').val(response.description);
                            $('#poliydetailId').val(id);
                            $('#cancellationDate').val(response.cancellationEndorsement
                                .cancellation_date)
                            addExistingCancellationEndorsementFile(response
                                .cancellationEndorsementMedia);
                            $('#action').val('edit');
                            $('#cancellationEndorsementId').val(response
                                .cancellationEndorsement.id);
                            $('#cancellatioRequestInformationModal').modal('show');
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

            $('#cancellatioRequestInformationModal').on('hidden.bs.modal', function() {
                var form = $('#cancellationRequestForm')[0];
                form.reset();
                // Clear all files from Dropzone
                cancellationRequestDropzone.removeAllFiles(true);
                $('#cancellationRequestDropzone').empty();
            });

            $('#cancelPolicyModal').on('hidden.bs.modal', function() {
                // Reset the form
                var cancelPolicyForm = $('#cancelPolicyForm')[0];
                if (cancelPolicyForm) {
                    cancelPolicyForm.reset();
                }

                // Clear all files from Dropzone
                if (typeof cancelPolicyDropzone !== 'undefined') {
                    cancelPolicyDropzone.removeAllFiles(true);
                    $('#cancelPolicyDropzone').empty();
                }
            });

            $(document).on('click', '.cancelPolicyButton', function() {
                var id = $(this).attr('id');
                $.ajax({
                    url: "{{ route('cancelled-policy.get-policy-approved-for-cancellation') }}",
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        id: id
                    },
                    success: function(response) {
                        console.log(response);
                        if (response.status == 'success') {
                            $('#cancelPolicyCompanyName').text(response.lead.company_name);
                            $('#cancelPolicyCarrier').text(response.policy.carrier);
                            $('#cancelPolicyInsuredName').text(response.generalInformation
                                .firstname +
                                ' ' +
                                response.generalInformation.lastname);
                            $('#cancelPolicyType').text(response.policy.quotation_product
                                .product);
                            $('#cancelPolicyTypeOfCancellation').text(response
                                .cancellationEndorsement
                                .type_of_cancellation);
                            $('#cancelaPolicyCancellationDate').text(response
                                .cancellationEndorsement.cancellation_date);
                            $('#cancelPolicyAddress').text(response.generalInformation.address);
                            $('#cancelPolicyTerm').text(response.paymentTerm);
                            $('#cancellationPolicyRemarks').text(response
                                .cancellationEndorsement
                                .agent_remarks);
                            $('#cancelaPolicyCancellationDate').val(response
                                .cancellationEndorsement.cancellation_date)
                            addExistingCancellationEndorsementFile(response.media);
                            $('#policyId').val(response.policy.id);
                            $('#cancellationEndorsementId').val(response.cancellationEndorsement
                                .id);
                            $('#cancelPolicyModal').modal('show');
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



        })
    </script>
@endsection
