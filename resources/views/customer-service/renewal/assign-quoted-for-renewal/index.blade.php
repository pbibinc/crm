@extends('admin.admin_master')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-6">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <h3 class="card-title mb-4"
                            style="display: flex; align-items: center; background-color: #2c3e50; color: #ecf0f1; padding: 10px 20px; border-radius: 5px;">
                            <i class="ri-file-list-3-line" style="font-size: 26px; margin-right: 15px;"></i>
                            <span style="font-weight: 600; letter-spacing: 1px;">ASSIGN FOR QUOTE RENEWAL
                                POLICIES</span>
                        </h3>
                        <div>
                            <button type="button" id="assignPolicy"
                                class="btn btn-primary btn-rounded waves-effect waves-light mb-4" data-bs-toggle="tooltip"
                                data-bs-placement="top" title="Button to assign checked Leads to a selected user"
                                style="box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);"> <i class="ri-user-received-2-line"></i>
                                Assign Policy</button>
                            <button type="button" id="reassignAppointedLead"
                                class="btn btn-light btn-rounded waves-effect waves-light mb-4" data-bs-toggle="tooltip"
                                data-bs-placement="top" title="Button to reassign checked Leads to a selected user"
                                style="background-color: white; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);"> <i
                                    class="ri-user-shared-2-line"></i> Reasign Policy</button>
                            <button type="button" id="voidAppointedLeads"
                                class="btn btn-outline-danger btn-rounded waves-effect waves-light mb-4"
                                data-bs-toggle="tooltip" data-bs-placement="top" title="Button To Void Leads to a user"
                                style="background-color: white; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);"><i
                                    class="ri-user-unfollow-line"></i> Void Lead</button>
                        </div>

                    </div>
                    <div class="card"
                        style=" box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05); border-radius: 10px; overflow: hidden;">
                        <div class="card-body">
                            <table id="dataTable" class="table table-bordered dt-responsive nowrap" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Company Name</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($groupedPolicy as $company => $policies)
                                        <tr style="background-color: #f0f0f0;">
                                            <td><strong>{{ $company }}</strong></td>
                                            <td><input type="checkbox" class="companyCheckAllBox"
                                                    data-company="{{ $company }}" name="company[]"></td>
                                            <th>Policy Number</th>
                                            <th>Product</th>
                                            <th>Previous Policy Price</th>
                                            <th>Renewal Date</th>
                                        </tr>

                                        @foreach ($policies as $policy)
                                            <tr class="policyRow {{ $company }}">
                                                <td></td>
                                                <td><input type="checkbox" class="companyCheckBox"
                                                        value="{{ $policy['policies']->id }}"
                                                        data-company="{{ $company }}" name="company[]"></td>
                                                <td>{{ $policy['policies']->policy_number }}</td>
                                                <td>{{ $policy['product']->product }}</td>
                                                <td>{{ $policy['quote']->full_payment }}</td>
                                                <td>{{ $policy['policies']->expiration_date }}</td>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
                <div class="col-6">
                    <div class="card"
                        style="box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05); border-radius: 10px; overflow: hidden;">
                        <div class="card-body">
                            <div class="row mb-4">
                                <div class="col-6">
                                    <label for="filterBy" class="form-label">Renewal:</label>
                                    <select id="renewalAgentDropdown" class="form-select">
                                        <option value="">Select Renewal Agent</option>
                                        @foreach ($renewals as $renewal)
                                            <option value="{{ $renewal->id }}">{{ $renewal->fullAmericanName() }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-6">
                                    <label for="filterBy" class="form-label">Agents:</label>
                                    <select id="agentDropDown" class="form-select">
                                        <option value="">Select Agent</option>
                                        @foreach ($userProfiles as $userProfile)
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
                                <table id="datatablePolicy" class="table table-bordered dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead style="background-color: #f0f0f0;">
                                        <tr>
                                            <th></th>
                                            <th>Policy No</th>
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
                aria-labelledby="mySmallModalLabel" aria-hidden="true" id="userDropdownModal">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Center modal</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row mb-4">
                                <div class="col-6">
                                    <label for="filterBy" class="form-label">Renewal:</label>
                                    <select id="renewwalAgentDropDownReassign" class="form-select">
                                        <option value="">Select Renewal Agent</option>
                                        @foreach ($renewals as $renewal)
                                            <option value="{{ $renewal->id }}">{{ $renewal->fullAmericanName() }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-6">
                                    <label for="filterBy" class="form-label">Agents:</label>
                                    <select id="agentDropDownReassign" class="form-select">
                                        <option value="">Select Agent</option>
                                        @foreach ($userProfiles as $userProfile)
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
                                id="submitReassign">Save</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#datatablePolicy').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ route('assign-quoted-policy.index') }}",
                    data: function(f) {
                        f.marketSpecialistId = $('#renewalAgentDropdown').val()
                        f.accountProfileId = $('#agentDropDown').val()
                    }
                },
                columns: [{
                        data: 'checkBox',
                        name: 'checkBox'
                    },
                    {
                        data: 'policy_number',
                        name: 'policy_number'
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

            $('.companyCheckAllBox').on('change', function() {
                // Get the company name from the clicked checkbox
                var companyName = $(this).data('company');

                // Find all checkboxes related to this company
                var relatedCheckboxes = $('.companyCheckBox[data-company="' + companyName + '"]');

                // Check or uncheck all related checkboxes based on the clicked checkbox state
                relatedCheckboxes.prop('checked', $(this).is(':checked'));
            });


            $('#renewalAgentDropdown').on('change', function() {
                let marketSpecialistUserProfileId = $(this).val();
                $('#datatablePolicy').DataTable().ajax.reload();
                if (marketSpecialistUserProfileId != "") {
                    console.log('test this code')
                    $('#agentDropDown').prop('disabled', true);
                } else {
                    $('#agentDropDown').prop('disabled', false);
                }
            });

            $('#agentDropDown').on('change', function() {
                let agentDropDownId = $(this).val();
                $('#datatablePolicy').DataTable().ajax.reload();
                if (agentDropDownId != "") {
                    $('#renewalAgentDropdown').prop('disabled', true);
                } else {
                    $('#renewalAgentDropdown').prop('disabled', false);
                }
            });

            $('#assignPolicy').on('click', function() {
                var id = [];
                var productsArray = [];
                $('.companyCheckBox:checked').each(function() {
                    productsArray.push($(this).val());
                });
                var renewalAgentId = $('#renewalAgentDropdown').val();
                var agentUserProfileId = $('#agentDropDown').val();
                if (productsArray.length > 0) {
                    if (renewalAgentId || agentUserProfileId) {
                        if (confirm("Are you sure you want to assign this policy?")) {
                            $.ajax({
                                url: "{{ route('assign-quoted-policy.store') }}",
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                method: "POST",
                                data: {
                                    product: productsArray,
                                    renewalAgentId: renewalAgentId,
                                    agentUserProfileId: agentUserProfileId
                                },
                                success: function(data) {
                                    Swal.fire({
                                        title: 'Success',
                                        text: 'Leads has been assigned',
                                        icon: 'success'
                                    }).then((result) => {
                                        location.reload();
                                    });
                                },
                                error: function(data) {
                                    Swal.fire({
                                        title: 'Error',
                                        text: 'Ther is a error while assigning leads',
                                        icon: 'error'
                                    });
                                }
                            });
                        }

                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: 'Please Select Agent',
                            icon: 'error'
                        });
                    }
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: 'Please select atleast one checkbox',
                        icon: 'error'
                    });
                }
            });

            var policyId = [];
            $('#voidAppointedLeads').on('click', function() {
                $('.policy_checkbox:checked').each(function() {
                    policyId.push($(this).val());
                });

                var userProfileId = $('#renewalAgentDropdown').val() ? $('#renewalAgentDropdown').val() : $(
                    '#agentDropDown').val();
                if (policyId.length > 0) {
                    if (confirm("Are you sure you want to void this leads?")) {
                        $.ajax({
                            url: "{{ route('void-quoted-renewal-policy') }}",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            method: "POST",
                            data: {
                                policyId: policyId,
                                userProfileId: userProfileId
                            },
                            success: function(data) {
                                Swal.fire({
                                    title: 'Success',
                                    text: 'Leads has been voided',
                                    icon: 'success'
                                }).then((result) => {
                                    location.reload();
                                });
                            },
                            error: function(data) {
                                Swal.fire({
                                    title: 'Error',
                                    text: 'Ther is a error while voiding leads',
                                    icon: 'error'
                                });
                            }
                        });
                    }
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: 'Please select atleast one checkbox',
                        icon: 'error'
                    });
                }
            });

            $('#reassignAppointedLead').on('click', function() {
                console.log('test this button for assigining');
                $('.policy_checkbox:checked').each(function() {
                    policyId.push($(this).val());
                });

                if (policyId.length > 0) {
                    $('#userDropdownModal').modal('show');
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: 'Please select atleast one checkbox',
                        icon: 'error'
                    });
                }
            });

            $('#renewwalAgentDropDownReassign').on('change', function() {
                let renewalAgentDropdownReassignId = $(this).val();
                if (renewalAgentDropdownReassignId != "") {
                    $('#agentDropDownReassign').prop('disabled', true);
                } else {
                    $('#agentDropDownReassign').prop('disabled', false);
                }
            });

            $('#agentDropDownReassign').on('change', function() {
                let agentDropDownId = $(this).val();
                if (agentDropDownId != "") {
                    $('#renewwalAgentDropDownReassign').prop('disabled', true);
                } else {
                    $('#renewwalAgentDropDownReassign').prop('disabled', false);
                }
            });

            $('#submitReassign').on('click', function() {
                var renewalAgentDropdownReassignId = $('#renewwalAgentDropDownReassign').val();
                var agentUserProfileDropdownId = $('#agentDropDownReassign').val();
                var renewalAgentDropdownId = $('#renewalAgentDropdown').val();
                var agentDropDownId = $('#agentDropDown').val();
                var oldProductOwnerUserProfileId = renewalAgentDropdownId ?
                    renewalAgentDropdownId : agentDropDownId;
                var userProfileId = renewalAgentDropdownReassignId ?
                    renewalAgentDropdownReassignId : agentUserProfileDropdownId;

                if (userProfileId > 0) {
                    $.ajax({
                        url: "{{ route('reassign-quoted-renewal-policy') }}",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        method: "POST",
                        data: {
                            policyId: policyId,
                            userProfileId: userProfileId,
                            oldProductOwnerUserProfileId: oldProductOwnerUserProfileId
                        },
                        success: function(data) {
                            Swal.fire({
                                title: 'Success',
                                text: 'Policy Successfully Reassigned',
                                icon: 'success'
                            }).then(() => {
                                $('#userDropdownModal').modal('hide');
                                location.reload();
                            });
                        },
                        error: function(data) {
                            Swal.fire({
                                title: 'Error',
                                text: 'Ther is a error while voiding leads',
                                icon: 'error'
                            });
                        }
                    });
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: 'Please select agent or market specialist',
                        icon: 'error'
                    });
                }
            });
        })
    </script>
@endsection
