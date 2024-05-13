<style>
    .message-box {
        max-width: 70%;
        clear: both;
    }

    .message-box.sender {
        margin-left: auto;
        background-color: #DCF8C6;

        /* Green */
        color: black;
        border-radius: 10px 0px 10px 10px !important;
    }

    .message-box.receiver {
        background-color: #f1f1f1;
        color: black;
        padding: 10px;
        border-radius: 0px 10px 10px 10px !important;
    }

    .message-box.receiver.danger {
        background-color: #f8d7da;
        color: black;
        padding: 10px;
        border-radius: 0px 10px 10px 10px !important;
    }

    .message-timestamp {
        font-size: 0.8rem;
        text-align: right;
    }

    .message-info {
        font-size: 0.8rem;
        margin-top: 5px;
    }

    .sender-info {
        text-align: right;
    }

    .message-box.sender.danger {
        margin-left: auto;
        background-color: #f8d7da;
        color: black;
        border-radius: 10px 0px 10px 10px !important;

    }
</style>
<div class="row">
    <table id="requestToBind" class="table table-bordered dt-responsive nowrap requestToBind"
        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
        <thead class="" style="background-color: #f0f0f0;">
            <th>Company Name</th>
            <th>Product</th>
            <th>Quoted By</th>
            <th>Appointed By</th>
            <th>Status</th>
            <th>Action</th>
        </thead>
        <tbody>

        </tbody>
    </table>
</div>

@include('leads.appointed_leads.log-activity.note-modal')

<script>
    $(document).ready(function() {
        $('.requestToBind').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('get-broker-request-to-bind') }}",
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            },
            columns: [{
                    data: 'companyName',
                    name: 'companyName'
                },
                {
                    data: 'product',
                    name: 'product'
                },
                {
                    data: 'quotedBy',
                    name: 'quotedBy'
                },
                {
                    data: 'appointedBy',
                    name: 'appointedBy'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'action',
                    name: 'action'
                }
            ],
        });

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

        $(document).on('click', '.resendBindButton', function() {
            var id = $(this).attr('id');
            console.log(id);
        })

    });
</script>
