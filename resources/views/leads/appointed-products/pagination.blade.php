<table id="assignAppointedLeadsTable" class="table table-bordered dt-responsive nowrap" style="width: 100%;">
    <thead>
        <tr>
            <th>Company Name</th>
            <th>Checkbox</th>
            <th>Product</th>
            <th>Telemarketer</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($groupedProducts as $companyName => $groupedProduct)
            <tr style="background-color: #f0f0f0;">
                <td><strong><b>{{ $companyName }}</b></strong></td>
                <td><input type="checkbox" class="companyCheckAllBox" data-company="{{ $companyName }}" name="company[]">
                </td>
                <td><strong><b>Product</b></strong></td>
                <td><strong><b>Telemarketer</b></strong></td>
                <td><strong><b>Status</b></strong></td>
                <td><strong><b>Action</b></strong></td>
            </tr>
            @foreach ($groupedProduct as $product)
                <tr class="productRow {{ $companyName }}">
                    <td></td>
                    <td><input type="checkbox" class="companyCheckBox" value="{{ $product['product']->id }}"
                            data-company="{{ $companyName }}" name="company[]"></td>
                    <td><a href="{{ route('appointed-list-profile-view', ['leadsId' => $product['leadId']]) }}">
                            {{ $product['product']->product }}</a>
                    </td>
                    <td>{{ $product['telemarketer'] }}</td>
                    <td>
                        <span class="badge {{ $product['product']->status == 7 ? 'bg-success' : 'bg-warning' }}">
                            {{ $product['product']->status == 7 ? 'Complete' : 'Incomplete' }}
                        </span>
                    </td>
                    <td>
                        @if ($product['product']->status == 7)
                            <button type="button" id="{{ $product['product']->id }}"
                                class="btn btn-sm btn-outline-success requestToQuote" data-bs-toggle="tooltip"
                                title="Request To Quote">
                                <i class="ri-task-line"></i>
                            </button>
                            <button type="button" id="{{ $product['leadId'] }}"
                                class="btn btn-sm btn-outline-primary viewProductForm" data-bs-toggle="tooltip"
                                title="View/Edit Form">
                                <i class="ri-share-box-line"></i>
                            </button>
                            <button type="button" id="{{ $product['product']->id }}"
                                class="btn btn-sm btn-outline-danger declinedAppointedProductButton"
                                data-bs-toggle="tooltip" title="Decline Product">
                                <i class="ri-forbid-2-line"></i>
                            </button>
                        @elseif($product['product']->status == 29)
                            <button type="button" id="{{ $product['leadId'] }}"
                                class="btn btn-sm btn-outline-primary viewProductForm" data-bs-toggle="tooltip"
                                title="View/Edit Form">
                                <i class="ri-share-box-line"></i>
                            </button>
                            <button type="button" id="{{ $product['product']->id }}"
                                class="btn btn-sm btn-outline-danger declinedAppointedProductButton"
                                data-bs-toggle="tooltip" title="Decline Product">
                                <i class="ri-forbid-2-line"></i>
                            </button>
                        @endif
                    </td>
                </tr>
            @endforeach
        @endforeach
    </tbody>
</table>

<!-- Pagination Links -->
<div class="d-flex justify-content-center mt-4">
    {{ $appointedProducts->links() }}
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

        $('.viewProductForm').on('click', function() {
            var url = "{{ env('APP_FORM_URL') }}";
            var id = $(this).attr('id');
            $.ajax({
                url: "{{ route('list-lead-id') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                method: 'POST',
                data: {
                    leadId: id,
                },
            });
            window.open(`${url}add-product-form`, "s_blank",
                "width=1000,height=849");
        });

        $('.declinedAppointedProductButton').on('click', function() {
            var id = $(this).attr('id');
            Swal.fire({
                title: 'Decline Product',
                text: 'Are you sure you want to decline this product?',
                icon: 'info',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'No'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('decline-appointed-product') }}",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        method: "POST",
                        data: {
                            id: id
                        },
                        success: function(data) {
                            Swal.fire({
                                title: 'Success',
                                text: 'Product has been declined',
                                icon: 'success'
                            }).then(() => {
                                location.reload();
                            });
                        },
                        error: function(data) {
                            Swal.fire({
                                title: 'Error',
                                text: 'There is an error while declining product',
                                icon: 'error'
                            });
                        }
                    });
                }
            })
        });
    });
</script>
