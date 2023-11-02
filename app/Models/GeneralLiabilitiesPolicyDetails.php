<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralLiabilitiesPolicyDetails extends Model
{
    use HasFactory;

    protected $table = 'general_liabilities_policy_details_table';

    protected $fillable = [
        'policy_details_id',
        'is_commercial_gl',
        'is_occur',
        'is_policy',
        'is_project',
        'is_loc',
        'is_additional_insd',
        'is_subr_wvd',
        'each_occurence',
        'damage_to_rented',
        'medical_expenses',
        'per_adv_injury',
        'gen_aggregate',
        'product_comp',
    'effective_date',
        'expiry_date',
        'status',
        'media_id',
    ];
}