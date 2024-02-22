<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExcessLiabilityInsurancePolicy extends Model
{
    use HasFactory;

    protected $table = 'excess_insurance_policy_details';

    protected $fillable = [
        'policy_details_id',
        'is_umbrella_liability',
        'is_excess_liability',
        'is_occur',
        'is_claims_made',
        'is_ded',
        'is_retention',
        'is_addl_insd',
        'is_subr_wvd',
        'each_occurrence',
        'aggregate',
    ];
}