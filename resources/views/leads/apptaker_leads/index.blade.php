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

                                    <div class="col-4">
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
                                    <div class="col-4">
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
                                    <div class="col-4">
                                        <div class="mb-3">
                                            <div class="form-group">
                                                <label class="form-label">Class Code</label>
                                                <select name="classCode" id="classCodeLeadDropdown" class="form-control select2" >

                                                    <option value="">Select Classcode</option>
                                                    <option value="">ALL</option>
                                                    @foreach($classCodeLeads as $classCodeLead)
                                                        <option value="{{ $classCodeLead->name }}">{{ $classCodeLead->name }}</option>
                                                    @endforeach

                                                </select>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                            
                                <thead>
                                    <tr>
                                        <th>Company Name</th>
                                        <th>Tel Num</th>
                                        <th>Class Code</th>
                                        <th>State Abbr</th>
                                        <th>Disposition</th>
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
        <div class="modal fade bs-example-modal-center" id="callbackModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="mySmallModalLabel">Call back</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-3">
                                <label for="example-datetime-local-input" class="col-form-label">Date and time</label>
                            </div>
                            <div class="col-9">
                                <input class="form-control" type="datetime-local" value="2011-08-19T13:45:00" id="example-datetime-local-input">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <label>Remarks</label>
                                <div>
                                    <textarea required class="form-control" rows="5"></textarea>
                                </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-success waves-effect waves-light">Submit</button>
                        <button type="button" class="btn btn-light waves-effect" data-bs-dismiss="modal">Close</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    </div>



{{-- //scripts for forms etc--}}
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
                    d.website_originated = $('#websiteOriginatedDropdown').val(),
                    d.classCodeLead = $('#classCodeLeadDropdown').val(),
                    d.states = $('#statesDropdown').val()
                }
            },
            columns: [
                {data: 'company_name_action', name: 'company_name_action'},
                {data: 'tel_num', name: 'tel_num'},
                {data: 'class_code', name: 'class_code'},
                {data: 'state_abbr', name: 'state_abbr'},
                {data: 'dispositions', name:'dispositions'},
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
        
        $('#classCodeLeadDropdown').on('change', function () {
             var classCodeLead = $(this).val();
             $('#datatable').DataTable().ajax.reload();
        });

        $('#statesDropdown').on('change', function (){
            $('#datatable').DataTable().ajax.reload();
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
 

  
        $(document).on('change', '[id^="dispositionDrodown"]', function(e){
            var dropdownId = $(this).attr('id')
            var rowId = dropdownId.replace('dispositionDropdown', '');
            var selectedDisposition = $(this).val();
            if(selectedDisposition == '2'){
                $('#callbackModal').modal('show');
            }
        });
       
   

        $(document).on('click', '[id^="companyLink"]', function(e){
            var rowId = $(this).data('id');
            var dropDown = $('select[data-row="'+rowId+'"]');
            var selectedDisposition = dropDown.val();

            if(selectedDisposition == 1){
                e.preventDefault();
                $('#leadsDataModal').modal('show');
            }
          
        });

    });
</script>

@endsection
