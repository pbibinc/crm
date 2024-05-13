<div class="modal fade" id="notesModal" tabindex="-1" aria-labelledby="notesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="notesModalLabel">Notes Log</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div id="notesContainer"></div>
                </div>
                <div class="row mb-3">
                    <label for="notes" class="form-label">Title:</label>
                    <div>
                        <input type="text" class="form-control" id="noteTitle" placeholder="Title" required>
                        <div class="invalid-feedback" id="noteTitleError"></div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="notesDescription">Description:</label>
                    <div>
                        <textarea required="" class="form-control" rows="5" placeholder="Type a note..." id="noteDescription" required></textarea>
                        <div class="invalid-feedback" id="noteDescriptionError"></div>
                    </div>
                </div>
                <div>
                    <input type="hidden" name="departmentIds" id="departmentIds">
                    <input type="hidden" name="leadId" id="leadId">
                    <button type="button" class="btn btn-outline-primary waves-effect waves-light" id="logNote"><i
                            class="ri-send-plane-fill"></i>Log Note</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#logNote').on('click', function() {
            var noteTitle = $('#noteTitle').val();
            var noteDescription = $('#noteDescription').val();
            var userToNotify = $('#userToNotifyDropdown').val();
            var leadId = $('#leadId').val();
            var departmentIds = JSON.parse($('#departmentIds').val());
            $.ajax({
                url: "{{ route('create-notes') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: "POST",
                data: {
                    noteTitle: noteTitle,
                    noteDescription: noteDescription,
                    leadId: leadId,
                    status: 'regular',
                    userToNotify: userToNotify,
                    departmentIds: departmentIds,
                },
                success: function(data) {
                    location.reload();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    if (jqXHR.status == 422) {
                        const errors = jqXHR.responseJSON.errors;
                        // Remove any existing errors
                        $('.is-invalid').removeClass('is-invalid');
                        $('.invalid-feedback').empty();

                        // Loop through and display error messages
                        for (let field in errors) {
                            const errorMessage = errors[field];
                            $(`#${field}`).addClass('is-invalid');
                            $(`#${field}Error`).text(errorMessage).show();
                        }
                    }
                },
            })
        });
    })
</script>
