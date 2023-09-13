<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuildersRisk extends Model
{
    use HasFactory;

    protected $table = 'builder_risk_table';

    protected $fillable = [
        'general_information_id',
        'property_address',
        'value_of_structure',
        'value_of_work',
        'has_project_started',
        'project_started_date',
        'construction_status',
        'construction_type',
        'protection_class',
        'square_footage',
        'number_floors',
        'number_dwelling',
        'jobsite_security',
        'firehydrant_distance',
        'firestation_distance',
    ];

    public static function getBuildersRiskData($id)
    {
        $buildersRisk = self::where('general_information_id', $id)->latest('created_at')->first();
        if($buildersRisk){
            return $buildersRisk;
        }

        return null;
    }

    public function newConstruction()
    {
        return $this->hasOne(NewContruction::class, 'builders_risk_id', 'id');
    }

    public function renovation()
    {
        return $this->hasOne(Rennovation::class, 'builders_risk_id', 'id');
    }

}
