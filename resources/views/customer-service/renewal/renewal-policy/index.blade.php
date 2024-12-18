@extends('admin.admin_master')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="card"
                    style=" box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05); border-radius: 10px; ,overflow: hidden;">
                    <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#policyForRenewal" role="tab">
                                <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                <span class="d-none d-sm-block">Policy For Renewal</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " data-bs-toggle="tab" href="#renewalProcess" role="tab">
                                <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                <span class="d-none d-sm-block">Process Renewal</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#renewalMakeAPayment" role="tab">
                                <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                <span class="d-none d-sm-block">Make A Payment</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#requestToBind" role="tab">
                                <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                <span class="d-none d-sm-block">Request To Bind</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#newRenewedPolicy" role="tab">
                                <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                <span class="d-none d-sm-block">New Renewed Policy</span>
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content p-3 text-muted">
                        <div class="tab-pane active" id="policyForRenewal" role="tabpanel">
                            @include(
                                'customer-service.renewal.renewal-policy.policy-for-renewal-list',
                                compact('userProfiles', 'userProfileId'))
                        </div>
                        <div class="tab-pane" id="renewalProcess" role="tabpanel">
                            @include(
                                'customer-service.renewal.renewal-policy.policy-renewal-process-list',
                                compact('userProfiles', 'userProfileId'))
                        </div>
                        <div class="tab-pane" id="renewalMakeAPayment" role="tabpanel">
                            @include(
                                'customer-service.renewal.renewal-policy.policy-renewal-make-payment',
                                compact('userProfiles', 'complianceOfficer', 'userProfileId'))
                        </div>
                        <div class="tab-pane" id="requestToBind" role="tabpanel">
                            @include(
                                'customer-service.renewal.renewal-policy.policy-renewal-request-to-bind',
                                compact('userProfiles', 'userProfileId'))
                        </div>
                        <div class="tab-pane" id="newRenewedPolicy" role="tabpanel">
                            @include(
                                'customer-service.renewal.renewal-policy.policy-renewed-list',
                                compact('userProfiles', 'userProfileId'))
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $(document).on('click', '.setOldRenewalButton', function() {
                var id = $(this).attr('id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to change the status to 'Old Renewal'?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('change-status-for-policy') }}",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            method: "POST",
                            data: {
                                id: id,
                                status: 'Old Renewal'
                            },
                            success: function(data) {
                                if (data.success) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Success',
                                        text: data.success,
                                    });
                                    location.reload();
                                }
                            }
                        })
                    }
                });
            });
        });
    </script>
@endsection
