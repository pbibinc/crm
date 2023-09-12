<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitedState extends Model
{
    use HasFactory;

    protected $table = 'us';

    public static function getUsAddress($zipcode)
    {
        $us = self::where('zipcode', $zipcode)->first();

        if($us){
            return $us;
        }

        return null;
    }
}
