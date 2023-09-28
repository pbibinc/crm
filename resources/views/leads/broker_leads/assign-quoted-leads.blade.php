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

                                    <th>Company Name</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($groupedProducts as $companyName => $products)
                                    <tr>

                                        <td><strong><b>{{ $companyName }}</b></strong></td>
                                        <td><input type="checkbox" class="companyCheckBox" data-company="{{ $companyName }}" name="company[]"></td>
                                        <td><strong><b>Product</b></strong></td>
                                        <td><strong><b>Quoted By</b></strong></td>
                                        <td><strong><b>Sent Out Date</b></strong></td>
                                    </tr>
                                    @foreach ($products as $product)
                                    <tr class="productRow {{ $companyName }}">
                                        <td></td>
                                        <td><input type="checkbox" class="productCheckBox"  data-company="{{ $companyName }}" name="quoteProduct[]" value="{{ $product['product']->id }}"></td>
                                        <td>{{ $product['product']->product  }}</td>
                                        <td>{{ $product['quoted_by']  }}</td>
                                        <td>{{ $product['product']->sent_out_date}}</td>
                                    </tr>
                                    @endforeach

                                @endforeach
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
                                <select id="brokerAssistantDropdown" class="form-select">
                                    <option value="">Select Broker Assistant</option>
                                    @foreach ($userProfile->brokerAssistant() as $broker)
                                    <option value="{{ $broker->id }}">{{ $broker->fullAmericanName() }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-6">
                                <label for="filterBy" class="form-label">Agents:</label>
                                <select id="agentDropdown" class="form-select">
                                    <option value="">Select Agent</option>
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
    $(document).ready(function () {
        $('.companyCheckBox').change(function(){
          const companyName = $(this).data('company');
          const isChecked = $(this).is(':checked');
          $('.productRow.' + companyName + ' .productCheckBox').prop('checked', isChecked);
          $(".productCheckBox[data-company='" + companyName + "']").prop('checked', isChecked);
        });

        $('#brokerAssistantDropdown').on('change', function(){
            let borkerFeeUserProfileId = $(this).val();
            // $('#datatableLeads').DataTable().ajax.reload();
            if(borkerFeeUserProfileId != ""){
                $('#agentDropdown').prop('disabled', true);
            }else{
                $('#agentDropdown').prop('disabled', false);
            }
        });

        $('#agentDropdown').on('change', function(){
            let agentDropDownId = $(this).val();
            // $('#datatableLeads').DataTable().ajax.reload();
            if(agentDropDownId != ""){
                $('#brokerAssistantDropdown').prop('disabled', true);
            }else{
                $('#brokerAssistantDropdown').prop('disabled', false);
            }
        });

        $('#assignQuotedLead').on('click', function(){
            var idsArr = [];
            var brokerAssistantId = $('#brokerAssistantDropdown').val();
            var agentUserProfileId = $('#agentDropdown').val();

            $(".productCheckBox:checked").each(function(){
                idsArr.push($(this).val());
            });
            if(idsArr.length <=0)
            {
               alert("Please select atleast one record to assign.");
            }  else {
                if(brokerAssistantId || agentUserProfileId)
                 {
                    if(confirm("Are you sure you want to assign these leads?")){
                    $.ajax({
                        url: "{{ route('assign-broker-assistant') }}",
                        headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        method: "POST",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            ids: idsArr,
                            brokerAssistantId: brokerAssistantId,
                            agentUserProfileId: agentUserProfileId
                        },
                        success: function(response){
                          Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Leads assigned successfully',
                            showConfirmButton: false,
                            timer: 1500
                          }).then((result) => {
                            location.reload();
                          })
                        },
                        error: function (data) {
                            alert(data);
                        }
                    });
                  }
                 }else{
                    alert("Please select broker assistant or agent to assign leads.");
                 }

            }
        });

    });
</script>
@endsection
