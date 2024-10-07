<style>
    .message-box {
        max-width: 70%;
        clear: both;
    }

    .message-box.sender {
        margin-left: auto;
        background-color: #DCF8C6;

        /* Green */
        color: black;
        border-radius: 10px 0px 10px 10px !important;
    }

    .message-box.receiver {
        background-color: #f1f1f1;
        color: black;
        padding: 10px;
        border-radius: 0px 10px 10px 10px !important;
    }

    .message-box.receiver.danger {
        background-color: #f8d7da;
        color: black;
        padding: 10px;
        border-radius: 0px 10px 10px 10px !important;
    }

    .message-timestamp {
        font-size: 0.8rem;
        text-align: right;
    }

    .message-info {
        font-size: 0.8rem;
        margin-top: 5px;
    }

    .sender-info {
        text-align: right;
    }

    .message-box.sender.danger {
        margin-left: auto;
        background-color: #f8d7da;
        color: black;
        border-radius: 10px 0px 10px 10px !important;

    }
</style>

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
                    <button type="button" class="btn btn-outline-primary waves-effect waves-light logNoteActivity"
                        id="logNote"><i class="ri-send-plane-fill"></i>Log Note</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#logNote').on('click', function(e) {
            e.preventDefault();
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
