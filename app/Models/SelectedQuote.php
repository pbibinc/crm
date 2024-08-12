<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SelectedQuote extends Model
{
    use HasFactory;
    protected $table = 'selected_quote';

    protected $fillable = [
        'quotation_product_id',
        'quotation_market_id',
        'pricing_breakdown_id',
        'payment_charged_id',
        'quote_no',
        'full_payment',
        'down_payment',
        'monthly_payment',
        'number_of_payments',
        'broker_fee',
        'recommended',
        'effective_date',
    ];

    public function SelectedPricingBreakDown()
    {
        return $this->belongsTo(SelectedPricingBreakDown::class, 'pricing_breakdown_id', 'id');
    }

    public function media()
    {
        return $this->belongsToMany(Metadata::class, 'selected_quote_media', 'selected_quote_id', 'metadata_id');
    }

    public function QuotationMarket()
    {
        return $this->belongsTo(QuoationMarket::class, 'quotation_market_id');
    }

    public function QuotationProduct()
    {
        return $this->belongsTo(QuotationProduct::class, 'quotation_product_id');
    }

    public function PaymentInformation()
    {
        return $this->hasOne(PaymentInformation::class, 'selected_quote_id');
    }

    public function PricingBreakdown()
    {
        return $this->belongsTo(SelectedPricingBreakDown::class, 'pricing_breakdown_id');
    }

    public function RenewalQuotation()
    {
        return $this->hasOne(RenewalQuote::class, 'quote_comparison_id');
    }

    public function PolicyDetail()
    {
        return $this->hasOne(PolicyDetail::class, 'selected_quote_id');
    }

    public function FinancingAgreement()
    {
        return $this->hasOne(FinancingAgreement::class, 'selected_quote_id', 'id');
    }

    public function TotalCost()
    {
        if($this->FinancingAgreement)
        {
            $totalMonthlyCost = (int)$this->monthly_payment * (int)$this->number_of_payments;
            $totalCostForInstallment = $totalMonthlyCost + (int)$this->down_payment;
            return $totalCostForInstallment;
        }else{
            return $this->full_payment;
        }
    }

}
