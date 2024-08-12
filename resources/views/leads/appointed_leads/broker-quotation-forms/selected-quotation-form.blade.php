@php
    use App\Models\SelectedQuote;
    use App\Models\QuoationMarket;
    use App\Models\SelectedPricingBreakDown;

    // $selectedQuote = SelectedQuote::find($selectedQuoteId);
    $quoteMarket = QuoationMarket::where('id', $selectedQuote->quotation_market_id)->first();
    $selectedPricingBreakdown = SelectedPricingBreakDown::find($selectedQuote->pricing_breakdown_id);

@endphp
<div class="row">
    <hr>
</div>
<div class="row mb-3">
    <div class="col-6">
        <b>Market:</b>
        {{ $quoteMarket->name }}
    </div>
    <div class="col-6">
        <b>Policy No:</b>
        {{ $selectedQuote->quote_no }}
    </div>
</div>
<div class="row mb-3">
    <div class="col-6">
        <b>Premium:</b>
        {{ $selectedPricingBreakdown->premium }}
    </div>
    <div class="col-6">
        <b>Endorsements:</b>
        {{ $selectedPricingBreakdown->endorsements }}
    </div>
</div>
<div class="row mb-3">
    <div class="col-6">
        <b>Policy Fee:</b>
        {{ $selectedPricingBreakdown->policy_fee }}
    </div>
    <div class="col-6">
        <b>Inspection Fee:</b>
        {{ $selectedPricingBreakdown->inspection_fee }}
    </div>
</div>
<div class="row mb-3">
    <div class="col-6">
        <b>Stamping Fee:</b>
        {{ $selectedPricingBreakdown->stamping_fee }}
    </div>
    <div class="col-6">
        <b>Surplus Lines Tax:</b>
        {{ $selectedPricingBreakdown->surplus_lines_tax }}
    </div>
</div>
<div class="row mb-3">
    <div class="col-6">
        <b>Placement Fee:</b>
        {{ $selectedPricingBreakdown->placement_fee }}
    </div>
    <div class="col-6">
        <b>Broker Fee:</b>
        {{ $selectedPricingBreakdown->broker_fee }}
    </div>
</div>
<div class="row mb-3">
    <div class="col-6">
        <b>Miscellaneous Fee:</b>
        {{ $selectedPricingBreakdown->miscellaneous_fee }}
    </div>
</div>
<div class="row mb-3">
    <div class="col-6">
        <b>Full Payment:</b>
        {{ $selectedQuote->full_payment }}
    </div>
    <div class="col-6">
        <b>Down Payment:</b>
        {{ $selectedQuote->down_payment }}
    </div>
</div>
<div class="row mb-3">
    <div class="col-6">
        <b>Monthly Payment:</b>
        {{ $selectedQuote->monthly_payment }}
    </div>
    <div class="col-6">
        <b>Number of Payments:</b>
        {{ $selectedQuote->number_of_payments }}
    </div>
</div>
