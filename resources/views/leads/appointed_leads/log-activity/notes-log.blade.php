<style>
    .ps-container {
        position: relative;
        overflow-y: auto !important;
        height: 400px;
        padding: 10px;
        background-color: #f9f9f9;
        border-radius: 8px;
        border: 1px solid #ddd;
    }

    .media {
        display: flex;
        align-items: flex-start;
        margin-bottom: 6px;
        /* Reduced margin for closer messages */
        padding: 4px 6px;
        /* Minimal padding for tighter look */
        background-color: #fff;
        border-radius: 6px;
        /* Small radius for slight rounding */
        border: 1px solid #ddd;
        max-width: fit-content;
        /* Width adjusts to content */
        word-wrap: break-word;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
    }

    .media-chat-reverse {
        flex-direction: row-reverse;
        margin-left: auto;
        padding: 4px 6px;
        /* Minimal padding for reversed messages */
        background-color: #e0e7ff;
        color: #333;
        border-radius: 6px;
        /* Matching small radius */
        border: 1px solid #c3dafe;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        max-width: fit-content;
        /* Width adjusts to content */
    }

    .media-chat-warning {
        background-color: #ffcccc;
        /* Light red background for non-regular notes */
        border: 1px solid #ff9999;
        /* Border color to match */
    }

    .avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        margin-left: 5px;
        /* Reduced margin for tighter alignment */
        background-color: #f5f6f7;
        color: #8b95a5;
        text-align: center;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        text-transform: uppercase;
    }

    .media-body {
        display: flex;
        flex-direction: column;
        max-width: 100%;
        /* Allow full width for text content */
    }

    .media-body h5 {
        margin: 0;
        font-size: 14px;
        font-weight: bold;
        color: inherit;
        margin-bottom: 2px;
    }

    .media-body p {
        margin: 0;
        font-size: 14px;
        color: inherit;
        margin-bottom: 2px;
        /* Minimal margin for compactness */
    }

    .media-body small {
        font-size: 12px;
        color: inherit;
    }

    .publisher {
        display: flex;
        align-items: center;
        padding: 10px;
        background-color: #f9fafb;
        border-top: 1px solid #ebebeb;
        gap: 10px;
    }

    .publisher-input {
        flex-grow: 1;
        border: 1px solid #ddd;
        padding: 6px;
        border-radius: 4px;
        background-color: #fff;
        font-size: 14px;
    }

    .publisher-btn {
        background-color: transparent;
        border: none;
        color: #48b0f7;
        font-size: 16px;
        cursor: pointer;
    }
</style>

@php
    $user = Auth::user();
    $userProfileId = $user->userProfile->id;
    $userProfiles = App\Models\UserProfile::get();
@endphp

<div id="notesDiv">

    <div class="ps-container mb-2" id="chat-content">
        @foreach ($generalInformation->lead->notes as $note)
            <div
                class="media {{ $userProfileId == $note->userProfile->id ? 'media-chat-reverse' : 'media-chat' }} {{ $note->status != 'regular' ? 'media-chat-warning' : '' }}">
                @if ($userProfileId != $note->userProfile->id)
                    <div class="avatar">
                        <img src="{{ asset($note->userProfile->media->filepath) }}" alt="User Avatar"
                            style="width: 100%; height: 100%; border-radius: 50%;">
                    </div>
                @endif
                <div class="media-body">
                    <h5>{{ $note->title }}</h5>
                    <p>{{ $note->description }}</p>
                    <small>
                        <i class="fa fa-clock-o"></i> {{ date('M d, Y H:i', strtotime($note->created_at)) }}
                    </small>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mb-3">
        <div>
            <label for="userToNotifyDropdown" class="form-label">User To Notify</label>
            <select class="form-select" name="userToNotifyDropdown[]" id="userToNotifyDropdown" multiple required>
                <option value="">Select User To Notify...</option>
                @foreach ($userProfiles as $userProfile)
                    <option value="{{ $userProfile->user_id }}">{{ $userProfile->fullAmericanName() }}</option>
                @endforeach
            </select>
            <div class="invalid-feedback" id="userToNotifyDropdownError"></div>
        </div>
    </div>

    <div class="publisher">
        <input class="publisher-input" type="text" placeholder="Title" id="noteTitle">
        <input class="publisher-input" type="text" placeholder="Write something" id="noteDescription">
        <button class="publisher-btn" id="logNote"><i class="fa fa-paper-plane"></i></button>
    </div>
</div>


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
                                    <h5 style="margin-bottom: 6px; font-weight: bold; color: #333;">{{ $note->title }}
                                    </h5> <!-- Make the title prominent -->
                                    <p style="margin-bottom: 8px; color: #555;">{{ $note->description }}</p>
                                    <!-- Style the description as a paragraph -->
                                    <small class="text-muted"
                                        style="{{ $userProfileId == $note->userProfile->id ? 'color: #fff !important;' : 'color: #000 !important;' }}">
                                        <i class="fa fa-clock-o"></i>
                                        {{ date('M d, Y H:i', strtotime($note->created_at)) }}
                                    </small>
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
                    location.reload();
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
