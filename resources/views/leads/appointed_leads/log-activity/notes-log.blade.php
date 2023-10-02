<div id="notesDiv">
    <div class="row">
        @foreach ($generalInformation->lead->notes as $index => $note)
            <div class="col-6">
                <div class="card card-body">
                    <h6 class="note-title text-truncate w-75 mb-0">{{ $note->title }}</h6>
                    <p class="note-date font-2 text-muted" style="font-size: 12px">{{ date('M d, Y', strtotime($note->created_at)) }}</p>
                    <div class="note-content">
                        <p class="note-inner-content text-muted" style="font-size: 12px">{{ $note->description }}</p>
                    </div>
                    <footer class="blockquote-footer m-0">Noted by <cite title="Source Title">{{ $note->userProfile->fullAmericanName()}}</cite><button type="button" class="btn btn-link waves-effect seeMore" value={{ $note->id }} >...</button></footer>
                </div>
            </div>
            @if (($index + 1) % 2 == 0) <!-- If the note is even-numbered, close the row and start a new one. -->
                </div><div class="row">
            @endif
        @endforeach
    </div>
</div>

<div class="offcanvas offcanvas-end" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1" id="noteCanvass" aria-labelledby="offcanvasRightLabel" aria-modal="true" role="dialog">
    <div class="offcanvas-header">
      <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
      <h5 id="canvasContentHeader">Offcanvas Right</h5>
      <p class="font-2 text-muted" style="font-size: 12px" id="canvassDate"></p>
      <p class="text-muted" id="canvassBodyContent"></p>
      <footer class="blockquote-footer m-0">Noted by <cite id="canvasAmericanName"></cite></footer>

    </div>
</div>



<script>
    $(document).ready(function(){
        var myOffcanvas = document.getElementById('noteCanvass');
        var bsOffcanvas = new bootstrap.Offcanvas(myOffcanvas);
        $(document).on('click', '.seeMore', function(){
            var id = $(this).val();
            $.ajax({
                url: "/quoatation/"+id+"/get-notes",
                headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function(data){
                    bsOffcanvas.show();
                    const unformattedDate = new Date(data.result.created_at);
                    const monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
                    const formattedDate = monthNames[unformattedDate.getMonth()] + ' ' + unformattedDate.getDate() + ', ' + unformattedDate.getFullYear();
                    $('#canvasContentHeader').text(data.result.title);
                    $('#canvassDate').text(formattedDate);
                    $('#canvassBodyContent').text(data.result.description);
                    $('#canvasAmericanName').text(data.fullamericanName);
                },
            })
        });
    });


</script>
