@extends('admin.admin_master')
@section('admin')
    <div class="page-content pt-6">
        <div class="container-fluid">
            <div class="row">
                <div class="col-7">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <h3 class="card-title mb-4"
                            style="display: flex; align-items: center; background-color: #2c3e50; color: #ecf0f1; padding: 10px 20px; border-radius: 5px;">
                            <i class="ri-file-list-3-line" style="font-size: 26px; margin-right: 15px;"></i>
                            <span style="font-weight: 600; letter-spacing: 1px;">LIST OF QUOTED LEADS</span>
                        </h3>
                        <div>
                            <button type="button" id="assignQuotedLead" class="btn btn-primary btn-rounded mb-4"
                                data-bs-toggle="tooltip" data-bs-placement="top"
                                title="Button to assign checked Leads to a selected user"
                                style=" 0 4px 8px rgba(0, 0, 0, 0.05);"> <i class="ri-user-received-2-line"></i> Assign
                                Lead</button>
                            <button type="button" id="reassigQoutedLead" class="btn btn-light btn-rounded mb-4"
                                data-bs-toggle="tooltip" data-bs-placement="top"
                                title="Button to reassign checked Leads to a selected user"
                                style="background-color: white; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);"> <i
                                    class="ri-user-shared-2-line"></i> Reasign Lead</button>
                            <button type="button" id="voidQuotedLeads" class="btn btn-outline-danger btn-rounded mb-4"
                                data-bs-toggle="tooltip" data-bs-placement="top" title="Button To Void Leads to a user"
                                style="background-color: white; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05); "><i
                                    class="ri-user-unfollow-line"></i> Void Lead</button>
                        </div>
                    </div>
                    <div class="card"
                        style="box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05); border-radius: 10px; overflow: hidden;">
                        <div class="card-body">
                            <table id="assignQoutedLeadsTable" class="table table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Company Name</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($groupedProducts as $companyName => $products)
                                        <tr style="background-color: #f0f0f0;">

                                            <td><strong><b>{{ $companyName }}</b></strong></td>
                                            <td><input type="checkbox" class="companyCheckBox"
                                                    data-company="{{ $companyName }}" name="company[]"></td>
                                            <td><strong><b>Product</b></strong></td>
                                            <td><strong><b>Quoted By</b></strong></td>
                                            <td><strong><b>Sent Out Date</b></strong></td>
                                        </tr>
                                        @foreach ($products as $product)
                                            <tr class="productRow {{ $companyName }}">
                                                <td></td>
                                                <td><input type="checkbox" class="productCheckBox"
                                                        data-company="{{ $companyName }}" name="quoteProduct[]"
                                                        value="{{ $product['product']->id }}"></td>
                                                <td>{{ $product['product']->product }}</td>
                                                <td>{{ $product['quoted_by'] }}</td>
                                                <td>{{ $product['product']->sent_out_date }}</td>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-5">
                    <div class="row">
                        <div class="col-6">
                            <div class="card"
                                style="box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05); border-radius: 10px; overflow: hidden;">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <p class="text-truncate font-size-14 mb-2">Pending Product</p>
                                            <h4 class="mb-2">{{ $quoationProduct->pendingProduct()->count() }}</h4>
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
                            <div class="card bg-info text-white-50"
                                style="box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05); border-radius: 10px; overflow: hidden;">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <p class="text-truncate font-size-14 mb-2" style="color: white">Qouted Product
                                            </p>
                                            <h4 class="mb-2" style="color: white">
                                                {{ $quoationProduct->quotedProduct()->count() }}</h4>
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
                    <div class="card"
                        style="box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05); border-radius: 10px; overflow: hidden;">
                        <div class="card-body" style="padding: 20px;">
                            <div class="row" style="margin-bottom: 20px;">
                                <div class="col-6">
                                    <label for="brokerAssistantDropdown" class="form-label"
                                        style="font-weight: 600; color: #34495e;">Broker Assitant:</label>
                                    <select id="brokerAssistantDropdown" class="form-select"
                                        style="border-radius: 5px; border: 1px solid #d1d9e6; padding: 8px 12px;">
                                        <option value="">Select Broker Assistant</option>
                                        @foreach ($userProfile->brokerAssistant() as $broker)
                                            <option value="{{ $broker->id }}">{{ $broker->fullAmericanName() }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-6">
                                    <label for="agentDropdown" class="form-label"
                                        style="font-weight: 600; color: #34495e;">Agents:</label>
                                    <select id="agentDropdown" class="form-select"
                                        style="border-radius: 5px; border: 1px solid #d1d9e6; padding: 8px 12px;">
                                        <option value="">Select Agent</option>
                                        @foreach ($userProfile->userProfiles() as $userProfile)
                                            <option value="{{ $userProfile->id }}">{{ $userProfile->fullAmericanName() }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card"
                        style="box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05); border-radius: 10px; overflow: hidden;">
                        <div class="card-body">
                            <div class="row mb-4">
                                <table id="datatableLeads" class="table table-bordered dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead style="background-color: #f0f0f0;">
                                        <tr>
                                            <th></th>
                                            <th>Product</th>
                                            <th>Company Name</th>
                                            {{-- <th>Action</th> --}}
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade bs-example-modal-center" tabindex="-1" role="dialog"
                aria-labelledby="mySmallModalLabel" aria-hidden="true" id="quoterDropdownModal">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Center modal</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row mb-4">
                                <div class="col-6">
                                    <label for="brokerAssistantReassignDropdown" class="form-label"
                                        style="font-weight: 600; color: #34495e;">Broker Assitant:</label>
                                    <select id="brokerAssistantReassignDropdown" class="form-select"
                                        style="border-radius: 5px; border: 1px solid #d1d9e6; padding: 8px 12px;">
                                        <option value="">Select Broker Assistant</option>
                                        @foreach ($userProfile->brokerAssistant() as $broker)
                                            <option value="{{ $broker->id }}">{{ $broker->fullAmericanName() }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-6">
                                    <label for="agentReassignDropdown" class="form-label"
                                        style="font-weight: 600; color: #34495e;">Agents:</label>
                                    <select id="agentReassignDropdown" class="form-select"
                                        style="border-radius: 5px; border: 1px solid #d1d9e6; padding: 8px 12px;">
                                        <option value="">Select Agent</option>
                                        @foreach ($userProfile->userProfiles() as $userProfile)
                                            <option value="{{ $userProfile->id }}">{{ $userProfile->fullAmericanName() }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary waves-effect"
                                data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary waves-effect waves-light"
                                id="submitQoutedReassign">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.companyCheckBox').change(function() {
                const companyName = $(this).data('company');
                const isChecked = $(this).is(':checked');
                $('.productRow.' + companyName + ' .productCheckBox').prop('checked', isChecked);
                $(".productCheckBox[data-company='" + companyName + "']").prop('checked', isChecked);
            });

            $('#brokerAssistantDropdown').on('change', function() {
                let borkerFeeUserProfileId = $(this).val();
                $('#datatableLeads').DataTable().ajax.reload();
                if (borkerFeeUserProfileId != "") {
                    $('#agentDropdown').prop('disabled', true);
                } else {
                    $('#agentDropdown').prop('disabled', false);
                }
            });

            $('#agentDropdown').on('change', function() {
                let agentDropDownId = $(this).val();
                $('#datatableLeads').DataTable().ajax.reload();
                if (agentDropDownId != "") {
                    $('#brokerAssistantDropdown').prop('disabled', true);
                } else {
                    $('#brokerAssistantDropdown').prop('disabled', false);
                }
            });

            $('#datatableLeads').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('get-assign-qouted-lead') }}",
                    data: function(d) {
                        d.brokerAssistantId = $('#brokerAssistantDropdown').val();
                        d.agentUserProfileId = $('#agentDropdown').val();
                    }
                },
                columns: [{
                        data: 'checkbox',
                        name: 'checkbox'
                    },
                    {
                        data: 'product',
                        name: 'product'
                    },
                    {
                        data: 'company_name',
                        name: 'company_name'
                    },
                ]
            });

            $('#assignQuotedLead').on('click', function() {
                var idsArr = [];
                var brokerAssistantId = $('#brokerAssistantDropdown').val();
                var agentUserProfileId = $('#agentDropdown').val();

                $(".productCheckBox:checked").each(function() {
                    idsArr.push($(this).val());
                });
                if (idsArr.length <= 0) {
                    alert("Please select atleast one record to assign.");
                } else {
                    if (brokerAssistantId || agentUserProfileId) {
                        if (confirm("Are you sure you want to assign these leads?")) {
                            $.ajax({
                                url: "{{ route('assign-broker-assistant') }}",
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                method: "POST",
                                data: {
                                    "_token": "{{ csrf_token() }}",
                                    ids: idsArr,
                                    brokerAssistantId: brokerAssistantId,
                                    agentUserProfileId: agentUserProfileId
                                },
                                success: function(response) {
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
                                error: function(data) {
                                    alert(data);
                                }
                            });
                        }
                    } else {
                        alert("Please select broker assistant or agent to assign leads.");
                    }
                }
            });

            var quotedIds = [];

            $('#voidQuotedLeads').on('click', function() {
                var userProfileId = $('#brokerAssistantDropdown').val() ? $('#brokerAssistantDropdown')
                    .val() : $('#agentDropdown').val();

                $(".leads_checkbox:checked").each(function() {
                    quotedIds.push($(this).val());
                });

                if (quotedIds.length < 0) {
                    alert("Please select atleast one record to void.");
                } else {
                    if (confirm("Are you sure you want to void these leads?")) {
                        $.ajax({
                            url: "{{ route('void-qouted-lead') }}",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            method: "POST",
                            data: {
                                "_token": "{{ csrf_token() }}",
                                ids: quotedIds,
                                userProfileId: userProfileId
                            },
                            success: function(response) {
                                Swal.fire({
                                    position: 'top-end',
                                    icon: 'success',
                                    title: 'Leads voided successfully',
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then((result) => {
                                    location.reload();
                                })
                            },
                            error: function(data) {
                                alert(data);
                            }
                        });
                    }
                }
            })

            $('#brokerAssistantReassignDropdown').on('change', function() {
                let borkerFeeUserProfileId = $(this).val();
                // $('#datatableLeads').DataTable().ajax.reload();
                if (borkerFeeUserProfileId != "") {
                    $('#agentReassignDropdown').prop('disabled', true);
                } else {
                    $('#agentReassignDropdown').prop('disabled', false);
                }
            });

            $('#agentReassignDropdown').on('change', function() {
                let agentDropDownId = $(this).val();
                // $('#datatableLeads').DataTable().ajax.reload();
                if (agentDropDownId != "") {
                    $('#brokerAssistantReassignDropdown').prop('disabled', true);
                } else {
                    $('#brokerAssistantReassignDropdown').prop('disabled', false);
                }
            });

            $('#reassigQoutedLead').on('click', function() {
                $(".leads_checkbox:checked").each(function() {
                    quotedIds.push($(this).val());
                });

                if (quotedIds <= 0) {
                    alert("Please select atleast one record to reassign.");
                } else {
                    $('#quoterDropdownModal').modal('show');;
                }

            });

            $('#submitQoutedReassign').on('click', function() {
                var userProfileId = $('#brokerAssistantReassignDropdown').val() ? $(
                    '#brokerAssistantReassignDropdown').val() : $('#agentReassignDropdown').val();
                var oldUserProfileId = $('#brokerAssistantDropdown').val() ? $('#brokerAssistantDropdown')
                    .val() : $('#agentDropdown').val();
                if (userProfileId) {
                    $.ajax({
                        url: "{{ route('redeploy-qouted-lead') }}",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        method: "POST",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            ids: quotedIds,
                            userProfileId: userProfileId,
                            oldUserProfileId: oldUserProfileId
                        },
                        success: function(response) {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'Leads reassigned successfully',
                                showConfirmButton: false,
                                timer: 1500
                            }).then((result) => {
                                location.reload();
                            })
                        },
                        error: function(data) {
                            alert(data);
                        }
                    });

                } else {
                    alert("Please select broker assistant or agent to reassign leads.");
                }
            });

        });
    </script>
@endsection
