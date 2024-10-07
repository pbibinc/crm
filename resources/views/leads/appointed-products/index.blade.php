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
                            <span style="font-weight: 600; letter-spacing: 1px;">LIST OF APPOINTED LEADS</span>
                        </h3>
                        <div>
                            <button type="button" id="bulkRequestForQuote"
                                class="btn btn-primary btn-rounded waves-effect waves-light mb-4" data-bs-toggle="tooltip"
                                data-bs-placement="top" title="Button to assign checked Leads to a selected user"
                                style="box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);"> <i class="ri-user-received-2-line"></i>
                                Request To Quote</button>
                            {{-- <button type="button" id="reassignAppointedLead"
                                class="btn btn-light btn-rounded waves-effect waves-light mb-4" data-bs-toggle="tooltip"
                                data-bs-placement="top" title="Button to reassign checked Leads to a selected user"
                                style="background-color: white; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);"> <i
                                    class="ri-user-shared-2-line"></i> Reasign Lead</button>
                            <button type="button" id="voidAppointedLeads"
                                class="btn btn-outline-danger btn-rounded waves-effect waves-light mb-4"
                                data-bs-toggle="tooltip" data-bs-placement="top" title="Button To Void Leads to a user"
                                style="background-color: white; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);"><i
                                    class="ri-user-unfollow-line"></i> Void Lead</button> --}}
                        </div>

                    </div>
                    <div class="card"
                        style="box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05); border-radius: 10px; overflow: hidden;">
                        <div class="card-body">
                            <table id="assignAppointedLeadsTable" class="table table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        {{-- <th></th> --}}
                                        <th>Company Name</th>
                                        {{-- <th>State</th> --}}
                                        {{-- <th>Products</th>
                                <th>Telemarketer</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($groupedProducts as $companyName => $groupedProduct)
                                        <tr style="background-color: #f0f0f0;">
                                            <td><strong><b>{{ $companyName }}</b></strong></td>
                                            <td><input type="checkbox" class="companyCheckAllBox"
                                                    data-company="{{ $companyName }}" name="company[]"></td>
                                            <td><strong><b>Product</b></strong></td>
                                            <td><strong><b>Telemarketer</b></strong></td>
                                            <td><strong><b>Action</b></strong></td>
                                            {{-- <td><strong><b>Sent Out Date</b></strong></td> --}}
                                        </tr>
                                        @foreach ($groupedProduct as $product)
                                            <tr class="productRow {{ $companyName }}">
                                                <td></td>
                                                <td><input type="checkbox" class="companyCheckBox"
                                                        value="{{ $product['product']->id }}"
                                                        data-company="{{ $companyName }}" name="company[]"></td>
                                                <td>{{ $product['product']->product }}</td>
                                                <td>{{ $product['telemarketer'] }}</td>
                                                <td> <button type="button" id="{{ $product['product']->id }}"
                                                        class="btn btn-sm btn-outline-success waves-effect waves-light mb-4 requestToQuote"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="Button For Requesting To Quote"> <i
                                                            class=" ri-task-line"></i>
                                                    </button></td>
                                            </tr>
                                        @endforeach
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('.companyCheckAllBox').on('change', function() {
                // Get the company name from the clicked checkbox
                var companyName = $(this).data('company');

                // Find all checkboxes related to this company
                var relatedCheckboxes = $('.companyCheckBox[data-company="' + companyName + '"]');

                // Check or uncheck all related checkboxes based on the clicked checkbox state
                relatedCheckboxes.prop('checked', $(this).is(':checked'));
            });

            $('#datatableLeads').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ route('get-data-table') }}",
                    data: function(f) {
                        f.marketSpecialistId = $('#marketSpecialistDropDown').val()
                        f.accountProfileId = $('#agentDropDown').val()
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
                        data: 'company',
                        name: 'company'
                    },
                ]
            });

            $('#marketSpecialistDropDown').on('change', function() {
                let marketSpecialistUserProfileId = $(this).val();
                $('#datatableLeads').DataTable().ajax.reload();
                if (marketSpecialistUserProfileId != "") {
                    $('#agentDropDown').prop('disabled', true);
                } else {
                    $('#agentDropDown').prop('disabled', false);
                }
            });

            $('#agentDropDown').on('change', function() {
                let agentDropDownId = $(this).val();
                $('#datatableLeads').DataTable().ajax.reload();
                if (agentDropDownId != "") {
                    $('#marketSpecialistDropDown').prop('disabled', true);
                } else {
                    $('#marketSpecialistDropDown').prop('disabled', false);
                }
            });

            $('#assignAppointedLead').on('click', function() {
                var id = [];
                var productsArray = [];


                $('.companyCheckBox:checked').each(function() {
                    productsArray.push($(this).val());
                });


                var marketSpecialistUserProfileId = $('#marketSpecialistDropDown').val();
                var agentUserProfileId = $('#agentDropDown').val();
                if (productsArray.length > 0) {
                    if (marketSpecialistUserProfileId || agentUserProfileId) {
                        if (confirm("Are you sure you want to assign this leads?")) {
                            $.ajax({
                                url: "{{ route('assign-leads-market-specialist') }}",
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                method: "POST",
                                data: {
                                    // id:id,
                                    product: productsArray,
                                    marketSpecialistUserProfileId: marketSpecialistUserProfileId,
                                    agentUserProfileId: agentUserProfileId
                                },
                                success: function(data) {
                                    Swal.fire({
                                        title: 'Success',
                                        text: 'Leads has been assigned',
                                        icon: 'success'
                                    }).then(() => {
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
            var productId = [];
            $('#voidAppointedLeads').on('click', function() {
                // var productsArray = [];
                // $('.companyCheckBox:checked').each(function(){
                //     productsArray.push($(this).val());
                // });

                $('.leads_checkbox:checked').each(function() {
                    productId.push($(this).val());
                });

                if (productId.length > 0) {
                    if (confirm("Are you sure you want to void this leads?")) {
                        $.ajax({
                            url: "{{ route('void-appointed-leads') }}",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            method: "POST",
                            data: {
                                productId: productId
                            },
                            success: function(data) {
                                Swal.fire({
                                    title: 'Success',
                                    text: 'Leads has been voided',
                                    icon: 'success'
                                });
                                // $('#assignAppointedLeadsTable').DataTable().ajax.reload();
                                // $('#datatableLeads').DataTable().ajax.reload();
                                location.reload();
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

                $('.leads_checkbox:checked').each(function() {
                    productId.push($(this).val());
                });
                if (productId.length > 0) {
                    $('#userDropdownModal').modal('show');
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: 'Please select atleast one checkbox',
                        icon: 'error'
                    });
                }
            })

            $('#marketSpecialistDropDownReassign').on('change', function() {
                let marketSpecialistUserProfileId = $(this).val();
                if (marketSpecialistUserProfileId != "") {
                    $('#agentDropDownReassign').prop('disabled', true);
                } else {
                    $('#agentDropDownReassign').prop('disabled', false);
                }
            });

            $('#agentDropDownReassign').on('change', function() {
                let agentDropDownId = $(this).val();
                if (agentDropDownId != "") {
                    $('#marketSpecialistDropDownReassign').prop('disabled', true);
                } else {
                    $('#marketSpecialistDropDownReassign').prop('disabled', false);
                }
            });

            $('#submitReassign').on('click', function() {
                var marketSpecialistUserProfileDropdownId = $('#marketSpecialistDropDownReassign').val();
                var agentUserProfileDropdownId = $('#agentDropDownReassign').val();
                var marketSpecialistDropDownId = $('#marketSpecialistDropDown').val();
                var agentDropDownId = $('#agentDropDown').val();
                var oldProductOwnerUserProfileId = marketSpecialistDropDownId ?
                    marketSpecialistDropDownId : agentDropDownId;
                var userProfileId = marketSpecialistUserProfileDropdownId ?
                    marketSpecialistUserProfileDropdownId : agentUserProfileDropdownId;

                if (userProfileId > 0) {
                    $.ajax({
                        url: "{{ route('redeploy-appointed-leads') }}",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        method: "POST",
                        data: {
                            productId: productId,
                            userProfileId: userProfileId,
                            oldProductOwnerUserProfileId: oldProductOwnerUserProfileId
                        },
                        success: function(data) {
                            Swal.fire({
                                title: 'Success',
                                text: 'Leads has been voided',
                                icon: 'success'
                            }).then(() => {
                                $('#userDropdownModal').modal('hide');
                                $('#datatableLeads').DataTable().ajax.reload();

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

            $('.requestToQuote').on('click', function() {
                Swal.fire({
                    title: 'Request To Quote',
                    text: 'Are you sure you want to request to quote this product?',
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var productId = $(this).attr('id');
                        $.ajax({
                            url: "{{ route('request-to-quote') }}",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            method: "POST",
                            data: {
                                productId: productId
                            },
                            success: function(data) {
                                Swal.fire({
                                    title: 'Success',
                                    text: 'Request to quote has been sent',
                                    icon: 'success'
                                }).then(() => {
                                    location.reload();
                                });
                            },
                            error: function(data) {
                                Swal.fire({
                                    title: 'Error',
                                    text: 'There is an error while sending request to quote',
                                    icon: 'error'
                                });
                            }
                        });
                    }
                })
            });
        })
    </script>
@endsection
