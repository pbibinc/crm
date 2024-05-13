<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuoteComparison extends Model
{
    use HasFactory;

    protected $table = 'quote_comparison_table';

    protected $fillable = [
        'quotation_product_id',
        'quotation_market_id',
        'pricing_breakdown_id',
        'qoute_no',
        'full_payment',
        'down_payment',
        'monthly_payment',
        'number_of_payments',
        'broker_fee',
        'recommended',
        'effective_date'
    ];

    public function QuotationMarket()
    {
        return $this->belongsTo(QuoationMarket::class, 'quotation_market_id');
    }

    public function media()
    {
        return $this->belongsToMany(Metadata::class, 'quoatation_comparison_media_table', 'quote_comparison_id', 'metadata_id');
    }

    public function QuotationProduct()
    {
        return $this->belongsTo(QuotationProduct::class);
    }

    public function PaymentInformation()
    {
        return $this->hasOne(PaymentInformation::class, 'quote_comparison_id');
    }

    public function PricingBreakdown()
    {
        return $this->belongsTo(PricingBreakdown::class, 'pricing_breakdown_id');
    }

    public function RenewalQuotation()
    {
        return $this->hasOne(RenewalQuote::class, 'quote_comparison_id');
    }
}