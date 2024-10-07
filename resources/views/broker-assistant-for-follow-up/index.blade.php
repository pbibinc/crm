@extends('admin.admin_master')
@section('admin')
    <div class="page-content pt-6">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card"
                        style="box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05); border-radius: 10px; overflow: hidden;">
                        <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#warmLeads" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                    <span class="d-none d-sm-block">Warm Leads</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#oldLeads" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                    <span class="d-none d-sm-block">Old Leads</span>
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content p-3 text-muted">
                            <div class="tab-pane active" id="warmLeads" role="tabpanel">
                                @include('broker-assistant-for-follow-up.warm-product-table')
                            </div>
                            <div class="tab-pane" id="oldLeads" role="tabpanel">
                                @include('broker-assistant-for-follow-up.old-product-table')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('leads.appointed_leads.log-activity.note-modal')

    <script>
        $(document).ready(function() {
            $(document).on('click', '.viewNotedButton', function() {
                var id = $(this).attr('id');
                var url = `/note/${id}/get-lead-note`;
                var departmentIds = [2, 3];
                $.ajax({
                    url: url,
                    type: "get",
                    data: {
                        id: id
                    },
                    success: function(response) {
                        var html =
                            '<div class="scrollable" style="height: 500px; overflow-y: auto;">';
                        var notes = Array.isArray(response.notes) ? response.notes : Array
                            .isArray(response) ? response : [];
                        notes.forEach(function(note) {
                            var noteClass = '';
                            if (note.status === 'declined-make-payment' || note
                                .status === 'Declined Binding') {
                                noteClass = 'danger';
                            } else if (note.status === 'yet-another-status') {
                                noteClass = 'yet-another-class';
                            }
                            var senderOrReceiverClass = (response.userProfileId == note
                                .user_profile_id) ? 'sender' : 'receiver';
                            var userInfo = (response.userProfileId == note
                                    .user_profile_id) ?
                                'sender-info' : '';
                            var marginLeft = (response.userProfileId != note
                                    .user_profile_id) ?
                                'style="margin-left: 10px"' : '';

                            html += `<div class="message-box ${senderOrReceiverClass} p-3 rounded ${noteClass}">
                        <div><strong>${note.title}</strong></div>
                        <div class="message-content">${note.description}</div>
                    </div>
                    <div class="message-info ${userInfo}" ${marginLeft}>
                        <p class="note-date font-2 text-muted">sent by: ${note.user_profile.american_name} ${new Date(note.created_at).toLocaleDateString('en-US', { month: 'short', day: '2-digit', year: 'numeric' })}</p>
                    </div>`;
                        });
                        $('#notesContainer').html(html);
                        $('#departmentIds').val(JSON.stringify(departmentIds));
                        $('#leadId').val(id);
                        $('#notesModal').modal('show');
                    }
                });
            });
        });
    </script>
@endsection
