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
                <div class="col-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h4 class="card-title mb-4">DNC List</h4>
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
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h4 class="card-title mb-4">Request for DNC List</h4>
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

            <div class="modal fade" id="importLeadModal" tabindex="-1" aria-labelledby="importLeadModal"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="importLeadModalLabel">EXPORT LEADS</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('dnc.lead.import') }}" id="exportDataModalForm">
                                @csrf
                                <input type="file" class="form-control" id="dnc-file" name="dnc-file">

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary " data-bs-dismiss="modal">Close</button>
                            <input type="submit" name="action_button" id="action_button" value="Import"
                                class="btn btn-primary ladda-button" data-style="expand-right">
                        </div>
                        </form>
                    </div>
                </div>
            </div>

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
                })
                $('#exportDataModalForm').on('submit', function() {
                    var button = $('#action_button');
                    var laddaButton = Ladda.create(button[0]);
                    laddaButton.start();
                    var checkDownloadToken = setInterval(() => {
                        $.ajax({
                            url: '/check-export',
                            method: 'GET',
                            success: function(response) {
                                console.log(response);
                                if (!response.exportToken) {
                                    clearInterval(checkDownloadToken);
                                    laddaButton.stop();
                                    $('#exportLeadModal').modal('hide');
                                }
                            },
                            error: function() {
                                // Handle error
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
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: "leads/" + dncLeadsId.join(',') + "/delete",
                        success: function(response) {
                            Swal.fire({
                                title: 'Success',
                                text: 'the leads sucessfully delete',
                                icon: 'success'
                            }).then(function() {
                                $('#deleteLeadModal').modal('hide');
                                location.reload();
                            });
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

            })
        </script>
    @endsection
