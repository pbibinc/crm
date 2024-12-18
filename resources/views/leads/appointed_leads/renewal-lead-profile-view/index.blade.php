@extends('admin.admin_master')
@section('admin')
    <div class="page-content pt-6">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4">
                    <div class="row mb-2">
                        <div class="col-12">
                            <div class="card"
                                style="background-color: white; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); border-radius: 8px; padding: 8px;">
                                <div class="card-body" style="text-align: center;">
                                    <h6 style="margin-bottom: 10px;">Change Status:</h6>
                                    <div class="form-group" style="margin-bottom: 10px;">
                                        <select class="form-control select2-search-disable" id="statusSelect"
                                            style="border: 1px solid #ccc; border-radius: 4px; padding: 6px;">
                                            @if ($product->status == 3 || $product->status == 4 || $product->status == 5)
                                                <option value="3" @if ($product->status == 3) selected @endif>
                                                    Pending
                                                </option>
                                                <option value="4" @if ($product->status == 4) selected @endif>
                                                    Follow
                                                    Up</option>
                                                <option value="5" @if ($product->status == 5) selected @endif>
                                                    Declined</option>
                                            @endif
                                            @if ($product->status == 11)
                                                <option value="11" @if ($product->status == 11) selected @endif>
                                                    Bound</option>
                                            @endif
                                            @if ($product->status == 8)
                                                <option value="8" @if ($product->status == 8) selected @endif>
                                                    Issued</option>
                                            @endif
                                            @if ($product->status == 9)
                                                <option value="9" @if ($product->status == 9) selected @endif>
                                                    Make A Payment</option>
                                            @endif
                                            @if ($product->status == 17 || $product->status == 10)
                                                <option value="17" @if ($product->status == 17) selected @endif>
                                                    Request To Bind</option>
                                                <option value="10" @if ($product->status == 10) selected @endif>
                                                    Payment Approved</option>
                                            @endif
                                            @if ($product->status == 13)
                                                <option value="13" @if ($product->status == 13) selected @endif>
                                                    Payment Declined</option>
                                            @endif
                                            @if ($product->status == 14)
                                                <option value="14" @if ($product->status == 14) selected @endif>
                                                    Binding Declined</option>
                                                <option value="18" @if ($product->status == 18) selected @endif>
                                                    Resend RTB</option>
                                            @endif
                                            @if ($product->status == 18)
                                                <option value="18" @if ($product->status == 18) selected @endif>
                                                    Resend RTB</option>
                                            @endif
                                            @if ($product->status == 19)
                                                <option value="19" @if ($product->status == 19) selected @endif>
                                                    Binding</option>
                                            @endif
                                            @if ($product->status == 20)
                                                <option value="20" @if ($product->status == 20) selected @endif>
                                                    Bound</option>
                                            @endif
                                            @if ($product->status == 12)
                                                <option value="12" @if ($product->status == 12) selected @endif>
                                                    Binding</option>
                                            @endif
                                            @if ($product->status == 23)
                                                <option value="23" @if ($product->status == 23) selected @endif>
                                                    Declined Binding</option>
                                                <option value="18" @if ($product->status == 18) selected @endif>
                                                    Resend RTB</option>
                                            @endif
                                        </select>
                                    </div>
                                    @if ($product->status !== 13 && $product->status !== 9)
                                        <button type="button" class="btn btn-success waves-effect waves-light"
                                            style="padding: 6px 12px; font-size: 14px;"
                                            id="saveStatusButton">Submit</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card shadow-lg mb-5 bg-white rounded">
                        <div class="card-body">
                            @include('leads.appointed_leads.apptaker-leads-view.client-general-information')
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="row mb-2">
                        @include('leads.appointed_leads.apptaker-leads-view.company-header', [
                            'leads' => $leads,
                        ])
                    </div>
                    @include('leads.appointed_leads.apptaker-leads-view.company-navigation-tab')
                    <div class="tab-content text-muted mt-3">

                        {{-- overview tab --}}
                        <div class="tab-pane fade show active" id="overview" role="tabpanel">
                            @include('leads.appointed_leads.apptaker-leads-view.profile-summary', [
                                'leads' => $leads,
                                'leadId' => $leads->id,
                                'carriers' => $carriers,
                                'markets' => $markets,
                                'templates' => $templates,
                                'activePolicies' => $activePolicies,
                                'userProfiles' => $userProfiles,
                            ])
                        </div>

                        {{-- client info tab --}}
                        <div class="tab-pane fade show" id="clientinfo" role="tabpanel">
                            <div class="card">
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
                                </div>
                            </div>

                            <div class="card shadow-lg mb-5 bg-white rounded">
                                <div class="card-body">

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

                        {{-- quote tab --}}
                        <div class="tab-pane" id="quotation" role="tabpanel">
                            <div class="card"
                                style="background-color: white; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05); border-radius: 10px; overflow: hidden;">
                                <div class="card-body">
                                    @include('leads.appointed_leads.renewal-quotation-forms/forms', [
                                        'product' => $product,
                                        'generalInformation' => $generalInformation,
                                        'quationMarket' => $quationMarket,
                                        'complianceOfficer' => $complianceOfficer,
                                        'policyDetail' => $policyDetail,
                                        'products' => $products,
                                        'quoteProduct' => $quotationProduct,
                                    ])
                                </div>
                            </div>
                        </div>

                        {{-- notes tab --}}
                        <div class="tab-pane fade show" id="messages" role="tabpanel">
                            <div class="card shadow-lg p-3 mb-5 bg-white rounded">
                                <div class="card-header">

                                </div>
                                <div class="card-body">
                                    @include('leads.appointed_leads.log-activity.notes-log', [
                                        'generalInformation' => $leads->generalInformation,
                                    ])
                                </div>
                            </div>
                        </div>

                        {{-- financing tab --}}
                        <div class="tab-pane" id="financing" role="tabpanel">
                            <div class="card shadow-lg p-3 mb-5 bg-white rounded">
                                <div class="card-header">
                                    <h4 class="card-title">Payments</h4>
                                </div>
                                <div class="card-body">
                                    @include(
                                        'leads.appointed_leads.accounting-tab.appointed-accounting-tab',
                                        [
                                            'complianceOfficer' => $complianceOfficer,
                                            'generalInformation' => $leads->generalInformation,
                                            'selectedQuotes' => $selectedQuotes,
                                            'policyDetailId' => null,
                                            'paymentType' => ' ',
                                        ]
                                    )
                                </div>
                            </div>

                            <div class="card shadow-lg p-3 mb-5 bg-white rounded">
                                <div class="card-header">
                                    <h4 class="card-title">Financing</h4>
                                </div>
                                <div class="card-body">
                                    @include(
                                        'customer-service.financing.finance-agreement.financing-table',
                                        [
                                            'leadId' => $leads->id,
                                            'financeCompany' => $financeCompany,
                                        ]
                                    )
                                </div>
                            </div>


                        </div>

                        {{-- audit tab --}}
                        <div class="tab-pane" id="audit" role="tabpanel">
                            <div class="card shadow-lg mb-5 bg-white rounded">
                                <div class="card-body">
                                    @include('customer-service.audit.audit-information-table', [
                                        'leadId' => $leads->id,
                                    ])
                                </div>
                            </div>
                        </div>

                        {{-- emails tab --}}
                        <div class="tab-pane" id="emails" role="tabpanel">
                            @include('email.client-emails-table', [
                                'productId' => $quotationProduct->id ?? null,
                                'templates' => $templates,
                                'leadId' => $leads->id,
                            ])
                        </div>

                        {{-- policy list tab --}}
                        <div class="tab-pane" id="policyList" role="tabpanel">
                            <div class="card shadow-lg p-3 mb-5 bg-white rounded">
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

                        {{-- activity log --}}
                        <div class="tab-pane fade show" id="activityLog" role="tabpanel">
                            <div class="card shadow-lg p-3 mb-5 bg-white rounded"
                                style="background-color: white; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05); border-radius: 10px; overflow: hidden;">
                                <div class="card-body">
                                    @include('leads.appointed_leads.log-activity.activity-log', [
                                        'generalInformation' => $leads->generalInformation,
                                    ])
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('customer-service.audit.audit-information-modal')
@endsection
