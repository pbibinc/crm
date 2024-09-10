@extends('admin.admin_master')
@section('admin')
    <div class="page-content pt-6">
        <div class="container-fluid">
            <div class="row mb-3">
                <div class="col-6">

                </div>
                <div class="col-2">
                    <div class="card">
                        <div class="card-body">
                            {{-- <label for="cancellationTypeFilter">Filter by Cancellation Type</label>
                            <select name="cancellationTypeFilter" id="cancellationTypeFilter" class="form-select">
                                <option value="">All</option>
                                <option value="Non-Payment">Non-Payment</option>
                                <option value="Requested by Customer">Requested by Customer</option>
                            </select> --}}
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="card">
                        <div class="card-body">

                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="card"
                            style="box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05); border-radius: 10px; overflow: hidden;">
                            <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#cancelledPolicy" role="tab">
                                        <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                        <span class="d-none d-sm-block">Cancelled Policy</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#firstTouchPolicy" role="tab">
                                        <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                        <span class="d-none d-sm-block">First Touch Cancelled Policy</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#secondTouchPolicy" role="tab">
                                        <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                        <span class="d-none d-sm-block">Second Touch Cancelled Policy</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#touchedPolicy" role="tab">
                                        <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                        <span class="d-none d-sm-block">Touched Cancelled Policy</span>
                                    </a>
                                </li>
                            </ul>
                            <div class="card-body">
                                <div class="row mb-4">
                                    <div class="col-6">
                                        <div class="col-6">
                                            <label for="cancellationTypeFilter">Filter by Cancellation Type:</label>
                                            <select name="cancellationTypeFilter" id="cancellationTypeFilter"
                                                class="form-select">
                                                <option value="">All</option>
                                                <option value="Non-Payment">Non-Payment</option>
                                                <option value="Requested by Customer">Requested by Customer</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="col-6">
                                            <label for="user">Assign To:</label>
                                            <select name="userProfileId" id='userProfileId' class="form-select">
                                                <option value="">All</option>
                                                @foreach ($userProfileList as $userProfile)
                                                    <option value={{ $userProfile->id }}>
                                                        {{ $userProfile->fullAmericanName() }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="tab-content p-3 text-muted">
                                        <div class="tab-pane active" id="cancelledPolicy" role="tabpanel">
                                            @include('customer-service.cancellation.cancelled-list.cancelled-policy-list-table')
                                        </div>
                                        <div class="tab-pane" id="firstTouchPolicy" role="tabpanel">
                                            @include('customer-service.cancellation.cancelled-list.first-cancel-policy-table')
                                        </div>
                                        <div class="tab-pane" id="secondTouchPolicy" role="tabpanel">
                                            @include('customer-service.cancellation.cancelled-list.second-cancel-policy-table')
                                        </div>
                                        <div class="tab-pane" id="touchedPolicy" role="tabpanel">
                                            @include('customer-service.cancellation.cancelled-list.touched-policies-list-table')
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('customer-service.cancellation.cancel-policy-modal')
    @include('customer-service.cancellation.cancelled-list.set-cancelled-policy-for-recall-modal');
    <script>
        Dropzone.autoDiscover = false;
        var cancelPolicyDropzone;
        $(document).ready(function() {

            function assignForRewrite(id, userProfileId, cancellationId) {
                $.ajax({
                    url: "{{ route('assign-for-rewrite-policy.store') }}",
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        id: id,
                        userProfileId: userProfileId,
                        cancellationId: cancellationId
                    },
                    success: function(response) {
                        if (response.status == 'success') {
                            Swal.fire(
                                'Rewrite!',
                                'Policy has been rewritten.',
                                'success'
                            ).then((result) => {
                                location.reload()
                            })
                        } else {
                            Swal.fire(
                                'Error!',
                                'Something went wrong.',
                                'error'
                            )
                        }
                    },
                    error: function(response) {
                        Swal.fire(
                            'Error!',
                            'Something went wrong.',
                            'error'
                        )
                    }
                });
            }

            //for rewrite button
            $(document).on('click', '.forRewriteButton', function() {
                var id = $(this).attr('id');

                var userProfileId = $('#userProfileId').val();
                var cancellationId = $(this).attr('data-cancel-id');

                if (userProfileId == '') {
                    Swal.fire(
                        'Error!',
                        'Please select a user to assign the policy.',
                        'error'
                    )
                    return;
                } else {
                    $.ajax({
                        url: "{{ route('get-user-profile-cancelled-policy') }}",
                        type: "POST",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            id: id,
                            userProfileId: userProfileId,
                            cancellationId: cancellationId
                        },
                        success: function(response) {
                            console.log(response);
                            Swal.fire({
                                title: 'Are you sure?',
                                text: `You want to assign the policy ${response.policyDetail.policy_number} for ${response.product.product} to ${response.userProfile.american_name}?`,
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Yes, assign it!'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    assignForRewrite(id, userProfileId, cancellationId);
                                }
                            })
                        },
                        error: function(response) {
                            Swal.fire(
                                'Error!',
                                'Something went wrong.',
                                'error'
                            )
                        }
                    })
                    // Swal.fire({
                    //     title: 'Are you sure?',
                    //     text: "You want to assign this policy for rewrite!",
                    //     icon: 'warning',
                    //     showCancelButton: true,
                    //     confirmButtonColor: '#3085d6',
                    //     cancelButtonColor: '#d33',
                    //     confirmButtonText: 'Yes, assign it!'
                    // }).then((result) => {
                    //     if (result.isConfirmed) {
                    //         assignForRewrite(id, userProfileId);
                    //     }
                    // })

                }

            });

            cancelPolicyDropzone = new Dropzone('#cancelPolicyDropzone', {
                url: "#",
                autoProcessQueue: false, // Prevent automatic upload
                clickable: true, // Allow opening file dialog on click
                maxFiles: 1,
                addRemoveLinks: true,
                init: function() {
                    this.on('addedfile', function(file) {
                        file.previewElement.addEventListener("click", function() {
                            var url = "{{ env('APP_FORM_LINK') }}";
                            var fileUrl = url + file.url;
                            Swal.fire({
                                title: 'File Options',
                                text: 'Choose an action for the file',
                                showDenyButton: true,
                                confirmButtonText: `Download`,
                                denyButtonText: `View`,
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    var downloadLink = document.createElement(
                                        "a");
                                    downloadLink.href = fileUrl;
                                    downloadLink.download = file.name;
                                    document.body.appendChild(downloadLink);
                                    downloadLink.click();
                                    document.body.removeChild(downloadLink);
                                } else if (result.isDenied) {
                                    window.open(fileUrl, '_blank');
                                }
                            });
                        });
                    });
                }
            });

            function addExistingCancellationEndorsementFile(file) {
                var mockFile = {
                    id: file.id,
                    name: file.basename,
                    size: parseInt(file.size),
                    type: file.type,
                    status: Dropzone.ADDED,
                    url: file.filepath // URL to the file's location
                };

                cancelPolicyDropzone.emit("addedfile", mockFile);
                cancelPolicyDropzone.emit("complete", mockFile);
            }

            $('#cancelPolicyModal').on('hidden.bs.modal', function() {
                // Reset the form
                var cancelPolicyForm = $('#cancelPolicyForm')[0];
                if (cancelPolicyForm) {
                    cancelPolicyForm.reset();
                }

                // Clear all files from Dropzone
                if (typeof cancelPolicyDropzone !== 'undefined') {
                    cancelPolicyDropzone.removeAllFiles(true);
                    $('#cancelPolicyDropzone').empty();
                }
            });

            //preview button
            $(document).on('click', '.previewButton', function() {
                var id = $(this).attr('id');
                $.ajax({
                    url: "{{ route('cancelled-policy.get-policy-approved-for-cancellation') }}",
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        id: id
                    },
                    success: function(response) {
                        console.log(response);
                        if (response.status == 'success') {
                            $('#cancelPolicyCompanyName').text(response.lead.company_name);
                            $('#cancelPolicyCarrier').text(response.policy.carrier);
                            $('#cancelPolicyInsuredName').text(response.generalInformation
                                .firstname +
                                ' ' +
                                response.generalInformation.lastname);
                            $('#cancelPolicyType').text(response.policy.quotation_product
                                .product);
                            $('#cancelPolicyTypeOfCancellation').text(response
                                .cancellationEndorsement
                                .type_of_cancellation);
                            $('#cancelaPolicyCancellationDate').text(response
                                .cancellationEndorsement.cancellation_date);
                            $('#cancelPolicyAddress').text(response.generalInformation.address);
                            $('#cancelPolicyTerm').text(response.paymentTerm);
                            $('#cancellationPolicyRemarks').text(response
                                .cancellationEndorsement
                                .agent_remarks);
                            $('#cancelaPolicyCancellationDate').val(response
                                .cancellationEndorsement.cancellation_date)
                            addExistingCancellationEndorsementFile(response.media);
                            $('#policyId').val(response.policy.id);
                            $('#cancellationEndorsementId').val(response.cancellationEndorsement
                                .id);
                            $('#cancelPolicyModal').modal('show');
                        } else {
                            swal.fire({
                                title: 'Error',
                                text: response.message,
                                icon: 'error',
                                confirmButtonText: 'Ok'
                            });
                        }
                    }
                });


            });

            //set button
            $(document).on('click', '.firstTouchButtonSetCall', function() {
                var id = $(this).attr('id');
                $.ajax({
                    url: "{{ route('get-cancelled-policy-for-recall-initial-data') }}",
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        id: id,
                        nummberOfDays: 90
                    },
                    success: function(response) {
                        console.log(response);
                        if (response.status == 'success') {
                            $('#canncelPolicyForRecallCompanyName').text(response.lead
                                .company_name);
                            $('#oldPolicyNumber').text(response.policy.policy_number);
                            $('#forRecallDate').val(response.dateToCall);
                            $('#forRecalPolicyId').val(response.policy.id);
                            $('#setCancelPolicyForRecallModal').modal('show');
                        } else {
                            swal.fire({
                                title: 'Error',
                                text: response.data.message,
                                icon: 'error',
                                confirmButtonText: 'Ok'
                            });
                        }

                    }
                });
            });

            $(document).on('click', '.secondTouchButtonSetCall', function() {
                var id = $(this).attr('id');
                $.ajax({
                    url: "{{ route('get-cancelled-policy-for-recall-initial-data') }}",
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        id: id,
                        nummberOfDays: 90
                    },
                    success: function(response) {
                        console.log(response);
                        if (response.status == 'success') {
                            $('#canncelPolicyForRecallCompanyName').text(response.lead
                                .company_name);
                            $('#oldPolicyNumber').text(response.policy.policy_number);
                            $('#forRecallDate').val(response.dateToCall);
                            $('#forRecalPolicyId').val(response.policy.id);
                            $('#forRecallRemarks').val(response.canncelledPolicyForRecall
                                .remarks);
                            $('#cancellationForRecallId').val(response.canncelledPolicyForRecall
                                .id)
                            $('#forRecallPolicyAction').val('edit');
                            $('#setCancelPolicyForRecallModal').modal('show');
                        } else {
                            swal.fire({
                                title: 'Error',
                                text: response.data.message,
                                icon: 'error',
                                confirmButtonText: 'Ok'
                            });
                        }

                    }
                });
            });

            $(document).on('click', '.thirdTouchButtonSetCall', function() {
                var id = $(this).attr('id');
                $.ajax({
                    url: "{{ route('get-cancelled-policy-for-recall-initial-data') }}",
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        id: id,
                        nummberOfDays: 180
                    },
                    success: function(response) {
                        console.log(response);
                        if (response.status == 'success') {
                            $('#canncelPolicyForRecallCompanyName').text(response.lead
                                .company_name);
                            $('#oldPolicyNumber').text(response.policy.policy_number);
                            $('#forRecallDate').val(response.dateToCall);
                            $('#forRecalPolicyId').val(response.policy.id);
                            $('#forRecallRemarks').val(response.canncelledPolicyForRecall
                                .remarks);
                            $('#cancellationForRecallId').val(response.canncelledPolicyForRecall
                                .id)
                            $('#forRecallPolicyAction').val('edit');
                            $('#setCancelPolicyForRecallModal').modal('show');
                        } else {
                            swal.fire({
                                title: 'Error',
                                text: response.data.message,
                                icon: 'error',
                                confirmButtonText: 'Ok'
                            });
                        }

                    }
                });
            });

            $(document).on('click', '.touchedButtonSetCall', function() {
                var id = $(this).attr('id');
                $.ajax({
                    url: "{{ route('get-cancelled-policy-for-recall-initial-data') }}",
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        id: id,
                        nummberOfDays: 60
                    },
                    success: function(response) {
                        console.log(response);
                        if (response.status == 'success') {
                            $('#canncelPolicyForRecallCompanyName').text(response.lead
                                .company_name);
                            $('#oldPolicyNumber').text(response.policy.policy_number);
                            $('#forRecallDate').val(response.dateToCall);
                            $('#forRecalPolicyId').val(response.policy.id);
                            $('#forRecallRemarks').val(response.canncelledPolicyForRecall
                                .remarks);
                            $('#cancellationForRecallId').val(response.canncelledPolicyForRecall
                                .id)
                            $('#forRecallPolicyAction').val('edit');
                            $('#setCancelPolicyForRecallModal').modal('show');
                        } else {
                            swal.fire({
                                title: 'Error',
                                text: response.data.message,
                                icon: 'error',
                                confirmButtonText: 'Ok'
                            });
                        }

                    }
                });
            });

            function removeForRecall($id) {
                $.ajax({
                    url: "{{ route('change-status-for-cancelled-policy-recall') }}",
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        id: id,
                        status: 'removed'
                    },
                    success: function(response) {
                        if (response.status == 'success') {
                            Swal.fire(
                                'Success!',
                                'Policy has been removed from recall.',
                                'success'
                            ).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire(
                                'Error!',
                                'Something went wrong.',
                                'error'
                            );
                        }
                    },
                    error: function(response) {
                        Swal.fire(
                            'Error!',
                            'Something went wrong.',
                            'error'
                        );
                    }
                });
            }

            $(document).on('click', '.removeForRecallButton', function() {
                var id = $(this).attr('id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to remove this policy from recall!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, remove it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        removeForRecall(id);
                    }
                })

            });

        });
    </script>
@endsection
