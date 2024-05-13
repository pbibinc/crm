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

<script>
    Dropzone.autoDiscover = false;
    var myDropzone;
    $(document).ready(function() {
        var id = {{ $generalInformation->lead->id }};
        console.log(id);
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
                    // $('#viewInvoiceModal').modal('show');
                    // $('#viewInvoiceModalBody').html(data);
                    // console.log(data);
                    addExistingFiles(data.media);
                    $('#fileViewingModal').modal('show');
                }
            });
        });
    });
</script>
