@php
    use app\Models\UserProfile;
@endphp

<style>
    .message-box {
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 15px;
        margin-bottom: 15px;
        background-color: #f9f9f9;
    }

    .message-box .sender-icon {
        margin-right: 10px;
    }

    .message-box .message-date {
        font-size: 0.9rem;
        color: #888;
    }
</style>
<div class="row mb-2">
    <div class="card">
        <div class="card-body">
            <div class="row mb-3">
                Recent Activity
            </div>

            <div class="row">
                @foreach ($leads->recentLeadHistories as $history)
                    @php
                        $changes = json_decode($history->changes);
                    @endphp
                    @if (isset($changes->assigned_at))
                        <div class="d-flex align-items-start mb-2">
                            <i class="ri-list-check mr-2"></i>
                            <div class="ml-2" style="margin-left: 1rem">
                                <p class="mb-0 text-muted font-14">Assigned to:
                                    {{ $history->userProfile->fullName() }}.</p>
                                <span
                                    class="cd-date">{{ \Carbon\Carbon::parse($changes->assigned_at)->format('M-j-Y g:iA') }}</span>
                            </div>
                        </div>
                    @elseif(isset($changes->reassigned_at))
                        <div class="d-flex align-items-start mb-2">
                            <i class="ri-list-check mr-2"></i>
                            <div class="ml-2" style="margin-left: 1rem">
                                <p class="mb-0 text-muted font-14">Reassigned to:
                                    {{ $history->userProfile->fullName() }}.</p>
                                <span
                                    class="cd-date">{{ \Carbon\Carbon::parse($changes->reassigned_at)->format('M-j-Y g:iA') }}</span>
                            </div>
                        </div>
                    @elseif (isset($changes->appointed_by))
                        <div class="d-flex align-items-start mb-2">
                            <i class="ri-list-check mr-2"></i>
                            <div class="ml-2" style="margin-left: 1rem">
                                <p class="mb-0 text-muted font-14">Application Taken by:
                                    {{ $history->userProfile->fullName() }}.</p>
                                <span
                                    class="cd-date">{{ \Carbon\Carbon::parse($changes->appointed_by)->format('M-j-Y g:iA') }}</span>
                            </div>
                        </div>
                    @elseif(isset($changes->assign_appointed_at))
                        @php
                            $product = $history->getProductByProductId($changes->product_id);
                        @endphp
                        <div class="d-flex align-items-start mb-2">
                            <i class="ri-list-check mr-2"></i>
                            <div class="ml-2" style="margin-left: 1rem">
                                <p class="mb-0 text-muted font-14"> {{ $product->product }} Has Been assigned to:
                                    {{ $history->userProfile->fullName() }}.</p>
                                <span
                                    class="cd-date">{{ \Carbon\Carbon::parse($changes->assign_appointed_at)->format('M-j-Y g:iA') }}</span>
                            </div>
                        </div>
                    @elseif(isset($changes->type) && $changes->type == 'renewal_reminder')
                        <div class="d-flex align-items-start mb-2">
                            <i class="ri-list-check mr-2"></i>
                            <div class="ml-2" style="margin-left: 1rem">
                                <p class="mb-0 text-muted font-14">Renewal Reminder Sent By:
                                    {{ $history->userProfile->fullName() }}.</p>
                                <span
                                    class="text-primary font-weight-bold">{{ \Carbon\Carbon::parse($changes->sent_date)->format('M j, Y g:i A') }}</span>
                            </div>
                        </div>
                    @elseif(isset($changes->changes) && $changes->type == 'general-information-update')
                        <div class="d-flex align-items-start mb-2">
                            <i class="ri-list-check mr-2"></i>
                            <div class="ml-2" style="margin-left: 1rem">
                                <p class="mb-0 text-muted font-14">General Information Updated By:
                                    {{ $history->userProfile->fullName() }}.</p>
                                <span
                                    class="cd-date">{{ \Carbon\Carbon::parse($changes->sent_out_date)->format('M-j-Y g:iA') }}</span>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="card">
        <div class="card-body">
            <div class="row mb-3">
                Recent Notes
            </div>
            @foreach ($leads->recentNotes as $note)
                <div class="row mb-2">
                    <div class="message-box d-flex">
                        <div class="sender-icon">
                            @php
                                $userProfileFilePath = UserProfile::find($note->user_profile_id)->media->filepath;
                            @endphp
                            <img src="{{ asset($userProfileFilePath) }}" class="me-1 mt-0 rounded-circle avatar-xs"
                                alt="user-pic">
                        </div>
                        <div>
                            <h5>{{ $note->title }}</h5>
                            <p class="mb-1 text-muted font-14">{{ $note->description }}</p>
                            <span
                                class="message-date">{{ \Carbon\Carbon::parse($note->created_at)->format('M-j-Y g:iA') }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
