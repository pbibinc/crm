<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ToolsEquipment extends Model
{
    use HasFactory;

    protected $table = 'tools_equipment_table';

    protected $fillable = [
        'general_information_id',
        'misc_tools_amount',
        'rented_less_equipment',
        'scheduled_equipment',
        'deductible_amount'
    ];

    public static function getIdByGeneralInformationId($leadId)
    {
        $toolsEquipment =  self::where('general_information_id', $leadId)->latest('created_at')->first()->id;

        if($toolsEquipment){
            return $toolsEquipment;
        }
        return null;
    }

    public static function getToolsEquipment($toolsEquipmentId)
    {
        $toolsEquipment = self::where('id', $toolsEquipmentId)->latest('created_at')->first();

        if($toolsEquipment){
            return $toolsEquipment;
        }
        return null;
    }

    public function equipmentInformation()
    {
        return $this->hasMany(EquipmentInformation::class, 'tools_equipment_id', 'id');
    }
}
