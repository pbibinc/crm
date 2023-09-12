<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriverInformation extends Model
{
    use HasFactory;

    protected $table = 'driver_information_table';

    protected $fillable = [
        'commercial_auto_id',
        'fullname',
        'date_of_birth',
        'driver_license_number',
        'marital_status',
        'years_of_experience',
        'created_at',
        'updated_at',

    ];

    public static function getDriverInformation($CommercialAutoId)
    {
        $driverInformation = self::where('commercial_auto_id', $CommercialAutoId)->get();

        if($driverInformation){
            return $driverInformation;
        }
        return null;
    }

    public function driverSpouse()
    {
        return $this->hasOne(DriverSpouse::class, 'driver_information_id', 'id');
    }


}
