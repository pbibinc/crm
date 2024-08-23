{{-- Qoutation Forms --}}

<div class="modal fade" id="uploadFileModal" tabindex="-1" aria-labelledby="addQuoteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadFileModalTitle">File Upload</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="quotationDropzone mt-4 border-dashed" id="quotationDropzone"
                    action="{{ url('/file-upload') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <input type="hidden" value="" id="hidden_id">
                </form>
                <input type="hidden" id="mediaIds" value="">
            </div>
        </div>
    </div>
</div>

<ul class="nav nav-pills nav-justified" role="tablistProduct">
    @foreach ($products as $key => $product)
        <li class="nav-item waves-effect waves-light">
            <a class="nav-link navProfile {{ $key === 0 ? 'active' : '' }}" data-bs-toggle="tab"
                href="#{{ str_replace(' ', '', $product->product) }}Quote" role="tab"
                id="{{ str_replace(' ', '', $product->product) }}Button" style="white-space: nowrap;">
                {{ $product->product }}
            </a>
        </li>
    @endforeach
</ul>

<div class="tab-content p-3 text-muted">
    @foreach ($products as $key => $product)
        <div class="tab-pane fade {{ $key === 0 ? 'show active' : '' }}"
            id="{{ str_replace(' ', '', $product->product) }}Quote" role="tabpanel">
            @if ($product->product == 'General Liability')
                @include('leads.appointed_leads.leads-quotation-forms.quoation-form', [
                    'generalInformation' => $generalInformation,
                    'quationMarket' => $quationMarket->getMarketByProduct('General Liability'),
                    'quoteProduct' => $lead->quoteLead->QuoteInformation->QuotationProduct->getQuotationProductByProduct(
                        'General Liability',
                        $lead->quoteLead->QuoteInformation->id),
                    'formId' => 'form_' . $product->id,
                    'productForm' => 'General_Liability',
                ])
            @elseif ($product->product == 'Workers Compensation')
                @include(
                    'leads.appointed_leads.leads-quotation-forms.workers-compensation-quotation-form',
                    [
                        'generalInformation' => $generalInformation,
                        'quationMarket' => $quationMarket->getMarketByProduct('Workers Compensation'),
                        'quoteProduct' => $lead->quoteLead->QuoteInformation->QuotationProduct->getQuotationProductByProduct(
                            'Workers Compensation',
                            $lead->quoteLead->QuoteInformation->id),
                        'formId' => 'form_' . $product->id,
                        'productForm' => 'Workers_Compensation',
                    ]
                )
            @elseif ($product->product == 'Commercial Auto')
                @include('leads.appointed_leads.leads-quotation-forms.commercial-auto-quoation-form', [
                    'generalInformation' => $generalInformation,
                    'quationMarket' => $quationMarket->getMarketByProduct('Commercial Auto'),
                    'quoteProduct' => $lead->quoteLead->QuoteInformation->QuotationProduct->getQuotationProductByProduct(
                        'Commercial Auto',
                        $lead->quoteLead->QuoteInformation->id),
                    'formId' => 'form_' . $product->id,
                    'productForm' => 'Commercial_Auto',
                ])
            @elseif ($product->product == 'Excess Liability')
                @include('leads.appointed_leads.leads-quotation-forms.excess-liability-quoation-form', [
                    'generalInformation' => $generalInformation,
                    'quationMarket' => $quationMarket->getMarketByProduct('Excess Liability'),
                    'quoteProduct' => $lead->quoteLead->QuoteInformation->QuotationProduct->getQuotationProductByProduct(
                        'Excess Liability',
                        $lead->quoteLead->QuoteInformation->id),
                    'formId' => 'form_' . $product->id,
                    'productForm' => 'Excess_Liability',
                ])
            @elseif ($product->product == 'Tools Equipment')
                @include('leads.appointed_leads.leads-quotation-forms.tools-equipment-quoation-form', [
                    'generalInformation' => $generalInformation,
                    'quationMarket' => $quationMarket->getMarketByProduct('Tools Equipment'),
                    'quoteProduct' => $lead->quoteLead->QuoteInformation->QuotationProduct->getQuotationProductByProduct(
                        'Tools Equipment',
                        $lead->quoteLead->QuoteInformation->id),
                    'formId' => 'form_' . $product->id,
                    'productForm' => 'Tools_Equipment',
                ])
            @elseif ($product->product == 'Builders Risk')
                @include('leads.appointed_leads.leads-quotation-forms.builders-risk-quoation-form', [
                    'generalInformation' => $generalInformation,
                    'quationMarket' => $quationMarket->getMarketByProduct('Builders Risk'),
                    'quoteProduct' => $lead->quoteLead->QuoteInformation->QuotationProduct->getQuotationProductByProduct(
                        'Builders Risk',
                        $lead->quoteLead->QuoteInformation->id),
                    'formId' => 'form_' . $product->id,
                    'productForm' => 'Builders_Risk',
                ])
            @elseif ($product->product == 'Business Owners')
                @include('leads.appointed_leads.leads-quotation-forms.business-owners-quoation-form', [
                    'generalInformation' => $generalInformation,
                    'quationMarket' => $quationMarket->getMarketByProduct('Business Owners Policy'),
                    'quoteProduct' => $lead->quoteLead->QuoteInformation->QuotationProduct->getQuotationProductByProduct(
                        'Business Owners',
                        $lead->quoteLead->QuoteInformation->id),
                    'formId' => 'form_' . $product->id,
                    'productForm' => 'Business_Owners',
                ])
            @endif
        </div>
    @endforeach



