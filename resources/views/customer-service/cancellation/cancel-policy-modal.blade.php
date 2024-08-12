<div class="modal fade" id="cancelPolicyModal" tabindex="-1" aria-labelledby="cancelPolicyModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cancelPolicyModalTitle">Cancel Policy
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-6">
                        <label for="cancelPolicyCompanyName">Company Name:</label>
                    </div>
                    <div class="col-6">
                        <label for="cancelPolicyCarrier">Carrier:</label>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-6">
                        <h6 id="cancelPolicyCompanyName"></h6>
                    </div>
                    <div class="col-6">
                        <h6 id="cancelPolicyCarrier"></h6>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <label for="cancelPolicyInsuredName">Insured Name:</label>
                    </div>
                    <div class="col-6">
                        <label for="cancelPolicyType">Policy Type:</label>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-6">
                        <h6 id="cancelPolicyInsuredName"></h6>
                    </div>
                    <div class="col-6">
                        <h6 id="cancelPolicyType"></h6>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <label for="cancelPolicyAddress">Address:</label>
                    </div>
                    <div class="col-6">
                        <label for="cancelPolicyTerm">Policy Term:</label>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-6">
                        <h6 id="cancelPolicyAddress"></h6>
                    </div>
                    <div class="col-6">
                        <h6 id="cancelPolicyTerm"></h6>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <label for="cancelPolicyTypeOfCancellation">Type of Cancellation:</label>
                    </div>
                    <div class="col-6">
                        <label for="cancelaPolicyCancellationDate">Cancellation Date</label>
                    </div>

                </div>
                <div class="row mb-4">
                    <div class="col-6">
                        <h6 id="cancelPolicyTypeOfCancellation"></h6>
                    </div>
                    <div class="col-6">
                        <input type="date" class="form-control" id="cancelaPolicyCancellationDate"
                            name="cancelaPolicyCancellationDate" required>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-12">
                        <label>Remarks/Description:</label>
                        <textarea name="cancellationPolicyRemarks" id="cancellationPolicyRemarks" class="form-control" rows="5"></textarea>
                    </div>
                </div>
                <div class="row mb-2">
                    <form action="cancelPolicyForm" enctype="multipart/form-data">
                        <div class="dropzone mt-4 border-dashed" id="cancelPolicyDropzone"
                            enctype="multipart/form-data"></div>
                        <input type="hidden" name="policyId" id="policyId">
                        <input type="hidden" name="cancellationEndorsementId" id="cancellationEndorsementId">
                    </form>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger" id="cancelPolicyBtn">Submit <i
                        class="mdi mdi-cancel"></i></button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#cancelPolicyBtn').on('click', function() {
            function saveCancelledPolicy() {
                $.ajax({
                    url: "{{ route('cancellation-policy.save-cancelled-policy') }}",
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        policyId: $('#policyId').val(),
                        cancellationEndorsementId: $('#cancellationEndorsementId').val(),
                        cancelaPolicyCancellationDate: $('#cancelaPolicyCancellationDate')
                            .val(),
                        cancellationPolicyRemarks: $('#cancellationPolicyRemarks').val(),
                    },
                    success: function(response) {
                        if (response.status == 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.message,

                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $('#cancelPolicyModal').modal('hide');
                                    window.location.reload();
                                }
                            })
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message,
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $('#cancelPolicyModal').modal('hide');
                                    window.location.reload();
                                }
                            })
                        }
                    },
                    error: function(response) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Something went wrong',

                        })
                    }


                })
            }


            Swal.fire({
                title: 'Are you sure?',
                text: "You want to cancel this policy!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, cancel it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    saveCancelledPolicy();
                }
            })



        });
    });
</script>
