<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CrossSell extends Model
{
    use HasFactory;

    protected $table = 'cross_sell_table';

    protected $fillable = [
        'lead_id',
        'product',
        'cross_sell',
        'created_at',
        'udated_at',
    ];

    public static function getCrossSelByLeadIdProduct($leadId, $product)
    {
        $crossSell = self::where('lead_id', $leadId)->where('product', $product)->latest('created_at')->first();

        if($crossSell){
            return $crossSell;
        }
        return null;
    }
}
