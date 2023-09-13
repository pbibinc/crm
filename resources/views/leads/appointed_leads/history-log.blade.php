<style>
    .scrollable{
      overflow-y: auto;
      max-height: 600px;
     }
</style>
<h6>History Logs <i class="ri-information-fill" style="vertical-align: middle; color: #6c757d;"></i></h6>
    <div class="card">
        <div class="card-body">
            <div class="scrollable">
                <section id="cd-timeline" class="cd-container">
                    <div class="cd-timeline-block">
                        <div class="cd-timeline-img cd-success">
                            <i class="mdi mdi-cloud-upload"></i>
                        </div>
                        <div class="cd-timeline-content">
                            <p class="mb-0 text-muted font-14">Leads Has been uploaded.</p>
                            <span class="cd-date">{{ \Carbon\Carbon::parse($generalInformation->lead->created_at)->format('M-j-Y g:iA') }}</span>
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
                                <p class="mb-0 text-muted font-14">Assigned to: {{ $leadHistory->userProfile->fullName()}}.</p>
                                <span class="cd-date">{{ \Carbon\Carbon::parse($changes->assigned_at)->format('M-j-Y g:iA')}}</span>
                            </div>
                            @elseif (isset($changes->reassigned_at))
                            <div class="cd-timeline-img cd-success">
                                <i class="mdi mdi-account-arrow-right"></i>
                            </div>
                            <div class="cd-timeline-content">
                                <p class="mb-0 text-muted font-14">Reassigned to: {{ $leadHistory->userProfile->fullName()}}.</p>
                                <span class="cd-date">{{ \Carbon\Carbon::parse($changes->reassigned_at)->format('M-j-Y g:iA')}}</span>
                            </div>
                            @elseif (isset($changes->appointed_by))
                            <div class="cd-timeline-img cd-success">
                                <i class="mdi mdi-book-edit"></i>
                            </div>
                            <div class="cd-timeline-content">
                                <p class="mb-0 text-muted font-14">Application Taken by: {{ $leadHistory->userProfile->fullName() }}.</p>
                                <span class="cd-date">{{  \Carbon\Carbon::parse($changes->appointed_by)->format('M-j-Y g:iA') }}</span>
                            </div>

                            @endif

                    </div>
                    @endforeach
                </section>
            </div>
        </div>
    </div>
