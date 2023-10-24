@extends('admin.admin_master')
@section('admin')
    <style>
        .button-container {
            display: flex;
            justify-content: space-between;
        }
    </style>
    <div class="page-content pt-6">
        <div class="container-fluid">
            <div class="row">
                <div class="col-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <div class="card bg-info text-white-50">
                                        <div class="card-body">
                                            <div class="d-flex">
                                                <div class="flex-grow-1">
                                                    <p class="text-truncate font-size-14 mb-2" style="color:white">Assign
                                                        Lead</p>
                                                    <h4 class="mb-2" style="color:white">{{ $assignLeadsCount }}</h4>
                                                    <p class="text-muted mb-0"><span
                                                            class="{{ $assignData['textClass'] }} fw-bold font-size-12 me-2"><i
                                                                class="{{ $assignData['arrowClass'] }} me-1 align-middle"></i>{{ $assignData['unassignedPercentage'] }}%</span><span
                                                            style="color: white;">{{ $assignData['message'] }}</span></p>
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
                                            <div class="d-flex">
                                                <div class="flex-grow-1">
                                                    <p class="text-truncate font-size-14 mb-2">New Leads</p>
                                                    <h4 class="mb-2" style="color:#ffc107;">{{ $newLeadsCount }}</h4>
                                                    <p class="text-muted mb-0"><span
                                                            class="text-success fw-bold font-size-12 me-2"><i
                                                                class="mdi mdi-account-hard-hat me-3"></i>9.23%</span>from
                                                        previous period</p>
                                                </div>
                                                <div class="avatar-sm">
                                                    <i class="mdi mdi-account-hard-hat font-size-24 "
                                                        style="color: #ffc107;"></i>
                                                    {{-- <i class="ri-shopping-cart-2-line font-size-24"></i>   --}}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-3">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('leads.import') }}" method="POST" id="import-form"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="file" name="file" class="form-control">
                                <br>
                                <div class="row">
                                    <div class="col-7">
                                        <button id="import-button" class="btn btn-primary"><i class="ri-upload-fill"></i>
                                            Import Leads Data</button>
                                    </div>
                                    <div class="col-5">
                                        {{-- <a href="" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addLeadsModal" id="create_record">
                                            <i class="mdi mdi-domain-plus"></i>
                                            ADD LEADS
                                        </a> --}}
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-3">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('leads.export') }}" method="get">
                                @csrf
                                <div class="row">
                                    <div class="col-6">
                                        <label for="startDateInput" class="col-form-label">Start Date</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="date" value="2020-03" name="start_date"
                                                id="startDateInput">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <label for="endDateInput" class="col-form-label">End Date</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="date" value="2020-03" name="end_date"
                                                id="endDateInput">
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <button id="dated-export-button" class="btn btn-success"> <i class="ri-download-fill"></i>
                                    Export Leads</button>

                                <br>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-8">
                    {{-- <span style="font-weight:1000; font-size:16px; margin-top:20px;">
                        Leads Master List <i class="mdi mdi-database"></i>
                    </span>  --}}
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span style="font-weight:1000; font-size:16px;">
                            Leads Master List <i class="mdi mdi-database"></i>
                        </span>
                        <a href="" style="font-size:15px; color: #0f9cf3; font-weight:500" data-bs-toggle="modal"
                            data-bs-target="#addLeadsModal" id="create_record"><i class="mdi mdi-plus"></i> Add Lead</a>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div>
                                <table class="table table-bordered yajra-datatable dt-responsive nowrap dataTable"
                                    id="dataTable" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Company Name</th>
                                            <th>Tel Number</th>
                                            <th>State abbr</th>
                                            <th>Class Code</th>
                                            <th>Website Originated</th>
                                            {{-- <th>Status</th> --}}
                                            <th>Imported at</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-4">

                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span style="font-weight:1000; font-size:16px;">
                            Do Not Call Uploading <i class="mdi mdi-headset-off"></i>
                        </span>
                        <a href="{{ route('leads.archive') }}"
                            style="font-size:15px; color: #0f9cf3; font-weight:500 margin-top:20px;"><i
                                class="mdi mdi-archive-arrow-down"></i> Leads Archive</a>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <form action="{{ route('dnc.lead.import') }}" method="POST" id="dnc-import-form"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <input type="file" name="dnc-file" class="form-control">
                                    <br>
                                    <div class="row">
                                        <div class="button-container">
                                            <button type="submit" class="btn btn-danger"><i
                                                    class="mdi mdi-alert-plus"></i> Import DNC Leads</button>
                                            <button class="btn btn-danger" id="addDnc"><i
                                                    class="mdi mdi-phone-off"></i> Add DNC</button>
                                            <button class="btn btn-danger" id="deleteLeads"><i
                                                    class="mdi mdi-trash-can-outline"></i>Delete Lead</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <br>
                            <div class="row">
                                <table class="table table-bordered dt-responsive nowrap" id="dncDataTable"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Company Name</th>
                                            <th>Tel Number</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteLeadModal" tabindex="-1" aria-labelledby="deleteLeadModal" aria-hidden="true">
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
                            <label for="name" class="form-label">Tel Num</label>
                            <input type="text" class="form-control" id="telNum" name="telNum"
                                data-parsley-length="[10,10]" data-parsley-pattern="^[0-9]*$" placeholder="Min 10 chars."
                                autocomplete="off" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-danger" id="submitDncButton">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addLeadsModal" tabindex="-1" aria-labelledby="addLeadsModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addLeadsModalLabel">Add Lead</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="leadsForm">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Company Name</label>
                            <input type="text" class="form-control" id="companyName" name="companyName"
                                autocomplete="off" required>
                        </div>

                        <div class="mb-3">
                            <label for="name" class="form-label">Tel Num</label>
                            <input type="text" class="form-control" id="telNum" name="telNum"
                                data-parsley-length="[10,10]" data-parsley-pattern="^[0-9]*$" placeholder="Min 10 chars."
                                autocomplete="off" required>
                        </div>

                        <div class="mb-3">
                            <label for="name" class="form-label">Class Code</label>
                            <select name="classCodeLead" id="classCodeLeadDropdown" class="form-control">
                                <option value="">Select Class Code</option>
                                <option value="">ALL</option>
                                @foreach ($classCodeLeads as $classCodeLead)
                                    <option value="{{ $classCodeLead->name }}">{{ $classCodeLead->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="name" class="form-label">Leads Type</label>
                            <select name="leadTypeDropdown" id="leadTypeDropdown" class="form-control">
                                <option value="">Select Lead Class</option>
                                <option value="">ALL</option>
                                <option value="2">Prime</option>
                                <option value="1">Normal</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="name" class="form-label">State Abbreviation</label>
                            <input type="text" class="form-control" id="stateAbbreviation" name="stateAbbreviation"
                                data-parsley-length="[2, 2]" autocomplete="off" required>
                        </div>

                        <div class="mb-3">
                            <label for="name" class="form-label">Website Originated</label>
                            <input type="text" class="form-control" id="websiteOriginated" name="websiteOriginated"
                                autocomplete="off" required>
                        </div>

                        <input type="hidden" name="action" id="action" value="add">
                        <input type="hidden" name="hidden_id" id="hidden_id" />

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <input type="submit" name="action_button" id="action_button" value="Add"
                        class="btn btn-primary">
                </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // DATA TABLE
        $(document).ready(function() {
            $('.select2').select2();
            $('.yajra-datatable').DataTable({
                paging: true,
                deferRender: true,
                processing: true,
                serverSide: true,
                ajax: "{{ route('leads') }}",
                columns: [{
                        data: 'company_name',
                        name: 'company_name'
                    },
                    {
                        data: 'tel_num',
                        name: 'tel_num'
                    },
                    {
                        data: 'state_abbr',
                        name: 'state_abbr'
                    },
                    {
                        data: 'class_code',
                        name: 'class_code'
                    },
                    {
                        data: 'website_originated',
                        name: 'website_originated'
                    },
                    // {
                    //     data: 'status',
                    //     name: 'status',
                    //     render: function (data, type, row) {
                    //         switch (data){
                    //             case 1: return 'New Leads';
                    //             case 2:
                    //                 // console.log(row);
                    //                 if(row.user_profile){
                    //                     let firstProfile = row.user_profile[0];
                    //                     if(firstProfile.firstname){
                    //                         let firstName = firstProfile.firstname;
                    //                         return 'Assign to' + ' ' + firstName + ' ' + firstProfile.american_surname;
                    //                     }
                    //                 }
                    //                 else{
                    //                     return 'Not Assigned';
                    //                 }
                    //             case 3: return ''
                    //         }
                    //     }
                    // },
                    {
                        data: 'created_at_formatted',
                        name: 'created_at',
                        searchable: false
                    },
                    // {data: 'updated_at_formatted', name: 'updated_at', searchable:false},
                    // {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });

            $('#dncDataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('leads.dnc') }}",
                columns: [{
                        data: 'checkbox',
                        name: 'checkbox',
                        orderable: false,
                        searchable: false,
                        title: '<input type="checkbox" id="check_all">'
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

            $('#addDnc').on('click', function(e) {
                e.preventDefault()
                $('#addDncModal').modal('show');
            });

            $('#submitDncButton').on('click', function(e) {
                e.preventDefault()
                var telNum = $('#telNum').val();
                $.ajax({
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ route('leads.add.dnc') }}",
                    data: {
                        telNum: telNum
                    },
                    success: function(response) {
                        if (response.hasLead) {
                            Swal.fire({
                                title: 'Success',
                                text: response.message,
                                icon: 'success'
                            }).then(function() {
                                $('#addDncModal').modal('hide');
                                $('#dncDataTable').DataTable().ajax.reload();

                            });
                        } else {
                            swal.fire({
                                title: 'Error',
                                text: response.message,
                                icon: 'error'
                            });
                        }
                    },
                    error: function(xhr) {
                        var errorMessage = 'An Error Occured';
                        if (xhr.responseJSON && xhr.responseJSON.error) {
                            errorMessage = xhr.responseJSON.error;
                        }
                        Swal.fire({
                            title: 'Error',
                            text: 'Encounterd some error',
                            icon: 'error'
                        });
                    }
                });
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

            $('#leadsForm').parsley();
            $('#leadsForm').on('submit', function(e) {
                e.preventDefault();
                if ($('#leadsForm').parsley().isValid()) {
                    $.ajax({
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: "{{ route('leads.store') }}",
                        data: $(this).serialize(),
                        success: function(response) {
                            Swal.fire({
                                title: 'Success',
                                text: response.success,
                                icon: 'success'
                            }).then(function() {
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
                } else {
                    console.log('Form is not valid');
                }

            });

            $('#import-button').click(function(event) {
                var fileInput = $('input[type="file"]');
                if (fileInput.get(0).files.length === 0) {
                    event.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'Oppss',
                        text: 'please selecta a file to import!!',
                    });
                }
            });

            $('#check_all').on('click', function(e) {
                $('.leads_checkbox').prop('checked', $(this).is(':checked'));
                e.stopPropagation();
            });
        });

        // $(document).ready(function() {
        //     $("#import-form").on("submit", function(e) {
        //         e.preventDefault();

        //         // Get form data
        //         var formData = new FormData(this);

        //         $.ajax({
        //             url: "{{ route('leads.import') }}",
        //             type: "POST",
        //             data: formData,
        //             contentType: false,
        //             processData: false,
        //             beforeSend: function() {
        //                 // Show preloader
        //                 $("#preloader").removeClass("d-none");

        //                 // Disable the button to prevent multiple submissions
        //                 $("#import").prop("disabled", true);
        //             },
        //             success: function(response) {
        //                 // Handle success
        //                 console.log(response);
        //             },
        //             error: function(xhr, status, error) {
        //                 // Handle error
        //                 console.error(xhr, status, error);
        //             },
        //             complete: function() {
        //                 // Hide preloader
        //                 $("#preloader").addClass("d-none");

        //                 // Enable the button
        //                 $("#import").prop("disabled", false);
        //             }
        //         });
        //     });
        // });
    </script>
@endsection
