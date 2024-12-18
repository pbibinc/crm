<div class="row">
    <table id="financingTable" class="table table-bordered table-sm dt-responsive nowrap financingTable"
        style="font-size: 13px; width: 100%;">
        <thead style="background-color: #f0f0f0;">
            <th>Policy Number</th>
            <th>Company Name</th>
            <th>Product</th>
            <th>Financing Company</th>
            <th>Auto Pay</th>
            {{-- <th>Media</th> --}}
            <th>Action</th>
        </thead>
    </table>
</div>

<div class="modal fade" id="createPfaModal" tabindex="-1" aria-labelledby="createPfaModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createPfaModalgModalTitle">Create Financing Agreement</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" id="createPfaForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="" class="form-label">Policy Number</label>
                                <input type="text" class="form-control" id="policyNumber" name="policyNumber"
                                    disabled>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="" class="form-label">Product</label>
                                <input type="text" class="form-control" id="product" name="product" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="" class="form-label">Financing Company</label>
                                <select name="financingCompany" id="financingCompany" class="form-control" required>
                                    <option value="">Select Financing Company</option>
                                    @foreach ($financeCompany as $company)
                                        <option value="{{ $company->id }}">{{ $company->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="" class="form-label">Amount Financed</label>
                                <input type="text" class="form-control input-mask text-left"
                                    data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'"
                                    inputmode="decimal" style="text-align: right;" id="amountFinanced"
                                    name="amountFinanced">
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="" class="form-label">Down Payment</label>
                                <input type="text" class="form-control input-mask text-left"
                                    data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'"
                                    inputmode="decimal" style="text-align: right;" id="pfaDownPayment"
                                    name="downPayment">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="" class="form-label">Monthly Payment</label>
                                <input type="text" class="form-control input-mask text-left"
                                    data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'"
                                    inputmode="decimal" style="text-align: right;" id="pfaMonthlyPayment"
                                    name="monthlyPayment">
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">

                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Payment Start</label>
                                <input class="form-control" type="date" value="2011-08-19" id="paymentStart"
                                    name="paymentStart" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Due Date</label>
                                <input class="form-control" type="number" id="dueDate" min="1"
                                    max="31" name="dueDate" required>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6" id="uploadFileFormGroup">
                            <div class="form-group">
                                <label for="" class="form-label">Upload File</label>
                                <input type="file" name="pfaFile" id="pfaFile" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="" class="form-label">Auto Pay</label>
                                <div class="square-switch">
                                    <input type="checkbox" id="isAutoPay" switch="info" name="isAutoPay">
                                    <label for="isAutoPay" data-on-label="Yes" data-off-label="No"></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <label for="" id="payOptionLabel" hidden>Pay Option</label>
                            <select name="payOption" class="form-select" id="payOption" hidden>
                                <option value="">Select Payment Option</option>
                                <option value="Recurring ACH">Recurring ACH</option>
                                <option value="Recurring Credit Card">Recurring Credit Card</option>
                            </select>
                        </div>
                        <div class="col-6" id="reaccuringUploadFileDiv">
                            <label for="" id="autoPayFileLabel" hidden>Upload File</label>
                            <input type="file" name="autoPayFile" id="autoPayFile" class="form-control" hidden>
                        </div>
                    </div>
                    <input type="hidden" name="selectedQuoteId" id="pfaSelectedQuoteId">
                    <input type="hidden" name="autoPay" id="autoPay" value="0">
                    <input type="hidden" name="financialStatusId" id="financialStatusId" value="0">
                    <input type="hidden" name="financingAgreementId" id="financingAgreementId">
                    <input type="hidden" name="action" id="action">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="pfaFIleViewModal" tabindex="-1" aria-labelledby="pfaFIleViewModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pfaFIleViewModalTitle">File Upload</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" class="dropzone mt-4 border-dashed" id="pfaFileDropzone"
                    enctype="multipart/form-data" action="{{ route('upload-pfa-file') }}">
                    @csrf
                    <input type="hidden" value="" id="pfaFileHiddenId">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                </form>
                <input type="hidden" id="mediaIds" value="">
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="reaccuringFileViewModal" tabindex="-1" aria-labelledby="reaccuringFileViewModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reaccuringFileViewModalTitle">File Upload</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" class="dropzone mt-4 border-dashed" id="reacurringFileDropzone"
                    enctype="multipart/form-data" action="{{ route('upload-pfa-file') }}">
                    @csrf
                    <input type="hidden" value="" id="reacurringFileHiddenId">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                </form>
                <input type="hidden" id="mediaIds" value="">
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        var id = {{ $leadId }}
        $('.financingTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('get-customers-financing-agreement') }}",
                type: "POST",
                async: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": id
                }
            },
            columns: [{
                    data: 'policy_number',
                    name: 'policy_number'
                },
                {
                    data: 'company_name',
                    name: 'company_name'
                },
                {
                    data: 'product',
                    name: 'product'
                },
                {
                    data: 'financing_company',
                    name: 'financing_company'
                },
                {
                    data: 'auto_pay',
                    name: 'auto_pay'
                },
                // {
                //     data: 'media',
                //     name: 'media'
                // },
                {
                    data: 'action',
                    name: 'action'
                }
            ],
        });

        $(document).on('click', '.editPfaButton', function(e) {
            e.preventDefault();
            var id = $(this).attr('id');
            var url = "{{ route('get-financing-data', ':id') }}".replace(':id', id);
            $.ajax({
                url: url,
                data: {
                    "_token": "{{ csrf_token() }}"
                },
                type: "GET",
                success: function(response) {
                    $('#policyNumber').val(response.selectedQuote.quote_no);
                    $('#product').val(response.quoteProduct.product);
                    $('#financingCompany').val(response.data.financing_company_id);
                    $('#amountFinanced').val(response.data.amount_financed);
                    $('#pfaDownPayment').val(response.data.down_payment);
                    $('#pfaMonthlyPayment').val(response.data.monthly_payment);
                    $('#paymentStart').val(response.data.payment_start);
                    $('#dueDate').val(response.data.due_date);
                    $('#financingAgreementId').val(response.data.id);
                    $('#pfaSelectedQuoteId').val(response.selectedQuote.id);
                    $('#action').val('edit');
                    $('#uploadFileFormGroup').attr('hidden', true);
                    $('#pfaFile').attr('required', false);
                    // Auto Pay handling
                    var isAutoPay = response.data.is_auto_pay == 1;
                    $('#isAutoPay').prop('checked', isAutoPay);

                    // Show or hide elements based on Auto Pay status
                    $('#payOptionLabel, #payOption').attr('hidden', !isAutoPay);
                    if (isAutoPay) {
                        $('#payOption').val(response.paymentOption.payment_option);
                        $('#autoPay').val(1);
                    } else {
                        $('#payOption').val(
                            ''); // Optionally clear the value if Auto Pay is not enabled
                    }
                    $('#reaccuringUploadFileDiv').attr('hidden', true);

                    $('#createPfaModal').modal('show');
                }
            })

        });

        $('#isAutoPay').on('change', function() {
            if ($(this).is(':checked')) {
                $('#autoPay').val(1);
                $('#payOption').removeAttr('hidden', false);
                $('#autoPayFile').removeAttr('hidden', false);
                $('#payOptionLabel').removeAttr('hidden', false);
                $('#autoPayFileLabel').removeAttr('hidden', false);
            } else {
                $('#autoPay').val(0);
                $('#payOption').attr('hidden', true);
                $('#autoPayFile').attr('hidden', true);
                $('#payOptionLabel').attr('hidden', true);
                $('#autoPayFileLabel').attr('hidden', true);
            }
        });

        $('#createPfaForm').on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            var action = $('#action').val();
            var url = action === 'edit' ? "{{ route('update-financing-agreement') }}" :
                "{{ route('financing-agreement.store') }}";
            $.ajax({
                url: url,
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    Swal.fire(
                        'Success!',
                        'PFA Successfully Created',
                        'success'
                    ).then((result) => {
                        $('#createPfaModal').modal('hide');
                        $('#financingTable').ajaxReload();
                    })
                },
                error: function(response) {
                    Swal.fire(
                        'Error!',
                        response.responseJSON.message ||
                        'Financing Agreement Creation Failed!',
                        'error'
                    )
                }
            })

        });

        $('#pfaFIleViewModal').on('hide.bs.modal', function() {
            $(".dropzone .dz-preview")
                .remove(); // This removes file previews from the DOM
            myDropzone.files.length = 0;
        });

        $('#reaccuringFileViewModal').on('hide.bs.modal', function() {
            $(".dropzone .dz-preview")
                .remove(); // This removes file previews from the DOM
            myDropzone.files.length = 0;
        });

        var pfaFileDropzone = new Dropzone("#pfaFileDropzone", {
            url: "{{ route('upload-pfa-file') }}",
            clickable: true, // Allow opening file dialog on click
            uploadMultiple: false, // Set to false for single file upload
            maxFiles: 1, // Allow only one file at a time
            acceptedFiles: 'image/*,application/pdf',
            paramName: "pfaFile", // Match the expected field name in the controller
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}" // Include CSRF token for Laravel
            },
            acceptedFiles: 'image/*,application/pdf',
            init: function() {
                this.on("sending", function(file, xhr, formData) {
                    formData.append("financingAgreementId", $('#pfaFileHiddenId').val());
                });
                this.on("addedfile", function(file) {
                    file.previewElement.addEventListener(
                        "click",
                        function() {
                            var url =
                                "{{ env('APP_FORM_LINK') }}";
                            var fileUrl = url +
                                file.url;
                            Swal.fire({
                                title: 'File Options',
                                text: 'Choose an action for the file',
                                showDenyButton: true,
                                confirmButtonText: `Download`,
                                denyButtonText: `View`,
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    var downloadLink =
                                        document
                                        .createElement(
                                            "a"
                                        );
                                    downloadLink
                                        .href =
                                        fileUrl;
                                    downloadLink
                                        .download =
                                        file
                                        .name;
                                    document
                                        .body
                                        .appendChild(
                                            downloadLink
                                        );
                                    downloadLink
                                        .click();
                                    document
                                        .body
                                        .removeChild(
                                            downloadLink
                                        );
                                } else if (result.isDenied) {
                                    window.open(fileUrl,
                                        '_blank'
                                    );
                                }
                            });
                        });
                });
            }
        });

        var reaccuringFiles = new Dropzone("#reacurringFileDropzone", {
            url: "{{ route('upload-recurring-file') }}",
            clickable: true, // Allow opening file dialog on click
            uploadMultiple: false, // Set to false for single file upload
            maxFiles: 100, // Allow only one file at a time
            acceptedFiles: 'image/*,application/pdf',
            paramName: "autoPayFile", // Match the expected field name in the controller
            addRemoveLinks: true,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}" // Include CSRF token for Laravel
            },
            acceptedFiles: 'image/*,application/pdf',
            init: function() {
                this.on("sending", function(file, xhr, formData) {
                    formData.append("financingAgreementId", $('#reacurringFileHiddenId')
                        .val());
                });
                this.on("addedfile", function(file) {
                    file.previewElement.addEventListener(
                        "click",
                        function() {
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
                                        "a"
                                    );
                                    downloadLink
                                        .href =
                                        fileUrl;
                                    downloadLink
                                        .download =
                                        file
                                        .name;
                                    document
                                        .body
                                        .appendChild(
                                            downloadLink
                                        );
                                    downloadLink
                                        .click();
                                    document
                                        .body
                                        .removeChild(
                                            downloadLink
                                        );
                                } else if (result.isDenied) {
                                    window.open(fileUrl,
                                        '_blank'
                                    );
                                }
                            });
                        });
                });
                this.on('removedfile', function(file) {
                    var mediaId = file.id;
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Proceed with the deletion
                            $.ajax({
                                url: "{{ route('remove-recurring-file') }}",
                                type: "POST",
                                data: {
                                    "_token": "{{ csrf_token() }}",
                                    "mediaId": mediaId
                                },
                                success: function(response) {
                                    console.log(response);
                                },
                                error: function(xhr) {
                                    Swal.fire(
                                        'Error!',
                                        'An error occurred while deleting the file.',
                                        'error'
                                    );
                                }
                            });
                        } else {
                            // Re-add the file if deletion was canceled
                            this.emit("addedfile", file);
                            this.emit("complete", file);
                        }
                    });
                });
            }
        });

        function addExistinPfaFile(file) {
            var mockFile = {
                id: file.id,
                name: file.basename,
                size: parseInt(file.size),
                type: file.type,
                status: Dropzone.ADDED,
                url: file.filepath // URL to the file's location
            };
            pfaFileDropzone.emit("addedfile", mockFile);
            // myDropzone.emit("thumbnail", mockFile, file.filepath); // If you have thumbnails
            pfaFileDropzone.emit("complete", mockFile);

        };

        function addRecuringFiles(files) {
            files.forEach(function(file) {
                var mockFile = {
                    id: file.id,
                    name: file.basename,
                    size: parseInt(file.size),
                    type: file.type,
                    status: Dropzone.ADDED,
                    url: file.filepath // URL to the file's location
                };
                reaccuringFiles.emit("addedfile", mockFile);
                // myDropzone.emit("thumbnail", mockFile, file.filepath); // If you have thumbnails
                reaccuringFiles.emit("complete", mockFile);
            });

        };

        $(document).on('click', '.uploadPFaFile', function(e) {
            e.preventDefault();
            var id = $(this).attr('id');
            $.ajax({
                url: "{{ route('get-financing-data', ':id') }}".replace(':id', id),
                type: "GET",
                success: function(response) {
                    addExistinPfaFile(response.pfaMedia);
                    $('#pfaFileHiddenId').val(id);
                    $('#pfaFIleViewModal').modal('show');
                }
            })
        });

        $(document).on('click', '.uploadRecuringFile', function(e) {
            var id = $(this).attr('id');
            $.ajax({
                url: "{{ route('get-financing-data', ':id') }}".replace(':id', id),
                type: "GET",
                success: function(response) {
                    console.log(response);
                    addRecuringFiles(response.recurringAchMedia);
                    $('#reacurringFileHiddenId').val(id);
                    $('#reaccuringFileViewModal').modal('show');
                }
            })
        });

    })
</script>
