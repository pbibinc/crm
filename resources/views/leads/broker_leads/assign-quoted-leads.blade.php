@extends('admin.admin_master')
@section('admin')
<div class="page-content pt-6">
    <div class="container-fluid">
        <div class="row">
            <div class="col-8">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-2">
                            <h4 class="card-title mb-4">LIST OF QUOTED LEADS</h4>
                        </div>
                        <table id="assignQoutedLeadsTable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Company Name</th>
                                    <th>Product</th>
                                    <th>Quoted By</th>
                                    <th>Sent Out Date</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-6">
                                <label for="filterBy" class="form-label">Broker Assitant:</label>
                                <select id="brokerFeeDropDown" class="form-select">
                                    <option value="">Select Market Specialist</option>
                                    @foreach ($userProfile->brokerAssistant() as $broker)
                                    <option value="{{ $broker->id }}">{{ $broker->fullAmericanName() }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-6">
                                <label for="filterBy" class="form-label">Agents:</label>
                                <select id="agentDropdown" class="form-select">
                                    <option value="">Select Market Specialist</option>
                                    @foreach ($userProfile->userProfiles() as $userProfile)
                                    <option value="{{ $userProfile->id }}">{{ $userProfile->fullAmericanName() }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-6">
                                <button type="button" id="assignQuotedLead" class="btn btn-primary waves-effect waves-light " data-bs-toggle="tooltip" data-bs-placement="top" title="Button to assign checked Leads to a selected user">Assign Lead</button>
                            </div>
                            <div class="col-6">
                                <button type="button" id="assign" class="btn btn-primary waves-effect waves-light " data-bs-toggle="tooltip" data-bs-placement="top" title="Button to assign checked Leads to a selected user">Assign Lead</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready( function () {
        $('#assignQoutedLeadsTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('get-quoted-product') }}",
            },
            columns: [
                {data: 'checkBox', name: 'checkBox'},
                {data: 'lead', name: 'lead'},
                {data: 'product', name: 'product'},
                {data: 'market_specialist', name: 'market_specialist'},
                {
                    data: 'formatted_sent_out_date',
                    name: 'formatted_sent_out_date',
                    orderable: false,
                    searchable: false
                },

            ]
        });

        $('#assignQuotedLead').on('click', function(){
            var idsArr = [];
            var marketSpecialistUserProfileId = $('#brokerFeeDropDown').val();
            var agentUserProfileId = $('#agentDropdown').val();

            $(".checkBox:checked").each(function(){
                idsArr.push($(this).val());
            });

            if(idsArr.length <=0)
            {
                alert("Please select atleast one record to assign.");
            }  else {

                if(confirm("Are you sure you want to assign these leads?")){
                    $.ajax({
                        url: "{{ route('assign-broker-assistant') }}",
                        headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        method: "POST",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            ids: idsArr,
                            marketSpecialistUserProfileId: marketSpecialistUserProfileId,
                            agentUserProfileId: agentUserProfileId
                        },
                        success: function(response){
                          Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Leads assigned successfully',
                            showConfirmButton: false,
                            timer: 1500
                          })
                        },
                        error: function (data) {
                            // alert(data);
                        }
                    });
                }
            }
        });

    });
</script>
@endsection
