<div class="modal fade" id="" tabindex="-1" aria-labelledby="addQuoteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changeStatusModalTitle">Change Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="changeBrokerStatusForm">
                <div class="modal-body">

                    <div class="row">
                        <div class="form-group">
                            <label for="taskDescription" class="form-label">Status</label>
                            <select class="form-select" id="status">
                                <option value="">Select Status</option>
                                <option value="32">Voicemail</option>
                                <option value="5">Declined/Closed Business</option>
                                <option value="31">Not Interested</option>
                                <option value="34">DNC</option>
                                <option value="33">Potential/Interested</option>
                            </select>
                        </div>
                    </div>


                    <input type="hidden" id="productId" value="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="changeStatusButton" class="btn btn-success">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade bs-example-modal-center" id="changeStatusModal" tabindex="-1" role="dialog"
    aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mySmallModalLabel">Dispositions</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="mb-3">
                        <div class="form-group">
                            <label class="form-label">Disposition</label>
                            <select name="timezone" id="dispositionDropDown" class="form-control">
                                <option value="">Select Status</option>
                                <option value="32">Voicemail</option>
                                <option value="5">Declined/Closed Business</option>
                                <option value="31">Not Interested</option>
                                <option value="34">DNC</option>
                                <option value="33">Potential/Interested</option>
                            </select>
                        </div>
                    </div>
                    <input type="hidden" id="brokerProductId">
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-success waves-effect waves-light"
                    id="submitRemarks">Submit</button>
                <button type="button" class="btn btn-light waves-effect" data-bs-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
    $(document).ready(function() {
        $('#submitRemarks').click(function() {
            $.ajax({
                url: "{{ route('change-broker-status') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: "POST",
                data: {
                    status: $('#dispositionDropDown').val(),
                    productId: $('#brokerProductId').val()
                },
                success: function(data) {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: data.success,
                        });
                        location.reload();
                    }
                }
            })
        });
    });
</script>
