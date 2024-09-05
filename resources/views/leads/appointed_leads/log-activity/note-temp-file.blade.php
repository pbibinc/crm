<style>
    .ps-container {
        position: relative;
    }

    .ps-container {
        -ms-touch-action: auto;
        touch-action: auto;
        overflow: hidden !important;
        -ms-overflow-style: none;
    }

    .media-chat {
        padding-right: 64px !important;
        margin-bottom: 0;
    }

    .media {
        padding: -1px 12px;
        -webkit-transition: background-color .2s linear !important;
        transition: background-color .2s linear !important;
    }

    .media .avatar {
        flex-shrink: 0;
    }

    .avatar {
        position: relative;
        display: inline-block;
        width: 36px;
        height: 36px;
        line-height: 36px;
        text-align: center;
        border-radius: 100%;
        background-color: #f5f6f7;
        color: #8b95a5;
        text-transform: uppercase;
    }

    .media-chat .media-body {
        -webkit-box-flex: initial;
        flex: initial;
        display: table;
    }

    .media-body {
        min-width: 0;
    }

    .media-chat .media-body p {
        position: relative;
        padding: 6px 8px;
        margin: 4px 0;
        background-color: #f5f6f7;
        border-radius: 3px;
        font-weight: 100;
        color: #9b9b9b;
    }

    .media>* {
        margin: 0 8px;
    }

    .media-chat .media-body p.meta {
        background-color: transparent !important;
        padding: 0;
        opacity: .8;
    }

    .media-meta-day {
        -webkit-box-pack: justify;
        justify-content: space-between;
        -webkit-box-align: center;
        align-items: center;
        margin-bottom: 0;
        color: #8b95a5;
        opacity: .8;
        font-weight: 400;
    }

    .media-meta-day::before,
    .media-meta-day::after {
        content: '';
        -webkit-box-flex: 1;
        flex: 1 1;
        border-top: 1px solid #ebebeb;
    }

    .media-meta-day::after {
        margin-left: 16px;
    }

    .media-chat.media-chat-reverse {
        padding-right: 12px;
        padding-left: 680px;
        -webkit-box-orient: horizontal;
        -webkit-box-direction: reverse;
        flex-direction: row-reverse;
    }


    .media-chat.media-chat-reverse .media-body p {
        float: right;
        clear: right;
        background-color: #48b0f7;
        color: #fff;
    }


    .border-light {
        border-color: #f1f2f3 !important;
    }

    .bt-1 {
        border-top: 1px solid #ebebeb !important;
    }

    .publisher {
        position: relative;
        display: -webkit-box;
        display: flex;
        -webkit-box-align: center;
        align-items: center;
        padding: 12px 20px;
        background-color: #f9fafb;
    }

    .publisher>*:first-child {
        margin-left: 0;
    }

    .publisher>* {
        margin: 0 8px;
    }

    .publisher-input {
        -webkit-box-flex: 1;
        flex-grow: 1;
        border: none;
        outline: none !important;
        background-color: transparent;
    }

    button,
    input,
    optgroup,
    select,
    textarea {
        font-family: Roboto, sans-serif;
        font-weight: 300;
    }

    .publisher-btn {
        background-color: transparent;
        border: none;
        color: #8b95a5;
        font-size: 16px;
        cursor: pointer;
        overflow: -moz-hidden-unscrollable;
        -webkit-transition: .2s linear;
        transition: .2s linear;
    }

    .file-group {
        position: relative;
        overflow: hidden;
    }

    .file-group input[type="file"] {
        position: absolute;
        opacity: 0;
        z-index: -1;
        width: 20px;
    }

    .text-info {
        color: #48b0f7 !important;
    }
</style>


@php
    $user = Auth::user();
    $userProfileId = $user->userProfile->id;
    $userProfiles = App\Models\UserProfile::get();
@endphp

{{-- <div id="notesDiv">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="container mt-5 d-flex flex-column">
                    <div class="ps-container ps-theme-default ps-active-y" id="chat-content"
                        style="overflow-y: scroll !important; height:400px !important; ">

                        @foreach ($generalInformation->lead->notes as $note)
                            <div
                                class="media media-chat {{ $userProfileId == $note->userProfile->id ? 'media-chat-reverse' : 'media-chat ?>' }} d-flex">
                                @if ($userProfileId != $note->userProfile->id)
                                    <img class="avatar" src="{{ asset($note->userProfile->media->filepath) }}"
                                        alt="...">
                                @endif

                                <div class="media-body">
                                    <p>
                                        <strong class="mb-2">{{ $note->title }}</strong><br>
                                        <span>{{ $note->description }}</span><br>
                                        <small class="text-muted" style="color: #fff !important;"><i
                                                class="fa fa-clock-o"></i>
                                            {{ date('M d, Y H:i', strtotime($note->created_at)) }}</small>
                                    </p>
                                </div>
                            </div>
                        @endforeach


                        <div class="ps-scrollbar-x-rail" style="left: 0px; bottom: 0px;">
                            <div class="ps-scrollbar-x" tabindex="0" style="left: 0px; width: 0px;"></div>
                        </div>
                        <div class="ps-scrollbar-y-rail" style="top: 0px; height: 0px; right: 2px;">
                            <div class="ps-scrollbar-y" tabindex="0" style="top: 0px; height: 2px;"></div>
                        </div>
                    </div>


                    <div class="mb-2">
                        <label for="userToNotifyDropdown" class="form-label">User To Notify</label>
                        <select class="form-select" name="userToNotifyDropdown[]" id="userToNotifyDropdown"
                            data-placeholder="Choose..." multiple="multiple" required>
                            <option value=" ">Select User To Notify....</option>
                            @foreach ($userProfiles as $userProfile)
                                <option value="{{ $userProfile->user_id }}">{{ $userProfile->fullAmericanName() }}
                                </option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback" id="userToNotifyDropdownError"></div>
                    </div>

                    <div class="publisher bt-1 border-light">


                        <div class="row">
                            <input class="publisher-input" type="text" placeholder="Title" id="noteTitle">
                        </div>

                        <input class="publisher-input" type="text" placeholder="Write something"
                            id="noteDescription">

                        <button class="publisher-btn text-info" href="#" data-abc="true"><i
                                class="fa fa-paper-plane" id="logNote"></i></button>
                    </div>



                </div>
            </div>
        </div>
    </div>
</div> --}}

