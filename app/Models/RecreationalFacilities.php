<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecreationalFacilities extends Model
{
    use HasFactory;

    protected $table = 'recreational_facilities';

    public function recreationalFacility()
    {
        return $this->belongsToMany(GeneralLiabilities::class, 'general_liabilities_table', 'recreational_facilities_id', 'general_liabilities_id')->withPivot('percentage');
    }


}