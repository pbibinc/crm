@extends('admin.admin_master')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex">
                                                <div class="flex-grow-1">
                                                    <p class="text-truncate font-size-14 mb-2" style="color:17a2b8">Total
                                                        DNC
                                                        Count</p>
                                                    <h4 class="mb-2" style="color:17a2b8">{{ $dncLeadCount }}</h4>

                                                </div>
                                                <div class="avatar-sm">
                                                    <span class="avatar-title bg-light text-primary rounded-3">
                                                        <i class="mdi mdi-headset font-size-24" style="color: #17a2b8;"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="card">
                                        <div class="card-body">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="row">

                <div class="col-7">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span style="font-weight:1000; font-size:16px;">
                            Do Not Call Uploading <i class="mdi mdi-headset-off"></i>
                        </span>
                        <a href="" style="font-size:15px; color: #0f9cf3; font-weight:500" data-bs-toggle="modal"
                            data-bs-target="#addDncModal" id="create_dnc"><i class="mdi mdi-plus"></i> Add DNC</a>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h4 class="card-title mb-4"></h4>
                                <div>
                                    <button class="btn btn-success" id="create_record" data-bs-toggle="modal"
                                        data-bs-target="#exportLeadModal"><i class="ri-download-fill"></i>
                                        Export DNC</button>
                                    <button class="btn btn-primary" id="import-dnc-id" data-bs-toggle="modal"
                                        data-bs-target="#importLeadModal"><i class="ri-upload-fill"></i>
                                        Import DNC</button>
                                </div>
                            </div>
                            <table id="dataTable"class="table table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead class="table-light">
                                    <tr>
                                        <th>Company Name</th>
                                        <th>Telephone Number</th>
                                        <th>Date</th>
                                        <th></th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-5">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span style="font-weight:1000; font-size:16px;">
                            Request For DNC LIST <i class="mdi mdi-headset-off"></i>
                        </span>
                        <span>

                        </span>
                        <a href="{{ route('leads.archive') }}"
                            style="font-size:15px; color: #0f9cf3; font-weight:500 margin-top:20px;"><i
                                class="mdi mdi-archive-arrow-down"></i> Leads Archive</a>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h4 class="card-title mb-4"></h4>
                                <div>
                                    <button class="btn btn-danger" id="deleteLeads"><i
                                            class="mdi mdi-trash-can-outline"></i>
                                        Delete</button>
                                </div>
                            </div>
                            <table id="requestForDncTable"class="table table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Company Name</th>
                                        <th>Telephone Number</th>
                                    </tr>
                                </thead>

                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- export lead modal --}}
            <div class="modal fade" id="exportLeadModal" tabindex="-1" aria-labelledby="exportLeadModal"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exportLeadModalLabel">EXPORT LEADS</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('leads-dnc-export') }}" id="exportDataModalForm">
                                @csrf
                                <div class="mb-3">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="startDateInput" class="col-form-label">Start Date</label>
                                                <div class="col-sm-10">
                                                    <input class="form-control" type="date" value="2020-03"
                                                        name="start_date" id="startDateInput">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <label for="endDateInput" class="col-form-label">End Date</label>
                                                <div class="col-sm-10">
                                                    <input class="form-control" type="date" value="2020-03"
                                                        name="end_date" id="endDateInput">
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary " data-bs-dismiss="modal">Close</button>
                            <input type="submit" name="action_button" id="action_button" value="Export"
                                class="btn btn-primary ladda-button" data-style="expand-right">
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            {{-- import lead modal --}}
            <div class="modal fade" id="importLeadModal" tabindex="-1" aria-labelledby="importLeadModal"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="importLeadModalLabel">Import LEADS</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('dnc.lead.import') }}" id="importDataModalForm" method="POST">
                                @csrf
                                <input type="file" class="form-control" id="dnc-file" name="dnc-file">

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary " data-bs-dismiss="modal">Close</button>
                            <input type="submit" name="importButton" id="importButton" value="Import"
                                class="btn btn-primary ladda-button" data-style="expand-right">
                        </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- delete lead modal --}}
            <div class="modal fade" id="deleteLeadModal" tabindex="-1" aria-labelledby="deleteLeadModal"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Delete Leads</h5>
                        </div>
                        <div class="modal-body">
                            Are you Sure you want to delete
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button class="btn btn-danger" id="submitDeleteLeads">Submit</button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- add dnc modal --}}
            <div class="modal fade" id="addDncModal" tabindex="-1" aria-labelledby="addDncModal" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">
                                <b>Add DNC</b>
                            </h5>
                        </div>
                        <div class="modal-body">
                            <form action="dncLeadForm">
                                @csrf
                                <div class="mb-3">
                                    <div class="row mb-3">
                                        <label for="name" class="form-label">Company Name</label>
                                        <div>
                                            <input type="text" class="form-control" id="companyName"
                                                name="companyName" placeholder="Company Name" autocomplete="off"
                                                required>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <label for="name" class="form-label">Tel Num</label>
                                        <div>
                                            <input type="text" class="form-control" id="telNum" name="telNum"
                                                data-parsley-length="[10,10]" data-parsley-pattern="^[0-9]*$"
                                                placeholder="Min 10 chars." autocomplete="off" required>
                                            <input type="hidden" name="hiddenDncId" id="hiddenDncId">

                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button class="btn btn-success" id="submitDncButton" dnc-action-button='add'>Submit</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <script>
            $(document).ready(function() {
                $('#dataTable').DataTable({
                    processing: true,
                    serverSide: true,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    ajax: {
                        url: "{{ route('leads-dnc-view') }}",
                    },
                    columns: [{
                            data: 'company_name',
                            name: 'company_name'
                        },
                        {
                            data: 'tel_num',
                            name: 'tel_num'
                        },
                        {
                            data: 'formatted_created_at',
                            name: 'formatted_created_at'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        }
                    ]
                });

                $('#requestForDncTable').DataTable({
                    processing: true,
                    serverSide: true,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    ajax: {
                        url: "{{ route('leads-dnc-request-view') }}",
                    },
                    columns: [{
                            data: 'checkbox',
                            name: 'checkbox'
                        },
                        {
                            data: 'company_name',
                            name: 'company_name'
                        },
                        {
                            data: 'tel_num',
                            name: 'tel_num'
                        },
                    ]
                });

                $('#exportDataModalForm').on('submit', function() {
                    var button = $('#action_button');
                    var laddaButton = Ladda.create(button[0]);
                    laddaButton.start();
                    var checkDownloadToken = setInterval(() => {
                        $.ajax({
                            url: "{{ route('leads-dnc-export') }}",
                            method: 'GET',
                            data: {
                                start_date: $('#startDateInput').val(),
                                end_date: $('#endDateInput').val()
                            },
                            success: function(response) {
                                console.log(response);
                                if (!response.exportToken) {
                                    clearInterval(checkDownloadToken);
                                    laddaButton.stop();
                                    $('#exportLeadModal').modal('hide');
                                    location.reload();
                                }
                            },
                            error: function() {
                                alert('An error occurred while exporting leads');
                                clearInterval(checkDownloadToken);
                                laddaButton.stop();
                                $('#exportLeadModal').modal('hide');
                            },
                        });
                    }, 2000);

                });

                var dncLeadsId = []
                $('#deleteLeads').on('click', function(e) {
                    e.preventDefault();
                    $('.leads_checkbox').each(function() {
                        var id = $(this).val();

                        if ($(this).is(':checked')) {
                            dncLeadsId.push(id);
                        } else {
                            var index = dncLeadsId.indexOf(id);
                            if (index !== -1) {
                                dncLeadsId.splice(index, 1);
                            }
                        }
                    });
                    if (dncLeadsId.length == 0) {
                        Swal.fire({
                            title: 'Error',
                            text: 'Please Select Lead',
                            icon: 'error'
                        });
                    } else {
                        $('#deleteLeadModal').modal('show');
                    }

                });

                $('#submitDeleteLeads').on('click', function(e) {
                    e.preventDefault();
                    $.ajax({
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: "{{ route('store-request-for-dnc') }}",
                        data: {
                            dncLeadsId: dncLeadsId
                        },
                        success: function(response) {
                            // Swal.fire({
                            //     title: 'Success',
                            //     text: 'the leads sucessfully delete',
                            //     icon: 'success'
                            // }).then(function() {
                            //     $('#deleteLeadModal').modal('hide');
                            //     location.reload();
                            // });
                        },
                        error: function(xhr) {
                            var errorMessage = 'An Error Occured';
                            if (xhr.responseJSON && xhr.responseJSON.error) {
                                errorMessage = xhr.responseJSON.error;
                            }
                            Swal.fire({
                                title: 'Error',
                                text: errorMessage,
                                icon: 'error'
                            });
                        }
                    });
                });

                $('#importDataModalForm').on('submit', function(e) {
                    e.preventDefault();

                    var formData = new FormData(this);

                    $.ajax({
                        url: "{{ route('dnc.lead.import') }}",
                        type: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            // Swal.fire({
                            //     title: 'Success',
                            //     text: 'Leads imported successfully',
                            //     icon: 'success'
                            // }).then(function() {
                            //     $('#importLeadModal').modal('hide');
                            //     location.reload();
                            // });
                        },
                        error: function(xhr) {
                            Swal.fire({
                                title: 'Error',
                                text: 'An error occurred while importing leads',
                                icon: 'error'
                            });
                        }
                    });
                });

                $('#submitDncButton').on('click', function(e) {
                    e.preventDefault()
                    var telNum = $('#telNum').val();
                    var companyName = $('#companyName').val();
                    var action = $(this).attr('dnc-action-button');
                    var url = (action == 'edit') ? "{{ route('update-dnc') }}" :
                        "{{ route('leads.add.dnc') }}";
                    var data = {
                        telNum: telNum,
                        companyName: companyName
                    };
                    if (action == 'edit') {
                        data.id = $('#hiddenDncId').val();
                    }
                    $.ajax({
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: url,
                        data: data,
                        success: function(response) {
                            Swal.fire({
                                title: 'Success',
                                text: response.message,
                                icon: 'success'
                            }).then(function() {
                                $('#addDncModal').modal('hide');
                                setTimeout(function() {
                                    $('body').removeClass('modal-open');
                                    $('.modal-backdrop').remove();
                                    $('#dataTable').DataTable().ajax.reload();
                                }, 500); // Delay to ensure modal closes properly
                            });
                        },
                        error: function(xhr) {
                            Swal.fire({
                                title: 'Error',
                                text: 'Encountered some error',
                                icon: 'error'
                            });
                        }
                    });
                });

                $('#addDncModal').on('hidden.bs.modal', function() {
                    $('#companyName').val('');
                    $('#telNum').val('');
                    $('#hiddenDncId').val('');
                    $('#submitDncButton').attr('dnc-action-button', 'add');
                });

                $(document).on('click', '.btnEdit', function(e) {
                    e.preventDefault();
                    var id = $(this).data('id');
                    $.ajax({
                        type: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: `leads/dnc/${id}/edit`,
                        data: {
                            id: id
                        },
                        success: function(response) {
                            $('#companyName').val(response.data.company_name);
                            $('#telNum').val(response.data.tel_num);
                            $('#hiddenDncId').val(response.data.id);
                            $('#submitDncButton').attr('dnc-action-button', 'edit');
                            $('#addDncModal').modal('show');
                        },
                        error: function(xhr) {
                            Swal.fire({
                                title: 'Error',
                                text: 'Encounterd some error',
                                icon: 'error'
                            });
                        }
                    });

                });

                $(document).on('click', '.btnDelete', function(e) {
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            var id = $(this).data('id');
                            console.log(id);
                            $.ajax({
                                type: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                        'content')
                                },
                                url: `{{ route('delete-dnc') }}`,
                                data: {
                                    id: id
                                },
                                success: function(response) {
                                    Swal.fire({
                                        title: 'Success',
                                        text: response.message,
                                        icon: 'success'
                                    }).then(function() {
                                        $('#dataTable').DataTable().ajax
                                            .reload();
                                    });
                                },
                                error: function(xhr) {
                                    Swal.fire({
                                        title: 'Error',
                                        text: 'Encounterd some error',
                                        icon: 'error'
                                    });
                                }
                            });
                        }
                    });

                });

            });
        </script>
    @endsection
