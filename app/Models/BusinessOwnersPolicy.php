<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessOwnersPolicy extends Model
{
    use HasFactory;

    protected $table = 'business_owners_policy_table';

    protected $fillable = [
        'general_information_id',
        'property_address',
        'loss_payee_information',
        'building_industry',
        'occupancy',
        'building_cost',
        'business_property_limit',
        'building_construction_type',
        'year_built',
        'square_footage',
        'floor_number',
        'automatic_sprinkler_system',
        'automatic_fire_alarm',
        'nereast_fire_hydrant',
        'nearest_fire_station',
        'commercial_coocking_system',
        'automatic_bulgar_alarm',
        'security_camera',
        'last_update_roofing',
        'last_update_heating',
        'last_update_plumbing',
        'last_update_electrical',
        'amount_policy',
    ];

    public static function getBusinessOwnersPolicyData($id)
    {
        $businessOwnersPolicy = self::where('general_information_id', $id)->latest('created_at')->first();
        if($businessOwnersPolicy){
            return $businessOwnersPolicy;
        }

        return null;
    }
}