<div id="notesDiv">
    <div class="card">
        <div class="card-body">
            <div class="container mt-5">
                <div class="ps-container" id="chat-content">
                    @foreach ($generalInformation->lead->notes as $note)
                        <div
                            class="media {{ $userProfileId == $note->userProfile->id ? 'media-chat-reverse' : 'media-chat' }}">
                            @if ($userProfileId != $note->userProfile->id)
                                <div class="avatar">
                                    <img src="{{ asset($note->userProfile->media->filepath) }}" alt="...">
                                </div>
                            @endif
                            <div class="media-body">
                                <p>
                                    <strong>{{ $note->title }}</strong>
                                    <span>{{ $note->description }}</span>
                                    <small class="text-muted"><i class="fa fa-clock-o"></i>
                                        {{ date('M d, Y H:i', strtotime($note->created_at)) }}</small>
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mb-2">
                    <label for="userToNotifyDropdown" class="form-label">User To Notify</label>
                    <select class="form-select" name="userToNotifyDropdown[]" id="userToNotifyDropdown"
                        multiple="multiple" required>
                        <option value="">Select User To Notify...</option>
                        @foreach ($userProfiles as $userProfile)
                            <option value="{{ $userProfile->user_id }}">{{ $userProfile->fullAmericanName() }}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback" id="userToNotifyDropdownError"></div>
                </div>

                <div class="publisher bt-1 border-light">
                    <input class="publisher-input" type="text" placeholder="Title" id="noteTitle">
                    <input class="publisher-input" type="text" placeholder="Write something" id="noteDescription">
                    <button class="publisher-btn text-info" id="logNote"><i class="fa fa-paper-plane"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>



{{-- <div class="row" id="chatDiv">
    <div class="mb-3">
        <div id="notesContainer"></div>
    </div>
    <div class="mb-2">
        <label for="notes" class="form-label">Title:</label>
        <input type="text" class="form-control" id="noteTitle" placeholder="Title" required>
        <div class="invalid-feedback" id="noteTitleError"></div>
    </div>
    <div class="mb-2">
        <label for="userToNotifyDropdown" class="form-label">User To Notify</label>
        <select class="form-select" name="userToNotifyDropdown[]" id="userToNotifyDropdown" data-placeholder="Choose..."
            multiple="multiple" required>
            @foreach ($userProfiles as $userProfile)
                <option value="{{ $userProfile->user_id }}">{{ $userProfile->fullAmericanName() }}</option>
            @endforeach
        </select>
        <div class="invalid-feedback" id="userToNotifyDropdownError"></div>
    </div>
    <div class="mb-2">
        <label for="notesDescription">Description:</label>
        <textarea required class="form-control" rows="4" placeholder="Type a note..." id="noteDescription"></textarea>
        <div class="invalid-feedback" id="noteDescriptionError"></div>
    </div>
    <button type="button" class="btn btn-outline-primary waves-effect waves-light" id="logNote"><i
            class="ri-send-plane-fill"></i>Log Note</button>
</div> --}}


<script>
    $(document).ready(function() {

        $('#userToNotifyDropdown').select2({
            placeholder: "Select User",
            allowClear: true
        });

        $('#logNote').on('click', function() {
            var noteTitle = $('#noteTitle').val();
            var noteDescription = $('#noteDescription').val();
            var leadId = {!! json_encode($generalInformation->lead->id) !!};
            var userToNotify = $('#userToNotifyDropdown').val();
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
                    userToNotify: userToNotify
                },
                success: function(data) {
                    var newNoteHtml = `<div class="message-box sender p-2 rounded">
                                        <div><strong>${noteTitle}</strong></div>
                                        <div class="message-content">${noteDescription}</div>
                                       </div>
                                       <div class="message-info">
                                        <p class="note-date font-2 text-muted">sent by: You just now</p>
                                       </div>`;
                    $('#notesContainer').append(newNoteHtml);
                    $('#noteTitle').val('');
                    $('#noteDescription').val('');
                    $('#userToNotifyDropdown').val(null).trigger('change');
                    scrollToBottom();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    if (jqXHR.status == 422) {
                        const errors = jqXHR.responseJSON.errors;
                        $('.is-invalid').removeClass('is-invalid');
                        $('.invalid-feedback').empty();
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
