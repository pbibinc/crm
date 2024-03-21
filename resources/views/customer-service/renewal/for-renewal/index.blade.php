@extends('admin.admin_master')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="card"
                    style=" box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05); border-radius: 10px; overflow: hidden;">
                    <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#policyForRenewal" role="tab">
                                <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                <span class="d-none d-sm-block">Policy For Renewal</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " data-bs-toggle="tab" href="#renewalReminder" role="tab">
                                <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                <span class="d-none d-sm-block">Renewal Reminder</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#renewalPolicyQuotation" role="tab">
                                <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                <span class="d-none d-sm-block">Renewal Policy Quotation</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#quotedRenewal" role="tab">
                                <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                <span class="d-none d-sm-block">Quoted Policies</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#handledPolicy" role="tab">
                                <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                <span class="d-none d-sm-block">Handled Policy</span>
                            </a>
                        </li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content p-3 text-muted">
                        <div class="tab-pane active" id="policyForRenewal" role="tabpanel">
                            @include('customer-service.renewal.for-renewal.policy-for-renewal')
                        </div>
                        <div class="tab-pane" id="renewalReminder" role="tabpanel">
                            @include('customer-service.renewal.for-renewal.renewal-reminder')
                        </div>

                        <div class="tab-pane" id="renewalPolicyQuotation" role="tabpanel">
                            @include('customer-service.renewal.for-renewal.renewal-policy-quotation')
                        </div>

                        <div class="tab-pane" id="quotedRenewal" role="tabpanel">
                            @include('customer-service.renewal.for-renewal.renewal-policy-quoted')
                        </div>

                        <div class="tab-pane" id="handledPolicy" role="tabpanel">
                            @include('customer-service.renewal.for-renewal.renewal-policy-handled')
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
