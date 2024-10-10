{{-- Qoutation Forms --}}

<div class="modal fade" id="uploadFileModal" tabindex="-1" aria-labelledby="addQuoteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadFileModalTitle">File Upload</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="dropzone mt-4 border-dashed" id="quotationDropzone" action="{{ url('/file-upload') }}"
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

@include('leads.appointed_leads.leads-quotation-forms.quoation-form', [
    'generalInformation' => $generalInformation,
    'quationMarket' => $quationMarket->getMarketByProduct('General Liability'),
    'quoteProduct' => $lead->quoteLead->QuoteInformation->QuotationProduct->getQuotationProductByProduct(
        'General Liability',
        $lead->quoteLead->QuoteInformation->id),
    'products' => $lead->getQuotationProducts(),
    'formId' => 'form_' . $product->id,
    'productForm' => 'General_Liability',
    'productsDropdown' => [
        'Workers Compensation',
        'General Liability',
        'Commercial Auto',
        'Excess Liability',
        'Tools Equipment',
        'Builders Risk',
        'Business Owners',
    ],
])

<script>
    Dropzone.autoDiscover = false;
    var quotationDropzone;
    $(document).ready(function() {

        var url = "{{ env('APP_FORM_URL') }}" + "/upload";
        quotationDropzone = new Dropzone("#quotationDropzone", {
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

        //edit button functionalities
        $(document).on('click', '.editQuoteButton', function(e) {
            e.preventDefault();
            var id = $(this).attr('id');
            // product = $(this).attr('data-product');
            console.log(id);
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
                    $('#premium').val(response.pricingBreakdown.premium);
                    $('#endorsements').val(response.pricingBreakdown
                        .endorsements);
                    $('#policyFee').val(response.pricingBreakdown
                        .policy_fee);
                    $('#inspectionFee').val(response.pricingBreakdown
                        .inspection_fee);
                    $('#stampingFee').val(response.pricingBreakdown
                        .stamping_fee);
                    $('#surplusLinesTax').val(response.pricingBreakdown
                        .surplus_lines_tax);
                    $('#placementFee').val(response.pricingBreakdown
                        .placement_fee);
                    $('#miscellaneousFee').val(response.pricingBreakdown
                        .miscellaneous_fee);

                    //quote comparison inputs
                    $('#marketDropdown').val(String(response.data
                        .quotation_market_id));
                    $('#productDropdown').val(response.data.quotation_product.product);
                    $('#productDropdown').attr('disabled', true);
                    $('#fullPayment').val(response.data.full_payment);
                    $('#downPayment').val(response.data.down_payment);
                    $('#monthlyPayment').val(response.data
                        .monthly_payment);
                    $('#numberOfPayment').val(response.data
                        .number_of_payments);
                    $('#brokerFee').val(response.data.broker_fee);
                    $('#product_hidden_id').val(response.data.id);
                    $('#productId').val(response.data
                        .quotation_product_id);
                    $('#quoteNo').val(response.data.quote_no);
                    $('#currentMarketId').val(response.data
                        .quotation_market_id);
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
                    $(`#addQuoteModal`).modal('show');
                }
            });

        });

        //view quote button
        $(document).on('click', '.viewQuoteButton', function(e) {
            e.preventDefault();
            var id = $(this).attr('id');
            // product = $(this).attr('data-product');
            console.log(id);
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
                    console.log(response.data.quotation_product.product);
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

        //creation of record
        $('.createRecord').on('click', function(e) {
            e.preventDefault();
            product = $(this).attr('data-product');
            console.log(product);
            $('#addQuoteModal').modal('show');
            // $('#action').val('add');
            $(`#marketDropdown, #fullPayment, #downPayment`).removeClass(
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


        $(`#create_record_`).on('click', function(e) {
            e.preventDefault();
            console.log('General_Liability');
            $('#action').val('add');
            $('#marketDropdown, #fullPayment, #downPayment').removeClass('input-error');
            $(`#addQuoteModal`).modal('show');
            $('#action_button').val('Add');
            $('#medias').show();
            $('#mediaLabelId').show();
        });


        //checkbox for recommended
        $(`#reccomended`).change(function(e) {
            if ($(this).is(':checked')) {
                $('#recommended_hidden').val(1);
            } else {
                $('#recommended_hidden').val(0);
            }
        });


        $(`#quotationForm`).on('submit', function(event) {
            event.preventDefault();
            console.log('submitting');
            var formData = new FormData(this);
            var action_url = '';

            $(`#marketDropdown, #fullPayment, #downPayment`)
                .removeClass('input-error');
            let fullPayment = parseFloat($(`#fullPayment`).val()) || 0;
            let downPayment = parseFloat($(`#downPayment`).val()) || 0;

            if ($(`#action`).val() == 'add') {
                action_url = "{{ route('save-quotation-comparison') }}";
            } else if ($(`#action`).val() == 'edit') {
                action_url = "{{ route('update-quotation-comparison') }}";
            }

            console.log(action_url);
            if (fullPayment < downPayment) {
                $(`#fullPayment`).addClass('input-error');
                $(`#downPayment`).addClass('input-error');
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
                            $(`#addQuoteModal`).modal('hide');
                            // Optionally reload the data table or update the UI
                            $('#qoutation-table').DataTable()
                                .ajax
                                .reload();
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
                                $(`#${key}`).addClass('input-error');
                                $(`#${key}_error`).html(value);
                            });
                        }
                    }
                });
            }
        });

        //function for parsing
        function parseCurrency(num) {
            if (num === undefined || num === null || num.trim() === "") {
                return 0;
            }
            return parseFloat(num.replace(/[^0-9-.]/g, ''));
        }

        $('.calculateInput').on('input', function() {
            calculateFullPayment(product);
        });

        function calculateFullPayment(product) {
            let premium = parseCurrency($(`#premium`).val()) || 0;
            let endorsements = parseCurrency($(`#endorsements`).val()) || 0;
            let policyFee = parseCurrency($(`#policyFee`).val()) || 0;
            let inspectionFee = parseCurrency($(`#inspectionFee`).val()) || 0;
            let stampingFee = parseCurrency($(`#stampingFee`).val()) || 0;
            let suplusLinesTax = parseCurrency($(`#suplusLinesTax`).val()) || 0;
            let placementFee = parseCurrency($(`#placementFee`).val()) || 0;
            let brokerFee = parseCurrency($(`#brokerFee`).val()) || 0;
            let miscellaneousFee = parseCurrency($(`#miscellaneousFee`).val()) || 0;

            let fullPayment = premium + endorsements + policyFee + inspectionFee + stampingFee +
                suplusLinesTax +
                placementFee + brokerFee + miscellaneousFee;

            $(`#fullPayment`).val('$ ' + fullPayment.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
        }

        $(document).on('click', '.setNewQuotation', function(e) {
            var id = $(this).attr('id');
            Swal.fire({
                title: 'Are you sure?',
                text: 'You want to set this quote as new one?',
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
                                $('#qoutation-table').DataTable()
                                    .ajax
                                    .reload();
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

        $(document).on('click', '.oldRenewQuotation', function(e) {
            e.preventDefault();
            var id = $(this).attr('id');
            Swal.fire({
                title: 'Are you sure?',
                text: 'Making this quote as old one!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes!',
                cancelButtonText: 'No'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('renewal-quote.edit-renewal-quote') }}",
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
                                text: 'Quote has been made as old one',
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

        $('#addQuoteModal').on('hidden.bs.modal', function() {
            console.log('modal closed');

            // Reset the form fields
            $('#quotationForm')[0].reset();

            // Clear any input masks or custom fields (if applicable)
            $('.input-mask').val('').trigger(
                'input'); // Assuming you have input masks that need to be reset

            // Reset dropdowns to default values (if needed)
            $('#marketDropdown').val('');
            $('#productDropdown').val('');

            // Re-enable all fields that were disabled during 'view' mode
            $('#quotationForm').find('input, select, textarea').removeAttr('disabled');

            // Show file input fields if they were hidden
            $('#medias').show();
            $('#mediaLabelId').show();

            // Remove attached files from file input
            $('#medias').val('');

            // Reset any custom flags or states
            $('#recommended_hidden').val('0');
            $('#renewalQuote').val('false');

            // Reset checkboxes
            $('#reccomended').prop('checked', false);

            // Reset other hidden fields
            $('#product_hidden_id').val('');
            $('#currentMarketId').val('');

            //reset action
            $('#action').val('add');

            // Reset the action button text and visibility
            $('#action_button').val('Add');
            $('#action_button').show();
        });

    });
</script>
