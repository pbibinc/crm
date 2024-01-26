@extends('admin.admin_master')
@section('admin')
    <style>
        .nav-tabs .nav-link.active {
            color: var(--bs-primary);
            border-top: 3px solid var(--bs-primary);
            /* adds a top border */
            border-bottom-color: transparent;
            /* to remove the default bottom border */
        }

        /* Adjust the hover effects if desired */
        .nav-tabs .nav-link.active:hover {
            color: darken(var(--bs-primary), 10%);
            /* darkens the color a bit on hover */
        }

        /* Add a right border to each nav item */
        .nav-separated .nav-item {
            border-right: 1px solid #dee2e6;
            /* Adjust the color as needed */
        }

        /* Remove the right border from the last nav item */
        .nav-separated .nav-item:last-child {
            border-right: none;
        }
    </style>

    <div class="page-content pt-6">
        <div class="container-fluid">
            <div class="row">
                <div class="col-4">
                    <div class="card bg-info"
                        style="background-color: white; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05); border-radius: 10px; overflow: hidden;">
                        <div class="card-body">
                            <h5 style="color:white"><i class="mdi mdi-account-hard-hat me-2"></i>{{ $lead->company_name }}
                            </h5>
                        </div>
                    </div>
                </div>
                <div class="col-4"></div>
                <div class="col-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>

                        </div>
                        <div>
                            <button type="button"
                                class="btn btn-lg btn-success btn-rounded waves-effect waves-light mt-2 d-flex align-items-center justify-content-center"
                                style="box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);"><i class="ri-add-circle-fill"></i> Add
                                Product</button>
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
                                    <h4>{{ $generalInformation->firstname . ' ' . $generalInformation->lastname }}</h4>
                                    {{ $generalInformation->job_position }}
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
                                    <strong>{{ $generalInformation->email_address }}</strong>
                                </div>
                                <div class="col-6">
                                    <strong>Tel Num:</strong>
                                    <br>
                                    <strong> {{ $lead->tel_num }}</strong>
                                </div>
                            </div>
                            <div class="row">
                                <strong>Alt Num:</strong>
                                <br>
                                <strong>{{ $generalInformation->alt_num ? $generalInformation->alt_num : $lead->tel_num }}</strong>
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
                                    <strong>{{ $generalInformation->address }}</strong>
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
                                    <strong>{{ $generalInformation->full_time_employee }}</strong>
                                </div>
                                <div class="col-6">
                                    <strong>Part Time Employee:</strong>
                                    <br>
                                    <strong>{{ $generalInformation->part_time_employee }}</strong>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6">
                                    <strong>Owners Payroll:</strong>
                                    <br>
                                    <strong>${{ number_format($generalInformation->owners_payroll, 2, '.', ',') }}</strong>
                                </div>
                                <div class="col-6">
                                    <strong>Employee Payroll:</strong>
                                    <br>
                                    <strong>${{ number_format($generalInformation->employee_payroll, 2, '.', ',') }}</strong>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6">
                                    <strong>Gross Receipt:</strong>
                                    <br>
                                    <strong>${{ number_format($generalInformation->gross_receipt, 2, '.', ',') }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-8">
                    <div class="card"
                        style="background-color: white; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05); border-radius: 10px; overflow: hidden;">

                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs nav-justified nav-separated" role="tablist" style="margin-top: 0px">
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
                                <a class="nav-link" data-bs-toggle="tab" href="#quotation" role="tab">
                                    <span class="d-none d-sm-block"><i class="fas fa-cog"></i> Quotation</span>
                                </a>
                            </li>
                        </ul>

                        <div class="card-body">
                            <!-- Tab panes -->
                            <div class="tab-content p-3 text-muted">
                                <div class="tab-pane fade show active" id="product" role="tabpanel">
                                    {{-- <div class="row mb-4"> --}}
                                    {{-- <div class="card mb-4 shadow-lg">
                                        <div class="card-body">
                                            <ul class="nav nav-pills nav-justified" role="tablist">
                                                @if ($product->product = 'General Liabilities')
                                                <li class="nav-item waves-effect waves-light">
                                                    <a class="nav-link navProfile active" data-bs-toggle="tab" href="#generalLiabilites" role="tab" id="generalLiabilitiesButton" style="white-space: nowrap;">
                                                       General Liabilities
                                                    </a>
                                                </li>
                                                @endif
                                                @if ($product->product = 'Workers Compensation')
                                                <li class="nav-item waves-effect waves-light">
                                                    <a class="nav-link navProfile" data-bs-toggle="tab" href="#workersCompensation" role="tab" style="white-space: nowrap;">
                                                        Workers Comp
                                                    </a>
                                                </li>
                                                @endif
                                                @if ($product->product = 'Commercial Auto')
                                                <li class="nav-item waves-effect waves-light">
                                                    <a class="nav-link navProfile" data-bs-toggle="tab" href="#commercialAuto" role="tab" style="white-space: nowrap;">
                                                        Commercial Auto
                                                    </a>
                                                </li>
                                                @endif
                                                @if ($product->product = 'Excess Liability')
                                                <li class="nav-item waves-effect waves-light">
                                                    <a class="nav-link navProfile" data-bs-toggle="tab" href="#excessLiabiliy" role="tab" style="white-space: nowrap;">
                                                        Excess Liability
                                                    </a>
                                                </li>
                                                @endif
                                                @if ($product->product = 'Tools Equipment')
                                                <li class="nav-item waves-effect waves-light">
                                                    <a class="nav-link navProfile" data-bs-toggle="tab" href="#toolsEquipment" role="tab" style="white-space: nowrap;">
                                                        Tools Equipment

                                                    </a>
                                                </li>
                                                @endif
                                                @if ($product->product = 'Builders Risk')
                                                <li class="nav-item waves-effect waves-light">
                                                    <a class="nav-link navProfile" data-bs-toggle="tab" href="#buildersRisk" role="tab" style="white-space: nowrap;">
                                                       Builders Risk
                                                    </a>
                                                </li>
                                                @endif
                                                @if ($product->product = 'Business Owners')
                                                <li class="nav-item waves-effect waves-light">
                                                    <a class="nav-link navProfile" data-bs-toggle="tab" href="#bop" role="tab" style="white-space: nowrap;">
                                                     Business Owners
                                                    </a>
                                                </li>
                                                @endif
                                            </ul>
                                        </div>
                                   </div> --}}
                                    {{-- </div> --}}

                                    <div class="row">

                                        @if ($product->product == 'General Liabilities')
                                            {{-- <div class="tab-pane active" id="generalLiabilites" role="tabpanel"> --}}
                                            @include(
                                                'leads.appointed_leads.product-view.general-liability-profile',
                                                [
                                                    'generalLiabilities' => $generalLiabilities,
                                                    'actionButtons' => false,
                                                ]
                                            )
                                            {{-- </div> --}}
                                        @endif
                                        @if ($product->product == 'Workers Compensation')
                                            {{-- <div class="tab-pane" id="workersCompensation" role="tabpanel"> --}}
                                            @include(
                                                'leads.appointed_leads.product-view.workers-comp-profile',
                                                [
                                                    'generalInformation' => $generalInformation,
                                                    'actionButtons' => false,
                                                ]
                                            )
                                            {{-- </div> --}}
                                        @endif
                                        @if ($product->product == 'Commercial Auto')
                                            {{-- <div class="tab-pane" id="commercialAuto" role="tabpanel"> --}}
                                            @include(
                                                'leads.appointed_leads.product-view.commercial-auto-profile',
                                                [
                                                    'generalInformation' => $generalInformation,
                                                    'actionButtons' => false,
                                                ]
                                            )
                                            {{-- </div> --}}
                                        @endif
                                        @if ($product->product == 'Excess Liability')
                                            {{-- <div class="tab-pane" id="excessLiabiliy" role="tabpanel"> --}}
                                            @include(
                                                'leads.appointed_leads.product-view.excess-liability-profile',
                                                [
                                                    'generalInformation' => $generalInformation,
                                                    'actionButtons' => false,
                                                ]
                                            )
                                            {{-- </div> --}}
                                        @endif
                                        @if ($product->product == 'Tools Equipment')
                                            {{-- <div class="tab-pane" id="toolsEquipment" role="tabpanel"> --}}
                                            @include(
                                                'leads.appointed_leads.product-view.tools-equipment-profile',
                                                [
                                                    'generalInformation' => $generalInformation,
                                                    'actionButtons' => false,
                                                ]
                                            )
                                            {{-- </div> --}}
                                        @endif
                                        @if ($product->product == 'Builders Risk')
                                            {{-- <div class="tab-pane" id="buildersRisk" role="tabpanel"> --}}
                                            @include(
                                                'leads.appointed_leads.product-view.builders-risk-profile',
                                                [
                                                    'generalInformation' => $generalInformation,
                                                    'actionButtons' => false,
                                                ]
                                            )
                                            {{-- </div> --}}
                                        @endif
                                        @if ($product->product == 'Business Owners')
                                            {{-- <div class="tab-pane" id="bop" role="tabpanel"> --}}
                                            @include(
                                                'leads.appointed_leads.product-view.business-owners-profile',
                                                [
                                                    'generalInformation' => $generalInformation,
                                                    'actionButtons' => false,
                                                ]
                                            )
                                            {{-- </div> --}}
                                        @endif

                                    </div>
                                </div>

                                <div class="tab-pane" id="activityLog" role="tabpanel">
                                    @include('leads.appointed_leads.log-activity.activity-log', [
                                        'generalInformation' => $generalInformation,
                                    ])
                                </div>

                                <div class="tab-pane" id="messages" role="tabpanel">
                                    @include('leads.appointed_leads.log-activity.notes-log', [
                                        'generalInformation' => $generalInformation,
                                    ])
                                </div>

                                <div class="tab-pane" id="quotation" role="tabpanel">
                                    @include('leads.appointed_leads.qoutation-forms/forms', [
                                        'product' => $product,
                                        'generalInformation' => $generalInformation,
                                        'quationMarket' => $quationMarket,
                                    ])

                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>

    <script>
        $(document).ready(function() {
            $('.quotation-form').hide()
            var target = '#generalLiabilitiesQuoationForm';
            $(target).show();
            $('.navProfile').on('click', function() {
                $('.quotation-form').hide()
                target = $(this).attr('href');
                if (target == '#generalLiabilites') {
                    $('#generalLiabilitiesQuoationForm').show();
                } else if (target == '#workersCompensation') {
                    $('#workersCompensationForm').show();
                } else if (target == '#commercialAuto') {
                    $('#commercialAutoForm').show();
                } else if (target == '#excessLiabiliy') {
                    $('#excessLiabilityForm').show();
                } else if (target == '#toolsEquipment') {
                    $('#toolsEquipmentForm').show();
                } else if (target == '#buildersRisk') {
                    $('#buildersRiskForm').show();
                } else if (target == '#bop') {
                    $('#businessOwnersPolicyForm').show();
                }
            });

        });
    </script>
@endsection
