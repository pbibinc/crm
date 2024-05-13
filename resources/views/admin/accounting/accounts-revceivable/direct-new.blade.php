<table id="account-payable-table" class="table table-bordered dt-responsive nowrap"
    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
    <thead>
        <tr>
            <th>Policy Number</th>
            <th>Payment Type</th>
            <th>Product</th>
            <th>Company Name</th>
            <th>Requested By</th>
            <th>Requested Date</th>
            <th>Action</th>
        </tr>
    </thead>
</table>

<div class="modal fade" id="dataModal" tabindex="-1" aria-labelledby="dataModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dataModalTitle">Payment Information</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-2">
                    <div class="col-3">
                        <label for="paymentType">Payment Type:</label>
                    </div>
                    <div class="col-9">
                        <h6 id="paymentType">
                        </h6>

                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-3">
                        <label for="complianceOfficer">Compliance By</label>
                    </div>
                    <div class="col-9">
                        <h6 id="complianceOfficer">
                        </h6>
                    </div>

                </div>
                <div class="row mb-2">
                    <div class="col-3">
                        <label for="market">Market:</label>
                    </div>
                    <div class="col-9">
                        <h6 id="market"></h6>

                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-3">
                        <label for="quoteNo">Policy No./Quote No:</label>
                    </div>
                    <div class="col-9">
                        <h6 id="quoteNo"></h6>
                    </div>

                </div>
                <div class="row mb-2">
                    <div class="col-3">
                        <label for="insuredName">Insured's Name:</label>
                    </div>
                    <div class="col-9">
                        <h6 id="insuredName"></h6>

                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-3">
                        <label for="companyName">DBA:</label>
                    </div>
                    <div class="col-9">
                        <h6 id="companyName"></h6>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-3">
                        <label for="productType">Product Type:</label>
                    </div>
                    <div class="col-9">
                        <h6 id="productType"></h6>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-3">
                        <label for="emailAddress">Email Address:</label>
                    </div>
                    <div class="col-9">
                        <h6 id="emailAddress"></h6>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-3">
                        <label for="effectiveDate">Effective Date:</label>
                    </div>
                    <div class="col-9">
                        <h6 id="effectiveDate"></h6>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-3">
                        <label for="paymentMethod">Payment Method</label>
                    </div>
                    <div class="col-9">
                        <h6 id="paymentMethod"></h6>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-3">
                        <label for="totalPremium">Total Premium</label>
                    </div>
                    <div class="col-9">
                        <h6 id="totalPremium"></h6>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-3">
                        <label for="amountToCharged">Amount to Charge:</label>
                    </div>
                    <div class="col-9">
                        <h6 id="amountToCharged"></h6>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-3">
                        <label for="paymentInformationNote">Note</label>
                    </div>
                    <div class="col-9">
                        <h6 id="paymentInformationNote"></h6>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-12">
                        <form action="" class="dropzone mt-4 border-dashed" id="dropzone"
                            enctype="multipart/form-data"></form>
                    </div>
                </div>

                {{-- <div class="row">
                            <div class="col-12">
                                <label for="receiptUpload">Attached Official Receipt</label>
                                <input type="file" class="form-control" id="receiptUpload" multiple>
                            </div>
                        </div> --}}
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button class="btn btn-warning" type="button" id="declinedPaymentButton">Declined</button>
                <button class="btn btn-info" type="" id="paymentFormButton">Open Payment Form</button>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="modalForm" tabindex="-1" aria-labelledby="modalForm" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalFormTitle">Payment Form</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" id="paymentChargedForm" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-2">
                        <div class="col-6">
                            <label for="paymentType">Invoice Number:</label>
                            <input type="text" class="form-control" id="invoiceNumber" name="invoiceNumber">
                        </div>
                        <div class="col-6">
                            <label for="invoiceMediaLabel">Attached File:</label>
                            <input type="file" class="form-control" id="invoiceFile" name="invoiceFile" multiple>
                        </div>
                    </div>
                    <input type="hidden" value="" id="paymentInformationId" name="paymentInformationId">
                    <input type="hidden" value="" id="quoteComparisonId" name="quoteComparisonId">
                    <input type="hidden" value="" id="quotationProductId" name="quotationProductId">

            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" id="backToPaymentInformationButton">Back</button>

                <input type="submit" class="btn btn-success">

            </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="declinedPaymentForm" tabindex="-1" aria-labelledby="declinedPaymentForm"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="declinedPaymentFormTitle">Declined Payment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    {{-- <label for="notesDescription">Description:</label> --}}
                    <div>
                        <textarea required="" class="form-control" rows="5" placeholder="Type a note..." id="noteDescription"
                            required></textarea>
                        <div class="invalid-feedback" id="noteDescriptionError"></div>
                    </div>
                </div>
                <input type="hidden" id="declinedHiddenTitle" name="declinedHiddenTitle">
                <input type="hidden" name="declinedHiddenProductId" id="declinedHiddenProductId">
                <input type="hidden" name="declinedLeadId" id="declinedLeadId">
                <input type="hidden" name="userToNotify" id="userToNotify">
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" id="bactkToViewInforationButton">Back</button>
                <button type="button" class="btn btn-outline-primary waves-effect waves-light" id="logNote"><i
                        class="ri-send-plane-fill"></i>Log Note</button>
            </div>

        </div>
    </div>
