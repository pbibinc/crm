<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true" id="auditInformationModal">
    <div class="modal-dialog modal-dialog-centered modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Audit Information Form</h5>
            </div>
            <form action="" id="auditInformationForm">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label" for="auditInformationStatus">Payment Term</label>
                                <select class="form-select" aria-label="Default select example"
                                    id="auditInformationStatus" name="auditInformationStatus" required>
                                    <option selected="">Status</option>
                                    <option value="Pending Requirements">Pending Requirements</option>
                                    <option value="Make A Payment">Make A Payment</option>
                                    <option value="Additional Premium">Additional Premium</option>
                                    <option value="Submitted To The Market">Submitted To The Market</option>
                                    <option value="Close Even">Close Event</option>
                                    <option value="Done">Done</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-6" id='colFileInput'>
                            <label class="form-label" for="auditInformationFormFile" id="fileLabel">Request For Edit
                                File</label>
                            <input type="file" name="file" id="file"
                                class="form-control auditInformationFormFile">
                        </div>
                        <input type="hidden" name="hiddenPolicyId" id="hiddenPolicyId" required>
                        <input type="hidden" name="hiddenAuditId" id="hiddenAuditId">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <input type="submit" name="audit_action_button" id="audit_action_button" value="Add"
                        class="btn btn-primary ladda-button auditInformationForm" data-style="expand-right">
                </div>
            </form>
        </div>
    </div>

</div>
<script>
    $(document).ready(function() {
        $('#auditInformationForm').on('submit', function(event) {
            event.preventDefault();

            // Initialize Ladda button
            var button = $('#audit_action_button');
            var laddaButton = Ladda.create(button[0]);

            var form_data = new FormData(this);
            var id = $('#hiddenAuditId').val();
            var action = $('#audit_action_button').val() == 'Edit' ?
                `{{ route('audit.update', ':id') }}`.replace(':id', id) :
                "{{ route('audit.store') }}";
            var method = $('#audit_action_button').val() == 'Edit' ? "POST" : "POST";

            if ($('#audit_action_button').val() == 'Edit' && $('#file').val() == '') {
                form_data.delete('file');
            }

            if ($('#audit_action_button').val() == 'Edit') {
                form_data.append('_method', 'PUT');
            }
            laddaButton.start();
            $.ajax({
                url: action,
                method: method,
                data: form_data,
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    laddaButton.stop();
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Audit Information Updated Successfully!',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $('#auditInformationModal').modal('hide');
                            location.reload();
                        }
                    });
                },
                error: function(data) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong!',
                    });
                },
                complete: function() {
                    laddaButton.stop(); // Stop the Ladda spinner
                }
            });
        });
    });
</script>
