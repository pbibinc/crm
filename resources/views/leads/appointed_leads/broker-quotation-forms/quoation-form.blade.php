@php
    use App\Models\SelectedQuote;
    use App\Models\QuoteComparison;
    use App\Models\PaymentInformation;

    $selectedQuote = SelectedQuote::where('quotation_product_id', $quoteProduct->id)
        ->latest()
        ->first();
    $quoteComparison = QuoteComparison::where('quotation_product_id', $quoteProduct->id)
        ->where('recommended', 2)
        ->first();
    $selectedQuoteId = $selectedQuote ? $selectedQuote->id : null;
    $paymentInformation = PaymentInformation::where('selected_quote_id', $selectedQuoteId)->first() ?? null;
@endphp

<style>
    .input-error {
        border: 1px solid red;
        /* or background-color: #ffcccc; for a red background */
    }
</style>
<div class="row mb-2">
    <div class="col-6 title-card">
        <h4 class="card-title mb-0" style="color: #ffffff">Request Quote Approval For {{ $quoteProduct->product }} </h4>
    </div>
    <div class="d-flex justify-content-between">
        <div class="row">
            <div class="col-12">
                <label for="product" class="form-label">Product</label>
                <select name="product" id="tableProductDropdown" class="form-select form-select-sm">
                    <option value="">Select Product</option>
                    @foreach ($productsDropdown as $product)
                        <option value="{{ $product }}">{{ $product }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div>
            {{-- <a href="#" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addQuoteModal"
                id="create_record">
                ADD QUOTE
            </a> --}}
        </div>
    </div>
    {{-- <div class="col-6 title-card">
        <h4 class="card-title mb-0" style="color: #ffffff">Quoations</h4>
    </div>
    <div class="d-flex justify-content-between">
        <div>
        </div>
        <a href="#" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addQuoteModal" id="create_record">
            ADD QUOTE
        </a>
    </div> --}}
</div>

<div class="row mb-3">
    <table id="BrokerQuotationTable" class="table table-bordered dt-responsive nowrap BrokerQuotationTable"
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

@if ($selectedQuote)
    <div class="row mb-2">
        <div class="col-6 title-card">
            <h4 class="card-title mb-0" style="color: #ffffff">Selected Quote Information</h4>
        </div>
        <div class="d-flex justify-content-between">
            <div>
            </div>
            <div>
                <button class="btn btn-primary editSelectedQuote" id="editSelectedQuote">
                    EDIT QUOTE
                </button>
                {{-- @if ($paymentInformation)
                    <button class="btn btn-primary editQuotationtMakePayment" id="makePaymentButton">
                        EDIT MAKE PAYMENT
                    </button>
                @else
                    <button class="btn btn-success makeQuotationPaymentButton" id="makePaymentButton">
                        MAKE PAYMENT
                    </button>
                @endif --}}

                {{-- @if ($paymentInformation->status == 'declined')
                    <button class="btn btn-success resendMakePayement" id="makePaymentButton">
                        RESEND PAYMENT
                    </button>
                @endif --}}

            </div>

        </div>
    </div>
    <div class="row">
        @include(
            'leads.appointed_leads.broker-quotation-forms.selected-quotation-form',
            compact('quoteProduct'));
    </div>
@endif


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
                <h5 class="modal-title" id="addQuoteModalLabel">Add Quotation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="quotationForm" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-2">
                        <div class="col-6">
                            <label for="marketDropdown">Market</label>
                            <select name="marketDropdown" id="marketDropdown" class="form-select">
                                <option value="">Select Market</option>
                                @foreach ($quationMarket as $market)
                                    <option value={{ $market->id }}>{{ $market->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6">
                            <label for="quoteNo" class="form-label">Policy No/Quote No:</label>
                            <input type="text" class="form-control" id="quoteNo" name="quoteNo" required
                                autocomplete="off">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6">
                            <label for="premium">Premium</label>
                            <input type="text" class="form-control calculateInput input-mask text-left"
                                id="premium" name="premium"
                                data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'"
                                inputmode="decimal" style="text-align: right;" required autocomplete="off">
                        </div>
                        <div class="col-6">
                            <label for="endorsements">Endorsements</label>
                            <input type="text" class="form-control input-mask text-left calculateInput"
                                id="endorsements" name="endorsements"
                                data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'"
                                inputmode="decimal" style="text-align: right;" autocomplete="off">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6">
                            <label for="policyFee">Policy Fee</label>
                            <input type="text" class="form-control input-mask text-left calculateInput"
                                id="policyFee" name="policyFee"
                                data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'"
                                inputmode="decimal" style="text-align: right;" autocomplete="off">
                        </div>
                        <div class="col-6">
                            <label for="inspectionFee">Inspection Fee</label>
                            <input type="text" class="form-control input-mask text-left calculateInput"
                                id="inspectionFee" name="inspectionFee"
                                data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'"
                                inputmode="decimal" style="text-align: right;" autocomplete="off">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6">
                            <label for="stampingFee">Stamping Fee</label>
                            <input type="text" class="form-control input-mask text-left calculateInput"
                                id="stampingFee" name="stampingFee"
                                data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'"
                                inputmode="decimal" style="text-align: right;" autocomplete="off">
                        </div>
                        <div class="col-6">
                            <label for="surplusLinesTax">Surplus lines Tax</label>
                            <input type="text" class="form-control input-mask text-left calculateInput"
                                id="surplusLinesTax" name="surplusLinesTax"
                                data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'"
                                inputmode="decimal" style="text-align: right;" autocomplete="off">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6">
                            <label for="placementFee">Placement Fee</label>
                            <input type="text" class="form-control input-mask text-left calculateInput"
                                id="placementFee" name="placementFee"
                                data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'"
                                inputmode="decimal" style="text-align: right;" required autocomplete="off">
                        </div>
                        <div class="col-6">
                            <label for="brokerFee">Broker Fee</label>
                            <input type="text" class="form-control input-mask text-left calculateInput"
                                id="brokerFee" name="brokerFee"
                                data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'"
                                inputmode="decimal" style="text-align: right;" required autocomplete="off">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6">
                            <label for="miscellaneousFee">Miscellaneous Fee</label>
                            <input type="text" class="form-control input-mask text-left calculateInput"
                                id="miscellaneousFee" name="miscellaneousFee"
                                data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'"
                                inputmode="decimal" style="text-align: right;" required autocomplete="off">
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-6">
                            <label for="fullPayment" class="form-label">Full Payment</label>
                            <input type="text" class="form-control input-mask text-left"
                                data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'"
                                inputmode="decimal" style="text-align: right;" id="fullPayment" name="fullPayment"
                                required readonly>
                        </div>
                        <div class="col-6">
                            <label for="downPayment" class="form-label">Down Payment</label>
                            <input type="text" class="form-control input-mask text-left" id="downPayment"
                                name="downPayment"
                                data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'"
                                inputmode="decimal" style="text-align: right;" required autocomplete="off">
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-6">
                            <label for="monthlyPayment" class="form-label">Monthly Payment</label>
                            <input type="text" class="form-control input-mask text-left" id="monthlyPayment"
                                name="monthlyPayment"
                                data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'"
                                inputmode="decimal" style="text-align: right;" required autocomplete="off">
                        </div>
                        <div class="col-6">
                            <label for="numberOfPayment" class="form-label">Number of Paymment</label>
                            <input type="number" class="form-control" id="numberOfPayment" name="numberOfPayment">
                        </div>

                    </div>

                    <div class="row mb-2">
                        <div class="col-6">
                            <label for="effectiveDate">Effective Date</label>
                            <input type="date" class="form-control" id="effectiveDate" name="effectiveDate"
                                required>
                        </div>
                    </div>

                    <div class="row">
                        <div>
                            <label for="medias" id="mediaLabelId">Attached File</label>
                            <input type="file" class="form-control" name="photos[]" id="medias" multiple />
                        </div>
                    </div>
                    <input type="hidden" name="action" id="action" value="add">
                    <input type="hidden" name="product_hidden_id" id="product_hidden_id" />
                    <input type="hidden" name="productId" id="productId" value="{{ $quoteProduct->id }}">
                    <input type="hidden" name="recommended" id="recommended_hidden" value="0" />
                    <input type="hidden" name="currentMarketId" id="currentMarketId">
                    <input type="hidden" name="sender" id="sender" value="marketSpecialist">
                    <input type="hidden" name="renewalQuote" id="renewalQuote" value="false">

            </div>
            <div class="modal-footer d-flex justify-content-between">
                <div class="form-check form-switch mb-3">
                    <input type="checkbox" class="form-check-input" id="reccomended" checked="">
                    <label class="form-check-label" for="reccomended">Reccomend this Quote</label>
                </div>
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

@include(
    'leads.appointed_leads.broker-quotation-forms.selected-quote-edit-form',
    compact('selectedQuoteId'))

{{-- @include('leads.appointed_leads') --}}
<script>
    Dropzone.autoDiscover = false;
    var myDropzoneBroker;
    $(document).ready(function() {
        var id = "{{ $quoteProduct->id }}";
        $('.BrokerQuotationTable').DataTable({
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

        $(document).on('click', '.selectQuoteButton', function(e) {
            e.preventDefault();
            var id = $(this).attr('id');
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to select this quote?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('selected-quote.store') }}",
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
                                position: 'center',
                                icon: 'success',
                                title: 'Quotation Comparison has been selected',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(() => {
                                location.reload();
                            });
                        },
                        error: function(xhr, status, error) {
                            var errorMessage = xhr.status + ': ' + xhr.statusText
                            Swal.fire({
                                title: 'Error',
                                text: 'Something went wrong: ' +
                                    errorMessage,
                                icon: 'error'
                            });
                        }
                    });
                }
            })

        });

    });

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

    $('#tableProductDropdown').val('{{ $quoteProduct->product }}').change();

    $('#tableProductDropdown').on('change', function() {
        $('#qoutation-table').DataTable().ajax.reload();
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
                                $('#BrokerQuotationTable').DataTable()
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
    // $(document).on('click', '.editQuoteButton', function(e) {
    //     e.preventDefault();
    //     var id = $(this).attr('id');
    //     $('#action').val('edit');
    //     $('#marketDropdown, #fullPayment, #downPayment').removeClass('input-error');
    //     $.ajax({
    //         url: "{{ route('edit-quotation-comparison') }}",
    //         method: "POST",
    //         data: {
    //             id: id,
    //             _token: "{{ csrf_token() }}"
    //         },
    //         dataType: "json",
    //         success: function(response) {
    //             // console.log(response.data.id)
    //             var url = `{{ asset('${response.media.filepath}') }}`;
    //             var filename = response.data.basename;

    //             //pricing breakdown inputs
    //             $('#premium').text(response.pricingBreakdown.premium);
    //             $('#endorsements').text(response.pricingBreakdown.endorsements);
    //             $('#policyFee').text(response.pricingBreakdown.policy_fee);
    //             $('#inspectionFee').text(response.pricingBreakdown.inspection_fee);
    //             $('#stampingFee').text(response.pricingBreakdown.stamping_fee);
    //             $('#suplusLinesTax').text(response.pricingBreakdown.surplus_lines_tax);
    //             $('#placementFee').text(response.pricingBreakdown.placement_fee);
    //             $('#miscellaneousFee').text(response.pricingBreakdown
    //                 .miscellaneous_fee);
    //             $('#numberOfPayment').text(response.data.number_of_payments);

    //             $('#market').text(response.market.name);
    //             $('#addQuoteModalLabel').text(
    //                 response.market.name);
    //             $('#effectiveDate').text(response.data
    //                 .effective_date);
    //             $('#fullPayment').text(response.data.full_payment);
    //             $(
    //                 '#hiddenFullpayment').val(response.data.full_payment);
    //             $('#downPayment')
    //                 .text(response.data.down_payment);
    //             $('#hiddenDownpayment').val(response.data
    //                 .down_payment);
    //             $('#monthlyPayment').text(response.data
    //                 .monthly_payment);
    //             $('#brokerFee').val(response.data.broker_fee);
    //             $(
    //                 '#product_hidden_id').val(response.data.id);
    //             $('#productId').text(
    //                 response.data.quotation_product_id);
    //             $('#quoteNo').text(response.data
    //                 .quote_no);
    //             $('#currentMarketId').val(response.data
    //                 .quotation_market_id);
    //             $('#medias').hide();
    //             $('#mediaLabelId').hide();
    //             $('#action_button').val('Update');
    //             if (response.data.recommended == 1) {
    //                 $('#reccomended').prop('checked', true);
    //             } else {
    //                 $('#reccomended').prop('checked', false);
    //             }
    //             $('#addQuoteModal').modal('show');
    //         }
    //     });

    // });

    $(document).on('click', '.editQuoteButton', function(e) {
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
                $('#premium').val(response.pricingBreakdown.premium);
                $('#endorsements').val(response.pricingBreakdown.endorsements);
                $('#policyFee').val(response.pricingBreakdown.policy_fee);
                $('#inspectionFee').val(response.pricingBreakdown.inspection_fee);
                $('#stampingFee').val(response.pricingBreakdown.stamping_fee);
                $('#surplusLinesTax').val(response.pricingBreakdown
                    .surplus_lines_tax)
                $('#placementFee').val(response.pricingBreakdown.placement_fee);
                $('#miscellaneousFee').val(response.pricingBreakdown.miscellaneous_fee);

                //quote comparison inputs
                $('#marketDropdown').val(String(response.data.quotation_market_id));
                $('#fullPayment').val(response.data.full_payment);
                $('#downPayment').val(response.data.down_payment);
                $('#monthlyPayment').val(response.data.monthly_payment);
                $('#numberOfPayment').val(response.data.number_of_payments);
                $('#brokerFee').val(response.data.broker_fee);
                $('#product_hidden_id').val(response.data.id);
                $('#productId').val(response.data.quotation_product_id);
                $('#quoteNo').val(response.data.quote_no);
                $('#currentMarketId').val(response.data.quotation_market_id);
                $('#effectiveDate').val(response.data.effective_date);

                $('#medias').hide();
                $('#mediaLabelId').hide();
                $('#action_button').val('Update');
                if (response.data.recommended == 1) {
                    $('#reccomended').prop('checked', true);
                    $('#recommended_hidden').val(1);
                } else {
                    $('#reccomended').prop('checked', false);
                    $('#recommended_hidden').val(0);
                }
                $('#addQuoteModal').modal('show');
            }
        });

    });

    //view quote button
    $(document).on('click', '.viewQuoteButton', function(e) {
        e.preventDefault();
        var id = $(this).attr('id');
        // product = $(this).attr('data-product');
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
                var url = `{{ asset('${response.media.filepath}') }}`;
                var filename = response.data.basename;

                //pricing breakdown inputs
                $('#premium').val(response.pricingBreakdown.premium).attr('disabled',
                    true);
                $('#endorsements').val(response.pricingBreakdown
                    .endorsements).attr('disabled', true);
                $('#policyFee').val(response.pricingBreakdown
                    .policy_fee).attr('disabled', true);
                $('#inspectionFee').val(response.pricingBreakdown
                    .inspection_fee).attr('disabled', true);
                $('#stampingFee').val(response.pricingBreakdown
                    .stamping_fee).attr('disabled', true);
                $('#surplusLinesTax').val(response.pricingBreakdown
                    .surplus_lines_tax).attr('disabled', true);
                $('#placementFee').val(response.pricingBreakdown
                    .placement_fee).attr('disabled', true);
                $('#miscellaneousFee').val(response.pricingBreakdown
                    .miscellaneous_fee).attr('disabled', true);

                //quote comparison inputs
                $('#marketDropdown').val(String(response.data
                    .quotation_market_id)).attr('disabled', true);
                $('#productDropdown').val(response.data.quotation_product.product);
                $('#productDropdown').attr('disabled', true);
                $('#fullPayment').val(response.data.full_payment).attr('disabled',
                    true);
                $('#downPayment').val(response.data.down_payment).attr('disabled',
                    true);
                $('#monthlyPayment').val(response.data
                    .monthly_payment).attr('disabled', true);
                $('#numberOfPayment').val(response.data
                    .number_of_payments).attr('disabled', true);
                $('#brokerFee').val(response.data.broker_fee).attr('disabled', true);
                $('#product_hidden_id').val(response.data.id).attr('disabled', true);
                $('#productId').val(response.data
                    .quotation_product_id);
                $('#quoteNo').val(response.data.quote_no).attr('disabled', true);
                $('#currentMarketId').val(response.data
                    .quotation_market_id).attr('disabled', true);
                $('#effectiveDate').val(response.data.effective_date).attr('disabled',
                    true);
                $('#medias').hide();
                $('#mediaLabelId').hide();
                $('#action_button').val('Update');
                $('#action_button').hide();
                if (response.data.recommended == 1) {
                    $('#reccomended').prop('checked', true);
                    $('#recommended_hidden').val(1);
                } else {
                    $('#reccomended').prop('checked', false);
                    $('#recommended_hidden').val(0);
                }
                $(`#addQuoteModal`).modal('show');
            }
        });
    });



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
    $(document).on('click', '.makeQuotationPaymentButton', function() {
        var id = "{{ $selectedQuoteId }}";
        $.ajax({
            url: "{{ route('edit-selected-quote') }}",
            method: "POST",
            data: {
                id: id,
                _token: "{{ csrf_token() }}"
            },
            dataType: "json",
            success: function(response) {

                $('#paymentType').val('Direct New').trigger('change');
                $('#quoteNumber').val(response.data.quote_no);
                $('#market').val(response.market.name);
                $('#companyName').val(response.leads.company_name);
                $('#firstName').val(response.generalInformation.firstname);
                $('#lastName').val(response.generalInformation.lastname);
                $('#emailAddress').val(response.generalInformation.email_address);
                $('#totalPremium').val(response.data.full_payment);
                $('#brokerFeeAmount').val(response.data.broker_fee);
                $('#generalInformationId').val(response.generalInformation.id);
                $('#leadsId').val(response.leads.id);
                $('#quoteComparisonId').val(id);
                $('#selectedQuoteId').val(id);
                $('#makePaymentEffectiveDate').val(response.data.effective_date);
                //$('#statusInput').val(data.quotation_product.status);
                $('#makePaymentModal').modal('show');
            }
        });
    });

    $(document).on('click', '.editQuotationtMakePayment', function() {
        $.ajax({
            url: "{{ route('get-payment-information') }}",
            method: "GET",
            data: {
                id: "{{ $paymentInformation ? $paymentInformation->id : '' }}",
                _token: "{{ csrf_token() }}"
            },
            dataType: "json",
            success: function(response) {
                var paymentMethod = response.paymentInformation.payment_method;
                $('#paymentType').val(response.paymentInformation.payment_type);
                $('#insuranceCompliance').val(response.paymentInformation.compliance_by);
                $('#market').val(response.market.name);
                $('#firstName').val(response.generalInformation.firstname);
                $('#companyName').val(response.lead.company_name);
                $('#makePaymentEffectiveDate').val(response.quoteComparison.effective_date);
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
                    if (['Visa', 'Master Card', 'American Express'].includes(paymentMethod)) {
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
                $('#selectedQuoteId').val({{ $selectedQuoteId }});
                $('#makePaymentModal').modal('show');
            }
        })
    });

    $(document).on('click', '.resendMakePayement', function() {
        $.ajax({
            url: "{{ route('get-payment-information') }}",
            method: "GET",
            data: {
                id: "{{ $paymentInformation ? $paymentInformation->id : '' }}",
                _token: "{{ csrf_token() }}"
            },
            dataType: "json",
            success: function(response) {
                var paymentMethod = response.paymentInformation.payment_method;
                $('#paymentType').val(response.paymentInformation.payment_type);
                $('#insuranceCompliance').val(response.paymentInformation.compliance_by);
                $('#market').val(response.market.name);
                $('#firstName').val(response.generalInformation.firstname);
                $('#companyName').val(response.lead.company_name);
                $('#makePaymentEffectiveDate').val(response.quoteComparison.effective_date);
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
                    if (['Visa', 'Master Card', 'American Express'].includes(paymentMethod)) {
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
                $('#selectedQuoteId').val({{ $selectedQuoteId }});
                $('#makePaymentModal').modal('show');
            }
        })
    });

    $(document).on('click', '.editSelectedQuote', function(e) {
        e.preventDefault();
        var baseUrl = "{{ url('quoatation/selected-quote') }}";
        var id = "{{ $selectedQuoteId }}";
        var url = `${baseUrl}/${id}/edit`;
        $('#action').val('edit');
        $('#marketDropdown, #fullPayment, #downPayment').removeClass('input-error');
        $.ajax({
            url: url,
            method: "GET",
            data: {
                id: id,
                _token: "{{ csrf_token() }}"
            },
            dataType: "json",
            success: function(response) {
                // console.log(response.data.id)
                var url = `{{ asset('${response.media.filepath}') }}`;
                var filename = response.data.basename;
                console.log(response.data);
                //pricing breakdown inputs
                $('#selectedPremium').val(response.pricingBreakdown.premium);
                $('#selectedEndorsements').val(response.pricingBreakdown.endorsements);
                $('#selectedPolicyFee').val(response.pricingBreakdown.policy_fee);
                $('#selectedInspectionFee').val(response.pricingBreakdown
                    .inspection_fee);
                $('#selectedStampingFee').val(response.pricingBreakdown.stamping_fee);
                $('#selectedSurplusLinesTax').val(response.pricingBreakdown
                    .surplus_lines_tax);
                $('#selectedPlacementFee').val(response.pricingBreakdown.placement_fee);
                $('#selectedMiscellaneousFee').val(response.pricingBreakdown
                    .miscellaneous_fee);

                //quote comparison inputs
                $('#selectedMarketDropdown').val(String(response.data
                    .quotation_market_id));
                $('#selectedFullPayment').val(response.data.full_payment);
                $('#selectedDownPayment').val(response.data.down_payment);
                $('#selectedMonthlyPayment').val(response.data.monthly_payment);
                $('#selectedNumberOfPayment').val(response.data.number_of_payments);
                $('#selectedBrokerFee').val(response.data.broker_fee);
                $('#selectedProduct_hidden_id').val(response.data.id);
                $('#selectedProductId').val(response.data.quotation_product_id);
                $('#selectedQuoteNo').val(response.data.quote_no);
                $('#selectedCurrentMarketId').val(response.data.quotation_market_id);
                $('#selectedEffectiveDate').val(response.data.effective_date);

                $('#medias').hide();
                $('#mediaLabelId').hide();
                $('#selectedQuoteAction_button').val('Update');
                if (response.data.recommended == 1) {
                    $('#reccomended').prop('checked', true);
                    $('#selectedRecommended_hidden').val(1);
                } else {
                    $('#reccomended').prop('checked', false);
                    $('#selectedRecommended_hidden').val(0);
                }
                $('#editSelectedQuoteModal').modal('show');
            }
        });
    });

    //function for parsing
    function parseCurrency(num) {
        if (num === undefined || num === null || num.trim() === "") {
            return 0;
        }
        return parseFloat(num.replace(/[^0-9-.]/g, ''));
    }

    //calculate total premium
    function calculateFullPayment() {
        let premium = parseCurrency($('#premium').val()) || 0;
        let endorsements = parseCurrency($('#endorsements').val()) || 0;
        let policyFee = parseCurrency($('#policyFee').val()) || 0;
        let inspectionFee = parseCurrency($('#inspectionFee').val()) || 0;
        let stampingFee = parseCurrency($('#stampingFee').val()) || 0;
        let suplusLinesTax = parseCurrency($('#suplusLinesTax').val()) || 0;
        let placementFee = parseCurrency($('#placementFee').val()) || 0;
        let brokerFee = parseCurrency($('#brokerFee').val()) || 0;
        let miscellaneousFee = parseCurrency($('#miscellaneousFee').val()) || 0;

        let fullPayment = premium + endorsements + policyFee + inspectionFee + stampingFee + suplusLinesTax +
            placementFee + brokerFee + miscellaneousFee;
        $('#fullPayment').val('$ ' + fullPayment.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
    }


    $('.calculateInput').on('input', function() {
        calculateFullPayment();
    });


    //submition of form
    $('#quotationForm').on('submit', function(event) {
        event.preventDefault();
        var formData = new FormData(this);

        var action_url = '';
        $('#marketDropdown, #fullPayment, #downPayment').removeClass('input-error');
        let fullPayment = parseFloat($('#fullPayment').val()) || 0;
        let downPayment = parseFloat($('#downPayment').val()) || 0;

        if ($('#action').val() == 'add') {
            action_url = "{{ route('save-quotation-comparison') }}";
        }

        if ($('#action').val() == 'edit') {
            action_url = "{{ route('update-quotation-comparison') }}";
        }
        if (fullPayment < downPayment) {
            $('#fullPayment').addClass('input-error');
            $('#downPayment').addClass('input-error');
        } else {
            $.ajax({
                url: action_url,
                method: "POST",
                processData: false, // Prevent jQuery from processing the data
                contentType: false,
                data: formData,
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
                        $('.modal-backdrop').remove();
                        $('#quotationForm select').val('');
                        $('#quotationForm input[type="text"], #quotationForm textarea')
                            .val('');
                        $('#quotationForm input[type="file"]').val('');
                        $('#quotationForm .input-mask').trigger('input');
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
        }
    });


    // $(document).on('click', '.resendMakePayement')


    //submition of form
    // $('#quotationForm').on('submit', function(event) {
    //     event.preventDefault();
    //     $.ajax({
    //         url: "{{ route('update-quotation-comparison') }}",
    //         method: "POST",
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
    //                 'content')
    //         },
    //         processData: false, // Prevent jQuery from processing the data
    //         contentType: false,
    //         data: new FormData(this),
    //         dataType: "json",
    //         success: function(response) {
    //             Swal.fire({
    //                 position: 'center',
    //                 icon: 'success',
    //                 title: 'Quotation Comparison has been saved',
    //                 showConfirmButton: false,
    //                 timer: 1500
    //             }).then(() => {
    //                 $('#addQuoteModal').modal('hide');
    //                 $('#BrokerQuotationTable').DataTable().ajax.reload();
    //             });
    //         },
    //         error: function(data) {
    //             var errors = data.responseJSON.errors;
    //             console.log(data);
    //             if (data.status == 422) {
    //                 Swal.fire({
    //                     title: 'Error',
    //                     text: data.responseJSON.error,
    //                     icon: 'error'
    //                 });
    //                 $('#marketDropdown').addClass('input-error');
    //             }
    //             if (errors) {
    //                 $.each(errors, function(key, value) {
    //                     $('#' + key).addClass('input-error');
    //                     $('#' + key + '_error').html(value);
    //                 });
    //             }
    //         }
    //     });

    // });

    //function for parsing
    // function parseCurrency(num) {
    //     return parseFloat(num.replace(/[^0-9-.]/g, ''));
    // }
</script>
