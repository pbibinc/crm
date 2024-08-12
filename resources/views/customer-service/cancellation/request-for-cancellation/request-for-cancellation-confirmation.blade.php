<div class="modal fade" id="requestForCancellationConfirmationModal" tabindex="-1"
    aria-labelledby="requestForCancellationConfirmationModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="requestForCancellationConfirmationModalTitle">Cancellation Request
                    Information
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-6">
                        <label for="companuName">Company Name:</label>
                    </div>
                    <div class="col-6">
                        <label for="carrier">Carrier:</label>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-6">
                        <h6 id="companyName">
                        </h6>
                    </div>
                    <div class="col-6">
                        <h6 id="carrier">
                        </h6>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <label for="insuredName">Insured Name:</label>
                    </div>
                    <div class="col-6">
                        <label for="policyType">Policy Type:</label>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-6">
                        <h6 id="insuredName">
                        </h6>
                    </div>
                    <div class="col-6">
                        <h6 id="policyType"></h6>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <label for="address">Address:</label>
                    </div>
                    <div class="col-6">
                        <label for="policyTerm">Policy Term:</label>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-6">
                        <h6 id="address"></h6>
                    </div>
                    <div class="col-6">
                        <h6 id="policyTerm"></h6>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <label for="cancellationTypeDescription">Type of Cancellation:</label>
                    </div>
                    <div class="col-6">
                        <label for="cancellationDae">Cancellation Date</label>
                    </div>

                </div>
                <div class="row mb-4">
                    <div class="col-6">
                        <h6 id="cancellationTypeDescription"></h6>
                    </div>
                    <div class="col-6">
                        <input type="date" class="form-control" id="cancellationDate" name="cancellationDate"
                            required>
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-12">
                        <label>Description:</label>
                        <textarea name="cancellationDescription" id="cancellationDescription" class="form-control" rows="5"></textarea>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-12">
                        <form id="cancellatioRequestConfirmationForm" enctype="multipart/form-data">
                            <input type="hidden" name="poliydetailId" id="poliydetailId">
                            <input type="hidden" name="typeOfCancellation" id="typeOfCancellation">
                            <div class="dropzone mt-4 border-dashed" id="cancellationRequestConfirmationDropzone"
                                enctype="multipart/form-data"></div>
                        </form>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button class="btn btn-danger" id="declinedCancellationRequestButton">Declined</button>
                <button class="btn btn-warning" id="subjectForRewrite">Subject For Rewrite</button>
                <button class="btn btn-success" type="" id="approveCancellationRequestButton">Approve</button>
            </div>

        </div>
    </div>
</div>
<script>
    Dropzone.autoDiscover = false;
    var cancellationRequestConfirmationDropzone;

    function cancellationEndorsement(file) {
        var mockFile = {
            id: file.id,
            name: file.basename,
            size: parseInt(file.size),
            type: file.type,
            status: Dropzone.ADDED,
            url: file.filepath // URL to the file's location
        };
        cancellationRequestConfirmationDropzone.emit("addedfile", mockFile);
        // myDropzone.emit("thumbnail", mockFile, file.filepath); // If you have thumbnails
        cancellationRequestConfirmationDropzone.emit("complete", mockFile);
    };

    $(document).ready(function() {
        cancellationRequestConfirmationDropzone = new Dropzone('#cancellationRequestConfirmationDropzone', {
            url: "#",
            autoProcessQueue: false, // Prevent automatic upload
            clickable: true, // Allow opening file dialog on click
            maxFiles: 1, //
            addRemoveLinks: true,
            init: function() {
                this.on("addedfile", function(file) {
                    file.previewElement.addEventListener('click', function() {
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

                    })
                });
            }
        });

        $('#requestForCancellationConfirmationModal').on('hidden.bs.modal', function() {

            var form = $('#cancellatioRequestConfirmationForm')[0];
            form.reset();
            // Clear all files from Dropzone
            cancellationRequestConfirmationDropzone.removeAllFiles(true);
            $('#cancellationRequestConfirmationDropzone').empty();
        });

        $('#approveCancellationRequestButton').on('click', function() {
            var status = 'Request For Cancellation Approved';
            var policyDetailId = parseInt($('#poliydetailId')
                .val()); // Ensure the ID is correctly parsed


            // Build the correct URL by including the policyDetailId in the route
            var url = `/customer-service/change-policy-status/${policyDetailId}`;

            $.ajax({
                url: url, // URL with the ID included as part of the path
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                data: {
                    status: status
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.reload();
                        }
                    });
                },
                error: function(xhr) {
                    var errorMessage = 'Something went wrong!';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    } else if (xhr.statusText) {
                        errorMessage = xhr.statusText;
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: errorMessage,
                    });
                }
            });
        });

    });
</script>
