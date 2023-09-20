<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