</div>



<script>
    Dropzone.autoDiscover = false;
    var myDropzone;
    $(document).ready(function() {
        $('#account-payable-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                        'content')
                },
                url: "{{ route('accounting-payable') }}",
                data: {
                    _token: "{{ csrf_token() }}"
                }
            },
            columns: [{
                    data: 'quote_no',
                    name: 'quote_no'
                },
                {
                    data: 'payment_type',
                    name: 'payment_type'
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
                    data: 'requested_date',
                    name: 'requested_date'
                },
                {
                    data: 'action',
                    name: 'action'
                }
            ],
            createdRow: function(row, data, dataIndex) {
                var status = data.status;
                if (status == 13) {
                    $(row).addClass('table-danger');
                } else if (status == 16) {
                    $(row).addClass('table-warning');
                }
            }

        });

        myDropzone = new Dropzone(".dropzone", {
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

        $('#dataModal').on('hide.bs.modal', function() {
            $(".dropzone .dz-preview").remove(); // This removes file previews from the DOM
            myDropzone.files.length = 0;
        });

        // $('#paymentInform').on('submit', function(e) {
        //     e.preventDefault();

        // });
        var paymentInformatioId;
        $(document).on('click', '.viewPaymentInformationButton', function() {
            var id = $(this).attr('id');
            paymentInformatioId = id;
            $.ajax({
                url: "{{ route('get-payment-information') }}",
                method: "GET",
                data: {
                    id: id,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    var files = response.medias;
                    // var userId = respinse.
                    console.log(response);
                    $('#paymentInformationId').val(response.paymentInformation.id);
                    $('#quoteComparisonId').val(response.quoteComparison.id);
                    $('#quotationProductId').val(response.quotationProduct.id);
                    $('#paymentType').text(response.paymentInformation.payment_type);
                    $('#complianceOfficer').text(response.paymentInformation.compliance_by);
                    $('#market').text(response.market.name);
                    $('#quoteNo').text(response.quoteComparison.quote_no);
                    $('#insuredName').text(response.fullName);
                    $('#companyName').text(response.lead.company_name);
                    $('#productType').text(response.quotationProduct.product);
                    $('#emailAddress').text(response.generalInformation.email_address);
                    $('#effectiveDate').text(response.quoteComparison.effective_date);
                    $('#paymentMethod').text(response.paymentInformation.payment_method);
                    $('#totalPremium').text(response.quoteComparison.full_payment);
                    $('#amountToCharged').text(response.paymentInformation
                        .amount_to_charged);
                    $('#paymentInformationNote').text(response.paymentInformation.note);
                    addExistingFiles(files);
                    $('#declinedHiddenTitle').val('Declined Payment For ' + response
                        .quotationProduct.product);
                    $('#declinedHiddenProductId').val(response.quotationProduct.id);
                    $('#declinedLeadId').val(response.lead
                        .id);
                    $('#userToNotify').val(response.userId);
                    $('#dataModal').modal('show');
                }
            })
        });

        // $('#dataMdal').on('show.bs.modal', function() {
        //     $('#paymentInformationNote').text(response.paymentInformation.note);
        //     addExistingFiles(files);
        // });

        $('#paymentChargedForm').on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                        'content')
                },
                url: "{{ route('payment-charged.store') }}",
                method: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    $('#modalForm').modal('hide');
                    $('#dataModal').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Payment Charged Successfully',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $('#account-payable-table').DataTable().ajax.reload();
                        }
                    });
                }
            })
        });

        $('#paymentFormButton').on('click', function() {
            // console.log('test this code');
            $('#modalForm').modal('show');
            $('#dataModal').modal('hide');
        });

        $('#backToPaymentInformationButton').on('click', function() {
            // var id = $(this).attr('id');
            $.ajax({
                url: "{{ route('get-payment-information') }}",
                method: "GET",
                data: {
                    id: paymentInformatioId,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    var files = response.medias;
                    $('#paymentInformationId').val(response.paymentInformation.id);
                    $('#quoteComparisonId').val(response.quoteComparison.id);
                    $('#quotationProductId').val(response.quotationProduct.id);
                    $('#paymentType').text(response.paymentInformation.payment_type);
                    $('#complianceOfficer').text(response.paymentInformation.compliance_by);
                    $('#market').text(response.market.name);
                    $('#quoteNo').text(response.quoteComparison.quote_no);
                    $('#insuredName').text(response.fullName);
                    $('#companyName').text(response.lead.company_name);
                    $('#productType').text(response.quotationProduct.product);
                    $('#emailAddress').text(response.generalInformation.email_address);
                    $('#effectiveDate').text(response.quoteComparison.effective_date);
                    $('#cardType').text(response.paymentInformation.credit_type);
                    $('#totalPremium').text(response.quoteComparison.full_payment);
                    $('#amountToCharged').text(response.paymentInformation
                        .amount_to_charged);
                    $('#paymentInformationNote').text(response.paymentInformation.note);
                    addExistingFiles(files);
                    $('#modalForm').modal('hide');
                    $('#dataModal').modal('show');
                }
            })
        });

        $('#declinedPaymentButton').on('click', function(e) {
            e.preventDefault();
            $('#declinedPaymentForm').modal('show');
            $('#dataModal').modal('hide');
        });

        $('#bactkToViewInforationButton').on('click', function(e) {
            e.preventDefault();
            $('#declinedPaymentForm').modal('hide');
            $('#dataModal').modal('show');
        });

        $('#logNote').on('click', function(e) {
            e.preventDefault();
            var noteTitle = $('#declinedHiddenTitle').val();
            var status = 'declined-make-payment';
            var productId = $('#declinedHiddenProductId').val();
            var leadId = $('#declinedLeadId').val();
            var noteDescription = $('#noteDescription').val();
            var userToNotify = $('#userToNotify').val();
            $.ajax({
                url: "{{ route('create-notes') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                        'content')
                },
                method: "POST",
                data: {
                    icon: 'error',
                    userToNotify: [userToNotify],
                    noteTitle: noteTitle,
                    noteDescription: noteDescription,
                    leadId: leadId,
                    status: status,
                    productId: productId
                },
                success: function(data) {
                    $.ajax({
                        url: "{{ route('change-quotation-status') }}",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                'content')
                        },
                        method: "POST",
                        data: {
                            id: productId,
                            status: 13,
                        },
                        success: function() {
                            Swal.fire({
                                title: 'Success',
                                text: 'has been saved',
                                icon: 'success'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $('#account-payable-table')
                                        .DataTable().ajax.reload();
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
                error: function(jqXHR, testStatus, errorThrown) {

                }
            });
        });

    })
</script>
