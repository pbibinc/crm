@extends('admin.admin_master')
@section('admin')
    <div class="page-content pt-6">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card"
                        style="box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05); border-radius: 10px; overflow: hidden;">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Products For Binding</h4>
                            <table id="getConfimedProductTable"
                                class="table table-bordered dt-responsive nowrap getConfimedProductTable"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <th>Product</th>
                                    <th>Company Name</th>
                                    <th>Requested By</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                    {{-- <th>Sent Out Date</th>
                                <th></th> --}}
                                </thead>
                                <tbody>

                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
            @include(
                'customer-service.policy-form.general-liabilities-policy-form',
                compact('carriers', 'markets'))
            @include('customer-service.policy-form.commercial-auto-policy-form')
            @include('customer-service.binding.view-binding-information')
        </div>
    </div>
    <script>
        Dropzone.autoDiscover = false;
        var myDropzone;
        $(document).ready(function() {
            $('.getConfimedProductTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('binding') }}",
                columns: [{
                        data: 'product',
                        name: 'product'
                    },
                    {
                        data: 'company_name',
                        name: 'company_name'
                    },
                    {
                        data: 'requestedBy',
                        name: 'requestedBy'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    }

                    // {data: 'status', name: 'status'},
                    // {data: 'sent_out_date', name: 'sent_out_date'},
                    // {data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                language: {
                    emptyTable: "No data available in the table"
                },
                initComplete: function(settings, json) {
                    if (json.recordsTotal === 0) {
                        // Handle the case when there's no data (e.g., show a message)
                        console.log("No data available.");
                    }
                }
            });
        });

        $(document).on('click', '.bindButton', function(e) {
            e.preventDefault();
            var id = $(this).attr('id');
            var product = $(this).attr('data-product');
            // var paymentInformation = $(this).attr('data-paymentInformation');
            // var payementInformationData = paymentInformation ? JSON.parse(paymentInformation) : '{}';
            var quote = $(this).attr('data-quote');
            var quoteData = quote ? JSON.parse(quote) : '{}';
            var marketName = $(this).attr('data-marketName');
            var company_name = $(this).attr('data-companyname');
            console.log(quoteData);
            $('#insuredInput').val(company_name);
            $('#policyNumber').val(quoteData.quote_no);
            $('#paymentTermInput').val(quoteData.payment_information.payment_term);
            $('#hiddenInputId').val(id);
            $('#hiddenQuoteId').val(quoteData.id);
            $('#marketInput').val(marketName);
            if (product == 'General Liabilities') {
                $('#generalLiabilitiesPolicyForm').modal('show');
            }
            if (product == 'Commercial Auto') {
                $('#commercialAutoPolicyForm').modal('show');
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


        $(document).on('click', '.viewBindingButton', function(e) {
            e.preventDefault();
            var id = $(this).attr('id');
            var quote = $(this).attr('data-quote');
            var quoteData = quote ? JSON.parse(quote) : '{}';

            var paymentInformation = $(this).attr('data-paymentInformation');
            var payementInformationData = paymentInformation ? JSON.parse(paymentInformation) : '{}';

            var lead = $(this).attr('data-lead');
            var leadData = lead ? JSON.parse(lead) : '{}';

            var paymentCharged = $(this).attr('data-paymentCharged');
            var paymentChargedData = paymentCharged ? JSON.parse(paymentCharged) : '{}';

            var generalInformation = $(this).attr('data-generalInformation');
            var generalInformationData = generalInformation ? JSON.parse(generalInformation) : '{}';

            var media = $(this).attr('data-media');
            var mediaData = media ? JSON.parse(media) : '{}';

            var marketName = $(this).attr('data-marketName');
            var product = $(this).attr('data-product');
            var name = $(this).attr('data-userProfileName');
            var status = $(this).attr('data-status');

            $('#companyName').text(leadData.company_name);
            $('#insuredName').text(generalInformationData.firstname + ' ' + generalInformationData.lastname);
            $('#state').text(leadData.state_abbr);
            $('#market').text(marketName);
            $('#product').text(product);
            $('#totalPolicyCost').text(quoteData.full_payment);
            $('#policyNum').text(quoteData.quote_no);
            $('#bindingEffectiveDate').text(quoteData.effective_date);
            $('#paymentType').text(payementInformationData.payment_type);
            $('#paymentApprovedBy').text(name);
            $('#inovoiceNumber').text(paymentChargedData.invoice_number);
            $('#paymentAprrovedDate').text(paymentChargedData.charged_date);
            $('#hiddenId').val(id);
            addExistingFiles(mediaData);
            if (status == 11) {
                $('#boundButton').hide();
                $('#declinedButton').hide();
            } else if (status == 6) {
                $('#boundButton').show();
                $('#declinedButton').show();
            };
            $('#declinedLeadId').val(leadData.id);
            $('#declinedHiddenProductId').val(id);
            $('#declinedHiddenTitle').val('Declined Binding for' + ' ' + product);
            $('#dataModal').modal('show');
        });

        $('#declinedButton').on('click', function(e) {
            e.preventDefault();
            $('#declinedBindingModal').modal('show');
            $('#dataModal').modal('hide');
        })
    </script>
@endsection
