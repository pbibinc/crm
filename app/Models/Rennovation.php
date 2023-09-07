<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rennovation extends Model
{
    use HasFactory;

    protected $table = 'rennovation_table';

    protected $fillable = [
        'builders_risk_id',
        'description',
        'last_update_roofing',
        'last_update_heating',
        'last_update_plumbing',
        'last_update_electrical',
        'stucture_occupied',
        'structure_built',
        'description_operation',
    ];

    public static function getRennovationData($id)
    {
        $rennovation = self::where('builders_risk_id', $id)->latest('created_at')->first();

        if($rennovation){
            return $rennovation;
        }

        return null;
    }
}
