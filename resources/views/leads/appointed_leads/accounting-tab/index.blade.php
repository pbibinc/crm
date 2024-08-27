<div class="row mb-2">
    <div class="d-flex justify-content-between align-items-center">
        <div class="card">

        </div>
        <div>
            <button class="btn btn-success btn-sm" id="accountingMakeAPayment" data-product=''>MAKE A
                PAYMENT</button>
        </div>
    </div>
</div>
<div class="row">
    <table id="accountingTable" class="table table-bordered dt-responsive nowrap"
        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
        <thead>
            <tr>
                <th>Type</th>
                <th>Product</th>
                <th>Policy Number</th>
                <th>Invoice Number</th>
                <th>Charged By</th>
                <th>Date</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<div class="modal fade" id="fileViewingModal" tabindex="-1" aria-labelledby="addQuoteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="fileViewingModalTitle">File Upload</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" class="dropzone mt-4 border-dashed" id="invoiceDropzone"
                    enctype="multipart/form-data">
                </form>
                <input type="hidden" id="mediaIds" value="">
            </div>
        </div>
    </div>
</div>

@include(
    'leads.appointed_leads.broker-forms.make-payment-form',
    compact('complianceOfficer', 'selectedQuotes'))

<script>
    Dropzone.autoDiscover = false;
    var myDropzone;
    $(document).ready(function() {
        var id = {{ $generalInformation->lead->id }};
        var generalInformationId = {{ $generalInformation->id }};
        $('#accountingTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                        'content')
                },
                url: "{{ route('payment-list') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id
                }
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
                    data: 'payment-information_status',
                    name: 'payment-information_status'
                },
                {
                    data: 'action',
                    name: 'action'
                }
            ]
        });

        myDropzone = new Dropzone("#invoiceDropzone", {
            url: "#",
            autoProcessQueue: false, // Prevent automatic upload
            clickable: true, // Allow opening file dialog on click
            maxFiles: 10, //
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

        $('#fileViewingModal').on('hide.bs.modal', function() {
            $(".dropzone .dz-preview").remove(); // This removes file previews from the DOM
            myDropzone.files.length = 0;
        });

        $(document).on('click', '.viewInvoiceButton', function(e) {
            e.preventDefault();
            var id = $(this).attr('id');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                        'content')
                },
                url: "{{ route('get-invoice-media') }}",
                method: 'POST',
                data: {
                    id: id,
                    _token: "{{ csrf_token() }}"
                },
                success: function(data) {
                    addExistingFiles(data.media);
                    $('#fileViewingModal').modal('show');
                }
            });
        });

        $('#accountingMakeAPayment').on('click', function(e) {
            e.preventDefault();
            $.ajax({
                type: "GET",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('general-information.edit', ':id') }}".replace(':id',
                    generalInformationId),
                data: {
                    id: id
                },
                success: function(response) {
                    console.log(response);
                    $('#companyName').val(response.lead.company_name);
                    $('#emailAddress').val(response.data.email_address);
                    $('#firstName').val(response.data.firstname);
                    $('#lastName').val(response.data.lastname);
                    $('#leadsId').val(response.lead.id);
                    $('#generalInformationId').val(response.data.id);
                    $('#market').attr('disabled', false);
                    $('#totalPremium').attr('disabled', false);
                    $('#brokerFeeAmount').attr('disabled', false);
                    $('#makePaymentModal').modal('show');
                }
            });


        });

        $(document).on('click', '.editPaymentInformationButton', function(e) {
            e.preventDefault();
            var id = $(this).attr('id');
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
                    if (response.paymentInformation.payment_type == 'Audit' || response
                        .paymentInformation.payment_type == 'Monthly Payment') {
                        $('#totaltPremiumDiv').attr('hidden', true);
                        $('#brokerFeeDiv').attr('hidden', true);
                        $('#paymentTermDiv').attr('hidden', true);
                        $('#effectiveDateDiv').attr('hidden', true);
                        $('#insuranceComplianceByDiv').attr('hidden', true);
                        $('#insuranceCompliance').attr('required', false);
                        $('#paymentTerm').attr('required', false);
                        $('#makePaymentEffectiveDate').attr('required', false);
                        $('#totalPremium').val('required', false);
                        $('#brokerFeeAmount').val('required', false);
                        $('#insuranceCompliance').val('');
                        $('#paymentTerm').val('');
                        $('#selectedQuoteDropdown').val(response.quoteComparison.id);
                    } else {
                        $('#totaltPremiumDiv').attr('hidden', false);
                        $('#brokerFeeDiv').attr('hidden', false);
                        $('#paymentTermDiv').attr('hidden', false);
                        $('#effectiveDateDiv').attr('hidden', false);
                        $('#insuranceComplianceByDiv').attr('hidden', false);
                        $('#insuranceCompliance').attr('required', true);
                        $('#paymentTerm').attr('required', true);
                        $('#makePaymentEffectiveDate').attr('required', true);
                        $('#totalPremium').val('required', true);
                        $('#brokerFeeAmount').val('required', true);

                        $('#selectedQuoteDropdown').val(response.quoteComparison.id);
                    }
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

                    $('#brokerFeeAmount').val(response.quoteComparison.broker_fee);
                    $('#chargedAmount').val(response.paymentInformation.amount_to_charged);
                    $('#note').val(response.paymentInformation.note);
                    $('#generalInformationId').val(response.generalInformation.id);
                    $('#leadsId').val(response.lead.id);
                    $('#quoteComparisonId').val(response.quoteComparison.id);
                    $('#paymentInformationId').val(response.paymentInformation.id);
                    $('#selectedQuoteId').val(response.quoteComparison.id);
                    $('#paymentInformationAction').val('Request A Payment');
                    $('#savePaymentInformation').val('Request A Payment');
                    $('#makePaymentModal').modal('show');
                }
            })
        });

        $(document).on('click', '.editChargedPaymentInformation', function(e) {
            e.preventDefault();
            var id = $(this).attr('id');
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
                    if (response.paymentInformation.payment_type == 'Audit' || response
                        .paymentInformation.payment_type == 'Monthly Payment') {
                        $('#totaltPremiumDiv').attr('hidden', true);
                        $('#brokerFeeDiv').attr('hidden', true);
                        $('#paymentTermDiv').attr('hidden', true);
                        $('#effectiveDateDiv').attr('hidden', true);
                        $('#insuranceComplianceByDiv').attr('hidden', true);
                        $('#insuranceCompliance').attr('required', false);
                        $('#paymentTerm').attr('required', false);
                        $('#makePaymentEffectiveDate').attr('required', false);
                        $('#totalPremium').val('required', false);
                        $('#brokerFeeAmount').val('required', false);
                        $('#insuranceCompliance').val('');
                        $('#paymentTerm').val('');
                        $('#selectedQuoteDropdown').val(response.quoteComparison.id);
                    } else {
                        $('#totaltPremiumDiv').attr('hidden', false);
                        $('#brokerFeeDiv').attr('hidden', false);
                        $('#paymentTermDiv').attr('hidden', false);
                        $('#effectiveDateDiv').attr('hidden', false);
                        $('#insuranceComplianceByDiv').attr('hidden', false);
                        $('#insuranceCompliance').attr('required', true);
                        $('#paymentTerm').attr('required', true);
                        $('#makePaymentEffectiveDate').attr('required', true);
                        $('#totalPremium').val('required', true);
                        $('#brokerFeeAmount').val('required', true);

                        $('#selectedQuoteDropdown').val(response.quoteComparison.id);
                    }
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

                    $('#brokerFeeAmount').val(response.quoteComparison.broker_fee);
                    $('#chargedAmount').val(response.paymentInformation.amount_to_charged);
                    $('#note').val(response.paymentInformation.note);
                    $('#generalInformationId').val(response.generalInformation.id);
                    $('#leadsId').val(response.lead.id);
                    $('#quoteComparisonId').val(response.quoteComparison.id);
                    $('#paymentInformationId').val(response.paymentInformation.id);
                    $('#selectedQuoteId').val(response.quoteComparison.id);
                    $('#paymentInformationAction').val('Update Payment Information');
                    $('#savePaymentInformation').val('Update Payment Information');
                    $('#makePaymentModal').modal('show');
                }
            })
        });

    });
</script>
