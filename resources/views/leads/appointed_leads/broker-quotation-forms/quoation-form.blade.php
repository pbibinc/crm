<style>
    .input-error {
        border: 1px solid red;
        /* or background-color: #ffcccc; for a red background */
    }
</style>


<div class="row mb-2">
    <div class="col-6 title-card">
        <h4 class="card-title mb-0" style="color: #ffffff">Quoations</h4>
    </div>
    <div class="d-flex justify-content-between">
        <div>
        </div>
        <a href="#" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addQuoteModal" id="create_record">
            ADD QUOTE
        </a>
    </div>
</div>

<div class="row">
    <table id="qoutation-table" class="table table-bordered dt-responsive nowrap"
        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
        <thead>
            <tr>
                <th>Market</th>
                <th>Full Payment</th>
                <th>Down Payment</th>
                <th>Monthly Payment</th>
                <th>Broker Fee</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>


<div class="modal fade" id="uploadFileModal" tabindex="-1" aria-labelledby="addQuoteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadFileModalTitle">File Upload</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="dropzone mt-4 border-dashed" id="dropzoneBrokerQuoation" action="{{ url('/file-upload') }}"
                    method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <input type="hidden" value="" id="hidden_id">
                </form>
                <input type="hidden" id="mediaIds" value="">
            </div>
        </div>
    </div>
</div>

<div class="modal fade " id="addQuoteModal" tabindex="-1" aria-labelledby="addQuoteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addQuoteModalLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="quotationForm" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-2">
                        <div class="col-6">
                            <div class="row">
                                <div class="col-6">
                                    <label for="quoteNo" class="form-label">Policy No/Quote No:</label>
                                </div>
                                <div class="col-6">
                                    <h6 id="quoteNo"></h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="row">
                                <div class="col-6">
                                    <label for="effectiveDate">Effective Date:</label>
                                </div>
                                <div class="col-6">
                                    <h6 id="effectiveDate"></h6>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-2">

                        <div class="col-6">
                            <div class="row">
                                <div class="col-6">
                                    <label for="premium">Total Premium:</label>
                                </div>
                                <div class="col-6">
                                    <h6 id="premium"></h6>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row mb-2">
                        <div class="col-6">
                            <div class="row">
                                <div class="col-6">
                                    <label for="endorsements">Endorsments:</label>
                                </div>
                                <div class="col-6">
                                    <h6 id="endorsements"></h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="row">
                                <div class="col-6">
                                    <label for="policyFee">Policy Fee:</label>
                                </div>
                                <div class="col-6">
                                    <h6 id="policyFee"></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6">
                            <div class="row">
                                <div class="col-6">
                                    <label for="inspectionFee">Inspection Fee:</label>
                                </div>
                                <div class="col-6">
                                    <h6 id="inspectionFee"></h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="row">
                                <div class="col-6">
                                    <label for="stampingFee">Stamping Fee:</label>
                                </div>
                                <div class="col-6">
                                    <h6 id="stampingFee"></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6">
                            <div class="row">
                                <div class="col-6">
                                    <label for="suplusLinesTax">Surplus Lines Tax:</label>
                                </div>
                                <div class="col-6">
                                    <h6 id="suplusLinesTax"></h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="row">
                                <div class="col-6">
                                    <label for="placementFee">Placement Fee:</label>
                                </div>
                                <div class="col-6">
                                    <h6 id="placementFee"></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6">
                            <div class="row">
                                <div class="col-6">
                                    <label for="miscellaneousFee">Miscellaneous Fee:</label>
                                </div>
                                <div class="col-6">
                                    <h6 id="miscellaneousFee"></h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="row">
                                <div class="col-6">
                                    <label for="fullPayment">Full Payment:</label>
                                </div>
                                <div class="col-6">
                                    <h6 id="fullPayment" name="fullPayment"></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <div class="row">
                                <div class="col-6">
                                    <label for="downPayment">Down Payment:</label>
                                </div>
                                <div class="col-6">
                                    <h6 id="downPayment" name="downPayment"></h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="row">
                                <div class="col-6">
                                    <label for="monthlyPayment">Monthly Payment:</label>
                                </div>
                                <div class="col-6">
                                    <h6 id="monthlyPayment" name="monthlyPayment"></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6">
                            <label for="brokerFee">Broker Fee</label>
                            <input type="text" class="form-control input-mask text-left calculateInput"
                                id="brokerFee" name="brokerFee"
                                data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'"
                                inputmode="decimal" style="text-align: right;" required autocomplete="off">
                        </div>

                    </div>
                    {{-- <div class="my-dropzone mt-4 border-dashed">
                        <div class="dz-message" data-dz-message><span>Drop files here or click to upload.</span></div>
                    </div> --}}

                    <input type="hidden" name="product_hidden_id" id="product_hidden_id" />
                    <input type="hidden" id="hiddenFullpayment" name="hiddenFullpayment">
                    <input type="hidden" id="hiddenDownpayment" name="hiddenDownpayment">
                    <input type="hidden" id="sender" name="sender" value="broker">
                    <input type="hidden" name="currentMarketId" id="currentMarketId">

            </div>
            <div class="modal-footer">
                <div>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <input type="submit" name="action_button" id="action_button" value="Add"
                        class="btn btn-primary">
                </div>
            </div>
            </form>
        </div>
    </div>
