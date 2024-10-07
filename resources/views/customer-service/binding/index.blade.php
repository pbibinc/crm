@extends('admin.admin_master')
@section('admin')
    <div class="page-content pt-6">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="card"
                            style="box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05); border-radius: 10px; overflow: hidden;">

                            <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#request-to-bind" role="tab">
                                        <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                        <span class="d-none d-sm-block">Request To Bind</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#incompleteBinding" role="tab">
                                        <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                        <span class="d-none d-sm-block">Incomplete Binding</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#binding" role="tab">
                                        <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                        <span class="d-none d-sm-block">Binding</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#bound" role="tab">
                                        <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                        <span class="d-none d-sm-block">Bound</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#policyList" role="tab">
                                        <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                        <span class="d-none d-sm-block">New Policies</span>
                                    </a>
                                </li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content p-3 text-muted">
                                <div class="tab-pane active" id="request-to-bind" role="tabpanel">
                                    @include('customer-service.binding.request-to-bind-view')
                                </div>
                                <div class="tab-pane" id="binding" role="tabpanel">
                                    @include('customer-service.binding.binding-view')
                                </div>
                                <div class="tab-pane" id="bound" role="tabpanel">
                                    <p class="mb-0">
                                        @include(
                                            'customer-service.bound.index',
                                            compact('carriers', 'markets'))
                                    </p>
                                </div>
                                <div class="tab-pane" id="incompleteBinding" role="incompleteBinding">
                                    <p class="mb-0">
                                        @include('customer-service.incomplete-binding.index')
                                    </p>
                                </div>
                                <div class="tab-pane" id="policyList" role="policyList">
                                    <p class="mb-0">
                                        @include('customer-service.policy.new-policy-list')
                                    </p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="row">

            </div>
            @include('customer-service.binding.view-binding-information')
        </div>
    </div>
    @include('leads.appointed_leads.log-activity.note-modal')
    <script>
        Dropzone.autoDiscover = false;
        var myDropzone;

        $('#declinedButton').on('click', function(e) {
            e.preventDefault();
            $('#declinedBindingModal').modal('show');
            $('#dataModal').modal('hide');
        })

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
    </script>
@endsection
