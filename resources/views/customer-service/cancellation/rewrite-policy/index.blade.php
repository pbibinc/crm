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
                                    <a class="nav-link active" data-bs-toggle="tab" href="#subjectForRewrite"
                                        role="tab">
                                        <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                        <span class="d-none d-sm-block">Subject For Rewrite</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#forRewrite" role="tab">
                                        <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                        <span class="d-none d-sm-block">For Rewrite</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#followUp" role="tab">
                                        <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                        <span class="d-none d-sm-block">Follow Up</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#quotation" role="tab">
                                        <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                        <span class="d-none d-sm-block">Quotation</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#payment" role="tab">
                                        <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                        <span class="d-none d-sm-block">Payment</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#binding" role="tab">
                                        <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                        <span class="d-none d-sm-block">Binding</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#handledPolicy" role="tab">
                                        <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                        <span class="d-none d-sm-block">Handled Policy</span>
                                    </a>
                                </li>
                            </ul>

                            <div class="tab-content p-3 text-muted">
                                <div class="tab-pane active" id="subjectForRewrite" role="tabpanel">
                                    @include('customer-service.cancellation.rewrite-policy.subject-for-rewrite-table')
                                </div>
                                <div class="tab-pane" id="forRewrite" role="tabpanel">
                                    @include('customer-service.cancellation.rewrite-policy.for-rewrite-policy-table')
                                </div>
                                <div class="tab-pane" id="quotation" role="tabpanel">
                                    @include('customer-service.cancellation.rewrite-policy.quotation-table')
                                </div>
                                <div class="tab-pane" id="payment" role="tabpanel">
                                    @include('customer-service.cancellation.rewrite-policy.make-a-payment-table')
                                </div>
                                <div class="tab-pane" id="binding" role="tabpanel">
                                    @include('customer-service.cancellation.rewrite-policy.binding-policy-table')
                                </div>
                                <div class="tab-pane" id="handledPolicy" role="tabpanel">
                                    @include('customer-service.cancellation.rewrite-policy.handled-policy-table')
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('leads.appointed_leads.log-activity.note-modal')
    @include('leads.appointed_leads.broker-forms.make-payment-form', compact('complianceOfficer'))

    <div class="modal fade bs-example-modal-center" id="requestToBindModal" tabindex="-1" role="dialog"
        aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="requestToBindModalTitle">Upload Request To Bind Files</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" id="rtbForm" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <input type="file" class="form-control" id="files" name="files[]" multiple>
                            </div>
                        </div>

                        <input type="hidden" id="rtbId" name="id" value="">
                        <input type="hidden" id="policyId" name="policyId" value="">
                </div>

                <div class="modal-footer">
                    <input type="submit" name="sendRequesToBindFile" id="sendRequesToBindFile" value="Submit"
                        class="btn btn-success">
                    <button type="button" class="btn btn-light waves-effect" data-bs-dismiss="modal">Close</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="resendRTBModal" tabindex="-1" aria-labelledby="addQuoteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="fileViewingModalTitle">File Upload</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" class="dropzone mt-4 border-dashed" id="resendRTBDropzone"
                        enctype="multipart/form-data">
                    </form>
                    <input type="hidden" id="mediaIds" value="">
                    <input type="hidden" id="productId">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="changeStatusButton" class="btn btn-success">Resend</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        Dropzone.autoDiscover = false;
        var myDropzone;
        $(document).ready(function() {
            var dropzoneElement = document.querySelector("#resendRTBDropzone");

            if (dropzoneElement) {
                myDropzone = new Dropzone("#resendRTBDropzone", {
                    url: "{{ route('upload-file-binding-docs') }}",
                    method: "post",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    autoProcessQueue: true,
                    clickable: true,
                    addRemoveLinks: true,
                    maxFiles: 10,
                    init: function() {
                        this.on("addedfile", function(file) {
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
                                        var downloadLink = document
                                            .createElement("a");
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
                        this.on('sending', function(file, xhr, formData) {
                            formData.append('hiddenId', $('#productId').val());
                        });
                        this.on('removedfile', function(file) {
                            $.ajax({
                                url: "{{ route('delete-binding-docs') }}",
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]')
                                        .attr(
                                            'content')
                                },
                                method: "POST",
                                data: {
                                    id: file.id
                                },
                                success: function() {
                                    // Optional: Handle success
                                },
                                error: function() {
                                    Swal.fire({
                                        title: 'Error',
                                        text: 'Something went wrong',
                                        icon: 'error'
                                    });
                                }
                            });
                        });
                    }
                });
            } else {
                console.error("Dropzone element not found");
            }

            //note button
            $(document).on('click', '.viewNotedButton', function() {
                var id = $(this).attr('id');
                var url = `/note/${id}/get-lead-note`;
                var departmentIds = [2, 3];
                $.ajax({
                    url: url,
                    type: "get",
                    data: {
                        id: id
                    },
                    success: function(response) {
                        var html =
                            '<div class="scrollable" style="height: 500px; overflow-y: auto;">';
                        var notes = Array.isArray(response.notes) ? response.notes : Array
                            .isArray(response) ? response : [];
                        notes.forEach(function(note) {
                            var noteClass = '';
                            if (note.status === 'declined-make-payment' || note
                                .status === 'Declined Binding') {
                                noteClass = 'danger';
                            } else if (note.status === 'yet-another-status') {
                                noteClass = 'yet-another-class';
                            }
                            var senderOrReceiverClass = (response.userProfileId == note
                                .user_profile_id) ? 'sender' : 'receiver';
                            var userInfo = (response.userProfileId == note
                                    .user_profile_id) ?
                                'sender-info' : '';
                            var marginLeft = (response.userProfileId != note
                                    .user_profile_id) ?
                                'style="margin-left: 10px"' : '';

                            html += `<div class="message-box ${senderOrReceiverClass} p-3 rounded ${noteClass}">
                        <div><strong>${note.title}</strong></div>
                        <div class="message-content">${note.description}</div>
                    </div>
                    <div class="message-info ${userInfo}" ${marginLeft}>
                        <p class="note-date font-2 text-muted">sent by: ${note.user_profile.american_name} ${new Date(note.created_at).toLocaleDateString('en-US', { month: 'short', day: '2-digit', year: 'numeric' })}</p>
                    </div>`;
                        });
                        $('#notesContainer').html(html);
                        $('#departmentIds').val(JSON.stringify(departmentIds));
                        $('#leadId').val(id);
                        $('#notesModal').modal('show');
                    }
                });
            });

            $(document).on('click', '.sendForQuotationButton', function() {
                var id = $(this).attr('id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to send this policy for quotation!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, send it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('change-status-for-policy') }}",
                            type: "POST",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: {
                                id: id,
                                status: 'For Rewrite Quotation'
                            },
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



                            }
                        });
                    }
                });


            });

            $(document).on('click', '.resendButton', function() {
                var id = $(this).attr('id');
                var policyId = $(this).attr('data-policy-id');
                $.ajax({
                    url: "{{ route('get-payment-information') }}",
                    method: "GET",
                    data: {
                        id: id,
                        _token: "{{ csrf_token() }}"
                    },
                    dataType: "json",
                    success: function(response) {
                        console.log(response);
                        var paymentMethod = response.paymentInformation.payment_method;
                        $('#paymentType').val(response.paymentInformation.payment_type);
                        $('#insuranceCompliance').val(response.paymentInformation
                            .compliance_by);
                        $('#market').val(response.market.name);
                        $('#firstName').val(response.generalInformation.firstname);
                        $('#companyName').val(response.lead.company_name);
                        $('#makePaymentEffectiveDate').val(response.quoteComparison
                            .effective_date);
                        $('#quoteNumber').val(response.quoteComparison.quote_no);
                        $('#paymentTerm').val(response.paymentInformation.payment_term);
                        $('#lastName').val(response.generalInformation.lastname);
                        $('#emailAddress').val(response.generalInformation.email_address);

                        // Set the payment method dropdown based on the fetched payment method
                        if (paymentMethod.toLowerCase() == 'checking') {
                            $('#paymentMethodMakePayment').val('Checking').trigger('change');
                        } else {
                            $('#paymentMethodMakePayment').val("Credit Card").trigger('change');
                            // Handling other card types
                            if (['Visa', 'Master Card', 'American Express'].includes(
                                    paymentMethod)) {
                                $('#cardType').val(paymentMethod).trigger('change');
                            } else {
                                $('#cardType').val('Other').trigger('change');
                                $('#otherCard').val(paymentMethod);
                            }
                        }
                        $('#totalPremium').val(response.quoteComparison.full_payment);
                        $('#brokerFeeAmount').val(response.quoteComparison.broker_fee);
                        $('#chargedAmount').val(response.paymentInformation.amount_to_charged);
                        $('#note').val(response.paymentInformation.note);
                        $('#generalInformationId').val(response.generalInformation.id);
                        $('#leadsId').val(response.lead.id);
                        $('#quoteComparisonId').val(response.quoteComparison.id);
                        $('#paymentInformationId').val(response.paymentInformation.id);
                        $('#policyDetailId').val(policyId);
                        $('#selectedQuoteId').val(response.paymentInformation
                            .selected_quote_id);
                        $('#makePaymentModal').modal('show');
                    }
                })
            });

            $(document).on('click', '.processButton', function() {
                var id = $(this).attr('id');
                $('#rtbId').val(id);
                $('#requestToBindModal').modal('show');
            });

            $('#sendRequesToBindFile').on('click', function(e) {
                e.preventDefault();
                var formData = new FormData($('#rtbForm')[0]);
                var id = $('#rtbId').val();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                            'content')
                    },
                    url: "{{ route('product-save-media') }}",
                    method: "POST",
                    data: formData,
                    // dataType: "json",
                    contentType: false,
                    // cache: false,
                    processData: false,
                    success: function(data) {
                        $.ajax({
                            url: "{{ route('change-quotation-status') }}",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                    'content')
                            },
                            method: "POST",
                            data: {
                                status: 24,
                                id: id,
                                cancellationStatus: 'true',
                                policyStatus: 'Rewrite Request To Bind'
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
                    },
                    error: function(e) {
                        console.log(e);
                        Swal.fire({
                            title: 'Error',
                            text: 'Something went wrong',
                            icon: 'error'
                        });
                    }
                });
            });

            function addExistingFiles(files) {
                files.forEach(file => {
                    var mockFile = {
                        id: file.id,
                        name: file.basename,
                        size: parseInt(file.size),
                        type: file.type,
                        status: Dropzone.ADDED,
                        url: file.filepath // URL to the file's location
                    };
                    myDropzone.emit("addedfile", mockFile);
                    // myDropzone.emit("thumbnail", mockFile, file.filepath); // If you have thumbnails
                    myDropzone.emit("complete", mockFile);
                });
            };

            $(document).on('click', '.resendRTB', function() {
                var id = $(this).attr('id');
                $.ajax({
                    url: "{{ route('product-get-rtb-media') }}",
                    method: "POST",
                    data: {
                        id: id,
                        _token: "{{ csrf_token() }}"
                    },
                    dataType: "json",
                    success: function(response) {
                        $('#productId').val(id);
                        addExistingFiles(response.medias);
                        $('#resendRTBModal').modal('show');

                    }
                })
            });

            $('#changeStatusButton').on('click', function() {
                var productId = $('#productId').val();
                $.ajax({
                    url: "{{ route('resend-rtb') }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    method: "POST",
                    data: {
                        id: productId,
                        status: 28,
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
    </script>
@endsection
