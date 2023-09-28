@extends('admin.admin_master')
@section('admin')

<div class="page-content pt-6">
    <div class="container-fluid">
        <div class="row">
            <div class="col-1">

            </div>
            <div class="col-7">

                <div class="row">
                    <div>
                        <h6>Contact <i class="ri-information-fill" style="vertical-align: middle; color: #6c757d;"></i></h6>
                        <div class="card">
                            <div class="card-body">
                                <div class="col-6">
                                    <h5>{{ $generalInformation->firstname. ' ' .$generalInformation->lastname}}</h5>
                                    <em>{{ $generalInformation->job_position }} at {{ $lead->company_name }}</em>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6">
                        <h6>Contact Info<i class="ri-information-fill" style="vertical-align: middle; color: #6c757d;"></i></h6>
                        <div class="card">
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <strong>Location</strong>
                                        <br>
                                        <strong>{{ $usAddress->city. ', ' .$usAddress->state }}</strong>
                                    </div>

                                    <div class="col-6">
                                       <strong>Local Time</strong>
                                       <br>
                                       <strong>{{ $localTime->format('M-d-Y g:iA') }}</strong>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <strong>Address</strong>
                                        <br>
                                        <strong>{{ $generalInformation->address}}</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                        <h6>Contact Details<i class="ri-information-fill" style="vertical-align: middle; color: #6c757d;"></i></h6>
                        <h6> <a href="" style="font-size:15px; color: #0f9cf3; font-weight:500" data-bs-toggle="modal" data-bs-target="#addLeadsModal" id="create_record"><i class="mdi mdi-plus"></i> Edit Contact Details</a></h6>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <strong>Email</strong>
                                        <br>
                                        <strong>{{ $generalInformation->email_address }}</strong>
                                    </div>
                                    <div class="col-6">
                                        <strong>Phone</strong>
                                        <br>
                                        <strong>{{ $lead->tel_num }}</strong>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <strong class="text-muted">Alternative Number</strong>
                                        <br>
                                        <strong>{{ $generalInformation->alt_num ? $generalInformation->alt_num : $lead->tel_num }}</strong>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div>
                        <h6>Products<i class="ri-information-fill" style="vertical-align: middle; color: #6c757d;"></i></h6>
                        <div class="card">
                            <div class="card-body">
                                <ul class="nav nav-pills nav-justified" role="tablist">
                                    @if ($generalInformation->generalLiabilities)
                                    <li class="nav-item waves-effect waves-light">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#generalLiabilites" role="tab" id="generalLiabilitiesButton">
                                            <span class="d-block d-sm-none"><i class="ri-umbrella-fill"></i></span>
                                            <span class="d-none d-sm-block">GL<i class="ri-umbrella-fill"  style="vertical-align: middle;"></i></span>
                                        </a>
                                    </li>
                                    @endif
                                    @if ($generalInformation->workersCompensation)
                                    <li class="nav-item waves-effect waves-light">
                                        <a class="nav-link" data-bs-toggle="tab" href="#workersCompensation" role="tab">
                                            <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                            <span class="d-none d-sm-block">WC<i class="ri-admin-fill" style="vertical-align: middle;"></i></span>
                                        </a>
                                    </li>
                                    @endif
                                    @if ($generalInformation->commercialAuto)
                                    <li class="nav-item waves-effect waves-light">
                                        <a class="nav-link" data-bs-toggle="tab" href="#commercialAuto" role="tab">
                                            <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                            <span class="d-none d-sm-block">CA<i class="ri-car-fill" style="vertical-align: middle;"></i></span>
                                        </a>
                                    </li>
                                    @endif
                                    @if ($generalInformation->excessLiability)
                                    <li class="nav-item waves-effect waves-light">
                                        <a class="nav-link" data-bs-toggle="tab" href="#excessLiabiliy" role="tab">
                                            <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                            <span class="d-none d-sm-block">EL<i class=" ri-hand-coin-fill" style="vertical-align: middle;"></i></span>
                                        </a>
                                    </li>
                                    @endif
                                    @if ($generalInformation->toolsEquipment)
                                    <li class="nav-item waves-effect waves-light">
                                        <a class="nav-link" data-bs-toggle="tab" href="#toolsEquipment" role="tab">
                                            {{-- <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span> --}}
                                            <span class="d-none d-sm-block">TE<i class="ri-tools-fill" style="vertical-align: middle;"></i></span>

                                        </a>
                                    </li>
                                    @endif
                                    @if ($generalInformation->buildersRisk)
                                    <li class="nav-item waves-effect waves-light">
                                        <a class="nav-link" data-bs-toggle="tab" href="#buildersRisk" role="tab">
                                            <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                            <span class="d-none d-sm-block">BR<i class="ri-building-fill" style="vertical-align: middle;"></i></span>
                                        </a>
                                    </li>
                                    @endif
                                    @if ($generalInformation->businessOwnersPolicy)
                                    <li class="nav-item waves-effect waves-light">
                                        <a class="nav-link" data-bs-toggle="tab" href="#bop" role="tab">
                                            <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                            <span class="d-none d-sm-block">BOP<i class="ri-suitcase-fill" style="vertical-align: middle;"></i></span>
                                        </a>
                                    </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="tab-content p-3 text-muted">
                        @if ($generalInformation->generalLiabilities)
                         <div class="tab-pane active" id="generalLiabilites" role="tabpanel">
                            @include('leads.appointed_leads.general-liability-profile', ['generalLiabilities' => $generalLiabilities])
                         </div>
                        @endif
                        @if ($generalInformation->workersCompensation)
                         <div class="tab-pane" id="workersCompensation" role="tabpanel">
                            @include('leads.appointed_leads.workers-comp-profile', ['generalInformation' => $generalInformation])
                         </div>
                        @endif
                        @if ($generalInformation->commercialAuto)
                          <div class="tab-pane" id="commercialAuto" role="tabpanel">
                            @include('leads.appointed_leads.commercial-auto-profile', ['generalInformation' => $generalInformation])
                          </div>
                        @endif
                        @if ($generalInformation->excessLiability)
                        <div class="tab-pane" id="excessLiabiliy" role="tabpanel">
                            @include('leads.appointed_leads.excess-liability-profile', ['generalInformation' => $generalInformation])
                        </div>
                        @endif
                        @if ($generalInformation->toolsEquipment)
                         <div class="tab-pane" id="toolsEquipment" role="tabpanel">
                            @include('leads.appointed_leads.tools-equipment-profile', ['generalInformation' => $generalInformation])
                         </div>
                        @endif
                        @if ($generalInformation->buildersRisk)
                          <div class="tab-pane" id="buildersRisk" role="tabpanel">
                            @include('leads.appointed_leads.builders-risk-profile', ['generalInformation' => $generalInformation])
                           </div>
                        @endif
                        @if ($generalInformation->businessOwnersPolicy)
                        <div class="tab-pane" id="bop" role="tabpanel">
                            @include('leads.appointed_leads.business-owners-profile', ['generalInformation' => $generalInformation])
                        </div>
                        @endif
                    </div>
                </div>

            </div>
            <div class="col-4">

                @include('leads.appointed_leads.history-log', ['generalInformation' => $generalInformation])
                <div class="tab-content p-3 text-muted">
                    <div class="quotation-form" id="generalLiabilitiesQuoationForm" role="tabpanel">
                        @if ($generalInformation->generalLiabilities)
                         @include('leads.appointed_leads.quoation-form', ['generalInformation' => $generalInformation, 'quationMarket' => $quationMarket, 'quoteProduct' => $lead->quoteLead->QuoteInformation->QuotationProduct->getQuotationProductByProduct('General Liabilities', $lead->quoteLead->QuoteInformation->id)])
                         @endif
                    </div>

                    <div class="quotation-form" id="workersCompensationForm" role="tabpanel">
                        @if ($generalInformation->workersCompensation)
                           @include('leads.appointed_leads.workers-compensation-quoation-form', ['generalInformation' => $generalInformation, 'quationMarket' => $quationMarket, 'quoteProduct' => $lead->quoteLead->QuoteInformation->QuotationProduct->getQuotationProductByProduct('Workers Compensation', $lead->quoteLead->QuoteInformation->id)])
                        @endif
                    </div>
                    <div class="quotation-form" id="commercialAutoForm" role="tabpanel">
                        @if ($generalInformation->commercialAuto)
                         @include('leads.appointed_leads.commercial-auto-quoation-form', ['generalInformation' => $generalInformation, 'quationMarket' => $quationMarket, 'quoteProduct' => $lead->quoteLead->QuoteInformation->QuotationProduct->getQuotationProductByProduct('Commercial Auto', $lead->quoteLead->QuoteInformation->id)])
                        @endif
                    </div>
                    {{-- <div class="quotation-form" id="excessLiabilityForm" role="tabpanel">
                        @if ($generalInformation->excessLiability)
                         @include('leads.appointed_leads.excess-liability-quoation-form', ['generalInformation' => $generalInformation, 'quationMarket' => $quationMarket, 'quoteProduct' => $lead->quoteLead->QuoteInformation->QuotationProduct->getQuotationProductByProduct('Excess Liability', $lead->quoteLead->QuoteInformation->id)])
                        @endif
                    </div> --}}
                    {{-- <div class="quotation-form" id="toolsEquipmentForm" role="tabpanel">
                        @if ($generalInformation->buildersRisk)
                          @include('leads.appointed_leads.tools-equipment-quoation-form', ['generalInformation' => $generalInformation, 'quationMarket' => $quationMarket, 'quoteProduct' => $lead->quoteLead->QuoteInformation->QuotationProduct->getQuotationProductByProduct('Tools Equipment', $lead->quoteLead->QuoteInformation->id)])
                        @endif
                    </div> --}}
                    {{-- <div class="quotation-form" id="buildersRiskForm" role="tabpanel">
                        @include('leads.appointed_leads.builders-risk-quoation-form', ['generalInformation' => $generalInformation, 'quationMarket' => $quationMarket, 'quoteProduct' => $lead->quoteLead->QuoteInformation->QuotationProduct->getQuotationProductByProduct('Builders Risk', $lead->quoteLead->QuoteInformation->id)])
                    </div> --}}
                    {{-- <div class="quotation-form" id="businessOwnersPolicyForm" role="tabpanel">
                        @include('leads.appointed_leads.business-owners-quoation-form', ['generalInformation' => $generalInformation, 'quationMarket' => $quationMarket, 'quoteProduct' => $lead->quoteLead->QuoteInformation->QuotationProduct->getQuotationProductByProduct('Business Owners', $lead->quoteLead->QuoteInformation->id)])
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function (){
        $('.quotation-form').hide()
        var target = '#generalLiabilitiesQuoationForm';
        $(target).show();
        $('.nav-link').on('click', function(){
            $('.quotation-form').hide()
            target = $(this).attr('href');
            if(target == '#generalLiabilites'){
                $('#generalLiabilitiesQuoationForm').show();
            }else if(target == '#workersCompensation'){
                $('#workersCompensationForm').show();
            }else if(target == '#commercialAuto'){
                $('#commercialAutoForm').show();
            }else if(target == '#excessLiabiliy'){
                $('#excessLiabilityForm').show();
            }
            else if(target == '#toolsEquipment'){
                $('#toolsEquipmentForm').show();
            }
            else if(target == '#buildersRisk'){
                $('#buildersRiskForm').show();
            }
            else if(target == '#bop'){
                $('#businessOwnersPolicyForm').show();
            }
        });

    });
</script>
@endsection

