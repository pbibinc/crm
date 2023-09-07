<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipmentInformation extends Model
{
    use HasFactory;

    protected $table = 'equipment_information_table';

    protected $fillable = [
        'tools_equipment_id',
        'equipment',
        'year',
        'make',
        'model',
        'serial_identification_no',
        'value',
        'year_acquired',
    ];

    public static function getEquipmentInformation($toolsEquipmentId)
    {
        $equipmentInformation = self::where('tools_equipment_id', $toolsEquipmentId)->latest('created_at')->first();

        if($equipmentInformation){
            return $equipmentInformation;
        }
        return null;
    }
}
