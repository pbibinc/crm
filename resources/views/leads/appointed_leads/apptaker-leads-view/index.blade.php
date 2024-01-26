@extends('admin.admin_master')
@section('admin')
    <div class="page-content pt-6">
        <div class="container-fluid">
            <div class="row">
                <div class="col-4">
                    <div class="card bg-info"
                        style="background-color: white; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05); border-radius: 10px; overflow: hidden;">
                        <div class="card-body">
                            <div class="card-body">
                                <h5 style="color:white"><i
                                        class="mdi mdi-account-hard-hat me-2"></i>{{ $leads->company_name }}
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-4">
                    <div class="card"
                        style="background-color: white; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05); border-radius: 10px; overflow: hidden;">
                        <div class="card-body">
                            <div class="row d-flex text-center">
                                <div>
                                    <h4>{{ $leads->GeneralInformation->firstname . ' ' . $leads->GeneralInformation->lastname }}
                                    </h4>
                                    {{ $leads->GeneralInformation->job_position }}
                                </div>
                            </div>
                            <div class="row">
                                <hr>
                            </div>

                            <div class="row mb-3">
                                <h5>Contact Information</h5>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6">
                                    <strong>Email Address:</strong>
                                    <br>
                                    <strong>{{ $leads->GeneralInformation->email_address }}</strong>
                                </div>
                                <div class="col-6">
                                    <strong>Tel Num:</strong>
                                    <br>
                                    <strong> {{ $leads->tel_num }}</strong>
                                </div>
                            </div>
                            <div class="row">
                                <strong>Alt Num:</strong>
                                <br>
                                <strong>{{ $leads->GeneralInformation->alt_num ? $leads->GeneralInformation->alt_num : $leads->tel_num }}</strong>
                            </div>

                            <div class="row">
                                <hr>
                            </div>
                            <div class="row mb-3">
                                <h5>Location Details</h5>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6">
                                    <strong>Location:</strong>
                                    <br>
                                    <strong>{{ $usAddress->city . ', ' . $usAddress->state }}</strong>
                                </div>

                                <div class="col-6">
                                    <strong>Local Time:</strong>
                                    <br>
                                    <strong>{{ $localTime->format('M-d-Y g:iA') }}</strong>
                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-6">
                                    <strong>Address:</strong>
                                    <br>
                                    <strong>{{ $leads->GeneralInformation->address }}</strong>
                                </div>
                            </div>
                            <div class="row">
                                <hr>
                            </div>
                            <div class="row mb-3">
                                <h5>Company Information</h5>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6">
                                    <strong>Full Time Employee:</strong>
                                    <br>
                                    <strong>{{ $leads->GeneralInformation->full_time_employee }}</strong>
                                </div>
                                <div class="col-6">
                                    <strong>Part Time Employee:</strong>
                                    <br>
                                    <strong>{{ $leads->GeneralInformation->part_time_employee }}</strong>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6">
                                    <strong>Owners Payroll:</strong>
                                    <br>
                                    <strong>${{ number_format($leads->GeneralInformation->owners_payroll, 2, '.', ',') }}</strong>
                                </div>
                                <div class="col-6">
                                    <strong>Employee Payroll:</strong>
                                    <br>
                                    <strong>${{ number_format($leads->GeneralInformation->employee_payroll, 2, '.', ',') }}</strong>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6">
                                    <strong>Gross Receipt:</strong>
                                    <br>
                                    <strong>${{ number_format($leads->GeneralInformation->gross_receipt, 2, '.', ',') }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-8">
                    <div class="card">
                        <div class="card-body">
                            <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist" style="margin-top: 0px">
                                <li class="nav-item">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#product" role="tab">
                                        <span class="d-none d-sm-block d-flex align-items-center justify-content-center"><i
                                                class=" ri-shopping-cart-2-line"></i> Product</span>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#activityLog" role="tab">
                                        <span class="d-none d-sm-block d-flex align-items-center justify-content-center"><i
                                                class=" ri-git-merge-line"></i> History Log</span>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#messages" role="tab">
                                        <span class="d-none d-sm-block"><i class="ri-file-edit-line"></i> Notes</span>
                                    </a>
                                </li>


                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#bindocsPfa" role="tab">
                                        <span class="d-none d-sm-block"><i class="ri-file-edit-line"></i> Bind
                                            Docs/PFA</span>
                                    </a>
                                </li>


                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#policies" role="tab">
                                        <span class="d-none d-sm-block"><i class="ri-file-edit-line"></i> Policies</span>
                                    </a>
                                </li>

                            </ul>
                        </div>
                    </div>
                    <div class="card"
                        style="background-color: white; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05); border-radius: 10px; overflow: hidden;">
                        <div class="card-body">
                            <div class="tab-content p-3 text-muted">
                                <div class="tab-pane fade show active" id="product" role="tabpanel">
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
                                                    $product->product == 'General Liabilities',
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
                                <div class="tab-pane fade show" id="activityLog" role="tabpanel">
                                    @include('leads.appointed_leads.log-activity.activity-log', [
                                        'generalInformation' => $leads->generalInformation,
                                    ])
                                </div>
                                <div class="tab-pane fade show" id="messages" role="tabpanel">
                                    @include('leads.appointed_leads.log-activity.notes-log', [
                                        'generalInformation' => $leads->generalInformation,
                                    ])
                                </div>
                                <div class="tab-pane fade show" id="bindocsPfa" role="tabpanel">
                                    testicles
                                </div>
                                <div class="tab-pane fade show" id="policies" role="tabpanel">
                                    @include('customer-service.policy.policy-view', ['id' => $leads->id])
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
