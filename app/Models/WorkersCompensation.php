<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkersCompensation extends Model
{
    use HasFactory;

    protected $fillable = [
        'general_information_id',
        'specific_employee_description',
        'fein_number',
        'ssin_number',
        'expiration',
        'prior_carrier',
        'policy_limit',
        'each_accident',
        'remarks'
    ];

    protected $table = 'workers_compensation_table';

    public function classCodePerEmployee()
    {
       return $this->hasMany(ClasscodePerEmployee::class);
    }

}