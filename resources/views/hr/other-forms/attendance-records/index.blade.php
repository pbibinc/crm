@extends('admin.admin_master')
@section('admin')

<div class="page-content">

    <style>
        #preloader-row .custom-loader {
            /* Start Center Items on Table */
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 10px;
            /* End Center Items on Table */
            width:50px;
            height:12px;
            background: 
                radial-gradient(circle closest-side,#0170A8 90%,#0000) 0%   50%,
                radial-gradient(circle closest-side,#0170A8 90%,#0000) 50%  50%,
                radial-gradient(circle closest-side,#0170A8 90%,#0000) 100% 50%;
            background-size:calc(100%/3) 100%;
            background-repeat: no-repeat;
            animation:d7 1s infinite linear;
        }
        @keyframes d7 {
            33%{background-size:calc(100%/3) 0%  ,calc(100%/3) 100%,calc(100%/3) 100%}
            50%{background-size:calc(100%/3) 100%,calc(100%/3) 0%  ,calc(100%/3) 100%}
            66%{background-size:calc(100%/3) 100%,calc(100%/3) 100%,calc(100%/3) 0%  }
        }
    </style>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">
                            Attendance Records
                            <i class="ri ri-information-fill" style="font-size: 1.5em;" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Note: Current records displayed is for current month."></i>
                        </h4>
                        {{-- <p class="card-title-desc">This is the lists of all user's attendance records, You can also filter all the datas and export the record as PDF or Excel.</p> --}}
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Select User</label>
                            <div class="col-sm-10">
                                <select class="form-select" id="userFilter" aria-label="attendance-filter-users">
                                    <option class="text-muted" value="0" selected>Choose a user</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->user_id }}">{{ $user->firstname . ' ' . $user->lastname }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Select Login Type</label>
                            <div class="col-sm-10">
                                <select class="form-select" id="loginFilter" aria-label="attendance-filter-login">
                                    <option class="text-muted" value="0" selected>Choose a login type</option>
                                    @foreach ($loginTypes as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="example-date-input" class="col-sm-2 col-form-label">Date</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="date" value="{!! $filterDateDefaultValue !!}" id="filterDate">
                            </div>
                        </div>
                        <table id="state-saving-datatable" class="table activate-select dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Name</th>
                                    <th>Shift</th>
                                    <th>Login Type</th>
                                    <th>Log In</th>
                                    <th>Log Out</th>
                                </tr>
                            </thead>
                            <tbody>
                                <div id="preloader-row" style="display:none;">
                                    <div class="custom-loader" style="display: inline-block;"></div>
                                </div>
                                @foreach ($attendanceFootprintsDisplay as $footprints)
                                <tr>
                                    <td>{!! $footprints->formatted_created_at !!}</td>
                                    <td>{!! $footprints->formatted_fullname !!}</td>
                                    <td>No data yet.</td>
                                    <td>{!! $footprints->formatted_logintype !!}</td>
                                    <td>{!! $footprints->formatted_login !!}</td>
                                    <td>{!! $footprints->formatted_logout !!}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> <!-- end col -->
        </div> 
    </div>
</div>
<!-- End Page-content -->

<script>

    // Initialize your variables.
    let userFilter, loginFilter, filterDate;

    // Listen to the change events.
    $("#userFilter").change(function() {
        userFilter = $(this).val();
        runAjaxCall();
    });

    $("#loginFilter").change(function() {
        loginFilter = $(this).val();
        runAjaxCall();
    });

    $("#filterDate").change(function() {
        filterDate = $(this).val();
        runAjaxCall();
    });

    // Function to run the AJAX call.
    function runAjaxCall() {
        let data = {};

        if (userFilter && userFilter !== "0") {
            data.userFilter = userFilter;
        }

        if (loginFilter && loginFilter !== "0") {
            data.loginFilter = loginFilter;
        }

        if (filterDate) {
            data.filterDate = filterDate;
        }

        // The AJAX call.
        $.ajax({
            url: "{{ route('hrforms.attendance-records-filter') }}",
            type: "GET",
            data: data,
            beforeSend: function () {
                $('#preloader-row').show();
            },
            success: function (response) {
                // Destroy current Datatable
                if ($.fn.dataTable.isDataTable('#state-saving-datatable')) {
                    $('#state-saving-datatable').DataTable().clear().destroy();
                }

                // Reinitialize the datatable with new data
                $('#state-saving-datatable').DataTable({
                    data: response.results,
                    columns: [
                        { data: 'formatted_created_at', name: 'formatted_created_at' },
                        { data: 'formatted_fullname', name: 'formatted_fname' },
                        { data: 'shift', name: 'shift', defaultContent: 'No data yet.' },
                        { data: 'formatted_logintype', name: 'formatted_logintype' },
                        { data: 'formatted_login', name: 'formatted_login' },
                        { data: 'formatted_logout', name: 'formatted_logout' }
                    ],
                    // searching: false
                });
            },
            complete: function () {
                $('#preloader-row').hide();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR.status);
                console.log('Error: ' + textStatus + ' - ' + errorThrown);
            },
        });
    }
</script>

@endsection