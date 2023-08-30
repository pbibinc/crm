<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommercialAutoSupllemental extends Model
{
    use HasFactory;

    protected $table = 'commercial_auto_supplemental_table';

    public $timestamps = false;

    protected $fillable = [
        'commercial_auto_id',
        'vehicle_maintenance_program',
        'vehicle_maintenace_description',
        'is_vehicle_customized',
        'vehicle_customized_description',
        'is_vehicle_owned_by_prospect',
        'declined_canceled_nonrenew_policy',
        'prospect_loss',
        'vehicle_use_for_towing',
    ];

    public static function getCommercialSupplementalAuto($commercialAutoId)
    {
        $commercialAutoSupplemental = self::where('commercial_auto_id', $commercialAutoId)->first();

        if($commercialAutoSupplemental){
            return $commercialAutoSupplemental;
        }
        return null;
    }
}
