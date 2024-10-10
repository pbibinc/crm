@php
    use App\Models\PolicyDetail;
    use App\Models\SelectedQuote;
    use App\Models\PaymentInformation;
    $selectedQuoteData = SelectedQuote::find($quoteProduct->selected_quote_id);
    $selectedQuote = $selectedQuoteData ? $selectedQuoteData : null;
    $selectedQuoteId = $selectedQuote ? $selectedQuote->id : null;
    $paymentInformation = PaymentInformation::where('selected_quote_id', $selectedQuoteId)->latest()->first();
@endphp

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
        <div>
            <a href="#" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addQuoteModal"
                id="create_record">
                ADD QUOTE
            </a>

            @if ($policyDetail->status == 'Renewal Quote')
                <button href="#" class="btn btn-primary" id="sendQuoteButton">SEND QUOTE</button>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <table id="qoutation-table" class="table table-bordered dt-responsive nowrap qoutation-table"
        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
        <thead>
            <tr>
                <th>Market</th>
                <th>Full Payment</th>
                <th>Down Payment</th>
                <th>Monthly Payment</th>
                <th>Broker Fee</th>
                <th>Status</th>
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
                {{-- @if (($paymentInformation && $paymentInformation->status == 'Pending') || $paymentInformation->status == 'declined')
                    <button class="btn btn-primary editMakePayment" id="makePaymentButton">
                        EDIT MAKE PAYMENT
                    </button>
                @else
                    <button class="btn btn-success makePaymentButton" id="makePaymentButton">
                        MAKE PAYMENT
                    </button>
                @endif --}}
                @if ($paymentInformation && ($paymentInformation->status == 'Pending' || $paymentInformation->status == 'declined'))
                    <button class="btn btn-primary editMakePayment" id="makePaymentButton">
                        EDIT MAKE PAYMENT
                    </button>
                @else
                    <button class="btn btn-success makePaymentButton" id="makePaymentButton">
                        MAKE PAYMENT
                    </button>
                @endif
            </div>

        </div>
    </div>
    <div class="row">
        @include(
            'leads.appointed_leads.broker-quotation-forms.selected-quotation-form',
            compact('quoteProduct', 'policyDetail', 'selectedQuote', 'paymentInformation'));
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
                <form class="dropzone mt-4 border-dashed" id="dropzone" action="{{ url('/file-upload') }}"
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
                            <input type="text" class="form-control" id="quoteNo" name="quoteNo" required>
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
                    <input type="hidden" name="recommended" id="recommended_hidden" value="5" />
                    <input type="hidden" name="currentMarketId" id="currentMarketId">
                    <input type="hidden" name="sender" id="sender" value="marketSpecialist">
                    <input type="hidden" name="renewalQuote" id="renewalQuote" value="true">

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
@include('leads.appointed_leads.broker-forms.make-payment-form', compact('complianceOfficer'))

