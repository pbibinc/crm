@extends('admin.admin_master')
@section('admin')
    <div class="page-content pt-6">
        <link rel="stylesheet" href="{{ asset('backend/assets/libs/twitter-bootstrap-wizard/prettify.css') }}">
        <div class="container-fluid">
            <div class="row">
                <div class="row">
                    <div class="col-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <p class="text-truncate font-size-14 mb-2">Total Appointed Leads</p>
                                        <h4 class="mb-2">{{ isset($dataCount) ? count($dataCount) : 0 }}</h4>
                                        <p class="text-muted mb-0"><span class="text-success fw-bold font-size-12 me-2"><i
                                                    class="ri-arrow-right-up-line me-1 align-middle"></i>9.23%</span>from
                                            previous period</p>
                                    </div>
                                    <div class="avatar-sm">
                                        <span class="avatar-title bg-light text-primary rounded-3">
                                            <i class="mdi mdi-account-check font-size-24 "></i>
                                        </span>
                                    </div>
                                </div>
                            </div><!-- end cardbody -->
                        </div>
                    </div>

                    <div class="col-3">
                        <div class="card bg-success">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <p class="text-truncate font-size-14 mb-2 text-white">Total Assigned Lead</p>
                                        <h4 class="mb-2 text-white"><span id="dataCount"></span></h4>
                                        <p class="text-white mb-0">
                                            <span class="text-light fw-bold font-size-12 me-2">
                                                <i class="mdi mdi-account-arrow-left"></i>9.23%

                                            </span>
                                            from previous period
                                        </p>
                                    </div>
                                    <div class="avatar-sm">
                                        <span class="avatar-title bg-light text-primary rounded-3">
                                            <i class="mdi mdi mdi-account-arrow-left font-size-24"
                                                style="color: #28a745;"></i>
                                        </span>
                                    </div>
                                </div>
                            </div><!-- end card-body -->
                        </div>
                    </div>

                    <div class="col-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <p class="text-truncate font-size-14 mb-2">Call Back</p>
                                        <h4 class="mb-2">21</h4>
                                        <p class="text-muted mb-0"><span class="text-success fw-bold font-size-12 me-2"><i
                                                    class="ri-arrow-right-up-line me-1 align-middle"></i>9.23%</span>from
                                            previous period</p>
                                    </div>
                                    <div class="avatar-sm">
                                        <span class="avatar-title bg-light text-primary rounded-3">
                                            <i class="ri-phone-line font-size-24"></i>
                                        </span>
                                    </div>
                                </div>
                            </div><!-- end cardbody -->
                        </div>
                    </div>

                    <div class="col-3">
                        <div class="card bg-info text-white-50">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <p class="text-truncate font-size-14 mb-2">Total Sales Per Month</p>
                                        <h4 class="mb-2">200</h4>
                                        <p class="text-muted mb-0"><span class="text-success fw-bold font-size-12 me-2"><i
                                                    class="ri-arrow-right-up-line me-1 align-middle"></i>9.23%</span>from
                                            previous period</p>
                                    </div>
                                    <div class="avatar-sm">
                                        <span class="avatar-title bg-light text-primary rounded-3">
                                            <i class="ri-shopping-cart-2-line font-size-24"></i>
                                        </span>
                                    </div>
                                </div>
                            </div><!-- end cardbody -->
                        </div>
                    </div>
                </div>

                <div class="col-xl-12">
                    <div class="card"
                        style="box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05); border-radius: 10px; overflow: hidden;">
                        <div class="card-body">
                            <table id="leadsApptakerDataTable" class="table table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <div class="row">

                                    <div class="col-3">
                                        <div class="mb-3">
                                            <div class="form-group">
                                                <label class="form-label">Time Zone</label>
                                                <select name="timezone" id="timezoneDropdown" class="form-control select2">
                                                    <option value="">Select a timezone</option>
                                                    @foreach ($timezones as $timezone => $identifier)
                                                        <option value="{{ $timezone }}">{{ $timezone }}</option>
                                                    @endforeach

                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-3">
                                        <div class="mb-3">
                                            <div class="form-group">
                                                <label for="" class="form-label">Select States</label>
                                                <select name="states" id="statesDropdown" class="form-control select2">
                                                    <option value="">Select States</option>
                                                    <option value="">ALL</option>
                                                    <option value="AL">Alabama</option>
                                                    <option value="AK">Alaska</option>
                                                    <option value="AZ">Arizona</option>
                                                    <option value="AR">Arkansas</option>
                                                    <option value="CA">California</option>
                                                    <option value="CO">Colorado</option>
                                                    <option value="CT">Connecticut</option>
                                                    <option value="DE">Delaware</option>
                                                    <option value="FL">Florida</option>
                                                    <option value="GA">Georgia</option>
                                                    <option value="HI">Hawaii</option>
                                                    <option value="ID">Idaho</option>
                                                    <option value="IL">Illinois</option>
                                                    <option value="IN">Indiana</option>
                                                    <option value="IA">Iowa</option>
                                                    <option value="KS">Kansas</option>
                                                    <option value="KY">Kentucky</option>
                                                    <option value="LA">Louisiana</option>
                                                    <option value="ME">Maine</option>
                                                    <option value="MD">Maryland</option>
                                                    <option value="MA">Massachusetts</option>
                                                    <option value="MI">Michigan</option>
                                                    <option value="MN">Minnesota</option>
                                                    <option value="MS">Mississippi</option>
                                                    <option value="MO">Missouri</option>
                                                    <option value="MT">Montana</option>
                                                    <option value="NE">Nebraska</option>
                                                    <option value="NV">Nevada</option>
                                                    <option value="NH">New Hampshire</option>
                                                    <option value="NJ">New Jersey</option>
                                                    <option value="NM">New Mexico</option>
                                                    <option value="NY">New York</option>
                                                    <option value="NC">North Carolina</option>
                                                    <option value="ND">North Dakota</option>
                                                    <option value="OH">Ohio</option>
                                                    <option value="OK">Oklahoma</option>
                                                    <option value="OR">Oregon</option>
                                                    <option value="PA">Pennsylvania</option>
                                                    <option value="RI">Rhode Island</option>
                                                    <option value="SC">South Carolina</option>
                                                    <option value="SD">South Dakota</option>
                                                    <option value="TN">Tennessee</option>
                                                    <option value="TX">Texas</option>
                                                    <option value="UT">Utah</option>
                                                    <option value="VT">Vermont</option>
                                                    <option value="VA">Virginia</option>
                                                    <option value="WA">Washington</option>
                                                    <option value="WV">West Virginia</option>
                                                    <option value="WI">Wisconsin</option>
                                                    <option value="WY">Wyoming</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-3">
                                        <div class="mb-3">
                                            <div class="form-group">
                                                <label class="form-label">Class Code</label>
                                                <select name="classCode" id="classCodeLeadDropdown"
                                                    class="form-control select2">
                                                    <option value="">Select Classcode</option>
                                                    <option value="">ALL</option>
                                                    @foreach ($classCodeLeads as $classCodeLead)
                                                        <option value="{{ $classCodeLead->name }}">
                                                            {{ $classCodeLead->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-3">
                                        <div class="mb-3">
                                            <div class="form-group">
                                                <label for="leadTypeDropdown" class="form-label">Leads Type</label>
                                                <select name="lead_type" id="leadTypeDropdown"
                                                    class="form-control select2">
                                                    <option value="">Select a Leads Type</option>
                                                    <option value="">ALL</option>
                                                    <option value="2">Prime Lead</option>
                                                    <option value="1">Normal Lead</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <thead style="background-color: #f0f0f0;">
                                    <tr>
                                        <th>Company Name</th>
                                        <th>Tel Num</th>
                                        <th>Class Code</th>
                                        <th>State Abbr</th>
                                        {{-- <th>Disposition</th> --}}
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
        @include('leads.apptaker_leads.assign-questionare')

        <!--Modal for Call Back Disposition-->
        <div class="modal fade bs-example-modal-center" id="callbackModal" tabindex="-1" role="dialog"
            aria-labelledby="mySmallModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="mySmallModalLabel">Call back</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <form action="">
                            <div class="row">
                                <div class="col-3">
                                    <label for="example-datetime-local-input" class="col-form-label">Date and time</label>
                                </div>
                                <div class="col-9">
                                    <input class="form-control" type="datetime-local" id="callBackDateTime"
                                        name="callBackDateTime">
                                </div>
                            </div>
                            <div class="row mt-3">
                                <label>Remarks</label>
                                <div>
                                    <textarea required class="form-control" rows="5" id="callBackRemarks"></textarea>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-success waves-effect waves-light callbackDispoSubmitButton"
                            id="callbackDispoSubmitButton">Submit</button>
                        <button type="button" class="btn btn-light waves-effect" data-bs-dismiss="modal">Close</button>
                    </div>

                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->


        <!--Modal for GateKeeper Disposition-->
        <div class="modal fade bs-example-modal-center" id="gateKeeperModal" tabindex="-1" role="dialog"
            aria-labelledby="mySmallModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="mySmallModalLabel">Call Back Schedule</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-3">
                                <label for="example-datetime-local-input" class="col-form-label">Date and time</label>
                            </div>
                            <div class="col-9">
                                <input class="form-control" type="datetime-local" id="callBackDateTime">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <label>Remarks</label>
                            <div>
                                <textarea required class="form-control" id="callBackRemarks" rows="5"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-success waves-effect waves-light callbackDispoSubmitButton"
                            id="callbackDispoSubmitButton">Submit</button>
                        <button type="button" class="btn btn-light waves-effect" data-bs-dismiss="modal">Close</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <!--Modal for No transaction Disposition-->
        <div class="modal fade bs-example-modal-center" id="transactionLogModal" tabindex="-1" role="dialog"
            aria-labelledby="mySmallModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="mySmallModalLabel">Dispositions</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="mb-3">
                                <div class="form-group">
                                    <label class="form-label">Disposition</label>
                                    <select name="timezone" id="dispositionDropDown" class="form-control">
                                        <option value="">Select Disposition</option>

                                        @foreach ($dispositions as $disposition)
                                            <option value="{{ $disposition->id }}">{{ $disposition->name }}</option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="row mt-3">
                            <label>Remarks</label>
                            <div>
                                <textarea required class="form-control" rows="5" id="remarksDescription"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-success waves-effect waves-light "
                            id="submitRemarks">Submit</button>
                        <button type="button" class="btn btn-light waves-effect" data-bs-dismiss="modal">Close</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->



        <script src="{{ asset('backend/assets/libs/twitter-bootstrap-wizard/jquery.bootstrap.wizard.min.js') }}"></script>
        <script src="{{ asset('backend/assets/libs/twitter-bootstrap-wizard/prettify.js') }}"></script>
        <script src="{{ asset('backend/assets/js/pages/form-wizard.init.js') }}"></script>
        <script src="{{ asset('backend/assets/js/pages/form-mask.init.js') }}"></script>
        <script src="{{ asset('backend/assets/libs/inputmask/jquery.inputmask.min.js') }}"></script>
        <script>
            $(document).ready(function() {
                $('#leadsApptakerDataTable').DataTable({
                    processing: true,
                    serverSide: true,
                    searching: true,
                    // scrollY: 500,
                    // scrollX: true,
                    ajax: {
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: "{{ route('apptaker-leads') }}",
                        data: function(d) {
                            d.website_originated = $('#websiteOriginatedDropdown').val(),
                                d.classCodeLead = $('#classCodeLeadDropdown').val(),
                                d.states = $('#statesDropdown').val(),
                                d.leadType = $('#leadTypeDropdown').val()
                        },
                        dataSrc: function(json) {
                            $('#dataCount').html(json.totalDataCount ? json.totalDataCount : 0);
                            return json.data;
                        }
                    },
                    columns: [{
                            data: 'company_name_action',
                            name: 'company_name_action',
                            render: function(data, type, row) {
                                if (row.prime_lead == 2) {
                                    return '<div class="d-flex justify-content-between">' + data +
                                        '<i class="far fa-gem"></i></div>'
                                } else {
                                    return data;
                                }
                            }
                        },
                        {
                            data: 'tel_num',
                            name: 'tel_num'
                        },
                        {
                            data: 'class_code',
                            name: 'class_code'
                        },
                        {
                            data: 'state_abbr',
                            name: 'state_abbr'
                        },
                        // {data: 'dispositions', name:'dispositions'},
                        // {data: 'website_originated', name: 'website_originated', searchable:false},

                    ]
                });

                // $('#openFormLinkButton').on('click', function(e) {
                //     window.open("http://localhost:3000/appointed-lead-questionare", "_blank",
                //         "width=400,height=800");
                // });

                // scripts for reloading and configuring the dropdowns filters
                $('#websiteOriginatedDropdown').on('change', function() {
                    $('#leadsApptakerDataTable').DataTable().ajax.reload();
                });

                $('#timezoneDropdown').on('change', function() {
                    var timezone = $(this).val();
                    $('#leadsApptakerDataTable').DataTable().ajax.url(
                        "{{ route('apptaker-leads') }}?timezone=" + timezone).load();
                });
                $('#companyLink').on('click', function() {
                    console.log('test')
                });

                $('#classCodeLeadDropdown').on('change', function() {
                    var classCodeLead = $(this).val();
                    $('#leadsApptakerDataTable').DataTable().ajax.reload();
                });

                $('#statesDropdown').on('change', function() {
                    $('#leadsApptakerDataTable').DataTable().ajax.reload();
                });

                $('#dataModal').on('submit', function(e) {
                    e.preventDefault();
                });

                $('#leadTypeDropdown').on('change', function() {
                    $('#leadsApptakerDataTable').DataTable().ajax.reload();
                });

                $(document).on('change', '#dispositionDropDown', function(e) {
                    var dropdownId = $(this).attr('id')
                    var rowId = dropdownId.replace('dispositionDropDown', '');
                    var selectedDisposition = $(this).val();
                    var url = "{{ env('APP_FORM_URL') }}";
                    if (selectedDisposition == '1') {
                        $.ajax({
                            url: "{{ route('list-lead-id') }}",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            dataType: 'json',
                            method: 'POST',
                            data: {
                                leadId: leadsId
                            },
                            success: function(response) {
                                window.open(`${url}appoinnted-lead-questionare`,
                                    "s_blank",
                                    "width=1000,height=849");
                                $('#transactionLogModal').modal('hide');
                            }
                        });
                    }
                    if (selectedDisposition == '2') {
                        $('#callbackModal').modal('show');
                        $('#transactionLogModal').modal('hide');
                    }

                    if (selectedDisposition == '6') {
                        $('#callbackModal').modal('show');
                        $('#transactionLogModal').modal('hide');
                    }

                    if (selectedDisposition == '11') {
                        $('#callbackModal').modal('show');
                        $('#transactionLogModal').modal('hide');
                    }

                    if (selectedDisposition == '12') {
                        $('#callbackModal').modal('show');
                        $('#transactionLogModal').modal('hide');
                    }

                    // if (selectedDisposition == '13') {
                    //     $('#transactionLogModal').modal('hide');
                    // }
                    var remarks = $('#remarksDescription').val();
                    $.ajax({
                        url: "{{ route('list-lead-id') }}",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        dataType: 'json',
                        method: 'POST',
                        data: {
                            dispositionId: selectedDisposition,
                            remarks: remarks,
                            leadId: leadsId
                        },
                        success: function(response) {}
                    });
                });

                $('.callbackDispoSubmitButton').on('click', function(e) {
                    e.preventDefault();
                    var dateTime = $('#callBackDateTime').val();
                    var callBackRemarks = $('#callBackRemarks').val();
                    var dispositionId = $('#dispositionDropDown').val();
                    var leadId = $('#leadId').val();
                    $.ajax({
                        url: "{{ route('call-back.store') }}",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        dataType: 'json',
                        method: 'POST',
                        data: {
                            dateTime: dateTime,
                            callBackRemarks: callBackRemarks,
                            type: dispositionId,
                            leadId: leadsId,
                            status: 1
                        },
                        success: function(response) {
                            location.reload();
                            console.log('test this code')
                            $('#transactionLogModal').modal('hide');
                        },
                        error: function(xhr, status, error) {
                            alert("please call your it for better assistance");
                        }
                    });
                });

                $('#transactionLogModal').on('hidden.bs.modal', function() {
                    $('#dispositionDropDown').val('');
                    $('#remarksDescription').val('');
                });

            });



            $('#submitRemarks').on('click', function(e) {
                e.preventDefault();
                var remarks = $('#remarksDescription').val();
                var dispositionId = $('#dispositionDropDown').val();
                var url = "{{ env('APP_FORM_URL') }}";
                var leadId = $('#leadId').val();
                if (leadId == 1) {
                    window.open(`${url}appoinnted-lead-questionare`,
                        "s_blank",
                        "width=1000,height=849");
                    $('#transactionLogModal').modal('hide');
                } else {
                    $.ajax({
                        url: "{{ route('assign-remark-leads') }}",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        dataType: 'json',
                        method: 'POST',
                        data: {
                            remarks: remarks,
                            dispositionId: dispositionId,
                            leadId: leadsId
                        },
                        success: function(response) {
                            $('#transactionLogModal').modal('hide');
                            location.reload();
                        },
                        error: function(xhr, status, error) {
                            alert(xhr.responseText);
                        }
                    });
                }
            });
        </script>
    @endsection
