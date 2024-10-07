@extends('admin.admin_master')
@section('admin')
    <style>
        .fab {
            position: fixed;
            width: 56px;
            height: 56px;
            bottom: 16px;
            right: 16px;
            background-color: #007bff;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
            cursor: pointer;
            z-index: 1000;
        }
    </style>

    <div class="page-content pt-6">
        <div class="container-fluid">
            <div class="fab" id="fab">
                <i class="fas fa-comment"></i>
            </div>
            {{-- <div class="row">
                <div>
                    @include(
                        'leads.appointed_leads.apptaker-leads-view.header-profile-section',
                        compact('leads', 'localTime'))
                </div>
            </div> --}}
            <div class="row">
                <div class="col-sm-3">
                    <div class="card"
                        style="background-color: white; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05); border-radius: 10px; overflow: hidden;">
                        <div class="card-body">
                            <div class="row mb-2">
                                <h6 style="font-size: 14px;">Contact Information</h6>
                            </div>
                            <div class="row mb-1">
                                <div class="col-6">
                                    <strong style="font-size: 12px;">Email Address:</strong>
                                    <br>
                                    <strong
                                        style="font-size: 12px;">{{ $leads->GeneralInformation->email_address }}</strong>
                                </div>
                                <div class="col-6">
                                    <strong style="font-size: 12px;">Tel Num:</strong>
                                    <br>
                                    <strong style="font-size: 12px;">{{ $leads->tel_num }}</strong>
                                </div>
                            </div>
                            <div class="row mb-1">
                                <strong style="font-size: 12px;">Alt Num:</strong>
                                <br>
                                <strong
                                    style="font-size: 12px;">{{ $leads->GeneralInformation->alt_num ? $leads->GeneralInformation->alt_num : $leads->tel_num }}</strong>
                            </div>

                            <div class="row">
                                <hr style="margin: 5px 0;">
                            </div>
                            <div class="row mb-2">
                                <h6 style="font-size: 14px;">Location Details</h6>
                            </div>
                            <div class="row mb-1">
                                <div class="col-6">
                                    <strong style="font-size: 12px;">Location:</strong>
                                    <br>
                                    <strong
                                        style="font-size: 12px;">{{ $usAddress->city . ', ' . $usAddress->state }}</strong>
                                </div>

                                <div class="col-6">
                                    <strong style="font-size: 12px;">Local Time:</strong>
                                    <br>
                                    <strong style="font-size: 12px;">{{ $localTime->format('M-d-Y g:iA') }}</strong>
                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-6">
                                    <strong style="font-size: 12px;">Address:</strong>
                                    <br>
                                    <strong style="font-size: 12px;">{{ $leads->GeneralInformation->address }}</strong>
                                </div>
                            </div>
                            <div class="row">
                                <hr style="margin: 5px 0;">
                            </div>
                            <div class="row mb-2">
                                <h6 style="font-size: 14px;">Company Information</h6>
                            </div>
                            <div class="row mb-1">
                                <div class="col-6">
                                    <strong style="font-size: 12px;">Full Time Employee:</strong>
                                    <br>
                                    <strong
                                        style="font-size: 12px;">{{ $leads->GeneralInformation->full_time_employee }}</strong>
                                </div>
                                <div class="col-6">
                                    <strong style="font-size: 12px;">Part Time Employee:</strong>
                                    <br>
                                    <strong
                                        style="font-size: 12px;">{{ $leads->GeneralInformation->part_time_employee }}</strong>
                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-6">
                                    <strong style="font-size: 12px;">Owners Payroll:</strong>
                                    <br>
                                    <strong
                                        style="font-size: 12px;">${{ number_format($leads->GeneralInformation->owners_payroll, 2, '.', ',') }}</strong>
                                </div>
                                <div class="col-6">
                                    <strong style="font-size: 12px;">Employee Payroll:</strong>
                                    <br>
                                    <strong
                                        style="font-size: 12px;">${{ number_format($leads->GeneralInformation->employee_payroll, 2, '.', ',') }}</strong>
                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-6">
                                    <strong style="font-size: 12px;">Gross Receipt:</strong>
                                    <br>
                                    <strong
                                        style="font-size: 12px;">${{ number_format($leads->GeneralInformation->gross_receipt, 2, '.', ',') }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-9">

                    <div class="tab-content text-muted">

                        <div class="tab-pane fade show active" id="summary" role="tabpanel">
                            @include('leads.appointed_leads.apptaker-leads-view.profile-summary', [
                                'leads' => $leads,
                                'leadId' => $leads->id,
                                'carriers' => $carriers,
                                'markets' => $markets,
                                'templates' => $templatpes,
                            ])
                        </div>

                        <div class="tab-pane fade show" id="product" role="tabpanel">
                            <div class="card"
                                style="background-color: white; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05); border-radius: 10px; overflow: hidden;">
                                <div class="card-body">
                                    <ul class="nav nav-pills nav-justified" role="tablistProduct">
                                        @foreach ($products as $key => $product)
                                            <li class="nav-item waves-effect waves-light">
                                                <a class="nav-link navProfile {{ $key === 0 ? 'active' : '' }}"
                                                    data-bs-toggle="tab"
                                                    href="#{{ str_replace(' ', '', $product->product) }}" role="tab"
                                                    id="{{ str_replace(' ', '', $product->product) }}Button"
                                                    style="white-space: nowrap;">
                                                    {{ $product->product }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <div class="tab-content p-3 text-muted">
                                        @foreach ($products as $key => $product)
                                            <div class="tab-pane fade show  {{ $key === 0 ? 'show active' : '' }}"
                                                id="{{ str_replace(' ', '', $product->product) }}" role="tabpanel">
                                                @includeWhen(
                                                    $product->product == 'General Liability',
                                                    'leads.appointed_leads.product-view.general-liability-profile',
                                                    [
                                                        'generalLiabilities' =>
                                                            $leads->generalInformation->generalLiabilities,
                                                        'actionButtons' => true,
                                                    ]
                                                )
                                                @includeWhen(
                                                    $product->product == 'Workers Compensation',
                                                    'leads.appointed_leads.product-view.workers-comp-profile',
                                                    [
                                                        'generalInformation' => $leads->generalInformation,
                                                        'actionButtons' => true,
                                                    ]
                                                )
                                                @includeWhen(
                                                    $product->product == 'Commercial Auto',
                                                    'leads.appointed_leads.product-view.commercial-auto-profile',
                                                    [
                                                        'generalInformation' => $leads->generalInformation,
                                                        'actionButtons' => true,
                                                    ]
                                                )
                                                @includeWhen(
                                                    $product->product == 'Excess Liability',
                                                    'leads.appointed_leads.product-view.excess-liability-profile',
                                                    [
                                                        'generalInformation' => $leads->generalInformation,
                                                        'actionButtons' => true,
                                                    ]
                                                )
                                                @includeWhen(
                                                    $product->product == 'Tools Equipment',
                                                    'leads.appointed_leads.product-view.tools-equipment-profile',
                                                    [
                                                        'generalInformation' => $leads->generalInformation,
                                                        'actionButtons' => true,
                                                    ]
                                                )
                                                @includeWhen(
                                                    $product->product == 'Builders Risk',
                                                    'leads.appointed_leads.product-view.builders-risk-profile',
                                                    [
                                                        'generalInformation' => $leads->generalInformation,
                                                        'actionButtons' => true,
                                                    ]
                                                )
                                                @includeWhen(
                                                    $product->product == 'Business Owners',
                                                    'leads.appointed_leads.product-view.business-owners-profile',
                                                    [
                                                        'generalInformation' => $leads->generalInformation,
                                                        'actionButtons' => true,
                                                    ]
                                                )
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade show" id="activityLog" role="tabpanel">
                            <div class="card"
                                style="background-color: white; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05); border-radius: 10px; overflow: hidden;">
                                <div class="card-body">
                                    @include('leads.appointed_leads.log-activity.activity-log', [
                                        'generalInformation' => $leads->generalInformation,
                                    ])
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade show" id="audit" role="tabpanel">
                            <div class="card"
                                style="background-color: white; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05); border-radius: 10px; overflow: hidden;">
                                <div class="card-body">
                                    @include('customer-service.audit.audit-information-table', [
                                        'leadId' => $leads->id,
                                    ])
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade show" id="messages" role="tabpanel">
                            <div class="card"
                                style="background-color: white; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05); border-radius: 10px; overflow: hidden;">
                                <div class="card-body">
                                    @include('leads.appointed_leads.log-activity.notes-log', [
                                        'generalInformation' => $leads->generalInformation,
                                    ])
                                </div>
                            </div>
                        </div>

                        {{-- <div class="tab-pane fade show" id="bindocsPfa" role="tabpanel">
                            <div class="card"
                                style="background-color: white; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05); border-radius: 10px; overflow: hidden;">
                                <div class="card-body">
                                    @include('customer-service.binding-docs-pfa.index', [
                                        'generalInformation' => $leads->generalInformation,
                                        'leadId' => $leads->id,
                                    ])
                                </div>
                            </div>
                        </div> --}}

                        <div class="tab-pane fade show" id="quotation" role="tabpanel">
                            <div class="card"
                                style="background-color: white; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05); border-radius: 10px; overflow: hidden;">
                                <div class="card-body">
                                    @include('leads.appointed_leads.leads-quotation-forms.forms', [
                                        'products' => $products,
                                        'generalInformation' => $leads->generalInformation,
                                        'quotationMarket' => $quationMarket,
                                        'lead' => $leads,
                                    ])
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane" id="accounting" role="tabpanel">
                            <div class="card"
                                style="background-color: white; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05); border-radius: 10px; overflow: hidden;">
                                <div class="card-body">
                                    @include(
                                        'leads.appointed_leads.accounting-tab.appointed-accounting-tab',
                                        [
                                            'complianceOfficer' => $complianceOfficer,
                                            'generalInformation' => $leads->generalInformation,
                                            'selectedQuotes' => $selectedQuotes,
                                            'policyDetailId' => null,
                                        ]
                                    )
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade show" id="financingAgreement" role="tabpanel">
                            <div class="card"
                                style="background-color: white; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05); border-radius: 10px; overflow: hidden;">
                                <div class="card-body">
                                    @include(
                                        'customer-service.financing.finance-agreement.financing-table',
                                        [
                                            'leadId' => $leads->id,
                                        ]
                                    )
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade show" id="emails" role="tabpanel">
                            <div class="card"
                                style="background-color: white; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05); border-radius: 10px; overflow: hidden;">
                                <div class="card-body">
                                    @include('email.client-emails-table', [
                                        'leadId' => $leads->id,
                                    ])
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade show" id="policyList" role="tabpanel">
                            <div class="card"
                                style="background-color: white; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05); border-radius: 10px; overflow: hidden;">
                                <div class="card-body">
                                    @include('customer-service.policy.policy-lead-table-list', [
                                        'leadId' => $leads->id,
                                        'carriers' => $carriers,
                                        'markets' => $markets,
                                        'templates' => $templates,
                                    ])
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        @include('customer-service.audit.audit-information-modal')
    </div>
    <script>
        $(document).ready(function() {
            $('#fab').on('click', function() {
                $('#chatBox').toggle();
            });
        });
    </script>
@endsection
