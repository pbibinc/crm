<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommercialAuto extends Model
{
    use HasFactory;

    protected $table = 'commercial_auto_table';

    protected $fillable = [
        'general_information_id',
        'fein',
        'ssn',
    ];

    public static function getIdbyGeneralInformationId($GeneralInformationId)
    {
        $commercialAuto = self::where('general_information_id', $GeneralInformationId)->latest()->value('id');

        if($commercialAuto){
            return $commercialAuto;
        }
        return null;
    }

    public static function getCommercialAuto($commercialAutoId)
    {
        $commercialAuto = self::where('id', $commercialAutoId)->first();

        if($commercialAuto){
            return $commercialAuto;
        }
        return null;
    }
}
