<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralLiabilities extends Model
{
    use HasFactory;

    protected $table = 'general_liabilities_table';

    protected $fillable = [
        'general_information_id',
        'business_description',
        'residential',
        'commercial',
        'new_construction',
        'repair',
        'self_perform_roofing',
        'concrete_foundation_work',
        'perform_track_work',
        'is_condo_townhouse',
        'perform_multi_dweling',
        'business_entity',
        'years_in_business',
        'years_in_professional',
        'largest_project',
        'largest_project_amount',
        'contact_license',
        'contact_license_name',
        'is_office_home',
        'expiration_of_general_liabilities',
        'policy_premium',
        'coverage_limit_id',
        'cross_sell'
    ];

}