<script>
    Dropzone.autoDiscover = false;
    var quoteRenewalDropzone;
    $(document).ready(function() {
        var id = {{ $quoteProduct->id }};

        $('.qoutation-table').DataTable({
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
                    data: 'renewal_status',
                    name: 'renewal_status'
                },
                {
                    data: 'renewal-quoted_action',
                    name: 'renewal-quoted_action',
                    orderable: false
                }
            ]
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

        var url = "{{ env('APP_FORM_URL') }}" + "/upload";

        quoteRenewalDropzone = new Dropzone("#dropzone", {
            clickable: false,
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
                                // console.log('download');
                                var downloadLink = document.createElement(
                                    "a");
                                downloadLink.href = fileUrl;
                                downloadLink.download = file.name;
                                document.body.appendChild(downloadLink);
                                downloadLink.click();
                                document.body.removeChild(downloadLink);
                            } else if (result.isDenied) {
                                // console.log('view');
                                window.open(fileUrl, '_blank');
                            }
                        });


                    });
                });
            },
            renameFile: function(file) {
                var dt = new Date();
                var time = dt.getTime();
                return time + file.name;
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
                quoteRenewalDropzone.emit("addedfile", mockFile);
                // myDropzone.emit("thumbnail", mockFile, file.filepath); // If you have thumbnails
                quoteRenewalDropzone.emit("complete", mockFile);
            });
        };



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
                    console.log(files);
                    addExistingFiles(files);
                    $('#uploadFileModal').modal('show');
                }
            });
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

        $('#addQuoteModal').on('hidden.bs.modal', function() {
            $('#quotationForm select').val('');
            $('#quotationForm input[type="text"], #quotationForm textarea')
                .val('');

            $('#quotationForm input[type="file"]').val('');
            $('#quotationForm .input-mask').trigger('input');
        });

        $('#uploadFileModal').on('hide.bs.modal', function() {
            $(".dropzone .dz-preview").remove(); // This removes file previews from the DOM
            myDropzone.files.length = 0;
        });

        //send quote button functionalities
        $('#sendQuoteButton').on('click', function() {
            var id = {{ $policyDetail->id }};
            Swal.fire({
                title: 'Are you sure?',
                text: 'You are about to send this quote to the client',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, send it!',
                cancelButtonText: 'No, keep it'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('customer-service/change-policy-status') }}/" +
                            id,
                        method: "POST",
                        data: {
                            id: id,
                            _token: "{{ csrf_token() }}",
                            status: "Renewal Quoted"
                        },
                        dataType: "json",
                        success: function(response) {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Renewal Quotation Has Been Sent',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(() => {
                                console.log('test this code');
                                location.reload();
                            });
                        }
                    });
                }
            });
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

    //broker side make payment button
    $(document).on('click', '.makePaymentButton', function() {
        var id = "{{ $selectedQuoteId }}";
        var policyId = "{{ $policyDetail->id }}";
        $.ajax({
            url: "{{ route('edit-selected-quote') }}",
            method: "POST",
            data: {
                id: id,
                _token: "{{ csrf_token() }}"
            },
            dataType: "json",
            success: function(response) {
                $('#paymentType').val('Direct Renewals').trigger('change');
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
                $('#policyDetailId').val(policyId);
                $('#makePaymentModal').modal('show');

            }
        });
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
        $('#paymentType').val(paymentInformation.payment_type);
        $('#insuranceCompliance').val(paymentInformation.compliance_by);
        $('#paymentMethod').val(paymentInformation.payment_method);
        $('#statusInput').val($(this).attr('data-status'));
        $('#quotationProductId').val($(this).attr('data-productId'));
        $('#chargedAmount').val(paymentInformation.amount_to_charged);
        $('#note').val(paymentInformation.note);
        $('#paymentInformationId').val(paymentInformation.id);
    });

    //renewal quote button
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
                        id: id,
                        stats: 4
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
        });
    });

    //edit make payment
    $(document).on('click', '.editMakePayment', function() {
        $.ajax({
            url: "{{ route('get-payment-information') }}",
            method: "GET",
            data: {
                id: "{{ $paymentInformation ? $paymentInformation->id : '' }}",
                _token: "{{ csrf_token() }}"
            },
            dataType: "json",
            success: function(response) {
                console.log(response);
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
                $('#policyDetailId').val({{ $policyDetail->id }});
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
                $('#premium').val(response.pricingBreakdown.premium);
                $('#endorsements').val(response.pricingBreakdown.endorsements);
                $('#policyFee').val(response.pricingBreakdown.policy_fee);
                $('#inspectionFee').val(response.pricingBreakdown.inspection_fee);
                $('#stampingFee').val(response.pricingBreakdown.stamping_fee);
                $('#suplusLinesTax').val(response.pricingBreakdown.surplus_lines_tax);
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


    // renew the quotation
    $(document).on('click', '.renewQuotation', function() {
        var id = $(this).attr('id');
        Swal.fire({
            title: 'Are you sure?',
            text: 'You are about to renew this quote',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, renew it!',
            cancelButtonText: 'No, keep it'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('renewal-quote.store') }}",
                    method: "POST",
                    data: {
                        id: id,
                        _token: "{{ csrf_token() }}"
                    },
                    dataType: "json",
                    success: function(response) {
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Quotation Comparison has been renewed',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            location.reload();
                        });
                    },
                    error: function(data) {
                        Swal.fire({
                            title: 'Error',
                            text: data.responseJSON.error,
                            icon: 'error'
                        });
                    }
                });
            }
        });
    });
</script>
