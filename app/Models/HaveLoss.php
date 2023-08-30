<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HaveLoss extends Model
{
    use HasFactory;

    protected $table = 'have_losses_table';

public $timestamps = false;

    protected $fillable = [
        'lead_id',
        'product',
        'losses',
        'date_of_claim',
        'loss_amount'
    ];

    public static function getHaveLossbyLeadIdProduct($leadId, $product)
    {
        $haveLoss = self::where('lead_id', $leadId)->where('product', $product)->latest('id')->first();

        if($haveLoss){
            return $haveLoss;
        }
        return null;
    }
}
