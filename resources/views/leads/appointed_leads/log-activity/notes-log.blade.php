<style>
.message-box {
    max-width: 70%; /* You can adjust this as per your requirements */
    clear: both;
}

.message-box.sender {
    margin-left: auto;
    background-color: #DCF8C6;; /* Green */
    color: black;
    border-radius: 10px 0px 10px 10px !important;
}

.message-box.receiver {
    background-color: #f1f1f1;
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

.scrollable{
      overflow-y: auto;
      overflow-x: hidden;
      max-height: 600px;
     }
</style>
<div id="notesDiv">
    <div class="card">
        <div class="card-body">

            @php
               $user = Auth::user();
               $id = $user->id;
               $adminData = App\Models\User::find($id);
              $userProfileId = $user->userProfile->id;
            @endphp

            <div class="row">
                <div class="container mt-5 d-flex flex-column">
                    <div class="scrollable">
                        @foreach ($generalInformation->lead->notes as $index => $note)
                        @if($userProfileId == $note->userProfile->id)
                        <!-- Sender's Message -->
                        <div class="message-box sender p-3 rounded">
                            <div> <strong>{{ $note->title }}</strong></div>
                            <div class="message-content">
                                {{ $note->description }}
                            </div>
                        </div>
                        <div class="message-info sender-info">
                            <p class="note-date font-2 text-muted">sent by: {{ $note->userProfile->fullAmericanName()}} {{ date('M d, Y', strtotime($note->created_at)) }}
                        </div>

                        @else
                        <!-- Receiver's Message -->
                        <div class="message-box receiver p-3 rounded">
                            <div> <strong>{{ $note->title }}</strong></div>
                            <div class="message-content">
                                {{ $note->description }}
                            </div>
                        </div>
                        <div class="message-info" style="margin-left: 10px">
                            <p class="note-date font-2 text-muted">sent by: {{ $note->userProfile->fullAmericanName()}} {{ date('M d, Y', strtotime($note->created_at)) }}
                        </div>
                        @endif
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="row"><hr></div>
            <div class="row">
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
                <button type="button" class="btn btn-outline-primary waves-effect waves-light" id="logNote"><i class="ri-send-plane-fill"></i>Log Note</button>
            </div>
        </div>
    </div>
</div>

<script>
    // $(document).ready(function(){
    //     var myOffcanvas = document.getElementById('noteCanvass');
    //     var bsOffcanvas = new bootstrap.Offcanvas(myOffcanvas);
    //     $(document).on('click', '.seeMore', function(){
    //         var id = $(this).val();
    //         $.ajax({
    //             url: "/quoatation/"+id+"/get-notes",
    //             headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
    //             success: function(data){
    //                 bsOffcanvas.show();
    //                 const unformattedDate = new Date(data.result.created_at);
    //                 const monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
    //                 const formattedDate = monthNames[unformattedDate.getMonth()] + ' ' + unformattedDate.getDate() + ', ' + unformattedDate.getFullYear();
    //                 $('#canvasContentHeader').text(data.result.title);
    //                 $('#canvassDate').text(formattedDate);
    //                 $('#canvassBodyContent').text(data.result.description);
    //                 $('#canvasAmericanName').text(data.fullamericanName);
    //             },
    //         })
    //     });
    // });
    $(document).ready(function(){
        $('#logNote').on('click', function(){
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