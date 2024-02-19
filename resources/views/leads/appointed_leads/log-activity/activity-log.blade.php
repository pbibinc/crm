<section id="cd-timeline" class="cd-container">
    <div class="cd-timeline-block">
        <div class="cd-timeline-img cd-success">
            <i class="mdi mdi-cloud-upload"></i>
        </div>
        <div class="cd-timeline-content">
            <p class="mb-0 text-muted font-14">Leads Has been uploaded.</p>
            <span
                class="cd-date">{{ \Carbon\Carbon::parse($generalInformation->lead->created_at)->format('M-j-Y g:iA') }}</span>
        </div>

    </div>
    @foreach ($generalInformation->lead->leadHistories as $leadHistory)
        <div class="cd-timeline-block">

            @php
                $changes = json_decode($leadHistory->changes);
            @endphp
            @if (isset($changes->assigned_at))
                <div class="cd-timeline-img cd-success">
                    <i class="mdi mdi-account-arrow-left"></i>
                </div>
                <div class="cd-timeline-content">
                    <p class="mb-0 text-muted font-14">Assigned to: {{ $leadHistory->userProfile->fullName() }}.</p>
                    <span
                        class="cd-date">{{ \Carbon\Carbon::parse($changes->assigned_at)->format('M-j-Y g:iA') }}</span>
                </div>
            @elseif (isset($changes->reassigned_at))
                <div class="cd-timeline-img cd-success">
                    <i class="mdi mdi-account-arrow-right"></i>
                </div>
                <div class="cd-timeline-content">
                    <p class="mb-0 text-muted font-14">Reassigned to: {{ $leadHistory->userProfile->fullName() }}.</p>
                    <span
                        class="cd-date">{{ \Carbon\Carbon::parse($changes->reassigned_at)->format('M-j-Y g:iA') }}</span>
                </div>
            @elseif (isset($changes->appointed_by))
                <div class="cd-timeline-img cd-success">
                    {{-- <i class="mdi mdi-book-edit"></i> --}}
                    <img src="{{ asset($leadHistory->userProfile->media->filepath) }}"
                        class="me-3 rounded-circle avatar-xs" alt="user-pic">
                </div>
                <div class="cd-timeline-content">
                    <p class="mb-0 text-muted font-14">Application Taken by:
                        {{ $leadHistory->userProfile->fullName() }}.</p>
                    <span
                        class="cd-date">{{ \Carbon\Carbon::parse($changes->appointed_by)->format('M-j-Y g:iA') }}</span>
                </div>
            @elseif(isset($changes->assign_appointed_at))
                @php
                    $product = $leadHistory->getProductByProductId($changes->product_id);
                @endphp
                <div class="cd-timeline-img">
                    {{-- <i class="mdi mdi-book-edit"></i> --}}
                    <img src="{{ asset($leadHistory->userProfile->media->filepath) }}"
                        class="me-1 mt-0 rounded-circle avatar-xs" alt="user-pic">
                </div>
                <div class="cd-timeline-content">
                    <p class="mb-0 text-muted font-14"> {{ $product->product }} Has Been assigned to:
                        {{ $leadHistory->userProfile->fullName() }}.</p>
                    <span
                        class="cd-date">{{ \Carbon\Carbon::parse($changes->assign_appointed_at)->format('M-j-Y g:iA') }}</span>
                </div>
            @endif

        </div>
    @endforeach
</section>