</div>

<script>
    Dropzone.autoDiscover = false;
    var quotationDropzone
    $(document).ready(function() {


        var url = "{{ env('APP_FORM_URL') }}" + "/upload";
        quotationDropzone = new Dropzone(".quotationDropzone", {
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

        var product = '';
        //edit button functionalities
        $(document).on('click', '.editButton', function(e) {
            e.preventDefault();
            var id = $(this).attr('id');
            product = $(this).attr('data-product');
            $('#action' + product).val('edit');
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
                    console.log(response);
                    var url = `{{ asset('${response.media.filepath}') }}`;
                    var filename = response.data.basename;

                    //pricing breakdown inputs
                    $('#premium' + product).val(response.pricingBreakdown.premium);
                    $('#endorsements' + product).val(response.pricingBreakdown
                        .endorsements);
                    $('#policyFee' + product).val(response.pricingBreakdown.policy_fee);
                    $('#inspectionFee' + product).val(response.pricingBreakdown
                        .inspection_fee);
                    $('#stampingFee' + product).val(response.pricingBreakdown.stamping_fee);
                    $('#surplusLinesTax' + product).val(response.pricingBreakdown
                        .surplus_lines_tax);
                    $('#placementFee' + product).val(response.pricingBreakdown
                        .placement_fee);
                    $('#miscellaneousFee' + product).val(response.pricingBreakdown
                        .miscellaneous_fee);

                    //quote comparison inputs
                    $('#marketDropdown' + product).val(String(response.data
                        .quotation_market_id));
                    $('#fullPayment' + product).val(response.data.full_payment);
                    $('#downPayment' + product).val(response.data.down_payment);
                    $('#monthlyPayment' + product).val(response.data.monthly_payment);
                    $('#numberOfPayment' + product).val(response.data.number_of_payments);
                    $('#brokerFee' + product).val(response.data.broker_fee);
                    $('#product_hidden_id' + product).val(response.data.id);
                    $('#productId' + product).val(response.data.quotation_product_id);
                    $('#quoteNo' + product).val(response.data.quote_no);
                    $('#currentMarketId' + product).val(response.data.quotation_market_id);
                    $('#effectiveDate' + product).val(response.data.effective_date);

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
                    $('#addQuoteModal' + product).modal('show');
                }
            });

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
                                    location.reload();
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

        //creation of record
        $('.createRecord').on('click', function(e) {
            e.preventDefault();
            product = $(this).attr('data-product');
            console.log(product);
            $('#addQuoteModal' + product).modal('show');
            // $('#action').val('add');
            $(`#marketDropdown${product}, #fullPayment${product}, #downPayment${product}`).removeClass(
                'input-error');
            // $('#addQuoteModal').modal('show');
            $('#action_button').val('Add');
            // $('#medias').show();
            // $('#mediaLabelId').show();
        });


        //event function for hiding the modal
        $('#uploadFileModal').on('hide.bs.modal', function() {
            $(".dropzone .dz-preview").remove(); // This removes file previews from the DOM
            myDropzone.files.length = 0;
        });


        //function for adding existing files
        function addExistingFiles(files) {
            files.forEach(file => {
                var mockFile = {
                    id: file.id,
                    name: file.basename,
                    size: parseInt(file.size),
                    type: file.type,
                    status: Dropzone.ADDED,
                    url: file.filepath
                };
                quotationDropzone.emit("addedfile", mockFile);
                // myDropzone.emit("thumbnail", mockFile, file.filepath); // If you have thumbnails
                quotationDropzone.emit("complete", mockFile);
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
                    addExistingFiles(files);
                    $('#uploadFileModal').modal('show');
                }
            });
        });

        //attachement of file
        $(document).on('change', '#attachedFile', function() {
            var file = $(this)[0].files[0];
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#currentImage').attr('src', e.target.result).show();
            }
            reader.readAsDataURL(file);
        })




        const products = ['Workers_Compensation', 'General_Liability', 'Commercial_Auto',
            'Excess_Liability', 'Tools_Equipment', 'Builders_Risk', 'Business_Owners'
        ]; // Add other products

        products.forEach(function(product) {
            console.log(`Binding events for ${product}`);
            handleFormSubmission(product);
            handleRecommended(product);
            handleModalOpen(product);
            bindCalculateInput(product);

        })
        // products.forEach(handleFormSubmission);
        // products.forEach(handleRecommended);
        // products.forEach(handleModalOpen);
        // products.forEach(bindCalculateInput);


        //checkbox for recommended
        function handleRecommended(product) {
            $(`#reccomended${product}`).change(function(e) {
                if ($(this).is(':checked')) {
                    $('#recommended_hidden' + product).val(1);
                } else {
                    $('#recommended_hidden' + product).val(0);
                }
            });
        }

        //submition of form
        function handleFormSubmission(product) {
            $(`#quotationForm${product}`).on('submit', function(event) {
                event.preventDefault();
                console.log('submitting');
                var formData = new FormData(this);
                var action_url = '';

                $(`#marketDropdown${product}, #fullPayment${product}, #downPayment${product}`)
                    .removeClass('input-error');
                let fullPayment = parseFloat($(`#fullPayment${product}`).val()) || 0;
                let downPayment = parseFloat($(`#downPayment${product}`).val()) || 0;

                if ($(`#action${product}`).val() == 'add') {
                    action_url = "{{ route('save-quotation-comparison') }}";
                } else if ($(`#action${product}`).val() == 'edit') {
                    action_url = "{{ route('update-quotation-comparison') }}";
                }

                console.log(action_url);
                if (fullPayment < downPayment) {
                    $(`#fullPayment${product}`).addClass('input-error');
                    $(`#downPayment${product}`).addClass('input-error');
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
                                $(`#addQuoteModal${product}`).modal('hide');
                                // Optionally reload the data table or update the UI
                                location.reload();
                            });
                        },
                        error: function(data) {
                            var errors = data.responseJSON.errors;
                            console.log(data);
                            if (data.status == 422) {
                                Swal.fire({
                                    title: 'Error',
                                    text: data.responseJSON.message ||
                                        'An error occurred',
                                    icon: 'error'
                                });
                            }
                            if (errors) {
                                $.each(errors, function(key, value) {
                                    $(`#${key}${product}`).addClass('input-error');
                                    $(`#${key}${product}_error`).html(value);
                                });
                            }
                        }
                    });
                }
            });
        }

        function handleModalOpen(product) {
            $(`#create_record_${product}`).on('click', function(e) {
                e.preventDefault();
                console.log('General_Liability');
                $('#action').val('add');
                $('#marketDropdown, #fullPayment, #downPayment').removeClass('input-error');
                $(`#addQuoteModal_${product}`).modal('show');
                $('#action_button').val('Add');
                $('#medias').show();
                $('#mediaLabelId').show();
            });
        }

        //function for parsing
        function parseCurrency(num) {
            if (num === undefined || num === null || num.trim() === "") {
                return 0;
            }
            return parseFloat(num.replace(/[^0-9-.]/g, ''));
        }

        // $('.calculateInput').on('input', function() {
        //     // calculateFullPayment();
        //     console.log('inputing');
        // });



        function bindCalculateInput(product) {
            $(`#premium${product}, #endorsements${product}, #policyFee${product}, #inspectionFee${product}, #stampingFee${product}, #suplusLinesTax${product}, #placementFee${product}, #brokerFee${product}, #miscellaneousFee${product}`)
                .on('input', function() {
                    calculateFullPayment(product);
                });
        }

        function calculateFullPayment(product) {
            let premium = parseCurrency($(`#premium${product}`).val()) || 0;
            let endorsements = parseCurrency($(`#endorsements${product}`).val()) || 0;
            let policyFee = parseCurrency($(`#policyFee${product}`).val()) || 0;
            let inspectionFee = parseCurrency($(`#inspectionFee${product}`).val()) || 0;
            let stampingFee = parseCurrency($(`#stampingFee${product}`).val()) || 0;
            let suplusLinesTax = parseCurrency($(`#suplusLinesTax${product}`).val()) || 0;
            let placementFee = parseCurrency($(`#placementFee${product}`).val()) || 0;
            let brokerFee = parseCurrency($(`#brokerFee${product}`).val()) || 0;
            let miscellaneousFee = parseCurrency($(`#miscellaneousFee${product}`).val()) || 0;

            let fullPayment = premium + endorsements + policyFee + inspectionFee + stampingFee +
                suplusLinesTax +
                placementFee + brokerFee + miscellaneousFee;

            $(`#fullPayment${product}`).val('$ ' + fullPayment.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
        }

    });
</script>
