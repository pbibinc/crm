@extends('admin.admin_master')
@section('admin')
    <div class="page-content pt-6">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card ">

                        <div class="card-body">
                            <div class="row mb-3">
                                <label class="form-label">Single Select</label>
                                <div class="col-lg-12">
                                    <select class="form-control select2" id="userProfileDropdown">
                                        <option value="">select agents</option>
                                        @foreach($userProfiles as $userProfile)
                                            <option value="{{$userProfile->id}}">{{$userProfile->firstname . " " . $userProfile->american_surname}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
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

                                        <div class="col-6">
                                            <div class="mb-3">
                                                <div class="form-group">
                                                    <label class="form-label">Time Zone</label>
                                                    <select name="timezone" id="timezoneDropdown" class="form-control select2" >
                                                        <option value="">Select a timezone</option>
                                                        <option value="">ALL</option>
                                                        @foreach ($timezones as $timezone => $identifier)
                                                            <option value="{{ $timezone }}">{{ $timezone }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-6">
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
                                            <div class="col-6">
                                                <div class="d-grid mb-3">
                                                    <button type="button" id="assignRandomLeadsUser" class="btn btn-info waves-effect waves-light " data-bs-toggle="tooltip" data-bs-placement="top" title="Button to assign Random Leads to a user base to the quantity input on top">Assign Random Leads to user</button>
                                                </div>
                                            </div>

                                            <div class="col-6">
                                                <div class="d-grid mb-3">
                                                <button type="button" id="assignRandomLeads" class="btn btn-info waves-effect waves-light " data-bs-toggle="tooltip" data-bs-placement="top" title="Button to assign Random Leads to a random user">Assign Random Leads</button>
                                                </div>
                                            </div>

                                        </div>

                                    <div class="row">
                                        <div class="d-grid mb-3">
                                            <button type="button" id="assignLead" class="btn btn-info waves-effect waves-light " data-bs-toggle="tooltip" data-bs-placement="top" title="Button to assign checked Leads to a selected user">Assign Lead</button>
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
                        @foreach($userProfiles as $userProfile)
                            <option value="{{$userProfile->id}}">{{$userProfile->firstname . " " . $userProfile->american_surname}}</option>
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


    {{-- start of modal for voiding the leads --}}
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
    {{-- end of deletion of modal --}}



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

    {{-- start of voiding all leads to a user --}}
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

    {{-- start of voiding all leads to a user --}}
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

    <script>

    {{--    <!-- Sweet Alerts js -->--}}
    {{--    <script src="{{asset('backend/assets/libs/sweetalert2/sweetalert2.min.js')}}"></script>--}}

    {{--<!-- Sweet alert init js-->--}}
    {{--<script src="{{asset('backend/assets/js/pages/sweet-alerts.init.js')}}"></script>--}}

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
                                    // d.userProfile = $('#userProfileDropdown').val(),
                                d.search = $('input[type="search"]').val()
                    }
                },
                columns: [
                    {data: 'checkbox', name: 'checkbox',  searchable: false},
                    {data: 'id', name: 'id'},
                    {data: 'company_name', name: 'company_name'},
                    {data: 'tel_num', name: 'tel_num'},
                    {data: 'state_abbr', name: 'state_abbr'},
                    {data: 'website_originated', name: 'website_originated'},
                    {data: 'created_at_formatted', name: 'created_at', searchable:false},

                    ]
            });

            // script for display leads that user have
            $('#datatableLeads').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('getDataTableLeads') }}",
                    data: function (f) {
                            f.userProfile = $('#userProfileDropdown').val()
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

            $('#timezoneDropdown').on('change', function() {
                var timezone = $(this).val();
                $('#dataTable').DataTable().ajax.url("{{ route('assign') }}?timezone=" + timezone).load();
            });

            $("#voidAll").hide()

            $('#userProfileDropdown').on('change', function() {
                $('#datatableLeads').DataTable().ajax.reload();
                let userProfileValue= $(this).val();
               if(userProfileValue != "")
               {
                   $('#voidAll').show();
               }else{
                   // console.log($('#voidAll'));
                   $("#voidAll").hide()
               }

            });


            // ajax script for randomly assign leads to user
            $('#assignRandomLeadsUser').on('click', function (){
                let userProfileId= $('#userProfileDropdown').val();
                if(userProfileId != ''){
                    $('#assignRandomLeadsToUser').modal('show');
                }else{
                    alert('Please Select Agent')
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
                        userProfileId: $('#userProfileDropdown').val()
                    },
                    success: function(response){
                        if(response.errors){
                            var errors = response.errors;
                            $.each(errors, function(key, value){
                                $('#' + key).addClass('is-invalid');
                                $('#' + key + '_error').html(value);
                            });
                        }else{
                            alert(response.success);
                            location.reload();
                        }
                    },
                    error:function(xhr, status, error)
                    {
                        console.log(xhr);
                        console.log(status);
                        console.log(error);
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
                $('.users_checkbox:checked').each(function (){
                    id.push($(this).val());
                });
                if(id.length > 0)
                {
                    if(userProfileId)
                    {
                        $.ajax({
                            url:"{{route('assign-leads')}}",
                            headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            dataType:"json",
                            method: "POST",
                            data:{
                                id:id,
                                userProfileId:userProfileId
                            },
                            success:function (data)
                            {
                                // $('#datatableLeads').DataTable().ajax.reload();
                                // $('#dataTable').DataTable().ajax.reload();
                                alert(data.success);
                                location.reload();
                            },
                            error: function (data) {
                                var errors =data.responseJSON;
                                console.log(errors);
                            }

                        });
                    }else{
                        alert('Please select agent');
                    }

                }
                else
                {
                    alert('Please select atleast one checkbox');
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
                            alert(response.success);
                            location.reload();
                        }
                    },
                    error:function(xhr, status, error)
                    {
                        console.log(xhr);
                        console.log(status);
                        console.log(error);
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
                alert(data.success);
                location.reload();
            },
            error: function(data){
                var errors = data.responseJSON;
                console.log(errors);
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
                    alert(data.success);
                    location.reload();
                },
                error: function(data){
                    var errors = data.responseJSON;
                    console.log(errors);
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
                    alert(data.success);
                    location.reload();
                },
                error: function(data){
                    var errors = data.responseJSON;
                    console.log(errors);
                }
            })
        });

    </script>

@endsection
