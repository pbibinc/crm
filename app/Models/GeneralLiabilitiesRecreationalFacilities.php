<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralLiabilitiesRecreationalFacilities extends Model
{
    use HasFactory;

    protected $table = 'general_liability_facilities_table';
    
    public $timestamps = false;

    protected $fillable = [
        'general_liabilities_id',
        'recreational_facilities_id'
    ];
    
}