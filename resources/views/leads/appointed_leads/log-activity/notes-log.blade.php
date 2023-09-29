<div id="notesDiv">
    <div class="row">
        @foreach ($generalInformation->lead->notes as $index => $note)
            <div class="col-6">
                <div class="card card-body">
                    <span class="side-stick"></span>
                    <h5 class="note-title text-truncate w-75 mb-0" data-noteheading="Go for lunch">{{ $note->title }}</h5>
                    <p class="note-date font-10 text-muted">01 April 2002</p>
                    <div class="note-content">
                        <p class="note-inner-content text-muted" data-notecontent="Blandit tempus porttitor aasfs. Integer posuere erat a ante venenatis.">{{ $note->description }}</p>
                    </div>
                    <footer class="blockquote-footer m-0">Noted by <cite title="Source Title">{{ $note->user_profile_id }}</cite></footer>
                </div>
            </div>
            @if (($index + 1) % 2 == 0) <!-- If the note is even-numbered, close the row and start a new one. -->
                </div><div class="row">
            @endif
        @endforeach
    </div>
</div>
