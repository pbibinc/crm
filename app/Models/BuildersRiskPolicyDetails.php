<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuildersRiskPolicyDetails extends Model
{
    use HasFactory;

    protected $table = 'builders_risk_policy_details';

    protected $fillable = [
        'policy_details_id',
        'is_subr_wvd',
        'is_addl_insd'
    ];
}
