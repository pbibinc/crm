<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriverSpouse extends Model
{
    use HasFactory;

    protected $table = 'driver_spouse_table';

    public $timestamps = false;

    protected $fillable = [
        'driver_information_id',
        'spouse_fullname',
    ];

    public static function getDriverSpouse($driverInformationId)
    {
        $driverSpouse = self::where('driver_information_id', $driverInformationId)->first();

        if($driverSpouse){
            return $driverSpouse;
        }
        return null;
    }
}
