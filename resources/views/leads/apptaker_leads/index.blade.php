@extends('admin.admin_master')
@section('admin')
    <div class="page-content pt-6">
        <link rel="stylesheet" href="{{asset('backend/assets/libs/twitter-bootstrap-wizard/prettify.css')}}">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
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
{{--                                        <div class="mb-3">--}}
{{--                                            <div class="form-group">--}}
{{--                                                <label for="websiteOriginatedDropdown" class="form-label">Website Originated</label>--}}
{{--                                                <select name="website_originated" id="websiteOriginatedDropdown" class="form-control select2">--}}
{{--                                                    <option value="">Select a Website</option>--}}
{{--                                                    <option value="">ALL</option>--}}
{{--                                                    @foreach($sites as $site)--}}
{{--                                                        <option value="{{substr($site->name, 0, strlen($site->name) - 4)}}">{{substr($site->name, 0, strlen($site->name) - 4)}}</option>--}}
{{--                                                    @endforeach--}}
{{--                                                </select>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
                                    </div>
                                </div>

                                <thead>
                                <tr>
                                    <th>Company Name</th>
                                    <th>Tel Num</th>
                                    <th>Disposition</th>
                                    <th>State Abbr</th>
{{--                                    <th>Website Originated</th>--}}
                                </thead>
                                <tbody>


                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade bs-example-modal-xl" tabindex="-1" id="leadsDataModal" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myExtraLargeModalLabel">Extra large modal</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Apptaker Questionare</h4>

                                    <div id="progrss-wizard" class="twitter-bs-wizard">

                                        <ul class="twitter-bs-wizard-nav nav-justified">

                                            <li class="nav-item">
                                                <a href="#progress-seller-details" class="nav-link" data-toggle="tab" id="progressSellerDetails">
                                                    <span class="step-number">01</span>
                                                    <span class="step-title">General Information</span>
                                                </a>
                                            </li>

                                            <li class="nav-item">
                                                <a href="#progress-company-document" class="nav-link" data-toggle="tab" id="progressCompanyDocument">
                                                    <span class="step-number">02</span>
                                                    <span class="step-title">Products</span>
                                                </a>
                                            </li>

                                            <li class="nav-item">
                                                <a href="#progress-bank-detail" class="nav-link" data-toggle="tab" id="progressBankDetail">
                                                    <span class="step-number">03</span>
                                                    <span class="step-title">Confirm Details</span>
                                                </a>
                                            </li>

                                            <li class="nav-item">
                                                <a href="#progress-confirm-detail" class="nav-link" data-toggle="tab" id="progressConfirmDetail">
                                                    <span class="step-number">04</span>
                                                    <span class="step-title">Submission</span>
                                                </a>
                                            </li>

                                        </ul>

                                        <div id="bar" class="progress mt-4">
                                            <div class="progress-bar bg-success progress-bar-striped progress-bar-animated"></div>
                                        </div>

                                        {{--General Information Tab--}}
                                        <div class="tab-content twitter-bs-wizard-tab-content">
                                            <div class="tab-pane" id="progress-seller-details">
                                                <form>
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <div class="mb-3">
                                                                <label class="form-label" for="progress-basicpill-firstname-input">First name</label>
                                                                <input type="text" class="form-control" id="firstName">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="mb-3">
                                                                <label class="form-label" for="progress-basicpill-lastname-input">Last name</label>
                                                                <input type="text" class="form-control" id="lastName">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <div class="mb-3">
                                                                <label class="form-label" for="progress-basicpill-firstname-input">Job Position</label>
                                                                <input type="text" class="form-control" name="jobPosition" id="jobPosition">
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <div class="mb-3">
                                                                <label class="form-label" for="progress-basicpill-phoneno-input">Phone</label>
                                                                <input type="text" class="form-control" name="phoneNumber" id="phoneNumber">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="mb-3">
                                                                <label class="form-label" for="progress-basicpill-phoneno-input">Alternative Phone Number</label>
                                                                <input type="text" class="form-control" name="altNumber" id="altNumber">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <div class="mb-3">
                                                                <label class="form-label" for="progress-basicpill-phoneno-input">Fax</label>
                                                                <input type="text" class="form-control" name="fax" id="fax">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="mb-3">
                                                                <label class="form-label" for="progress-basicpill-email-input">Email</label>
                                                                <input type="email" class="form-control" id="email">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <div class="mb-3">
                                                                <label class="form-label" for="progress-basicpill-phoneno-input">Full Employee</label>
                                                                <input class="form-control" type="number" value="10" id="fullTimeEmployee" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="mb-3">
                                                                <label class="form-label" for="progress-basicpill-email-input">Part Time Employee</label>
                                                                <input class="form-control" type="number" value="10" id="partTimeEmployee" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <div class="mb-3">
                                                                <label class="form-label" for="progress-basicpill-phoneno-input">Gross Receipt</label>
                                                                <input class="form-control input-mask text-left"  id="grossReceipt" onkeypress="return event.charCode >= 48 && event.charCode <= 57" data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="mb-3">
                                                                <label class="form-label" for="progress-basicpill-email-input">Employee Pay Roll</label>
                                                                <input class="form-control input-mask text-left"  id="employeePayRoll" onkeypress="return event.charCode >= 48 && event.charCode <= 57" data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'">
                                                            </div>
                                                        </div>
                                                    </div>
{{--                                                    <div class="row">--}}
{{--                                                        <div class="col-lg-12">--}}
{{--                                                            <div class="mb-3">--}}
{{--                                                                <label class="form-label" for="progress-basicpill-address-input">Address</label>--}}
{{--                                                                <textarea id="progress-basicpill-address-input" class="form-control" rows="2"></textarea>--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
                                                </form>
                                            </div>
                                            <div class="tab-pane" id="progress-company-document">
                                                <div class="row">

                                                    <!-- Product Nav tabs -->
                                                    <ul class="nav nav-pills nav-justified" role="tablist">
                                                                <li class="nav-item waves-effect waves-light">
                                                                    <a class="nav-link active" data-bs-toggle="tab" href="#general-liability-1" role="tab">
                                                                        <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                                                        <span class="d-none d-sm-block">General Liabilities</span>
                                                                    </a>
                                                                </li>

                                                                <li class="nav-item waves-effect waves-light">
                                                                    <a class="nav-link" data-bs-toggle="tab" href="#worker-comp-1" role="tab">
                                                                        <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                                                        <span class="d-none d-sm-block">Workers Comp</span>
                                                                    </a>
                                                                </li>

                                                                <li class="nav-item waves-effect waves-light">
                                                                    <a class="nav-link" data-bs-toggle="tab" href="#commercial-auto-1" role="tab">
                                                                        <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                                                        <span class="d-none d-sm-block">Commercial Auto</span>
                                                                    </a>
                                                                </li>

                                                                <li class="nav-item waves-effect waves-light">
                                                                    <a class="nav-link" data-bs-toggle="tab" href="#excess-liability-1" role="tab">
                                                                        <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                                                        <span class="d-none d-sm-block">Excess Liability</span>
                                                                    </a>
                                                                </li>

                                                            <li class="nav-item waves-effect waves-light">
                                                                <a class="nav-link" data-bs-toggle="tab" href="#tools-equipment-1" role="tab">
                                                                    <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                                                    <span class="d-none d-sm-block">Tools Equipment</span>
                                                                </a>
                                                            </li>
                                                    </ul>

                                                    <!-- Tab panes -->
                                                    <div class="tab-content p-3 text-muted">


                                                        {{--General Liabilities Tab--}}
                                                        <div class="tab-pane active" id="general-liability-1" role="tabpanel">
                                                            <div class="row">
                                                                <div class="mb-3">
                                                                    <label>Business Description</label>
                                                                    <div>
                                                                        <textarea required class="form-control" id="businessDescription" rows="5"></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-6">
                                                                    <label class="form-label">Residential</label>
                                                                    <input id="residential" type="text" value="50" name="residential">
                                                                </div>
                                                                <div class="col-6">
                                                                    <label class="form-label">Commercial</label>
                                                                    <input id="commercial" type="text" value="50" name="commercial">
                                                                </div>
                                                            </div>
                                                            <br>


                                                            <div class="row">
                                                                <div class="col-6">
                                                                    <label class="form-label">New Contruction</label>
                                                                    <input id="newConstruction" type="text" value="50" name="newConstruction">
                                                                </div>
                                                                <div class="col-6">
                                                                    <label class="form-label">Repair</label>
                                                                    <input id="repair" type="text" value="50" name="repair">
                                                                </div>
                                                            </div>
                                                            <br>

                                                            <div class="row">
                                                                <div class="col-6">
                                                                    <label class="form-label">Multiple State Work</label>
                                                                </div>
                                                                <div class="col-6">
                                                                    <label class="form-label">Self Performing Roofing</label>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-6">
                                                                    <div class="square-switch">
                                                                        <input type="checkbox" id="multipleStateWork" switch="info"/>
                                                                        <label for="multipleStateWork" data-on-label="Yes" data-off-label="No"></label>
                                                                    </div>
                                                                </div>

                                                                <div class="col-6">
                                                                    <div class="square-switch">
                                                                        <input type="checkbox" id="roofing" switch="info"/>
                                                                        <label for="roofing" data-on-label="Yes" data-off-label="No"></label>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-6">
                                                                    <label class="form-label">Concrete Foundation Work</label>
                                                                </div>
                                                                <div class="col-6">
                                                                    <label class="form-label">Do you Perform Tract work?</label>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-6">
                                                                    <div class="square-switch">
                                                                        <input type="checkbox" id="concreteFoundation" switch="info"/>
                                                                        <label for="concreteFoundation" data-on-label="Yes" data-off-label="No"></label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-6">
                                                                    <div class="square-switch">
                                                                        <input type="checkbox" id="trackWork" switch="info"/>
                                                                        <label for="trackWork" data-on-label="Yes" data-off-label="No"></label>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-6">
                                                                    <label class="form-label">Do you do any work for condominium</label>
                                                                </div>
                                                                <div class="col-6">
                                                                    <label class="form-label">Will you perform any new/remodeling work in multi-dwelling residences?</label>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-6">
                                                                    <div class="square-switch">
                                                                        <input type="checkbox" id="condoTownHouse" switch="info"/>
                                                                        <label for="condoTownHouse" data-on-label="Yes" data-off-label="No"></label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-6">
                                                                    <div class="square-switch">
                                                                        <input type="checkbox" id="square-switch3" switch="info"/>
                                                                        <label for="square-switch3" data-on-label="Yes" data-off-label="No"></label>
                                                                    </div>
                                                                </div>
                                                            </div>








                                                        </div>
                                                        {{-- End General Liabilities Tab--}}


                                                        <div class="tab-pane" id="worker-comp-1" role="tabpanel">
                                                            <p class="mb-0">
                                                                This tabs will have the form for WorkerComp Questionare
                                                            </p>
                                                        </div>
                                                        <div class="tab-pane" id="commercial-auto-1" role="tabpanel">
                                                            <p class="mb-0">
                                                                This tabs will have the form for Commercial Auto Questionare
                                                            </p>
                                                        </div>
                                                        <div class="tab-pane" id="excess-liability-1" role="tabpanel">
                                                            <p class="mb-0">
                                                                This tabs will have the form for Excess Liability Questionare
                                                            </p>
                                                        </div>
                                                        <div class="tab-pane" id="tools-equipment-1" role="tabpanel">
                                                            <p class="mb-0">
                                                                This tabs will have the form for Tools Equipment Questionare
                                                            </p>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="tab-pane" id="progress-bank-detail">
                                               <p>INFORMATION CONFIRMATION</p>
                                            </div>


                                            {{--submission part--}}
                                            <div class="tab-pane" id="progress-confirm-detail">
                                                <div class="row justify-content-center">
                                                    <div class="col-lg-6">
                                                        <div class="text-center">
                                                            <div class="mb-4">
                                                                <i class="mdi mdi-check-circle-outline text-success display-4"></i>
                                                            </div>
                                                            <div>
                                                                <h5>Confirm Detail</h5>
                                                                <p class="text-muted">If several languages coalesce, the grammar of the resulting</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            {{--End of Submission--}}

                                        </div>
                                        <ul class="pager wizard twitter-bs-wizard-pager-link">
                                            <li class="previous"><a href="javascript: void(0);">Previous</a></li>
                                            <li class="next" id="nextButtonContainer"><a href="javascript: void(0);" id="nextButton">Next</a></li>
                                            <li class="submit" style="display: none;" id="submitButtonContainer"><button type="submit" id="submitButton" class="btn btn-primary">Submit</button></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->



        {{-- start of modal for adding multiple statework--}}
        <div class="modal fade bs-example-modal-lg" id="dataModal" tabindex="-1" aria-labelledby="dataModal" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="dataModalLabel">Mutiple State</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <form id="dataModalForm">
                            @csrf
                            <div class="mb-3">
                                <div class="form-group">
                                    <table class="table table-bordered" id="dynamicAddRemove">
                                        <tr>
                                            <th>States</th>
                                            <th>Percentage</th>
                                            <th>Action</th>
                                        </tr>

                                        <tr>
                                            <td>  <select name="statesDropdown[0][state]" id="statesDropdown" class="form-control" >
                                                    <option value="">Select a timezone</option>
                                                    <option value="">ALL</option>
                                                    @foreach ($states as $state)
                                                        <option value="{{ $state }}">{{ $state }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <div class="input-group">
                                                    <input class="form-control" type="number" value="42" id="stateWorkPercentage" name="statePercentage[0][percentage]">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">%</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <button id="addRowButton" class="btn btn-primary">Add Row</button>
                                            </td>
                                        </tr>

                                    </table>
                                </div>
                            </div>
                            <input type="hidden" name="action" id="action" value="add">
                            <input type="hidden" name="hidden_id" id="hidden_id" />

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <input type="submit" name="action_button" id="action_button" id='#stateWorkPercentage' value="Submit" class="btn btn-primary">
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- end of modal --}}

    </div>


{{--    //scripts for forms etc--}}
    <script src="{{asset('backend/assets/libs/twitter-bootstrap-wizard/jquery.bootstrap.wizard.min.js')}}"></script>
    <script src="{{asset('backend/assets/libs/twitter-bootstrap-wizard/prettify.js')}}"></script>
    <script src="{{asset('backend/assets/js/pages/form-wizard.init.js')}}"></script>
    <script src="{{asset('backend/assets/js/pages/form-mask.init.js')}}"></script>
    <script src="{{asset('backend/assets/libs/inputmask/jquery.inputmask.min.js')}}"></script>


    <script>
        $(document).ready(function (){
            $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('apptaker-leads') }}",
                    data:function (d) {
                        d.website_originated = $('#websiteOriginatedDropdown').val()
                    }
                },
                columns: [
                    {data: 'company_name_action', name: 'company_name_action'},
                    {data: 'tel_num', name: 'tel_num'},
                    {data: 'dispositions', name:'dispositions'},
                    {data: 'state_abbr', name: 'state_abbr'},
                    // {data: 'website_originated', name: 'website_originated', searchable:false},

                ]
            });

            // scripts for reloading and configuring the dropdowns filters
            $('#websiteOriginatedDropdown').on('change', function () {
                $('#datatable').DataTable().ajax.reload();
            });

            $('#timezoneDropdown').on('change', function() {
                var timezone = $(this).val();
                $('#datatable').DataTable().ajax.url("{{ route('apptaker-leads') }}?timezone=" + timezone).load();
            });



            var leadsId = null;
            $(document).on('click', '#companyLink', function(event){
                event.preventDefault();
                leadsId = $(this).data('id');
                var companyName = $(this).data('name');
                $('#myExtraLargeModalLabel').text(companyName);
                if(leadsId == localStorage.getItem('id')){
                    $('#firstName').val(localStorage.getItem('firstName'));
                    $('#lastName').val(localStorage.getItem('lastName'));
                    $('#jobPosition').val(localStorage.getItem('jobPosition'));
                    $('#phoneNumber').val(localStorage.getItem('phoneNumber'));
                    $('#altNumber').val(localStorage.getItem('altNumber'));
                    $('#fax').val(localStorage.getItem('fax'));
                    $('#email').val(localStorage.getItem('email'));
                    $('#fullTimeEmployee').val(localStorage.getItem('fullTimeEmployee'));
                    $('#partTimeEmployee').val(localStorage.getItem('partTimeEmployee'));
                    $('#grossReceipt').val(localStorage.getItem('grossReceipt'));
                    $('#employeePayRoll').val(localStorage.getItem('employeePayRoll'));
                    $('#residential').val(localStorage.getItem('residential'));
                    $('#commercial').val(localStorage.getItem('commercial'));
                    $('#newConstruction').val(localStorage.getItem('newConstruction'));
                    $('#repair').val(localStorage.getItem('repair'));
                    $('#businessDescription').val(localStorage.getItem('businessDescription'));
                } else{
                    $('#firstName').val('');
                    $('#lastName').val('');
                    $('#jobPosition').val('');
                    $('#phoneNumber').val('');
                    $('#altNumber').val('');
                    $('#fax').val('');
                    $('#email').val('');
                    $('#fullTimeEmployee').val('');
                    $('#partTimeEmployee').val('');
                    $('#grossReceipt').val('');
                    $('#employeePayRoll').val('');
                    $('#residential').val('');
                    $('#commercial').val('');
                    $('#newConstruction').val('');
                    $('#repair').val('');
                    $('#businessDescription').val('');
                }
                $('#leadsDataModal').modal('show');
            });

            $('#leadsDataModal').on('hidden.bs.modal', function(){
                    var formValues = {
                        id:  leadsId,
                        firstName: $('#firstName').val(),
                        lastName: $('#lastName').val(),
                        jobPosition: $('#jobPosition').val(),
                        phoneNumber: $('#phoneNumber').val(),
                        altNumber: $('#altNumber').val(),
                        fax: $('#fax').val(),
                        email: $('#email').val(),
                        fullTimeEmployee: $('#fullTimeEmployee').val(),
                        partTimeEmployee: $('#partTimeEmployee').val(),
                        grossReceipt: $('#grossReceipt').val(),
                        employeePayRoll: $('#employeePayRoll').val(),
                        residential: $('#residential').val(),
                        commercial: $('#commercial').val(),
                        newConstruction: $('#newConstruction').val(),
                        repair: $('#repair').val(),
                        businessDescription: $('#businessDescription').val(),
                        multipleStateWork: $('#multipleStateWork').val()
                    };
            if(localStorage.getItem('firstName') == '' || localStorage.getItem('lastName') == '' || localStorage.getItem('jobPosition') == ''){
                $.each(formValues, function(key, value) {
                    localStorage.setItem(key, value);
                });
            }
            });

            $('#residential, #commercial').TouchSpin({
                min: 0,
                max: 100,
                step: 1,
                decimals: 0,
                boostat: 5,
                maxboostedstep: 10,
                postfix: '%'
            });


            $('#newConstruction, #repair').TouchSpin({
                min: 0,
                max: 100,
                step: 1,
                decimals: 0,
                boostat: 5,
                maxboostedstep: 10,
                postfix: '%'
            });



            $('#residential').on('change', function(){
               var value1 =  parseInt($(this).val()) || 0;
                var value2 = 100 - value1;

                $('#commercial').val(value2);
            });
            $('#commercial').on('change', function(){
                var value2 =  parseInt($(this).val()) || 0;
                var value1 = 100 - value2;

                $('#residential').val(value1);
            });

            $('#newConstruction').on('change', function(){
               var value1 = parseInt($(this).val()) || 0;
               var value2 = 100 - value1;

               $('#repair').val(value2);
            });


            $('#repair').on('change', function(){
                var value2 = parseInt($(this).val()) || 0;
                var value1 = 100 - value2;

                $('#newConstruction').val(value1);
            });

            $('#multipleStateWork').on('change', function(){
                if($(this).is(':checked')){
                   $('#dataModal').modal('show');
                }else{

                }

            });


            var rowCounter = 1;
            var maxPercentage = 100;

            // Function to recalculate total percentage
            function recalculatePercentages() {
                var totalPercentage = 0;

                $('.percentageInput').each(function() {
                    var percentage = parseInt($(this).val()) || 0;
                    totalPercentage += percentage;
                });

                $('#totalPercentage').text(totalPercentage);
            }

            // if ($('#nextButton').is(':disabled')) {
            //     // Replace the Next button with the Submit button
            //     console.log('this test the disable');
            //     $('#nextButtonContainer').hide();
            //     $('#submitButton').parent().show();
            // }



            // Add Row button click event
            $('#addRowButton').on('click', function() {
                var totalPercentage = parseInt($('#totalPercentage').text()) || 0;
                var remainingPercentage = maxPercentage - totalPercentage;
                // if (remainingPercentage <= 0) {
                //     alert('Total percentage has reached 100%. Cannot add more rows.');
                //     return;
                // }

                var newRow = `
                <tr id="row${rowCounter}" class="dynamic-row">
                    <td>
                        <select name="statesDropdown[${rowCounter}][state]" class="form-control statesDropdown">
                            <option value="">Select a state</option>
                            <option value="ALL">ALL</option>
                            @foreach ($states as $state)
                            <option value="{{ $state }}">{{ $state }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                      <div class="input-group">
                        <input class="form-control percentageInput" type="number" value="0" name="statePercentage[${rowCounter}][percentage]">
                            <div class="input-group-append">
                                <span class="input-group-text">%</span>
                            </div>
                      </div>
                   </td>
                    <td>
                        <button class="btn btn-danger removeRowButton">Remove</button>
                    </td>
                </tr>
            `;

                $('#dynamicAddRemove tbody').append(newRow);
                rowCounter++;

                recalculatePercentages();

            });


            // Remove Row button click event
            $(document).on('click', '.removeRowButton', function() {
                $(this).closest('tr').remove();
                recalculatePercentages();
            });

            $('#progress-bank-detail').on('click', function(){
                console.log('this test the progress-bank-detail');
                var activeStep = $('.nav-link.active').attr('href');
                if(activeStep == '#progress-bank-detail'){
                    $('#nextButtonContainer').hide();
                    $('#submitButtonContainer').show();
                }
                if(activeStep == '#progress-company-document'){
                    $('#nextButtonContainer').show();
                    $('#submitButtonContainer').hide();
                }
                if(activeStep == '#progress-company-document'){
                    $('#nextButtonContainer').show();
                    $('#submitButtonContainer').hide();
                }
            });
            $('#progress-bank-detail').on('click', function(){
                console.log('this test the progress-bank-detail');
                var activeStep = $('.nav-link.active').attr('href');
                if(activeStep == '#progress-bank-detail'){
                    $('#nextButtonContainer').hide();
                    $('#submitButtonContainer').show();
                }
                if(activeStep == '#progress-company-document'){
                    $('#nextButtonContainer').show();
                    $('#submitButtonContainer').hide();
                }
                if(activeStep == '#progress-company-document'){
                    $('#nextButtonContainer').show();
                    $('#submitButtonContainer').hide();
                }
            });

            $('#progress-bank-detail').on('click', function(){
                console.log('this test the progress-bank-detail');
                var activeStep = $('.nav-link.active').attr('href');
                if(activeStep == '#progress-bank-detail'){
                    $('#nextButtonContainer').hide();
                    $('#submitButtonContainer').show();
                }
                if(activeStep == '#progress-company-document'){
                    $('#nextButtonContainer').show();
                    $('#submitButtonContainer').hide();
                }
                if(activeStep == '#progress-company-document'){
                    $('#nextButtonContainer').show();
                    $('#submitButtonContainer').hide();
                }
            });




            //event for showing the multiple state work
            $('#dataModal').on('show.bs.modal', function(){
                var storedData = localStorage.getItem('formData');
                var formData = JSON.parse(storedData);
                var propertyNames = Object.keys(formData);

                var rowProperties = propertyNames.filter(function(propertyName) {
                    return propertyName.startsWith('statesDropdown[') && propertyName.endsWith('][state]');
                });

                var rowCount = rowCounter;
                    var newRow = `
                <tr id="row${rowCounter}" class="dynamic-row">
                    <td>
                        <select name="statesDropdown[${rowCounter}][state]" class="form-control statesDropdown">
                            <option value="">Select a state</option>
                            <option value="ALL">ALL</option>
                            @foreach ($states as $state)
                    <option value="{{ $state }}">{{ $state }}</option>
                            @endforeach
                    </select>
                </td>
                <td>
                  <div class="input-group">
                    <input class="form-control percentageInput" type="number" value="0" name="statePercentage[${rowCounter}][percentage]">
                            <div class="input-group-append">
                                <span class="input-group-text">%</span>
                            </div>
                      </div>
                   </td>
                    <td>
                        <button class="btn btn-danger removeRowButton">Remove</button>
                    </td>
                </tr>
            `;
                    console.log(rowCount);
                if(rowCount >= 1) {
                    for (var i = 1; i <= rowCount; i++) {
                        $('#dynamicAddRemove tbody').append(newRow);
                    }
                }


                for (var i = 0; i <= rowCount; i++) {
                    var state = formData[`statesDropdown[${i}][state]`];
                    var percentage = formData[`statePercentage[${i}][percentage]`];



                    if (state || percentage) {
                        $('[name="statesDropdown[' + i + '][state]"]').val(state);
                        $('[name="statePercentage[' + i + '][percentage]"]').val(percentage);

                    }
                }
            });



            // Form submission event
            $('#dataModalForm').on('submit', function(e) {
                e.preventDefault();


                // if (totalPercentage !== 100) {
                //     alert('Total percentage should be 100%. Please adjust the percentages.');
                //     return;
                // }

                // Perform form submission
                // Uncomment the following line when you are ready to submit the form
                // $(this).unbind('submit').submit();
            });

            $('#dataModal').on('submit', function (e) {
                e.preventDefault();
            });


            $('#dataModal').on('hidden.bs.modal', function() {
                var formData = $('#dataModalForm').serializeArray();
                var dataObject = {};

                $.each(formData, function(index, field){
                    dataObject[field.name]  = field.value;
                });
                localStorage.setItem('formData', JSON.stringify(dataObject));

                var dynamicRowQuantity = rowCounter - 1;

                if(dynamicRowQuantity >= 1){
                    $('#dynamicAddRemove tbody tr').slice(dynamicRowQuantity).remove();
                }else{
                    console.log(dynamicRowQuantity);
                }

                // $('#dynamicAddRemove tbody').empty();
            });




        });
    </script>

@endsection
