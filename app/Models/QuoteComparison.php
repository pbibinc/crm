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
        'full_payment',
        'down_payment',
        'monthly_payment',
        'broker_fee',
    ];

    public function QuotationMarket()
    {
        return $this->belongsTo(QuotationMarket::class, 'quotation_market_id');
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
}
