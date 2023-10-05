@extends('admin.admin_master')
@section('admin')
<style>
    .permission-badge {
    margin-right: 5px;  /* adjust as needed */
    margin-bottom: 5px; /* adjust as needed */
}
</style>


<div class="page-content pt-6">
    <div class="container-fluid">
        <div class="row">
            <div class="col-6">

            </div>
        </div>
        <div class="row">
            <div class="col-8" >
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <h3 class="card-title mb-4" style="display: flex; align-items: center;">  <i class="ri-file-list-3-line font-size-24"></i> LIST OF APPOINTED LEADS</h3>
                    <div>
                        <button type="button" id="assignAppointedLead" class="btn btn-primary btn-rounded waves-effect waves-light mb-4" data-bs-toggle="tooltip" data-bs-placement="top" title="Button to assign checked Leads to a selected user">   <i class="ri-user-received-2-line"></i> Assign Lead</button>
                        <button type="button" id="assignAppointedLead" class="btn btn-light btn-rounded waves-effect waves-light mb-4" data-bs-toggle="tooltip" data-bs-placement="top" title="Button to assign checked Leads to a selected user" style="background-color: white"> <i class="ri-user-shared-2-line"></i> Reasign Lead</button>
                        <button type="button" id="assignAppointedLead" class="btn btn-outline-danger btn-rounded waves-effect waves-light mb-4" data-bs-toggle="tooltip" data-bs-placement="top" title="Button to assign checked Leads to a selected user" style="background-color: white"><i class="ri-user-unfollow-line"></i> Void Lead</button>
                    </div>

                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="row mb-2">

                        </div>

                        <div class="row">
                            <div class="col-6">

                            </div>
                        </div>
                        <table id="assignAppointedLeadsTable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>ID</th>
                                    <th>Company Name</th>
                                    {{-- <th>State</th> --}}
                                    <th>Products</th>
                                    <th>Telemarketer</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            <div class="col-4">
                <div class="row">
                    <div class="col-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <p class="text-truncate font-size-14 mb-2">Appointed Leads</p>
                                        <h4 class="mb-2">1452</h4>
                                    </div>
                                    <div class="avatar-sm">
                                        <span class="avatar-title bg-light text-primary rounded-3">
                                            <i class="ri-file-edit-line font-size-24"></i>
                                        </span>
                                    </div>
                                </div>
                            </div><!-- end cardbody -->
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card bg-info text-white-50">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <p class="text-truncate font-size-14 mb-2" style="color: white">Appointed Product</p>
                                        <h4 class="mb-2" style="color: white">1452</h4>
                                    </div>
                                    <div class="avatar-sm">
                                        <span class="avatar-title bg-light text-primary rounded-3">
                                            <i class="ri-umbrella-line font-size-24" style="color: #17a2b8;"></i>
                                        </span>
                                    </div>
                                </div>
                            </div><!-- end cardbody -->
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-6">
                                <label for="filterBy" class="form-label">Market Specialist:</label>
                                <select id="marketSpecialistDropDown" class="form-select">
                                    <option value="">Select Market Specialist</option>
                                    @foreach ($quoters as $quoter)
                                    <option value="{{ $quoter->id }}">{{ $quoter->fullAmericanName() }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-6">
                                <label for="filterBy" class="form-label">Agents:</label>
                                <select id="agentDropDown" class="form-select">
                                    <option value="">Select Agent</option>
                                    @foreach ($userProfiles as $userProfile)
                                    <option value="{{ $userProfile->id }}">{{ $userProfile->fullAmericanName() }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="row mb-4">
                            <table id="datatableLeads" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Company Name</th>
                                        <th>Tel Num</th>
                                        {{-- <th>Action</th> --}}
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function (){
        $('#assignAppointedLeadsTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('assign-appointed-lead') }}",
            columns: [
                {data: 'checkbox', name: 'checkbox'},
                {data: 'id', name: 'id'},
                {data: 'company_name', name: 'company_name'},
                // {data: 'state_abbr', name: 'state_abbr'},
                {data: 'products', name: 'products'},
                {data: 'current_user', name: 'current_user'},
            ]
        })
        $('#datatableLeads').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('get-data-table') }}",
                    data: function (f) {
                            f.marketSpecialistId = $('#marketSpecialistDropDown').val()
                            f.accountProfileId = $('#agentDropDown').val()
                    }
                },
                columns: [
                    // {data: 'checkbox', name: 'checkbox',  searchable: false},
                    // {data: 'id', name: 'id'},
                    {data: 'company_name', name: 'company_name'},
                    {data: 'tel_num', name: 'tel_num'},
                    // {data: 'state_abbr', name: 'state_abbr'},
                    // {data: 'website_originated', name: 'website_originated'},
                    // {data: 'created_at_formatted', name: 'created_at', searchable:false},
                    // {data: 'updated_at_formatted', name: 'updated_at', searchable:false},
                    // {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });
        $('#marketSpecialistDropDown').on('change', function(){
            let marketSpecialistUserProfileId = $(this).val();
            $('#datatableLeads').DataTable().ajax.reload();
            if(marketSpecialistUserProfileId != ""){
                $('#agentDropDown').prop('disabled', true);
            }else{
                $('#agentDropDown').prop('disabled', false);
            }
        });
        $('#agentDropDown').on('change', function(){
            let agentDropDownId = $(this).val();
            $('#datatableLeads').DataTable().ajax.reload();
            if(agentDropDownId != ""){
                $('#marketSpecialistDropDown').prop('disabled', true);
            }else{
                $('#marketSpecialistDropDown').prop('disabled', false);
            }
        });
        $('#assignAppointedLead').on('click', function(){
            var id = [];
            var productsArray = [];
            $('.users_checkbox:checked').each(function(){
                id.push($(this).val());
                var row = $(this).closest('tr');
                var productDiv = row.find('.product-column');
                var products = [];
                productDiv.find('h6').each(function(){
                    products.push($(this).text());
                });
                productsArray.push(products);

            });

            var marketSpecialistUserProfileId = $('#marketSpecialistDropDown').val();
            var agentUserProfileId = $('#agentDropDown').val();
            if(id.length > 0){
                if(marketSpecialistUserProfileId || agentUserProfileId)
                {
                    $.ajax({
                        url: "{{ route('assign-leads-market-specialist') }}",
                        headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        method: "POST",
                        data: {
                            id:id,
                            product:productsArray,
                            marketSpecialistUserProfileId:marketSpecialistUserProfileId, agentUserProfileId:agentUserProfileId
                        },
                        success: function(data){
                            Swal.fire({
                                title: 'Success',
                                text: 'Leads has been assigned',
                                icon: 'success'
                            });
                            $('#assignAppointedLeadsTable').DataTable().ajax.reload();
                            $('#datatableLeads').DataTable().ajax.reload();
                        },
                        error: function(data){
                            Swal.fire({
                                title: 'Error',
                                text: 'Ther is a error while assigning leads',
                                icon: 'error'
                            });
                        }
                    });
                }else{
                    Swal.fire({
                            title: 'Error',
                            text: 'Please Select Agent',
                            icon: 'error'
                        });
                }
            } else
                {
                    Swal.fire({
                        title: 'Error',
                        text: 'Please select atleast one checkbox',
                        icon: 'error'
                    });
                }
        });
    })
</script>
@endsection
