
<div id="createNotes">

    <div class="row mb-3" >
      <label for="notes" class="form-label">Title:</label>
      <div>
         <input type="text" class="form-control" id="noteTitle" placeholder="Title">
       </div>
     </div>

     <div class="row mb-3">
        <label for="notesDescription">Description:</label>
        <div>
            <textarea required="" class="form-control" rows="5" placeholder="Type a note..." id="noteDescription"></textarea>
        </div>
    </div>

    <div>
        <button type="button" class="btn btn-outline-primary waves-effect waves-light" id="logNote">Log Note</button>
    </div>
</div>


<script>
    $(document).ready(function(){
        $('#createNotes').on('click', function(){
            var noteTitle = $('#noteTitle').val();
            var noteDescription = $('#noteDescription').val();
            var leadId = {!! json_encode($generalInformation->lead->id) !!};
            $('#preloader').show();
            $.ajax({
                url: "{{ route('create-notes') }}",
                headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                method: "POST",
                data: {noteTitle:noteTitle, noteDescription:noteDescription, leadId:leadId},
                success: function(data){
                    $("#notesDiv").load(window.location.href + " #notesDiv > *");
                    $("#createNotes").load(window.location.href + " #createNotes > *");
                },
            });
        });
    });
</script>
