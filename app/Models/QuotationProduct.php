<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use League\CommonMark\Extension\SmartPunct\Quote;

class QuotationProduct extends Model
{
    use HasFactory;

    protected $table = 'quotation_product_table';

    protected $fillable = [
        'quote_information_id',
        'product_id',
        'quantity',
        'price',
        'total',
    ];

    public function QouteComparison()
    {
        return $this->hasMany(QouteComparison::class, 'quotation_product_id');
    }

    public function QuoteInformation()
    {
        return $this->belongsTo(QuoteInformation::class, 'quote_information_id');
    }

    public static function getQuotationProductByProduct($product , $quote_information_id)
    {
        return self::where('quote_information_id', $quote_information_id)
            ->where('product', $product)
            ->first()
            ->id;


    }
}
