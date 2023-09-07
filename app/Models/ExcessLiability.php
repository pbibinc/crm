<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExcessLiability extends Model
{
    use HasFactory;

    protected $table = 'excess_liability_table';

    protected $fillable = [
        'general_information_id',
        'excess_limit',
        'excess_date',
        'insurance_carrier',
        'policy_number',
        'policy_premium',
        'general_liability_effective_date',
        'general_liability_expiration_date',
    ];

    public static function getExcessLiabilityData($id)
    {
        $excessLiability = self::where('general_information_id', $id)->latest('created_at')->first();
        if($excessLiability){
            return $excessLiability;
        }

        return null;
    }
}
