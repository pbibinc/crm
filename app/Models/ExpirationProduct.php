<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpirationProduct extends Model
{
    use HasFactory;

    protected $table = 'expiration_product_table';

    protected $fillable = [
        'general_information_id',
        'product',
        'expiration',
        'prior_carrier',
        'policy_limit',
        'each_accident',
        'remarks'
    ];

    public static function getExpirationProductByLeadIdProduct($leadId, $product)
    {
        $expirationProduct = self::where('lead_id', $leadId)
        ->where('product', $product)
        ->latest('created_at')
        ->first();

        if($expirationProduct){
            return $expirationProduct;
        }
        return null;
    }


}
