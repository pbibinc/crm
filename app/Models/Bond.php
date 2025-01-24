<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bond extends Model
{
    use HasFactory;


    protected $table = 'bond';

    protected $fillable = [
        'general_information_id',
        'bond_state',
        'bond_type',
        'ssn',
        'date_of_birth',
        'marital_status',
        'contractor_license',
        'bond_obligee',
        'obligee_address',
        'bond_amount',
    ];

    public function generalInformation()
    {
        return $this->belongsTo(GeneralInformation::class);
    }



}
