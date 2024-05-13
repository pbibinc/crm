<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuotationProductCallback extends Model
{
    use HasFactory;

    protected $table = 'quotation_product_callback';

    protected $fillable = [
        'quotation_product_id',
        'date_time',
        'remarks',
    ];

    public $timestamps = false;

    public function QuotationProduct()
    {
        return $this->belongsTo(QuotationProduct::class, 'quotation_product_id');
    }
}
