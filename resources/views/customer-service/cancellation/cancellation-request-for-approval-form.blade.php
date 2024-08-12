<div class="modal fade" id="cancellatioRequestInformationModal" tabindex="-1"
    aria-labelledby="cancellatioRequestInformationModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cancellatioRequestInformationModalTitle">Cancellation Request Information
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
                        <form id="cancellationRequestForm" enctype="multipart/form-data">
                            <input type="hidden" name="poliydetailId" id="poliydetailId">
                            <input type="hidden" name="typeOfCancellation" id="typeOfCancellation">
                            <input type="hidden" name="action" id="action">
                            <input type="hidden" name="cancellationEndorsementId" id="cancellationEndorsementId">
                            <div class="dropzone mt-4 border-dashed" id="cancellationRequestDropzone"
                                enctype="multipart/form-data"></div>
                        </form>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button class="btn btn-warning" id="submitForRewrite">Subject For Rewrite</button>
                <button class="btn btn-success" type="" id="submitCancellationRequest">Submit</button>
            </div>

        </div>
    </div>
</div>
<script>
    $(document).ready(function() {

    });
</script>
