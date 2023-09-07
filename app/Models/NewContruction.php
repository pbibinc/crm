<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewContruction extends Model
{
    use HasFactory;

    protected $table = 'new_construction_table';

    protected $fillable = [
        'builders_risk_id',
        'description_operation',
    ];

    public static function getNewConstructionData($id)
    {
        $newConstruction = self::where('builders_risk_id', $id)->latest('created_at')->first();
        if($newConstruction){
            return $newConstruction;
        }

        return null;
    }
}
