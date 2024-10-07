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
                                {{-- <li class="nav-item">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#products" role="tab">
                                        <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                        <span class="d-none d-sm-block">Products</span>
                                    </a>
                                </li> --}}
                                <li class="nav-item">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#requestForApproval"
                                        role="tab">
                                        <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                        <span class="d-none d-sm-block">For Broker Approval</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#followup" role="tab">
                                        <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                        <span class="d-none d-sm-block">For Follow Up</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#makePayment" role="tab">
                                        <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                        <span class="d-none d-sm-block">Make A Payment</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#requestToBind" role="tab">
                                        <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                        <span class="d-none d-sm-block">Request To Bind</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#recentBoundProduct" role="tab">
                                        <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                        <span class="d-none d-sm-block">Recent Bound Product</span>
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content p-3 text-muted">
                                <div class="tab-pane" id="products" role="tabpanel">
                                    @include('leads.broker_leads.pending-product-view')
                                </div>
                                <div class="tab-pane active" id="requestForApproval" role="tabpanel">
                                    @include('leads.broker_leads.compliance-product-view')
                                </div>
                                <div class="tab-pane" id="followup" role="tabpanel">
                                    @include('leads.broker_leads.for-follow-up-product-view')
                                </div>
                                <div class="tab-pane" id="makePayment" role="tabpanel">
                                    @include('leads.broker_leads.make-a-payment-list-view', [
                                        'complianceOfficer' => $complianceOfficer,
                                    ])
                                </div>
                                <div class="tab-pane" id="requestToBind" role="tabpanel">
                                    @include('leads.broker_leads.request-to-bind-product-view')
                                </div>
                                <div class="tab-pane" id="recentBoundProduct" role="tabpanel">
                                    @include('leads.broker_leads.recent-bound-list')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="resendRTBModal" tabindex="-1" aria-labelledby="addQuoteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="fileViewingModalTitle">File Upload</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" class="dropzone mt-4 border-dashed" id="resendRTBDropzoneBroker"
                        enctype="multipart/form-data">
                    </form>
                    <input type="hidden" id="mediaIds" value="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="changeStatusButton" class="btn btn-success">Resend</button>
                </div>
            </div>
        </div>
    </div>

    @include('leads.appointed_leads.log-activity.note-modal')
    <script>
        $(document).ready(function() {
            Dropzone.autoDiscover = false;
            var myBrokerDropzone;
            var dropzoneElement = document.querySelector("#resendRTBDropzoneBroker");
            if (dropzoneElement) {
                myBrokerDropzone = new Dropzone("#resendRTBDropzoneBroker", {
                    url: "{{ route('upload-file-binding-docs') }}",
                    method: "post",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    autoProcessQueue: true,
                    clickable: true,
                    addRemoveLinks: true,
                    maxFiles: 10,
                    init: function() {
                        this.on("addedfile", function(file) {
                            file.previewElement.addEventListener("click", function() {
                                var url = "{{ env('APP_FORM_LINK') }}";
                                var fileUrl = url + file.url;
                                Swal.fire({
                                    title: 'File Options',
                                    text: 'Choose an action for the file',
                                    showDenyButton: true,
                                    confirmButtonText: `Download`,
                                    denyButtonText: `View`,
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        var downloadLink = document
                                            .createElement("a");
                                        downloadLink.href = fileUrl;
                                        downloadLink.download = file.name;
                                        document.body.appendChild(downloadLink);
                                        downloadLink.click();
                                        document.body.removeChild(downloadLink);
                                    } else if (result.isDenied) {
                                        window.open(fileUrl, '_blank');
                                    }
                                });
                            });
                        });
                        this.on('sending', function(file, xhr, formData) {
                            formData.append('hiddenId', $('#mediaIds').val());
                        });
                        this.on('removedfile', function(file) {
                            $.ajax({
                                url: "{{ route('delete-binding-docs') }}",
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                        'content')
                                },
                                method: "POST",
                                data: {
                                    id: file.id
                                },
                                success: function() {
                                    // Optional: Handle success
                                },
                                error: function() {
                                    Swal.fire({
                                        title: 'Error',
                                        text: 'Something went wrong',
                                        icon: 'error'
                                    });
                                }
                            });
                        });
                    }
                });
            } else {
                console.error("Dropzone element not found");
            }

            function addExistingFiles(files) {
                files.forEach(file => {
                    var mockFile = {
                        id: file.id,
                        name: file.basename,
                        size: parseInt(file.size),
                        type: file.type,
                        status: Dropzone.ADDED,
                        url: file.filepath // URL to the file's location
                    };
                    myBrokerDropzone.emit("addedfile", mockFile);
                    // myBrokerDropzone.emit("thumbnail", mockFile, file.filepath); // If you have thumbnails
                    myBrokerDropzone.emit("complete", mockFile);
                });
            };

            $('#assignPendingLeadsTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('get-pending-product') }}"
                },
                columns: [{
                        data: 'product',
                        name: 'product'
                    },
                    {
                        data: 'company_name',
                        name: 'company_name'
                    },
                    {
                        data: 'sent_out_date',
                        name: 'sent_out_date'
                    },
                    {
                        data: 'statusColor',
                        name: 'statusColor'
                    },
                    {
                        data: 'viewButton',
                        name: 'viewButton'
                    }
                ],
                order: [
                    [2, 'desc']
                ],
                // language: {
                //     emptyTable: "No data available in the table"
                // },
                // initComplete: function(settings, json) {
                //     if (json.recordsTotal === 0) {
                //         // Handle the case when there's no data (e.g., show a message)
                //         console.log("No data available.");
                //     }
                // }
                // createdRow: function (row, data, dataIndex) {
                //     if (data.status == 3) {
                //       $(row).css({
                //         'background-color': '#fff1da',   // Soft background color for visibility
                //         'border': 'solid #e89a3d',   // Bold border for emphasis
                //         'border-radius': '5px'
                //       }); // Adjust the color as you see fit.
                //     }
                // },
            });

            $('.getConfimedProductTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('get-confirmed-product') }}"
                },
                columns: [{
                        data: 'product',
                        name: 'product'
                    },
                    {
                        data: 'company_name',
                        name: 'company_name'
                    },
                    {
                        data: 'viewButton',
                        name: 'viewButton'
                    }
                    // {data: 'status', name: 'status'},
                    // {data: 'sent_out_date', name: 'sent_out_date'},
                    // {data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                createdRow: function(row, data, dataIndex) {
                    var status = data.status;
                    if (status == 11) {
                        $(row).addClass('table-success');
                    } else if (status == 6 || status == 15) {
                        $(row).addClass('table-warning');
                    } else if (status == 13 || status == 14) {
                        $(row).addClass('table-danger');
                    }
                }
                // language: {
                //     emptyTable: "No data available in the table"
                // },
                // initComplete: function(settings, json) {
                //     if (json.recordsTotal === 0) {
                //         // Handle the case when there's no data (e.g., show a message)
                //         console.log("No data available.");
                //     }
                // }
            })

            $('#assignPendingLeadsTable').on('click', '.viewButton', function() {
                $id = $(this).attr('id');
                $.ajax({
                    url: "{{ route('quoted-product-profile') }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    method: "POST",
                    data: {
                        id: $id
                    },
                    success: function(data) {
                        window.location.href =
                            `{{ url('quoatation/broker-profile-view/${data.leadId}/${data.generalInformationId}/${data.productId}') }}`;
                    }
                })
            });

            $('.getConfimedProductTable').on('click', '.viewButton', function() {
                $id = $(this).attr('id');
                $.ajax({
                    url: "{{ route('quoted-product-profile') }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    method: "POST",
                    data: {
                        id: $id
                    },
                    success: function(data) {
                        window.location.href =
                            `{{ url('quoatation/broker-profile-view/${data.leadId}/${data.generalInformationId}/${data.productId}') }}`;
                    }
                })
            });

            $(document).on('click', '.resendBindButton', function() {
                var id = $(this).attr('id');
                $.ajax({
                    url: "{{ route('get-binding-docs') }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    method: "POST",
                    data: {
                        id: id
                    },
                    success: function(data) {
                        addExistingFiles(data);
                        $('#resendRTBModal').modal('show');
                    },
                    error: function() {
                        Swal.fire({
                            title: 'Error',
                            text: 'Something went wrong',
                            icon: 'error'
                        });
                    }
                });
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


        });
    </script>
@endsection
