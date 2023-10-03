<style>
.is-invalid {
    border-color: red;
}

.invalid-feedback {
    color: red;
}
</style>

<div>
      <div class="row mb-3" >
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
          <button type="button" class="btn btn-outline-primary waves-effect waves-light" id="logNote">Log Note</button>
      </div>
</div>
<script>
    $(document).ready(function(){
        $('#createNotes').on('click', '#logNote', function(){
            event.preventDefault();
            var noteTitle = $('#noteTitle').val();
            var noteDescription = $('#noteDescription').val();
            var leadId = {!! json_encode($generalInformation->lead->id) !!};
            $.ajax({
                url: "{{ route('create-notes') }}",
                headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                method: "POST",
                data: {noteTitle:noteTitle, noteDescription:noteDescription, leadId:leadId},
                success: function(data){
                    location.reload();
                },
                error: function(jqXHR, textStatus, errorThrown){
                    if(jqXHR.status == 422){
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
            });
        });
    });
</script>
