<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkersCompPolicy extends Model
{
    use HasFactory;

    protected $table = 'workers_comp_policy_details';

    protected $fillable = [
        'policy_details_id',
        'is_subr_wvd',
        'is_per_statute',
        'el_each_accident',
        'el_disease_each_employee',
        'el_disease_policy_limit'
    ];
}