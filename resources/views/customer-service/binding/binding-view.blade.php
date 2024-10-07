<div class="row">
    <table id="bindingProductTable" class="table table-bordered dt-responsive nowrap bindingProductTable"
        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
        <thead class="" style="background-color: #f0f0f0;">
            <th>Policy Number</th>
            <th>Product</th>
            <th>Company Name</th>
            <th>Requested By</th>
            <th>Total Cost</th>
            <th>Effective Date</th>
            <th>Action</th>
            {{-- <th>Sent Out Date</th>
                        <th></th> --}}
        </thead>
        <tbody>

        </tbody>
    </table>
</div>
<script>
    $(document).ready(function() {
        var token = '{{ csrf_token() }}';
        $('.bindingProductTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('binding-view-list') }}",
                type: "POST",
            },
            columns: [{
                    data: 'policy_number',
                    name: 'policy_number'
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
                    data: 'total_cost',
                    name: 'total_cost'
                },
                {
                    data: 'effective_date',
                    name: 'effective_date'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ],
            createdRow: function(row, data, dataIndex) {
                var status = data.status;
                if (status == 15) {
                    $(row).addClass('table-warning');
                }
            },
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
            var productStatus = $(this).data('status');
            var type = $(this).attr('type');
            $.ajax({
                url: "{{ route('request-to-bind-information') }}",
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    id: id,
                    type: type
                },
                dataType: "json",
                success: function(data) {
                    console.log(data);
                    $('#companyName').text(data.lead.company_name);
                    $('#insuredName').text(data.generalInformation.firstname + ' ' +
                        data.generalInformation.lastname);
                    $('#state').text(data.lead.state_abbr);
                    $('#market').text(data.marketName.name);
                    $('#product').text(data.product.product);
                    $('#totalPolicyCost').text(data.market.full_payment);
                    $('#policyNum').text(data.market.quote_no);
                    $('#bindingEffectiveDate').text(data.market.effective_date);
                    $('#paymentType').text(data.paymentInformation.payment_type);
                    $('#paymentApprovedBy').text(data.userProfile.firstname);
                    $('#inovoiceNumber').text(data.paymentCharged.invoice_number);
                    $('#paymentAprrovedDate').text(data.paymentCharged.charged_date);
                    $('#hiddenId').val(id);
                    $('#hiddenPaymentInformationId').val(data.paymentInformation.id);
                    addExistingFiles(data.medias);
                    if (status == 11) {
                        $('#boundButton').hide();
                        $('#declinedButton').hide();
                    } else if (status == 6) {
                        $('#boundButton').show();
                        $('#declinedButton').show();
                    };
                    $('#declinedLeadId').val(data.lead.id);
                    $('#declinedHiddenProductId').val(id);
                    $('#declinedHiddenTitle').val('Declined Binding for' + ' ' + data
                        .product.product);
                    $('#userToNotify').val(data.userId);
                    $('#productStatus').val(productStatus);
                    $('#bindingProductStatus').val(productStatus);
                    $('#dataModal').modal('show');
                },
                error: function(data) {
                    var errors = data.responseJSON;
                    console.log(errors);
                }
            });
        });

    });
</script>
