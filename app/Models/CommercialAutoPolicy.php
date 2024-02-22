<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommercialAutoPolicy extends Model
{
    use HasFactory;

    protected $table = 'commercial_auto_policy_detail';

    protected $fillable = [
        'policy_details_id',
        'is_any_auto',
        'is_owned_auto',
        'is_scheduled_auto',
        'is_hired_auto',
        'is_non_owned_auto',
        'is_addl_insd',
        'is_subr_wvd',
        'combined_single_unit',
        'bi_per_person',
        'bi_per_accident',
        'property_damage'
    ];
}