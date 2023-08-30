<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleInformation extends Model
{
    use HasFactory;

    protected $table = 'vehicle_information_table';

    public $timestamps = false;

    protected $fillable = [
        'commercial_auto_id',
        'year',
        'make',
        'model',
        'vin',
        'radius_miles',
        'cost_new_vehicle'
    ];

    public static function getVehicleInformation($CommercialAutoId)
    {
        $vehicleInformation = self::where('commercial_auto_id', $CommercialAutoId)->get();

        if($vehicleInformation){
            return $vehicleInformation;
        }
        return null;
    }

}
