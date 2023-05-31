@extends('admin.admin_master')
@section('admin')
    <div class="page-content pt-6">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card ">

                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <label class="form-label">App Taker</label>
                                    <div class="col-lg-12">
                                        <select class="form-control select2" id="userProfileDropdown">
                                            <option value="">select agents</option>
                                            @foreach($userProfiles as $userProfile)
                                            @php
                                            $ratings = $userProfile->ratings;
                                            $numberOfRatings = $ratings->count();
                                            $sumOfRatings = $ratings->sum('rating');
                                            $divisorRatings = $numberOfRatings * 5;
                                            $overallRating = ($numberOfRatings > 0) ? $sumOfRatings / $numberOfRatings : 0;
                                            $overallRatingPercentage = ($numberOfRatings > 0) ?  $sumOfRatings / $divisorRatings * 100 : 0 ;
                                            $leadsCounter = count($userProfile->leads);
                                            @endphp
                                                <option value="{{$userProfile->id}}">
                                                    {{$userProfile->firstname . " " . $userProfile->american_surname}} <small class="text-muted">({{ $overallRating }} star) ({{ $leadsCounter }} leads)</small>
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
                                            @foreach($accounts as $account)
                                            @php
                                            $accountLeadsCounter = count($account->leads);
                                            @endphp
                                                <option value="{{$account->id}}">{{$account->firstname . " " . $account->american_surname}}<small class="text-muted"> ({{ $accountLeadsCounter }} leads)</small></option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="d-grid mb-3">
                                <button type="button" id="voidAll" class="btn btn-outline-danger waves-effect waves-light" data-bs-toggle="tooltip" data-bs-placement="top" title="Button to void all leads to account">Void ALL Leads</button>
                            </div>
{{--                            <div class="p-3">--}}
{{--                                <p>A message with auto close timer</p>--}}
{{--                                <button type="button" class="btn btn-primary waves-effect waves-light" id="sa-close">Click me</button>--}}
{{--                            </div>--}}

                            <br>
                            <table id="datatableLeads" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                <tr>
                                    <th>Company Name</th>
                                    <th>Tel Num</th>
                                    <th>State Abbr</th>
                                    <th>Website Originated</th>
                                    <th>action</th>
{{--                                    <th>Created At</th>--}}
{{--                                    <th>Updated At</th>--}}
{{--                                    <th>Disposition Name</th>--}}
{{--                                    <th></th>--}}
                                </tr>
                                </thead>
                                <tbody>


                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered dt-responsive nowrap" id="dataTable" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <div class="row">
                                        <div class="col-4">
                                            <label class="form-label">Time Zone</label>
                                            <select name="timezone" id="timezoneDropdown" class="form-control select2" >
                                                <option value="">Select a timezone</option>
                                                <option value="">ALL</option>
                                                @foreach ($timezones as $timezone => $identifier)
                                                    <option value="{{ $timezone }}">{{ $timezone }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-4">
                                            <div class="mb-3">
                                                <div class="form-group">
                                                    <label class="form-label">States</label>
                                                    <select name="states" id="statesDropdown" class="form-control select2" >
                                                        <option value="">Select</option>
                                                        <option value="">All</option>
                                                            <option value="AK">Alaska</option>
                                                            <option value="HI">Hawaii</option>
                                                            <option value="CA">California</option>
                                                            <option value="NV">Nevada</option>
                                                            <option value="OR">Oregon</option>
                                                            <option value="WA">Washington</option>
                                                            <option value="AZ">Arizona</option>
                                                            <option value="CO">Colorado</option>
                                                            <option value="ID">Idaho</option>
                                                            <option value="MT">Montana</option>
                                                            <option value="NE">Nebraska</option>
                                                            <option value="NM">New Mexico</option>
                                                            <option value="ND">North Dakota</option>
                                                            <option value="UT">Utah</option>
                                                            <option value="WY">Wyoming</option>
                                                            <option value="AL">Alabama</option>
                                                            <option value="AR">Arkansas</option>
                                                            <option value="IL">Illinois</option>
                                                            <option value="IA">Iowa</option>
                                                            <option value="KS">Kansas</option>
                                                            <option value="KY">Kentucky</option>
                                                            <option value="LA">Louisiana</option>
                                                            <option value="MN">Minnesota</option>
                                                            <option value="MS">Mississippi</option>
                                                            <option value="MO">Missouri</option>
                                                            <option value="OK">Oklahoma</option>
                                                            <option value="SD">South Dakota</option>
                                                            <option value="TX">Texas</option>
                                                            <option value="TN">Tennessee</option>
                                                            <option value="WI">Wisconsin</option>
                                                            <option value="CT">Connecticut</option>
                                                            <option value="DE">Delaware</option>
                                                            <option value="FL">Florida</option>
                                                            <option value="GA">Georgia</option>
                                                            <option value="IN">Indiana</option>
                                                            <option value="ME">Maine</option>
                                                            <option value="MD">Maryland</option>
                                                            <option value="MA">Massachusetts</option>
                                                            <option value="MI">Michigan</option>
                                                            <option value="NH">New Hampshire</option>
                                                            <option value="NJ">New Jersey</option>
                                                            <option value="NY">New York</option>
                                                            <option value="NC">North Carolina</option>
                                                            <option value="OH">Ohio</option>
                                                            <option value="PA">Pennsylvania</option>
                                                            <option value="RI">Rhode Island</option>
                                                            <option value="SC">South Carolina</option>
                                                            <option value="VT">Vermont</option>
                                                            <option value="VA">Virginia</option>
                                                            <option value="WV">West Virginia</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-4">
                                            <div class="mb-3">
                                                <div class="form-group">
                                                    <label for="websiteOriginatedDropdown" class="form-label">Website Originated</label>
                                                    <select name="website_originated" id="websiteOriginatedDropdown" class="form-control select2">
                                                        <option value="">Select a Website</option>
                                                        <option value="">ALL</option>
                                                        @foreach($sites as $site)
                                                            <option value="{{substr($site->name, 0, strlen($site->name) - 4)}}">{{substr($site->name, 0, strlen($site->name) - 4)}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <label class="form-label">Class Code</label>
                                            <select name="classCodeLead" id="classCodeLeadDropdown" class="form-control select2" >
                                                <option value="">Select Class Code</option>
                                                <option value="">ALL</option>
                                                @foreach ($classCodeLeads as $classCodeLead)
                                                    <option value="{{ $classCodeLead->name }}">{{ $classCodeLead->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-6">
                                            <div class="mb-3">
                                                <div class="form-group">
                                                    <label for="leadTypeDropdown" class="form-label">Leads Type</label>
                                                    <select name="lead_type" id="leadTypeDropdown" class="form-control select2">
                                                        <option value="">Select a Website</option>
                                                        <option value="">ALL</option>
                                                        <option value="2">Prime Lead</option>
                                                        <option value="1">Normal Lead</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                    </div>



                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label class="form-label">Assign Lead Quantity</label>
                                                <input class="form-control" type="number" value="10" id="leadsQuantityUser" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
{{--                                                {!! Form::label('assign_leads_quantity', 'Assign Lead Quantity') !!}--}}
{{--                                                {!! Form::text('assign_leads_quantity', null, ['class' => 'form-control']) !!}--}}
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="form-group">
                                                <label class="form-label">Assign Random Leads Quantity</label>
                                                <input class="form-control" type="number" value="10" id="leadsQuantityRandom" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
{{--                                                {!! Form::label('random_leads_quantity', 'Assign Random Leads Quantity') !!}--}}
{{--                                                {!! Form::text('random_leads_quantity', null, ['class' => 'form-control']) !!}--}}
                                            </div>
                                        </div>
                                    </div>
                                    <br>

                                        <div class="row">

                                            <div class="col-3">
                                                <div class="d-grid mb-3">
                                                    <button type="button" id="assignRandomLeadsUser" class="btn btn-primary waves-effect waves-light " data-bs-toggle="tooltip" data-bs-placement="top" title="Button to assign Random Leads to a user base to the quantity input on top">Assign Random Leads to user</button>
                                                </div>
                                            </div>

                                            <div class="col-3">
                                                <div class="d-grid mb-3">
                                                    <button type="button" id="assignLead" class="btn btn-primary waves-effect waves-light " data-bs-toggle="tooltip" data-bs-placement="top" title="Button to assign checked Leads to a selected user">Assign Lead</button>
                                                </div>
                                            </div>

                                            <div class="col-3">
                                                <div class="d-grid mb-3">
                                                    <button type="button" id="assignPremiumLead" class="btn btn-primary waves-effect waves-light" data-bs-toggle="tooltip" data-bs-placement="top" title="Button for assgining premium leads">Assign Premium Lead</button>
                                                </div>
                                            </div>

                                            <div class="col-3">
                                                <div class="d-grid mb-3">
                                                <button type="button" id="assignRandomLeads" class="btn btn-primary waves-effect waves-light " data-bs-toggle="tooltip" data-bs-placement="top" title="Button to assign Random Leads to a random user">Assign Random Leads</button>
                                                </div>
                                            </div>
                                
                                        </div>

                                    <br>
                                    <thead>
                                    <tr>
                                        <th></th>
                                        <th>ID</th>
                                        <th>Company Name</th>
                                        <th>Tel Number</th>
                                        <th>State abbr</th>
                                        <th>Class Code</th>
                                        <th>Website Originated</th>
                                        <th>Imported Date</th>
{{--                                        <th>Updated at</th>--}}
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

    {{-- start of modal for redeploying of leads--}}
    <div class="modal fade" id="dataModal" tabindex="-1" aria-labelledby="dataModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header" >
                    <h5 class="modal-title"><b>Redeploy Leads To other Agent</b></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <select class="form-control" id="userProfileRedeployDropdown">
                        <option value="">select agents</option>
                        @foreach($accounts as $account)
                            <option value="{{$account->id}}">{{$account->firstname . " " . $account->american_surname}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success" name="submit_button" id="submit_button">Submit</button>
                </div>
            </div>
        </div>
    </div>
    {{-- end of modal --}}

     {{-- start for assiging premium leads modal --}}
     <div class="modal fade" id="assigningPremiumLeadModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header" >
                    <h5 class="modal-title"><b>Confirmation</b></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Assiging Premium Leads Plss confirm.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success" name="okAssignPremiumButton" id="okAssignPremiumButton">Assign</button>
                </div>
            </div>
        </div>
    </div>
    {{-- end of modal --}}

    {{-- start for voiding leads to user modal --}}
    <div class="modal fade" id="confirmModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header" >
                    <h5 class="modal-title"><b>Confirmation</b></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to void this leads?.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" name="ok_button" id="ok_button">Void</button>
                </div>
            </div>
        </div>
    </div>
    {{-- end of modal --}}



    {{-- start of voiding all leads to a user --}}
    <div class="modal fade" id="confirmVoidAllModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header" >
                    <h5 class="modal-title"><b>Confirmation</b></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to void all leads on this account?.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" name="void_ok_button" id="void_ok_button">Void</button>
                </div>
            </div>
        </div>
    </div>
    {{-- end of deletion of modal --}}

    {{-- start of assigning random leads to user modal --}}
    <div class="modal fade" id="assignRandomLeadsToUser" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header" >
                    <h5 class="modal-title"><b>Confirmation</b></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure?.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success" name="assign_ok_button" id="assign_ok_button">Assign</button>
                </div>
            </div>
        </div>
    </div>
    {{-- end of deletion of modal --}}

    {{-- start of assigning random leads to random user modal--}}
    <div class="modal fade" id="assignRandomLeadsToRandomUser" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header" >
                    <h5 class="modal-title"><b>Confirmation</b></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure?.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success" name="assign_random_ok_button" id="assign_random_ok_button">Assign</button>
                </div>
            </div>
        </div>
    </div>
    {{-- end of deletion of modal --}}
    <script src="{{asset('backend/assets/libs/bootstrap-rating/bootstrap-rating.min.js')}}"></script>
    <script src="{{asset('backend/assets/js/pages/rating-init.js') }}"></script>
        {{--    <!-- Sweet Alerts js -->--}}
    {{--    <script src="{{asset('backend/assets/libs/sweetalert2/sweetalert2.min.js')}}"></script>--}}

    {{--<!-- Sweet alert init js-->--}}
    {{--<script src="{{asset('backend/assets/js/pages/sweet-alerts.init.js')}}"></script>--}}
    <script>
        // DATA TABLE
        $(document).ready(function() {
            $('.select2').select2();
            $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('assign') }}",
                    data: function (d) {
                                d.website_originated = $('#websiteOriginatedDropdown').val(),
                                d.timezone = $('#timezoneDropdown').val(),
                                d.states = $('#statesDropdown').val(),
                                d.classCodeLead = $('#classCodeLeadDropdown').val(),
                                    // d.userProfile = $('#userProfileDropdown').val(),
                                d.search = $('input[type="search"]').val(),
                                d.leadType = $('#leadTypeDropdown').val()
                    }
                },
                columns: [
                    {data: 'checkbox', name: 'checkbox',  orderable: false, searchable: false, title: '<input type="checkbox" id="check_all">'},
                    {data: 'id', name: 'id'},
                    {
                        data: 'company_name', 
                        name: 'company_name',
                        render: function(data, type, row){
                            if(row.prime_lead == 2){
                                return '<div class="d-flex justify-content-between">' + data + '<i class="far fa-gem"></i></div>'
                            }else{
                                return data;
                            }
                        }
                    },
                    {data: 'tel_num', name: 'tel_num'},
                    {data: 'state_abbr', name: 'state_abbr'},
                    {data: 'class_code', name: 'class_code'},
                    {data: 'website_originated', name: 'website_originated'},
                    {data: 'created_at_formatted', name: 'created_at', searchable:false},
                    ]
            });

            $(document).on('click', '#check_all', function(e){
                $('.users_checkbox').prop('checked', $(this).is(':checked'));
                e.stopPropagation();
            });

            // script for display leads that user have
            $('#datatableLeads').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('getDataTableLeads') }}",
                    data: function (f) {
                            f.userProfile = $('#userProfileDropdown').val()
                            f.accountProfileValue = $('#accountsDropdown').val()
                    }
                },
                columns: [
                    // {data: 'checkbox', name: 'checkbox',  searchable: false},
                    // {data: 'id', name: 'id'},
                    {data: 'company_name', name: 'company_name'},
                    {data: 'tel_num', name: 'tel_num'},
                    {data: 'state_abbr', name: 'state_abbr'},
                    {data: 'website_originated', name: 'website_originated'},
                    // {data: 'created_at_formatted', name: 'created_at', searchable:false},
                    // {data: 'updated_at_formatted', name: 'updated_at', searchable:false},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });

            // scripts for reloading and configuring the dropdowns filters
            $('#websiteOriginatedDropdown').on('change', function () {
                $('#dataTable').DataTable().ajax.reload();
            });

            $('#leadTypeDropdown').on('change', function(){
                $('#dataTable').DataTable().ajax.reload();
            });

            $('#statesDropdown').on('change', function () {
                var states = $(this).val();
                $('#dataTable').DataTable().ajax.url("{{ route('assign') }}?states=" + states).load();
            });


            $('#timezoneDropdown').on('change', function() {
                var timezone = $(this).val();
                $('#dataTable').DataTable().ajax.url("{{ route('assign') }}?timezone=" + timezone).load();
            });

            $('#classCodeLeadDropdown').on('change', function () {
                var classCodeLead = $(this).val();
                $('#dataTable').DataTable().ajax.url("{{ route('assign') }}?classCodeLead=" + classCodeLead).load();
            });

            //event for assigning premium leads
            var leadsId = [];
           $('#assignPremiumLead').on('click', function(){
            $('.users_checkbox:checked').each(function (){
                leadsId.push($(this).val());
                });
            if(leadsId.length === 0){
                Swal.fire({
                        title: 'Error',
                        text: 'Please Select Lead',
                        icon: 'error'
                    });
            }else{
                $('#assigningPremiumLeadModal').modal('show');
            }
           });

           $('#okAssignPremiumButton').on('click', function(){ 
            console
            $.ajax({
                url:"{{route('assign-premium-leads')}}",
                headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                dataType:"json",
                method: "POST",
                data:{
                    leadsId:leadsId
                },
                success: function(response){
                     // Handle the response from the server
                    console.log(response);
                  if (response.success) {
                     // Display a success message
                     Swal.fire({
                      title: 'Success',
                      text: 'Leads assigned successfully.',
                      icon: 'success'
                      }).then(function() {
                         location.reload();
                        });
                    }else {
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
            $("#voidAll").hide()

            $('#userProfileDropdown').on('change', function() {
                $('#datatableLeads').DataTable().ajax.reload();
                let userProfileValue= $(this).val();
               if(userProfileValue != "")
               {
                   $('#voidAll').show();
                   $('#accountsDropdown').prop('disabled', true);
               }else{
                   // console.log($('#voidAll'));
                   $("#voidAll").hide();
                   $('#accountsDropdown').prop('disabled', false);
               }

            });

            $('#accountsDropdown').on('change', function () {
                $('#datatableLeads').DataTable().ajax.reload();
                let accountsProfileValue= $(this).val();
                if(accountsProfileValue != "")
                {
                    $('#voidAll').show();
                    $('#userProfileDropdown').prop('disabled', true);

                }else{
                    // console.log($('#voidAll'));
                    $("#voidAll").hide()
                    $('#userProfileDropdown').prop('disabled', false);
                }
            });


            // ajax script for randomly assign leads to user
            
            $('#assignRandomLeadsUser').on('click', function (){
                let userProfileId= $('#userProfileDropdown').val();
                let accountProfileId= $('#accountsDropdown').val()
                if(userProfileId != '' || accountProfileId != ''){
                    $('#assignRandomLeadsToUser').modal('show');
                }else{
                    Swal.fire({
                        title: 'Error',
                        text: 'Please Select Agent',
                        icon: 'error'
                    });
                }

            });

            //ajax for submitting the button for assigning random leads to user
            $('#assign_ok_button').on('click', function(){
                $.ajax({
                    url:"{{route('assign-random-leads-user')}}",
                    headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    dataType:"json",
                    method: "POST",
                    data:{
                        leadsQuantityUser:$('#leadsQuantityUser').val(),
                        userProfileId: $('#userProfileDropdown').val(),
                        accountProfileValue: $('#accountsDropdown').val()
                    },
                    success: function(response){
                        if(response.errors){
                            var errors = response.errors;
                            $.each(errors, function(key, value){
                                $('#' + key).addClass('is-invalid');
                                $('#' + key + '_error').html(value);
                            });
                        }else{
                            Swal.fire({
                                title: 'Success',
                                text: response.success,
                                icon: 'success'
                            }).then(function() {
                                location.reload();
                            });
                        }
                    },
                    error:function(xhr, status, error)
                    {
                        var errorMessage = 'An Error Occured';
                        if(xhr.responseJSON && xhr.responseJSON.error){
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
            $('#assignRandomLeads').on('click', function (){
                $('#assignRandomLeadsToRandomUser').modal('show');
            });


            

            // ajax script for assigning checked leads
            $('#assignLead').on('click', function (){
                var id = [];
                var userProfileId = $('#userProfileDropdown').val()
                var accountProfileId = $('#accountsDropdown').val()
                $('.users_checkbox:checked').each(function (){
                    id.push($(this).val());
                });
                if(id.length > 0)
                {
                    if(userProfileId || accountProfileId)
                    {
                        $.ajax({
                            url:"{{route('assign-leads')}}",
                            headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            dataType:"json",
                            method: "POST",
                            data:{
                                id:id,
                                userProfileId:userProfileId,
                                accountProfileId:accountProfileId
                            },
                            success:function (data)
                            {
                                Swal.fire({
                                    title: 'Success',
                                    text: data.success,
                                    icon: 'success'
                                }).then(function() {
                                    location.reload();
                                });
                            },
                            error: function (data) {
                                var errors =data.responseJSON;
                                console.log(errors);
                            }

                        });
                    }else{
                        Swal.fire({
                            title: 'Error',
                            text: 'Please Select Agent',
                            icon: 'error'
                        });
                    }

                }
                else
                {
                    Swal.fire({
                        title: 'Error',
                        text: 'Please select atleast one checkbox',
                        icon: 'error'
                    });
                }
            });



            // ajax script for randomly assign leads to a random users
            $('#assign_random_ok_button').on('click', function (){
                var id = [];
                // console.log('this test the button shit');
                $.ajax({
                    url:"{{route('assign-random-leads')}}",
                    headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    dataType:"json",
                    method: "POST",
                    data:{
                       leadsQuantityRandom:$('#leadsQuantityRandom').val(),
                    },
                    success: function(response){
                        if(response.errors){
                            var errors = response.errors;
                            $.each(errors, function(key, value){
                                $('#' + key).addClass('is-invalid');
                                $('#' + key + '_error').html(value);
                            });
                        }else{
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
                    error:function(xhr, status, error)
                    {
                        var errorMessage = 'An Error Occured';
                        if(xhr.responseJSON && xhr.responseJSON.error){
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


            $('#confirmVoidAllModal').on('hidden.bs.modal', function(){
                voidAllClicked = false;
            });

        });




    let voidAllClicked = false;

     //this script is for showing the modal for voiding all leads from leads
    $('#voidAll').on('click', function (){
        $('#confirmVoidAllModal').modal('show');
        voidAllClicked = true;
    });



    //script for sending the ajax request
    $('#void_ok_button').click(function(){
        event.preventDefault();
        $.ajax({
            url: "{{route('void-all')}}",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            method:'POST',
            dataType:"json",
            data:{
                userProfileId:$('#userProfileDropdown').val(),
            },
            success:function (data){
                Swal.fire({
                    title: 'Success',
                    text: data.success,
                    icon: 'success'
                }).then(function() {
                    location.reload();
                });
            },
            error: function(data){
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
            $(document).on('click', '.btn-outline-danger', function(event){
                leadsId = $(this).attr('id');
                if(voidAllClicked){
                    $('#confirmModal').modal('hide');

                }else{
                    $('#confirmModal').modal('show');
                }
            });



            //script for voiding leads from user
        $('#ok_button').click(function(){
            event.preventDefault();
            $.ajax({
                url: "{{route('void-leads-user')}}",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                method:'POST',
                dataType:"json",
                data:{
                    id:leadsId,
                },
                success:function (data){
                    Swal.fire({
                        title: 'Success',
                        text: data.success,
                        icon: 'success'
                    }).then(function() {
                        location.reload();
                    });
                },
                error: function(data){
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
        $(document).on('click', '.btn-outline-info', function (event){
            leadsIdRedeploy = $(this).attr('id');
            $('#dataModal').modal('show');
        });


        //script for submiting of redeployement
        $('#submit_button').click(function(){
            event.preventDefault();
            $.ajax({
                url:"{{route('redeploy-leads-user')}}",
                headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                method:'POST',
                dataType:"json",
                data:{
                    id:leadsIdRedeploy,
                    userProfileId:$('#userProfileRedeployDropdown').val()
                },
                success:function (data){
                    Swal.fire({
                        title: 'Success',
                        text: data.success,
                        icon: 'success'
                    }).then(function() {
                        location.reload();
                    });
                },
                error: function(data){
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
