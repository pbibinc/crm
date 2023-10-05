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
