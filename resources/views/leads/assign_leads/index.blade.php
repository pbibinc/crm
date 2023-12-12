@extends('admin.admin_master')
@section('admin')
    <div class="page-content pt-6">
        <div class="container-fluid">
            <div class="row">
                <div class="col-8">
                    <div class="row">
                        <div>
                            <div class="card"
                                style=" box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05); border-radius: 10px; overflow: hidden;">
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="timezoneDropdown" class="form-label">Time Zone</label>
                                                <select name="timezone" id="timezoneDropdown" class="form-control select2">
                                                    <option value="">Select a timezone</option>
                                                    <option value="">ALL</option>
                                                    @foreach ($timezones as $timezone => $identifier)
                                                        <option value="{{ $timezone }}">{{ $timezone }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="statesDropdown" class="form-label">States</label>
                                                <select name="states" id="statesDropdown" class="form-control select2">
                                                    <option value="">Select</option>
                                                    <option value="">All</option>
                                                    @foreach ($states as $abbr => $name)
                                                        <option value="{{ $abbr }}">{{ $name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="websiteOriginatedDropdown" class="form-label">Website
                                                    Originated</label>
                                                <select name="website_originated" id="websiteOriginatedDropdown"
                                                    class="form-control select2">
                                                    <option value="">Select a Website</option>
                                                    <option value="">ALL</option>
                                                    @foreach ($websitesOriginated as $site)
                                                        <option value="{{ $site }}">{{ $site }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="classCodeLeadDropdown" class="form-label">Class Code</label>
                                                <select name="classCodeLead" id="classCodeLeadDropdown"
                                                    class="form-control select2">
                                                    <option value="">Select Class Code</option>
                                                    <option value="">ALL</option>
                                                    @foreach ($classCodeLeads as $classCodeLead)
                                                        <option value="{{ $classCodeLead->name }}">
                                                            {{ $classCodeLead->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="leadTypeDropdown" class="form-label">Leads Type</label>
                                                <select name="lead_type" id="leadTypeDropdown" class="form-control select2">
                                                    <option value="">Select a Type</option>
                                                    <option value="">ALL</option>
                                                    <option value="2">Prime Lead</option>
                                                    <option value="1">Normal Lead</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="card"
                                style=" box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05); border-radius: 10px; overflow: hidden;">
                                <div class="card-body d-flex flex-column justify-content-between">
                                    <div class="row">
                                        <div class="col-6">
                                            <label for="leadsQuantityUser" class="form-label">Assign Lead Quantity</label>
                                            <div class="input-group mb-3">
                                                <input class="form-control" type="number" value="10"
                                                    id="leadsQuantityUser"
                                                    onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                                                <button type="button" id="assignRandomLeadsUser"
                                                    class="btn btn-outline-primary" data-bs-toggle="tooltip"
                                                    data-bs-placement="top"
                                                    title="Assign Random Leads to user based on the quantity input above">Assign
                                                    to User</button>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <label for="leadsQuantityRandom" class="form-label">Assign Random Leads To
                                                Apptaker
                                                Quantity </label>
                                            <div class="input-group">
                                                <input class="form-control" type="number" value="10"
                                                    id="leadsQuantityRandom"
                                                    onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                                                <button type="button" id="assignRandomLeads"
                                                    class="btn btn-outline-primary" data-bs-toggle="tooltip"
                                                    data-bs-placement="top"
                                                    title="Assign Random Leads to a random apptaker">Assign Random</button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="card"
                                style=" box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05); border-radius: 10px; overflow: hidden;">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-6">
                                            <button type="button" id="assignLead" class="btn btn-primary btn-lg mb-2"
                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="Assign checked Leads to a selected user">Assign Lead</button>
                                        </div>
                                        <div class="col-6">
                                            <button type="button" id="assignPremiumLead" class="btn btn-primary btn-lg"
                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="Assign premium leads">Assign Premium</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div>
                            <div class="card"
                                style=" box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05); border-radius: 10px; overflow: hidden;">
                                <div class="card-body">
                                    <div>
                                        <table class="table table-bordered dt-responsive nowrap" id="dataTable"
                                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <br>
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>Company Name</th>
                                                    {{-- <th>Tel Number</th> --}}
                                                    <th>State abbr</th>
                                                    <th>Class Code</th>
                                                    <th>Website Originated</th>
                                                    <th>Imported Date</th>

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

                <div class="col-4">
                    <div class="row">
                        <div class="card"
                            style=" box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05); border-radius: 10px; overflow: hidden;">
                            <div class="card-body">
                                <div class="row mb-2">
                                    <div class="col-6">
                                        <label class="form-label">App Taker</label>
                                        <div class="col-lg-12">
                                            <select class="form-control select2" id="userProfileDropdown">
                                                <option value="">select agents</option>
                                                @foreach ($userProfiles as $userProfile)
                                                    @php
                                                        $ratings = $userProfile->ratings;
                                                        $numberOfRatings = $ratings->count();
                                                        $sumOfRatings = $ratings->sum('rating');
                                                        $divisorRatings = $numberOfRatings * 5;
                                                        $overallRating = $numberOfRatings > 0 ? $sumOfRatings / $numberOfRatings : 0;
                                                        $overallRatingPercentage = $numberOfRatings > 0 ? ($sumOfRatings / $divisorRatings) * 100 : 0;
                                                        $leadsCounter = count(
                                                            $userProfile->leads->filter(function ($lead) {
                                                                return $lead->pivot->current_user_id !== 0;
                                                            }),
                                                        );
                                                    @endphp
                                                    <option value="{{ $userProfile->id }}">
                                                        {{ $userProfile->firstname . ' ' . $userProfile->american_surname }}
                                                        <small class="text-muted">({{ $overallRating }} star)
                                                            ({{ $leadsCounter }} leads)
                                                        </small>
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label">Accounts</label>
                                        <div class="col-lg-12">
                                            <select class="form-control select2" id="accountsDropdown">
                                                <option value="">select agents</option>
                                                @foreach ($accounts as $account)
                                                    @php
                                                        $accountLeadsCounter = count($account->leads);
                                                    @endphp
                                                    <option value="{{ $account->id }}">
                                                        {{ $account->firstname . ' ' . $account->american_surname }}<small
                                                            class="text-muted"> ({{ $accountLeadsCounter }} leads)</small>
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" id="voidAll"
                                    class="btn btn-outline-danger waves-effect waves-light" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Button to void all leads to account">Void ALL
                                    Leads</button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="card"
                            style=" box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05); border-radius: 10px; overflow: hidden;">

                            <div class="card-body">

                                <table id="datatableLeads" class="table table-bordered dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Company Name</th>
                                            <th>Tel Num</th>
                                            {{-- <th>State Abbr</th>
                                        <th>Website Originated</th> --}}
                                            <th>action</th>
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

    {{-- start of modal for redeploying of leads --}}
    <div class="modal fade" id="dataModal" tabindex="-1" aria-labelledby="dataModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><b>Redeploy Leads To other Agent</b></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <select class="form-control" id="userProfileRedeployDropdown">
                        <option value="">select agents</option>
                        @foreach ($accounts as $account)
                            <option value="{{ $account->id }}">
                                {{ $account->firstname . ' ' . $account->american_surname }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success ladda-button" data-style="expand-right"
                        data-toggle="tooltip" name="submit_button" id="submit_button">Submit</button>
                </div>

            </div>
        </div>
    </div>
    {{-- end of modal --}}

    {{-- start for assiging premium leads modal --}}
    <div class="modal fade" id="assigningPremiumLeadModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title"><b>Confirmation</b></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <p>Assiging Premium Leads Plss confirm.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success ladda-button" data-style="expand-right"
                        data-toggle="tooltip" name="okAssignPremiumButton" id="okAssignPremiumButton">Assign</button>
                </div>
            </div>
        </div>
    </div>
    {{-- end of modal --}}

    {{-- start for voiding leads to user modal --}}
    <div class="modal fade" id="confirmModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><b>Confirmation</b></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to void this leads?.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger ladda-button" data-style="expand-right"
                        data-toggle="tooltip" name="ok_button" id="ok_button">Void</button>
                </div>
            </div>
        </div>
    </div>
    {{-- end of modal --}}

    {{-- start of voiding all leads to a user --}}
    <div class="modal fade" id="confirmVoidAllModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><b>Confirmation</b></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to void all leads on this account?.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger ladda-button" data-style="expand-right"
                        data-toggle="tooltip" name="void_ok_button" id="void_ok_button">Void</button>
                </div>
            </div>
        </div>
    </div>
    {{-- end of deletion of modal --}}

    {{-- start of assigning random leads to user modal --}}
    <div class="modal fade" id="assignRandomLeadsToUser" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><b>Confirmation</b></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure?.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success ladda-button" data-style="expand-right"
                        data-toggle="tooltip" name="assign_ok_button" id="assign_ok_button">Assign</button>
                </div>
            </div>
        </div>
    </div>
    {{-- end of deletion of modal --}}

    {{-- start of assigning random leads to random user modal --}}
    <div class="modal fade" id="assignRandomLeadsToRandomUser" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><b>Confirmation</b></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure?.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success ladda-button" data-style="expand-right"
                        data-toggle="tooltip" name="assign_random_ok_button" id="assign_random_ok_button">Assign</button>
                </div>
            </div>
        </div>
    </div>

    {{-- end of deletion of modal --}}
    <script src="{{ asset('backend/assets/libs/bootstrap-rating/bootstrap-rating.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/pages/rating-init.js') }}"></script>
    {{--    <!-- Sweet Alerts js --> --}}
    {{--    <script src="{{asset('backend/assets/libs/sweetalert2/sweetalert2.min.js')}}"></script> --}}

    {{-- <!-- Sweet alert init js--> --}}
    {{-- <script src="{{asset('backend/assets/js/pages/sweet-alerts.init.js')}}"></script> --}}
    <script>
        // DATA TABLE
        $(document).ready(function() {
            $('.select2').select2();
            $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                searching: true,
                // scrollY: 500,
                // scrollX: true,
                ajax: {
                    url: "{{ route('assign') }}",
                    data: function(d) {
                        d.website_originated = $('#websiteOriginatedDropdown').val(),
                            d.timezone = $('#timezoneDropdown').val(),
                            d.states = $('#statesDropdown').val(),
                            d.classCodeLead = $('#classCodeLeadDropdown').val(),
                            // d.userProfile = $('#userProfileDropdown').val(),
                            // d.search = $('input[type="search"]').val(),
                            d.leadType = $('#leadTypeDropdown').val(),
                            d.appTakerId = $('#userProfileDropdown').val(),
                            d.accountsId = $('#accountsDropdown').val()
                    }
                },
                columns: [{
                        data: 'checkbox',
                        name: 'checkbox',
                        orderable: false,
                        searchable: false,
                        title: '<input type="checkbox" id="check_all">'
                    },
                    {
                        data: 'company_name',
                        name: 'company_name',
                        render: function(data, type, row) {
                            if (row.prime_lead == 2) {
                                return '<div class="d-flex justify-content-between">' + data +
                                    '<i class="far fa-gem"></i></div>'
                            } else {
                                return data;
                            }
                        }
                    },
                    // {
                    //     data: 'tel_num',
                    //     name: 'tel_num'
                    // },
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
                    {
                        data: 'created_at_formatted',
                        name: 'created_at',
                        searchable: false
                    },
                ]
            });

            $(document).on('click', '#check_all', function(e) {
                $('.users_checkbox').prop('checked', $(this).is(':checked'));
                e.stopPropagation();
            });

            // script for display leads that user have
            $('#datatableLeads').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('getDataTableLeads') }}",
                    data: function(f) {
                        f.userProfile = $('#userProfileDropdown').val()
                        f.accountProfileValue = $('#accountsDropdown').val()
                    }
                },
                columns: [
                    // {data: 'checkbox', name: 'checkbox',  searchable: false},
                    // {data: 'id', name: 'id'},
                    {
                        data: 'company_name',
                        name: 'company_name'
                    },
                    {
                        data: 'tel_num',
                        name: 'tel_num'
                    },
                    // {data: 'state_abbr', name: 'state_abbr'},
                    // {data: 'website_originated', name: 'website_originated'},
                    // {data: 'created_at_formatted', name: 'created_at', searchable:false},
                    // {data: 'updated_at_formatted', name: 'updated_at', searchable:false},
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            // scripts for reloading and configuring the dropdowns filters
            $('#websiteOriginatedDropdown').on('change', function() {
                $('#dataTable').DataTable().ajax.reload();
            });

            //lead drop down configuration mainly use for filter
            $('#leadTypeDropdown').on('change', function() {
                $('#dataTable').DataTable().ajax.reload();
            });

            //states drop down configuration mainly use for filter
            $('#statesDropdown').on('change', function() {
                var states = $(this).val();
                $('#dataTable').DataTable().ajax.url("{{ route('assign') }}?states=" + states).load();
            });

            //time zone drop down configuration mainly use for filter
            $('#timezoneDropdown').on('change', function() {
                var timezone = $(this).val();
                $('#dataTable').DataTable().ajax.url("{{ route('assign') }}?timezone=" + timezone).load();
            });

            //class code drop down configuration mainly use for filter
            $('#classCodeLeadDropdown').on('change', function() {
                var classCodeLead = $(this).val();
                $('#dataTable').DataTable().ajax.url("{{ route('assign') }}?classCodeLead=" +
                    classCodeLead).load();
            });



            //event for assigning premium leads
            var leadsId = [];
            $('#assignPremiumLead').on('click', function() {
                $('.users_checkbox:checked').each(function() {
                    leadsId.push($(this).val());
                });

                if (leadsId.length === 0) {
                    Swal.fire({
                        title: 'Error',
                        text: 'Please Select Lead',
                        icon: 'error'
                    });
                } else {
                    $('#assigningPremiumLeadModal').modal('show');
                }
            });

            $('#okAssignPremiumButton').on('click', function() {
                var laddaButton = Ladda.create($(this)[0]);
                laddaButton.start();
                $.ajax({
                    url: "{{ route('assign-premium-leads') }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: "json",
                    method: "POST",
                    data: {
                        leadsId: leadsId
                    },
                    success: function(response) {
                        // Handle the response from the server
                        console.log(response);
                        if (response.success) {
                            laddaButton.stop();
                            // Display a success message
                            Swal.fire({
                                title: 'Success',
                                text: 'Leads assigned successfully.',
                                icon: 'success'
                            }).then(function() {
                                location.reload();
                            });
                        } else {
                            // Display an error message
                            Swal.fire({
                                title: 'Error',
                                text: 'Failed to assign leads.',
                                icon: 'error'
                            });
                        }
                    }
                })

            });

            //hiding some content for event to be show
            $("#voidAll").hide()
            $('#selectStatesLabel').hide();
            $('#userStatesDropdown').next('.select2-container').hide();

            //Apptaker Dropdown Configuration
            $('#userProfileDropdown').on('change', function() {
                $('#datatableLeads').DataTable().ajax.reload();
                // $('#dataTable').DataTable().ajax.reload();
                let userProfileValue = $(this).val();
                if (userProfileValue != "") {
                    $.ajax({
                        url: "{{ route('get-states') }}",
                        type: 'GET',
                        data: {
                            userProfileValue: userProfileValue
                        },
                        success: function(data) {
                            var stateSelect = $('#userStatesDropdown');
                            stateSelect.empty();
                            stateSelect.append('<option value="">Select States</option>');
                            stateSelect.append('<option value="">ALL</option>');
                            $.each(data, function(key, value) {
                                stateSelect.append('<option value="' + key + '">' +
                                    value + '</option>')
                            });
                        }
                    });
                    $('#voidAll').show();
                    $('#userStatesDropdown').next('.select2-container').show();
                    $('#selectStatesLabel').show();
                    $('#accountsDropdown').prop('disabled', true);
                } else {
                    // console.log($('#voidAll'));
                    $("#voidAll").hide();
                    $('#userStatesDropdown').next('.select2-container').hide();
                    $('#selectStatesLabel').hide();
                    $('#accountsDropdown').prop('disabled', false);
                }
            });

            //Accounts Dropdown Configuration
            $('#accountsDropdown').on('change', function() {
                $('#datatableLeads').DataTable().ajax.reload();
                // $('#dataTable').DataTable().ajax.reload();
                let accountsProfileValue = $(this).val();
                if (accountsProfileValue != "") {
                    $.ajax({
                        url: "{{ route('get-states') }}",
                        type: 'GET',
                        data: {
                            userProfileValue: accountsProfileValue
                        },
                        success: function(data) {
                            var stateSelect = $('#userStatesDropdown');
                            stateSelect.empty();
                            stateSelect.append('<option value="">Select States</option>');
                            stateSelect.append('<option value="">ALL</option>');
                            $.each(data, function(key, value) {
                                stateSelect.append('<option value="' + key + '">' +
                                    value + '</option>')
                            });
                        }
                    });
                    $('#voidAll').show();
                    $('#userStatesDropdown').next('.select2-container').show();
                    $('#selectStatesLabel').show();
                    $('#userProfileDropdown').prop('disabled', true);

                } else {
                    // console.log($('#voidAll'));
                    $("#voidAll").hide();
                    $('#userStatesDropdown').next('.select2-container').hide();
                    $('#selectStatesLabel').hide();
                    $('#userProfileDropdown').prop('disabled', false);
                }
            });



            // ajax script for randomly assign leads to user

            $('#assignRandomLeadsUser').on('click', function() {
                let userProfileId = $('#userProfileDropdown').val();
                let accountProfileId = $('#accountsDropdown').val()
                if (userProfileId != '' || accountProfileId != '') {
                    $('#assignRandomLeadsToUser').modal('show');
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: 'Please Select Agent',
                        icon: 'error'
                    });
                }

            });

            //ajax for submitting the button for assigning random leads to user
            $('#assign_ok_button').on('click', function() {
                var laddaButton = Ladda.create($(this)[0]);
                laddaButton.start();
                $.ajax({
                    url: "{{ route('assign-random-leads-user') }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: "json",
                    method: "POST",
                    data: {
                        leadsQuantityUser: $('#leadsQuantityUser').val(),
                        userProfileId: $('#userProfileDropdown').val(),
                        accountProfileValue: $('#accountsDropdown').val()
                    },
                    success: function(response) {
                        laddaButton.stop();
                        if (response.errors) {
                            var errors = response.errors;
                            $.each(errors, function(key, value) {
                                $('#' + key).addClass('is-invalid');
                                $('#' + key + '_error').html(value);
                            });
                        } else {
                            Swal.fire({
                                title: 'Success',
                                text: response.success,
                                icon: 'success'
                            }).then(function() {
                                location.reload();
                            });
                        }
                    },
                    error: function(xhr, status, error) {
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



            // ajax script for randomly assign leads to users
            $('#assignRandomLeads').on('click', function() {
                $('#assignRandomLeadsToRandomUser').modal('show');
            });




            // ajax script for assigning checked leads
            $('#assignLead').on('click', function() {
                var id = [];
                var userProfileId = $('#userProfileDropdown').val()
                var accountProfileId = $('#accountsDropdown').val()
                $('.users_checkbox:checked').each(function() {
                    id.push($(this).val());
                });
                if (id.length > 0) {
                    if (userProfileId || accountProfileId) {
                        var laddaButton = Ladda.create($(this)[0]);
                        laddaButton.start();
                        $.ajax({
                            url: "{{ route('assign-leads') }}",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            dataType: "json",
                            method: "POST",
                            data: {
                                id: id,
                                userProfileId: userProfileId,
                                accountProfileId: accountProfileId
                            },
                            success: function(data) {
                                laddaButton.stop();
                                Swal.fire({
                                    title: 'Success',
                                    text: data.success,
                                    icon: 'success'
                                }).then(function() {
                                    location.reload();
                                });
                            },
                            error: function(data) {
                                var errors = data.responseJSON;
                                console.log(errors);
                            }

                        });
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: 'Please Select Agent',
                            icon: 'error'
                        });
                    }

                } else {
                    Swal.fire({
                        title: 'Error',
                        text: 'Please select atleast one checkbox',
                        icon: 'error'
                    });
                }
            });



            // ajax script for randomly assign leads to a random users
            $('#assign_random_ok_button').on('click', function() {
                var id = [];
                // console.log('this test the button shit');
                var laddaButton = Ladda.create($(this)[0]);
                var userCount = {{ count($userProfiles) }}
                if (userCount == 0) {
                    Swal.fire({
                        title: 'Error',
                        text: 'There is no Apptaker Please Asssign a apptaker then use this button again',
                        icon: 'error'
                    });
                } else {
                    laddaButton.start();
                    $.ajax({
                        url: "{{ route('assign-random-leads') }}",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        dataType: "json",
                        method: "POST",
                        data: {
                            leadsQuantityRandom: $('#leadsQuantityRandom').val(),
                        },
                        success: function(response) {
                            laddaButton.stop();
                            if (response.errors) {
                                var errors = response.errors;
                                $.each(errors, function(key, value) {
                                    $('#' + key).addClass('is-invalid');
                                    $('#' + key + '_error').html(value);
                                });
                            } else {
                                Swal.fire({
                                    title: 'Success',
                                    text: response.success,
                                    icon: 'success'
                                }).then(function() {
                                    location.reload();
                                });
                                location.reload();
                            }
                        },
                        error: function(xhr, status, error) {
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
                }

            });


            $('#confirmVoidAllModal').on('hidden.bs.modal', function() {
                voidAllClicked = false;
            });

        });




        let voidAllClicked = false;

        //this script is for showing the modal for voiding all leads from leads
        $('#voidAll').on('click', function() {
            $('#confirmVoidAllModal').modal('show');
            voidAllClicked = true;
        });



        //script for sending the ajax request
        $('#void_ok_button').click(function() {
            event.preventDefault();
            var laddaButton = Ladda.create($(this)[0]);
            laddaButton.start();
            $.ajax({
                url: "{{ route('void-all') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: 'POST',
                dataType: "json",
                data: {
                    userProfileId: $('#userProfileDropdown').val(),
                    accountProfileId: $('#accountsDropdown').val(),
                },
                success: function(data) {
                    laddaButton.stop();
                    Swal.fire({
                        title: 'Success',
                        text: data.success,
                        icon: 'success'
                    }).then(function() {
                        location.reload();
                    });
                },
                error: function(data) {
                    var errors = data.responseJSON;
                    Swal.fire({
                        title: 'Error',
                        text: errors,
                        icon: 'error'
                    });
                }
            })
        });

        //script for showing modal of void confirmation
        var leadsId
        var userProfileId
        $(document).on('click', '.btn-outline-danger', function(event) {
            leadsId = $(this).attr('id');
            if (voidAllClicked) {
                $('#confirmModal').modal('hide');

            } else {
                $('#confirmModal').modal('show');
            }
        });

        var userProfileId = $('#userProfileDropdown').val()
        var accountProfileId = $('#accountsDropdown').val()
        //script for voiding lead from user
        $('#ok_button').click(function() {
            event.preventDefault();
            var laddaButton = Ladda.create($(this)[0]);
            laddaButton.start();
            $.ajax({
                url: "{{ route('void-leads-user') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: 'POST',
                dataType: "json",
                data: {
                    id: leadsId,
                    userProfileId: $('#userProfileDropdown').val(),
                    accountProfileId: $('#accountsDropdown').val()
                },
                success: function(data) {
                    laddaButton.stop();
                    Swal.fire({
                        title: 'Success',
                        text: data.success,
                        icon: 'success'
                    }).then(function() {
                        location.reload();
                    });
                },
                error: function(data) {
                    var errors = data.responseJSON;
                    Swal.fire({
                        title: 'Error',
                        text: errors,
                        icon: 'error'
                    });
                }
            })
        });


        //script for triggiring modal on redeploying
        var leadsIdRedeploy
        $(document).on('click', '.btn-outline-info', function(event) {
            leadsIdRedeploy = $(this).attr('id');
            $('#dataModal').modal('show');
            console.log(leadsIdRedeploy);
        });


        //script for submiting of redeployement
        $('#submit_button').click(function() {
            event.preventDefault();
            var laddaButton = Ladda.create($(this)[0]);
            laddaButton.start();
            $.ajax({
                url: "{{ route('redeploy-leads-user') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: 'POST',
                dataType: "json",
                data: {
                    id: leadsIdRedeploy,
                    userProfileId: $('#userProfileRedeployDropdown').val()
                },
                success: function(data) {
                    laddaButton.stop();
                    Swal.fire({
                        title: 'Success',
                        text: data.success,
                        icon: 'success'
                    }).then(function() {
                        location.reload();
                    });
                },
                error: function(data) {
                    var errors = data.responseJSON;
                    Swal.fire({
                        title: 'Error',
                        text: errors,
                        icon: 'error'
                    });
                }
            })
        });
    </script>
@endsection
