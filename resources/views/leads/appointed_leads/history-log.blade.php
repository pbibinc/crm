<style>
    .scrollable {
        overflow-y: auto;
        overflow-x: hidden;
        max-height: 600px;
    }
</style>
<h6>Logs & Activities <i class="ri-information-fill" style="vertical-align: middle; color: #6c757d;"></i></h6>
<div class="card">
    <div class="card-body">
        <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#activityLogs" role="tab" aria-selected="false">
                    <span class="d-none d-sm-block">Activity Log</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#logNotes" role="tab" aria-selected="false">
                    <span class="d-none d-sm-block">Notes</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#createNotes" role="tab" aria-selected="false">
                    <span class="d-none d-sm-block">Create Notes</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#settings1" role="tab" aria-selected="true">
                    <span class="d-none d-sm-block">File Upload</span>
                </a>
            </li>
        </ul>

        <div class="tab-content p-3 text-muted">

            <div class="tab-pane" id="activityLogs" role="tabpanel">
                <div class="scrollable">
                    @include('leads.appointed_leads.log-activity.activity-log', [
                        'generalInformation' => $generalInformation,
                    ])
                </div>
            </div>

            <div class="tab-pane" id="logNotes" role="tabpanel">
                <div class="scrollable">
                    <div>
                        @include('leads.appointed_leads.log-activity.notes-log', [
                            'generalInformation' => $generalInformation,
                        ])
                    </div>
                </div>
            </div>

            <div class="tab-pane" id="createNotes" role="tabpanel">
                @include('leads.appointed_leads.log-activity.create-notes', [
                    'generalInformation' => $generalInformation,
                ])
            </div>

        </div>
    </div>
</div>
