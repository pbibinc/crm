{{-- Qoutation Forms --}}

@if ($quoteProduct->product == 'General Liability')
    @include('leads.appointed_leads.renewal-quotation-forms.quoation-form', [
        'generalInformation' => $generalInformation,
        'quationMarket' => $quationMarket->getMarketByProduct('General Liability'),
        'policyDetail' => $policyDetail,
        'quoteProduct' => $quoteProduct,
        'complianceOfficer' => $complianceOfficer,
        'productsDropdown' => [
            'Workers Compensation',
            'General Liability',
            'Commercial Auto',
            'Excess Liability',
            'Tools Equipment',
            'Builders Risk',
            'Business Owners',
        ],
    ])d
@endif

@if ($quoteProduct->product == 'Workers Compensation')
    @include('leads.appointed_leads.renewal-quotation-forms.quoation-form', [
        'generalInformation' => $generalInformation,
        'quationMarket' => $quationMarket->getMarketByProduct('Workers Compensation'),
        'quoteProduct' => $quoteProduct,
        'complianceOfficer' => $complianceOfficer,
        'productsDropdown' => [
            'Workers Compensation',
            'General Liability',
            'Commercial Auto',
            'Excess Liability',
            'Tools Equipment',
            'Builders Risk',
            'Business Owners',
        ],
    ])
@endif

@if ($quoteProduct->product == 'Commercial Auto')
    @include('leads.appointed_leads.renewal-quotation-forms.quoation-form', [
        'generalInformation' => $generalInformation,
        'quationMarket' => $quationMarket->getMarketByProduct('Commercial Auto'),
        'quoteProduct' => $quoteProduct,
        'complianceOfficer' => $complianceOfficer,
        'productsDropdown' => [
            'Workers Compensation',
            'General Liability',
            'Commercial Auto',
            'Excess Liability',
            'Tools Equipment',
            'Builders Risk',
            'Business Owners',
        ],
    ])
@endif

@if ($quoteProduct->product == 'Excess Liability')
    @include('leads.appointed_leads.renewal-quotation-forms.quoation-form', [
        'generalInformation' => $generalInformation,
        'quationMarket' => $quationMarket->getMarketByProduct('Excess Liability'),
        'quoteProduct' => $quoteProduct,
        'complianceOfficer' => $complianceOfficer,
        'productsDropdown' => [
            'Workers Compensation',
            'General Liability',
            'Commercial Auto',
            'Excess Liability',
            'Tools Equipment',
            'Builders Risk',
            'Business Owners',
        ],
    ])
@endif

@if ($quoteProduct->product == 'Tools Equipment')
    @include('leads.appointed_leads.renewal-quotation-forms.quoation-form', [
        'generalInformation' => $generalInformation,
        'quationMarket' => $quationMarket->getMarketByProduct('Tools Equipment'),
        'quoteProduct' => $quoteProduct,
        'complianceOfficer' => $complianceOfficer,
        'productsDropdown' => [
            'Workers Compensation',
            'General Liability',
            'Commercial Auto',
            'Excess Liability',
            'Tools Equipment',
            'Builders Risk',
            'Business Owners',
        ],
    ])
@endif

@if ($quoteProduct->product == 'Builders Risk')
    @include('leads.appointed_leads.renewal-quotation-forms.quoation-form', [
        'generalInformation' => $generalInformation,
        'quationMarket' => $quationMarket->getMarketByProduct('Builders Risk'),
        'quoteProduct' => $quoteProduct,
        'complianceOfficer' => $complianceOfficer,
        'productsDropdown' => [
            'Workers Compensation',
            'General Liability',
            'Commercial Auto',
            'Excess Liability',
            'Tools Equipment',
            'Builders Risk',
            'Business Owners',
        ],
    ])
@endif

@if ($quoteProduct->product == 'Business Owners')
    @include('leads.appointed_leads.renewal-quotation-forms.quoation-form', [
        'generalInformation' => $generalInformation,
        'quationMarket' => $quationMarket->getMarketByProduct('Business Owners Policy'),
        'quoteProduct' => $quoteProduct,
        'complianceOfficer' => $complianceOfficer,
        'productsDropdown' => [
            'Workers Compensation',
            'General Liability',
            'Commercial Auto',
            'Excess Liability',
            'Tools Equipment',
            'Builders Risk',
            'Business Owners',
        ],
    ])
@endif
