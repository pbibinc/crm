<div class="card mb-4 shadow-lg">
    <div class="card-body">
        <div class="row">
            <ul class="nav nav-pills nav-justified" role="tablist">
                @if ($generalInformation->generalLiabilities)
                <li class="nav-item waves-effect waves-light">
                    <a class="nav-link navProfile active" data-bs-toggle="tab" href="#generalLiabilites" role="tab" id="generalLiabilitiesButton" style="white-space: nowrap;">
                       General Liabilities
                    </a>
                </li>
                @endif
                @if ($generalInformation->workersCompensation)
                <li class="nav-item waves-effect waves-light">
                    <a class="nav-link navProfile" data-bs-toggle="tab" href="#workersCompensation" role="tab" style="white-space: nowrap;">
                        Workers Comp
                    </a>
                </li>
                @endif
                @if ($generalInformation->commercialAuto)
                <li class="nav-item waves-effect waves-light">
                    <a class="nav-link navProfile" data-bs-toggle="tab" href="#commercialAuto" role="tab" style="white-space: nowrap;">
                        Commercial Auto
                    </a>
                </li>
                @endif
                @if ($generalInformation->excessLiability)
                <li class="nav-item waves-effect waves-light">
                    <a class="nav-link navProfile" data-bs-toggle="tab" href="#excessLiabiliy" role="tab" style="white-space: nowrap;">
                        Excess Liability
                    </a>
                </li>
                @endif
                @if ($generalInformation->toolsEquipment)
                <li class="nav-item waves-effect waves-light">
                    <a class="nav-link navProfile" data-bs-toggle="tab" href="#toolsEquipment" role="tab" style="white-space: nowrap;">
                        Tools Equipment

                    </a>
                </li>
                @endif
                @if ($generalInformation->buildersRisk)
                <li class="nav-item waves-effect waves-light">
                    <a class="nav-link navProfile" data-bs-toggle="tab" href="#buildersRisk" role="tab" style="white-space: nowrap;">
                       Builders Risk
                    </a>
                </li>
                @endif
                @if ($generalInformation->businessOwners)
                <li class="nav-item waves-effect waves-light">
                    <a class="nav-link navProfile" data-bs-toggle="tab" href="#bop" role="tab" style="white-space: nowrap;">
                     Business Owners
                    </a>
                </li>
                @endif
            </ul>
        </div>
    </div>
</div>




{{-- Qoutation Forms --}}
<div class="quotation-form" id="generalLiabilitiesQuoationForm" role="tabpanel">
    @if ($generalInformation->generalLiabilities )
     @include('leads.appointed_leads.qoutation-forms.quoation-form', ['generalInformation' => $generalInformation, 'quationMarket' => $quationMarket, 'quoteProduct' => $lead->quoteLead->QuoteInformation->QuotationProduct->getQuotationProductByProduct('General Liabilities', $lead->quoteLead->QuoteInformation->id)])
     @endif
</div>

<div class="quotation-form" id="workersCompensationForm" role="tabpanel">
    @if ($generalInformation->workersCompensation)
       @include('leads.appointed_leads.qoutation-forms.workers-compensation-quoation-form', ['generalInformation' => $generalInformation, 'quationMarket' => $quationMarket, 'quoteProduct' => $lead->quoteLead->QuoteInformation->QuotationProduct->getQuotationProductByProduct('Workers Compensation', $lead->quoteLead->QuoteInformation->id)])
    @endif
</div>
<div class="quotation-form" id="commercialAutoForm" role="tabpanel">
    @if ($generalInformation->commercialAuto)
     @include('leads.appointed_leads.qoutation-forms.commercial-auto-quoation-form', ['generalInformation' => $generalInformation, 'quationMarket' => $quationMarket, 'quoteProduct' => $lead->quoteLead->QuoteInformation->QuotationProduct->getQuotationProductByProduct('Commercial Auto', $lead->quoteLead->QuoteInformation->id)])
    @endif
</div>
<div class="quotation-form" id="excessLiabilityForm" role="tabpanel">
    @if ($generalInformation->excessLiability)
     @include('leads.appointed_leads.qoutation-forms.excess-liability-quoation-form', ['generalInformation' => $generalInformation, 'quationMarket' => $quationMarket, 'quoteProduct' => $lead->quoteLead->QuoteInformation->QuotationProduct->getQuotationProductByProduct('Excess Liability', $lead->quoteLead->QuoteInformation->id)])
    @endif
</div>
<div class="quotation-form" id="toolsEquipmentForm" role="tabpanel">
    @if ($generalInformation->toolsEquipment)
      @include('leads.appointed_leads.qoutation-forms.tools-equipment-quoation-form', ['generalInformation' => $generalInformation, 'quationMarket' => $quationMarket, 'quoteProduct' => $lead->quoteLead->QuoteInformation->QuotationProduct->getQuotationProductByProduct('Tools Equipment', $lead->quoteLead->QuoteInformation->id)])
    @endif
</div>
<div class="quotation-form" id="buildersRiskForm" role="tabpanel">
    @if ($generalInformation->buildersRisk)
    @include('leads.appointed_leads.qoutation-forms.builders-risk-quoation-form', ['generalInformation' => $generalInformation, 'quationMarket' => $quationMarket, 'quoteProduct' => $generalInformation->lead->quoteLead->QuoteInformation->QuotationProduct->getQuotationProductByProduct('Builders Risk', $generalInformation->lead->quoteLead->QuoteInformation->id)])
    @endif
</div>
<div class="quotation-form" id="businessOwnersPolicyForm" role="tabpanel">
    @if ($generalInformation->businessOwners)
    @include('leads.appointed_leads.qoutation-forms.business-owners-quoation-form', ['generalInformation' => $generalInformation, 'quationMarket' => $quationMarket, 'quoteProduct' => $lead->quoteLead->QuoteInformation->QuotationProduct->getQuotationProductByProduct('Business Owners', $lead->quoteLead->QuoteInformation->id)])
    @endif
</div>