</div>

@include('leads.appointed_leads.broker-forms.make-payment-form', compact('complianceOfficer'))

<script>
    Dropzone.autoDiscover = false;
    var myDropzoneBroker;
    $(document).ready(function() {
        var url = "{{ env('APP_FORM_URL') }}" + "/upload";
        myDropzoneBroker = new Dropzone("#dropzoneBrokerQuoation", {
            clickable: true,
            init: function() {
                this.on("sending", function(file, xhr, formData) {

                    // Get the value from the hidden input
                    var hiddenId = $('#hidden_id').val();
                    // Append it to the FormData object
                    formData.append("hidden_id", hiddenId);

                });
                this.on("removedfile", function(file, formData) {
                    var id = file.id;
                    var url = "{{ url('/delete-quotation-file') }}"
                    // Get the value from the hidden input
                    var hiddenId = $('#hidden_id').val();
                    Swal.fire({
                        title: 'Confirm File Removal',
                        text: 'Are you sure you want to remove this file?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, remove it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: url, // Replace with your delete file route
                                method: "POST",
                                data: {
                                    id: id,
                                    hiddenId: hiddenId,
                                    _token: "{{ csrf_token() }}"
                                },
                                dataType: "json",
                                success: function(response) {
                                    console.log(response);
                                },
                                error: function(xhr, textStatus,
                                    errorThrown) {
                                    console.error(textStatus);
                                }
                            });
                        } else {
                            Swal.fire(
                                'Cancelled',
                                'Your file is safe :)',
                                'error'
                            )
                        }
                    })

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
            },
            renameFile: function(file) {
                var dt = new Date();
                var date = dt.toLocaleDateString('en-US', {
                    year: 'numeric',
                    month: '2-digit',
                    day: '2-digit'
                }).replace(/\//g, '-');
                var time = dt.getTime();
                var name = file.name;
                var ext = name.substring(name.lastIndexOf('.')); // gets the file extension
                var newName = date + '_' + time + '_' + name.replace(ext, '') +
                    ext; // prepend date and timestamp before the name, and keep the extension at the end
                return newName;
            },
            addRemoveLinks: true,
            timeout: 5000,
            success: function(file, response) {
                console.log(response);
            },
            error: function(file, response) {
                return false;
            }
        });
        var id = {{ $quoteProduct->id }};
        $('#qoutation-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                        'content')
                },
                url: "{{ route('get-general-liabilities-quotation-table') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id
                }
            },
            columns: [{
                    data: 'market_name',
                    name: 'market_name'
                },
                {
                    data: 'full_payment',
                    name: 'full_payment'
                },
                {
                    data: 'down_payment',
                    name: 'down_payment'
                },
                {
                    data: 'monthly_payment',
                    name: 'monthly_payment'
                },
                {
                    data: 'broker_fee',
                    name: 'broker_fee'
                },
                {
                    data: 'broker_action',
                    name: 'broker_action',
                    orderable: false
                }
            ],
            createdRow: function(row, data, dataIndex) {
                var status = data.status;
                if (status == 2) {
                    $(row).addClass('table-warning');
                } else if (status == 3) {
                    $(row).addClass('table-success');
                }
            }
        });

        //checkbox for recommended
        $('#reccomended').change(function() {
            if ($(this).is(':checked')) {
                $('#recommended_hidden').val(1);
            } else {
                $('#recommended_hidden').val(0);
            }
        });

        //deletion of quote
        $(document).on('click', '.deleteButton', function(e) {
            e.preventDefault();
            var id = $(this).attr('id');
            Swal.fire({
                title: 'Are you sure?',
                text: 'You will not be able to recover this!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, keep it'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('delete-quotation-comparison') }}",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                'content')
                        },
                        method: "POST",
                        data: {
                            id: id
                        },
                        success: function() {
                            Swal.fire({
                                title: 'Success',
                                text: 'has been deleted',
                                icon: 'success'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $('#qoutation-table').DataTable()
                                        .ajax
                                        .reload();
                                }
                            })
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

        $(document).on('click', '#create_record', function(e) {
            e.preventDefault();
            $('#action').val('add');
            $('#marketDropdown, #fullPayment, #downPayment').removeClass('input-error');
            $('#addQuoteModal').modal('show');
            $('#action_button').val('Add');
            $('#medias').show();
            $('#mediaLabelId').show();
        });

        $(document).on('change', '#attachedFile', function() {
            var file = $(this)[0].files[0];
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#currentImage').attr('src', e.target.result).show();
            }
            reader.readAsDataURL(file);
        })

        function addExistingQuotationFiles(files) {

            files.forEach(file => {
                var mockFile = {
                    id: file.id,
                    name: file.basename,
                    size: parseInt(file.size),
                    type: file.type,
                    status: Dropzone.ADDED,
                    url: file.filepath // URL to the file's location
                };
                myDropzoneBroker.emit("addedfile", mockFile);
                // myDropzoneBroker.emit("thumbnail", mockFile, file.filepath); // If you have thumbnails
                myDropzoneBroker.emit("complete", mockFile);
            });
        };

        $('#uploadFileModal').on('hide.bs.modal', function() {
            $(".dropzone .dz-preview").remove(); // This removes file previews from the DOM
            myDropzoneBroker.files.length = 0;
        });

        //upload file button functionalities
        $(document).on('click', '.uploadFileButton', function(e) {
            e.preventDefault();
            var id = $(this).attr('id');
            $.ajax({
                url: "{{ route('edit-quotation-comparison') }}",
                method: "POST",
                data: {
                    id: id,
                    _token: "{{ csrf_token() }}"
                },
                dataType: "json",
                success: function(response) {
                    $('#hidden_id').val(response.data.id);
                    var files = response.media;
                    addExistingQuotationFiles(files);
                    $('#uploadFileModal').modal('show');
                }
            });
        });

        //edit button functionalities
        $(document).on('click', '.editButton', function(e) {
            e.preventDefault();
            var id = $(this).attr('id');
            $('#action').val('edit');
            $('#marketDropdown, #fullPayment, #downPayment').removeClass('input-error');
            $.ajax({
                url: "{{ route('edit-quotation-comparison') }}",
                method: "POST",
                data: {
                    id: id,
                    _token: "{{ csrf_token() }}"
                },
                dataType: "json",
                success: function(response) {
                    // console.log(response.data.id)
                    var url = `{{ asset('${response.media.filepath}') }}`;
                    var filename = response.data.basename;

                    //pricing breakdown inputs
                    $('#premium').text(response.pricingBreakdown.premium);
                    $('#endorsements').text(response.pricingBreakdown.endorsements);
                    $('#policyFee').text(response.pricingBreakdown.policy_fee);
                    $('#inspectionFee').text(response.pricingBreakdown.inspection_fee);
                    $('#stampingFee').text(response.pricingBreakdown.stamping_fee);
                    $('#suplusLinesTax').text(response.pricingBreakdown.surplus_lines_tax);
                    $('#placementFee').text(response.pricingBreakdown.placement_fee);
                    $('#miscellaneousFee').text(response.pricingBreakdown
                        .miscellaneous_fee);

                    $('#market').text(response.market.name);
                    $('#addQuoteModalLabel').text(response.market.name);
                    $('#effectiveDate').text(response.data.effective_date);
                    $('#fullPayment').text(response.data.full_payment);
                    $('#hiddenFullpayment').val(response.data.full_payment);
                    $('#downPayment').text(response.data.down_payment);
                    $('#hiddenDownpayment').val(response.data.down_payment);
                    $('#monthlyPayment').text(response.data.monthly_payment);
                    $('#brokerFee').val(response.data.broker_fee);
                    $('#product_hidden_id').val(response.data.id);
                    $('#productId').text(response.data.quotation_product_id);
                    $('#quoteNo').text(response.data.quote_no);
                    $('#currentMarketId').val(response.data.quotation_market_id);
                    $('#medias').hide();
                    $('#mediaLabelId').hide();
                    $('#action_button').val('Update');
                    if (response.data.recommended == 1) {
                        $('#reccomended').prop('checked', true);
                    } else {
                        $('#reccomended').prop('checked', false);
                    }
                    $('#addQuoteModal').modal('show');
                }
            });

        });

        //submition of form
        $('#quotationForm').on('submit', function(event) {
            event.preventDefault();
            $.ajax({
                url: "{{ route('update-quotation-comparison') }}",
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                        'content')
                },
                processData: false, // Prevent jQuery from processing the data
                contentType: false,
                data: new FormData(this),
                dataType: "json",
                success: function(response) {
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Quotation Comparison has been saved',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        $('#addQuoteModal').modal('hide');
                        $('#qoutation-table').DataTable().ajax.reload();
                    });
                },
                error: function(data) {
                    var errors = data.responseJSON.errors;
                    console.log(data);
                    if (data.status == 422) {
                        Swal.fire({
                            title: 'Error',
                            text: data.responseJSON.error,
                            icon: 'error'
                        });
                        $('#marketDropdown').addClass('input-error');
                    }
                    if (errors) {
                        $.each(errors, function(key, value) {
                            $('#' + key).addClass('input-error');
                            $('#' + key + '_error').html(value);
                        });
                    }
                }
            });

        });

        //function for parsing
        function parseCurrency(num) {
            return parseFloat(num.replace(/[^0-9-.]/g, ''));
        }

        $('#brokerFee').on('focus', function() {
            let currentBrokerFee = parseCurrency($(this).val()) || 0;
            $(this).data('lastBrokerFee', currentBrokerFee);
        });

        $('#brokerFee').on('input', function() {
            const currentBrokerFee = parseCurrency($(this).val()) || 0;
            const lastBrokerFee = $(this).data('lastBrokerFee') || 0;

            let fullPayment = parseCurrency($('#fullPayment').text()) || 0;
            let downPayment = parseCurrency($('#downPayment').text()) || 0;

            // Subtract last broker fee and add new broker fee
            fullPayment = fullPayment - lastBrokerFee + currentBrokerFee;
            downPayment = downPayment - lastBrokerFee + currentBrokerFee;

            // Format and update their values
            $('#fullPayment').text('$ ' + fullPayment.toFixed(2).replace(/\d(?=(\d{3})+\.)/g,
                '$&,'));
            $('#downPayment').text('$ ' + downPayment.toFixed(2).replace(/\d(?=(\d{3})+\.)/g,
                '$&,'));

            $('#hiddenFullpayment').val('$ ' + fullPayment.toFixed(2).replace(/\d(?=(\d{3})+\.)/g,
                '$&,'));
            $('#hiddenDownpayment').val('$ ' + downPayment.toFixed(2).replace(/\d(?=(\d{3})+\.)/g,
                '$&,'));

            // Update the last broker fee for the next change
            $(this).data('lastBrokerFee', currentBrokerFee);
        });


        //function for resetting the input inside modal
        $('#addQuoteModal').on('hide.bs.modal', function() {
            // Reset the content of the modal
            $(this).find('form').trigger('reset'); // Reset all form fields
            // If there are other elements to clear, handle them here
            $('#marketDropdown, #fullPayment, #downPayment').removeClass('input-error');
        });

        //broker side make payment button
        $(document).on('click', '.makePaymentButton', function() {

            var id = $(this).attr('id');
            var market = $(this).attr('data-market');
            var quoteNo = $(this).attr('data-quoteNo');
            var companyName = $(this).attr('data-company-name');
            var firstname = $(this).attr('data-insured-firstname');
            var lastname = $(this).attr('data-insured-lastname');
            var email = $(this).attr('data-email');
            var totalPremium = $(this).attr('data-total-premium');
            var brokerFee = $(this).attr('data-broker-fee');
            var generalInformationId = $(this).attr('data-general-information-id');
            var leadsId = $(this).attr('data-lead-id');
            var effectiveDate = $(this).attr('data-effective-date');
            var paymentInformation = $(this).attr('data-payment-information') ? JSON.parse($(this).attr(
                'data-payment-information')) : {};

            if (Object.keys(paymentInformation).length !== 0) {
                $('#paymentTerm').val(paymentInformation.payment_term);
                if (paymentInformation.payment_method == 'Visa' || paymentInformation.payment_method ==
                    'Master Card' || paymentInformation.payment_method == 'American Express' ||
                    paymentInformation
                    .payment_method == 'Discover') {
                    $('#paymentMethodMakePayment').val('Credit Card');
                    $('#cardType').attr('hidden', false);
                    $('#cardTypeLabel').attr('hidden', false);
                    $('#cardType').val(paymentInformation.payment_method);
                } else if (paymentInformation.method == 'Checking') {
                    $('#paymentMethodMakePayment').val('Checking');

                } else {
                    $('#paymentMethodMakePayment').val('Credit Card');
                    $('#cardType').attr('hidden', false);
                    $('#cardType').val('Other');
                    $('#cardTypeLabel').attr('hidden', false);
                    $('#otherCardLabel').attr('hidden', false);
                    $('#otherCard').attr('hidden', false);
                    $('#otherCard').val(paymentInformation.payment_method);
                }
            }
            $('#quoteNumber').val(quoteNo);
            $('#market').val(market);
            $('#companyName').val(companyName);
            $(
                '#firstName').val(firstname);
            $('#lastName').val(lastname);
            $('#emailAddress').val(
                email);
            $('#totalPremium').val(totalPremium);
            $('#brokerFeeAmount').val(brokerFee);
            $(
                '#generalInformationId').val(generalInformationId);
            $('#leadsId').val(leadsId);
            $(
                '#quoteComparisonId').val(id);
            $('#makePaymentEffectiveDate').val(effectiveDate);
            $(
                '#paymentType').val(paymentInformation.payment_type);
            $('#insuranceCompliance').val(
                paymentInformation.compliance_by);
            $('#paymentMethod').val(paymentInformation
                .payment_method);
            $('#statusInput').val($(this).attr('data-status'));
            $(
                '#quotationProductId').val($(this).attr('data-productId'));

            $('#chargedAmount').val(paymentInformation.amount_to_charged);
            $('#note').val(paymentInformation
                .note);
            $('#paymentInformationId').val(paymentInformation.id);
            $('#makePaymentModal').modal(
                'show');
            // $('#makePaymentModalTitle').text(
            //     `Make A Payment For Market' ${market} 'With Quote No'  ${quoteNo}`);
        });
    });
</script>
