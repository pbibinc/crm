@extends('admin.admin_master')
@section('admin')
    <div class="page-content pt-6">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <form action="{{ route('leads.import') }}" method="POST" id="import-form" enctype="multipart/form-data">
                                        @csrf
                                        <input type="file" name="file" class="form-control">
                                        <br>
                                        <button id="import-button" class="btn btn-primary">Import Leads Data</button>
                                    </form>
                                </div>
                                @if(session('success'))
                                 <script>
                                    Swal.fire({
                                        title: "Success",
                                        text:"{{ session('success') }}",
                                        icon: "success",
                                        button: "OK",
                                    });
                                 </script>
                                @endif
                                <div class="col-6">
                                    <div class="row">

                                        <div class="col-lg-6">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="d-flex">
                                                        <div class="flex-grow-1">
                                                            <p class="text-truncate font-size-14 mb-2">New Leads</p>
                                                            <h4 class="mb-2" style="color:#ffc107;">{{$newLeadsCount}}</h4>
                                                            <p class="text-muted mb-0"><span class="text-success fw-bold font-size-12 me-2"><i class="mdi mdi-account-hard-hat me-3"></i>9.23%</span>from previous period</p>
                                                        </div>
                                                        <div class="avatar-sm">
                                                            <span class="avatar-title bg-light text-primary rounded-3">
                                                                <i class="mdi mdi-account-hard-hat font-size-24 " style="color: #ffc107;"></i>
                                                                {{-- <i class="ri-shopping-cart-2-line font-size-24"></i>   --}}
                                                            </span>
                                                        </div>
                                                    </div>                                            
                                                </div><!-- end cardbody -->
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="card bg-info text-white-50">
                                                <div class="card-body">
                                                    <div class="d-flex">
                                                        <div class="flex-grow-1">
                                                            <p class="text-truncate font-size-14 mb-2" style="color:white">Assign Lead</p>
                                                            <h4 class="mb-2" style="color:white">{{$assignLeadsCount}}</h4>
                                                            <p class="text-muted mb-0"><span class="{{ $assignData['textClass'] }} fw-bold font-size-12 me-2"><i class="{{ $assignData['arrowClass'] }} me-1 align-middle"></i>{{ $assignData['unassignedPercentage'] }}%</span><span style="color: white;">{{ $assignData['message'] }}</span></p>
                                                        </div>
                                                        <div class="avatar-sm">
                                                            <span class="avatar-title bg-light text-primary rounded-3">
                                                                <i class="mdi mdi-headset font-size-24" style="color: #17a2b8;"></i>
                                                            </span>
                                                        </div>
                                                    </div>                                            
                                                </div><!-- end cardbody -->
                                            </div>
                                        </div>
                                        
                                 </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-auto m-lg-1">
                                        <a href="" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addLeadsModal" id="create_record">
                                            ADD LEADS
                                        </a>
                                    </div>
                                </div>
                                <br>
                                    <div class="table-responsive">
                                        <table class="table table-bordered dt-responsive nowrap" id="dataTable" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Company Name</th>
                                                <th>Tel Number</th>
                                                <th>State abbr</th>
                                                <th>Class Code</th>
                                                <th>Website Originated</th>
                                                <th>Status</th>
                                                <th>Imported at</th>
{{--                                                <th>Updated at</th>--}}
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
                                    <input type="text" class="form-control" id="companyName" name="companyName" autocomplete="off" required>
                                </div>

                                <div class="mb-3">
                                    <label for="name" class="form-label">Tel Num</label>
                                    <input type="text" class="form-control" id="telNum" name="telNum" data-parsley-length="[10,10]" data-parsley-pattern="^[0-9]*$" placeholder="Min 10 chars." autocomplete="off" required>
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
                                    <select name="\" id="leadTypeDropdown" class="form-control">
                                        <option value="">Select Lead Class</option>
                                        <option value="">ALL</option>
                                        <option value="2">Prime</option>
                                        <option value="1">Normal</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="name" class="form-label">State Abbreviation</label>
                                    <input type="text" class="form-control" id="stateAbbreviation" name="stateAbbreviation" data-parsley-length="[2, 2]" autocomplete="off" required>
                                </div>

                                <div class="mb-3">
                                    <label for="name" class="form-label">Website Originated</label>
                                    <input type="text" class="form-control" id="websiteOriginated" name="websiteOriginated" autocomplete="off" required>
                                </div>

                                <input type="hidden" name="action" id="action" value="add">
                                <input type="hidden" name="hidden_id" id="hidden_id" />

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <input type="submit" name="action_button" id="action_button" value="Add" class="btn btn-primary">
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script>
    // DATA TABLE
    $(document).ready(function() {
        $('.select2').select2();
        $('#dataTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('leads') }}",
            columns: [
                {data: 'id', name: 'id'},
                {data: 'company_name', name: 'company_name'},
                {data: 'tel_num', name: 'tel_num'},
                {data: 'state_abbr', name: 'state_abbr'},
                {data: 'class_code', name: 'class_code'},
                {data: 'website_originated', name: 'website_originated'},
                {
                    data: 'status',
                    name: 'status',
                    render: function (data, type, row) {
                        switch (data){
                            case 1: return 'New Leads';
                            case 2:
                                if (row.user_profile && row.user_profile.firstname) {
                                    let firstNameInitial = row.user_profile.firstname.charAt(0).toUpperCase();
                                    return 'Assign to ' + row.user_profile.position.name + ' ' + firstNameInitial + '. ' + row.user_profile.american_surname;
                                } else {
                                    return ''; // Handle the case when user_profile or firstname is null
                                }
                            case 3: return ''
                        }
                    }
                },
                {data: 'created_at_formatted', name: 'created_at', searchable:false},
                // {data: 'updated_at_formatted', name: 'updated_at', searchable:false},
                // {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
        $('#leadsForm').parsley();
        $('#leadsForm').on('submit', function(e){
            e.preventDefault();
            if($('#leadsForm').parsley().isValid()){
               $.ajax({
                   type: 'POST',
                   headers: {'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')},
                   url: "{{ route('leads.store') }}",
                   data:$(this).serialize(),
                   success: function(response){
                       Swal.fire({
                           title: 'Success',
                           text: response.success,
                           icon: 'success'
                       }).then(function() {
                           location.reload();
                       });
                   },
                   error: function(xhr){
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
            }else{
                console.log('Form is not valid');
            }

        });
    });
</script>
@endsection
