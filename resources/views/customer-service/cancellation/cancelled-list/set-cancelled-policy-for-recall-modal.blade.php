<div class="modal fade" id="setCancelPolicyForRecallModal" tabindex="-1" aria-labelledby="setCancelPolicyForRecallModal"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cancelPolicyModalTitle">Set Cancel Policy For Recall</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="setCancelPolicyForRecallForm">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6">
                            <label for="cancelPolicyCompanyName">Company Name:</label>
                        </div>
                        <div class="col-6">
                            <label for="oldPolicyNumber">Old Policy Number:</label>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6">
                            <h6 id="canncelPolicyForRecallCompanyName"></h6>
                        </div>
                        <div class="col-6">
                            <h6 id="oldPolicyNumber"></h6>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <label for="forRecallDate">For Recall Date</label>
                        </div>
                        <div class="col-6"></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6">
                            <input type="date" class="form-control" id="forRecallDate" name="forRecallDate">
                        </div>
                        <div class="col-6"></div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <label>Remarks/Description:</label>
                            <textarea name="forRecallRemarks" id="forRecallRemarks" class="form-control" rows="5"></textarea>
                        </div>
                    </div>
                    <input type="hidden" name="forRecalPolicyId" id="forRecalPolicyId">
                    <input type="hidden" name="cancellationForRecallId" id="cancellationForRecallId">
                    <input type="hidden" name="forRecallPolicyAction" id="forRecallPolicyAction" value="save">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#setCancelPolicyForRecallForm').on('submit', function(e) {
            e.preventDefault();
            var cancellationForRecallId = $('#cancellationForRecallId').val();
            var url = $('#forRecallPolicyAction').val() == 'edit' ?
                `{{ route('cancelled-policy-for-recall.update', ':id') }}`.replace(':id',
                    cancellationForRecallId) :
                "{{ route('cancelled-policy-for-recall.store') }}";
            var method = $('#forRecallPolicyAction').val() == 'edit' ? 'PUT' : 'POST';
            $.ajax({
                url: url,
                type: method,
                data: $(this).serialize(),
                success: function(response) {
                    console.log(response);
                    if (response.status === 'success') {
                        Swal.fire(
                            'Success!',
                            'Policy has been set for recall.',
                            'success'
                        ).then(() => {
                            $('#setCancelPolicyForRecallModal').modal('hide');
                            location.reload();
                        });
                    } else {
                        Swal.fire(
                            'Error!',
                            'Something went wrong.',
                            'error'
                        );
                    }
                },
                success: function(response) {
                    console.log(response);
                    Swal.fire(
                        'Success!',
                        'Policy has been set for recall.',
                        'success'
                    ).then(() => {
                        $('#setCancelPolicyForRecallModal').modal('hide');
                        location.reload();
                    });
                },
                error: function(xhr, status, error) {
                    Swal.fire(
                        'Error!',
                        'An error occurred while processing your request.',
                        'error'
                    );
                }
            });
        });
    });
</script>
