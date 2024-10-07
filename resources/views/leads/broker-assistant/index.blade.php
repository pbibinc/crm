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
                                    <a class="nav-link active" data-bs-toggle="tab" href="#products" role="tab">
                                        <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                        <span class="d-none d-sm-block">Pending</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#forFollowUp" role="tab">
                                        <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                        <span class="d-none d-sm-block">For Follow Up</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#makePayment" role="tab">
                                        <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                        <span class="d-none d-sm-block">Make A Payment </span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#binding" role="tab">
                                        <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                        <span class="d-none d-sm-block">Binding</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#handledProduct" role="tab">
                                        <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                        <span class="d-none d-sm-block">Handled Product</span>
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content p-3 text-muted">
                                <div class="tab-pane active" id="products" role="tabpanel">
                                    @include('leads.broker-assistant.pending-product-view')
                                </div>
                                <div class="tab-pane" id="forFollowUp" role="tabpanel">
                                    @include('leads.broker-assistant.broker-product-view')
                                </div>
                                <div class="tab-pane" id="makePayment" role="tabpanel">
                                    @include('leads.broker-assistant.make-payment-list-view')
                                </div>
                                <div class="tab-pane" id="binding" role="tabpanel">
                                    @include('leads.broker-assistant.binding-product-view')
                                </div>
                                <div class="tab-pane" id="handledProduct" role="tabpanel">
                                    @include('leads.broker-assistant.handled-product-view')
                                </div>
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

            // $(document).on('click', '.processButton', function(e) {
            //     e.preventDefault();
            //     $.ajax({
            //         url: "{{ route('general-notification.store') }}",
            //         data: {
            //             'userToNotify': response
            //                 .data.broker_quotation
            //                 .user_profile_id,
            //             'title': 'Broker Approve Quotation',
            //             'description': 'Broker has approved the quotation',
            //             'link': `quoatation/broker-profile-view/${response.data.id}`,
            //             'leadId': leadId,


            //         }
            //     }).then((result) => {
            //         if (result.isConfirmed) {
            //             Swal.fire({
            //                 title: 'Success',
            //                 text: 'has been saved',
            //                 icon: 'success'
            //             }).then((result) => {
            //                 if (result.isConfirmed) {
            //                     location.reload();
            //                 }
            //             });
            //         }
            //     });
            // })

            $(document).on('click', '.processButton', function(e) {
                var id = $(this).attr('id');
                var leadId = $(this).data('lead-id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to process this Quotation?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('change-quotation-status') }}",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                    'content')
                            },
                            method: "POST",
                            data: {
                                id: id,
                                status: 3,
                            },
                            success: function(response) {
                                console.log(response);
                                $.ajax({
                                    url: "{{ route('general-notification.store') }}",
                                    headers: {
                                        'X-CSRF-TOKEN': $(
                                            'meta[name="csrf-token"]').attr(
                                            'content')
                                    },
                                    method: "POST",
                                    data: {
                                        'userToNotify': response
                                            .data.broker_quotation
                                            .user_profile_id,
                                        'title': 'Broker Approve Quotation',
                                        'link': `quoatation/broker-profile-view/${response.data.id}`,
                                        'description': 'Breaker has approved the quotation',
                                        'leadId': leadId,
                                    },
                                    success: function() {
                                        Swal.fire({
                                            title: 'Success',
                                            text: 'has been saved',
                                            icon: 'success'
                                        }).then((result) => {
                                            if (result
                                                .isConfirmed) {
                                                location.reload();
                                            }
                                        });
                                    }
                                })

                            },
                            error: function() {
                                Swal.fire({
                                    title: 'Error',
                                    text: 'Something went wrong',
                                    icon: 'error'
                                });
                            }
                        })
                    }
                });
            });

        });
    </script>
@endsection
