{{-- Qoutation Forms --}}

@if ($product->product == 'General Liability')
    @include('leads.appointed_leads.renewal-quotation-forms.quoation-form', [
        'generalInformation' => $generalInformation,
        'quationMarket' => $quationMarket->getMarketByProduct('General Liability'),
        'policyDetail' => $policyDetail,
        'quoteProduct' => $lead->quoteLead->QuoteInformation->QuotationProduct->getQuotationProductByProduct(
            'General Liability',
            $lead->quoteLead->QuoteInformation->id),
        'complianceOfficer' => $complianceOfficer,
    ])
@endif

@if ($product->product == 'Workers Compensation')
    @include('leads.appointed_leads.renewal-quotation-forms.quoation-form', [
        'generalInformation' => $generalInformation,
        'quationMarket' => $quationMarket->getMarketByProduct('Workers Compensation'),
        'quoteProduct' => $lead->quoteLead->QuoteInformation->QuotationProduct->getQuotationProductByProduct(
            'Workers Compensation',
            $lead->quoteLead->QuoteInformation->id),
        'complianceOfficer' => $complianceOfficer,
    ])
@endif

@if ($product->product == 'Commercial Auto')
    @include('leads.appointed_leads.renewal-quotation-forms.quoation-form', [
        'generalInformation' => $generalInformation,
        'quationMarket' => $quationMarket->getMarketByProduct('Commercial Auto'),
        'quoteProduct' => $lead->quoteLead->QuoteInformation->QuotationProduct->getQuotationProductByProduct(
            'Commercial Auto',
            $lead->quoteLead->QuoteInformation->id),
        'complianceOfficer' => $complianceOfficer,
    ])
@endif

@if ($product->product == 'Excess Liability')
    @include('leads.appointed_leads.renewal-quotation-forms.quoation-form', [
        'generalInformation' => $generalInformation,
        'quationMarket' => $quationMarket->getMarketByProduct('Excess Liability'),
        'quoteProduct' => $lead->quoteLead->QuoteInformation->QuotationProduct->getQuotationProductByProduct(
            'Excess Liability',
            $lead->quoteLead->QuoteInformation->id),
        'complianceOfficer' => $complianceOfficer,
    ])
@endif

@if ($product->product == 'Tools Equipment')
    @include('leads.appointed_leads.renewal-quotation-forms.quoation-form', [
        'generalInformation' => $generalInformation,
        'quationMarket' => $quationMarket->getMarketByProduct('Tools Equipment'),
        'quoteProduct' => $lead->quoteLead->QuoteInformation->QuotationProduct->getQuotationProductByProduct(
            'Tools Equipment',
            $lead->quoteLead->QuoteInformation->id),
        'complianceOfficer' => $complianceOfficer,
    ])
@endif

@if ($product->product == 'Builders Risk')
    @include('leads.appointed_leads.renewal-quotation-forms.quoation-form', [
        'generalInformation' => $generalInformation,
        'quationMarket' => $quationMarket->getMarketByProduct('Builders Risk'),
        'quoteProduct' => $generalInformation->lead->quoteLead->QuoteInformation->QuotationProduct->getQuotationProductByProduct(
            'Builders Risk',
            $generalInformation->lead->quoteLead->QuoteInformation->id),
        'complianceOfficer' => $complianceOfficer,
    ])
@endif

@if ($product->product == 'Business Owners')
    @include('leads.appointed_leads.renewal-quotation-forms.quoation-form', [
        'generalInformation' => $generalInformation,
        'quationMarket' => $quationMarket->getMarketByProduct('Business Owners Policy'),
        'quoteProduct' => $lead->quoteLead->QuoteInformation->QuotationProduct->getQuotationProductByProduct(
            'Business Owners',
            $lead->quoteLead->QuoteInformation->id),
        'complianceOfficer' => $complianceOfficer,
    ])
@endif
