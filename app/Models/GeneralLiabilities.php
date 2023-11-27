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

    public function generalInformation()
    {
        return $this->belongsTo(GeneralInformation::class);
    }

    public function coverageLimit()
    {
        return $this->hasOne(CoverageLimit::class, 'id', 'coverage_limit_id');
    }

    public function classCodes()
    {
        return $this->hasMany(ClassCodePercentage::class, 'general_liabilities_id', 'id');
    }

    public function classCodePercentage()
    {
        return $this->belongsToMany(ClassCodeLead::class, 'classcode_percentage_table', 'general_liabilities_id', 'classcode_id')->withPivot('percentage');
    }

    public function multiStates()
    {
        return $this->hasMany(MultipleState::class, 'general_liabilities_id', 'id');
    }

    public function generalLiabilityFacilities()
    {
        return $this->hasMany(GeneralLiabilitiesRecreationalFacilities::class, 'general_liabilities_id', 'id');
    }

    public function subcontractor()
    {
        return $this->hasOne(Subcontractor::class, 'general_liabilities_id', 'id');
    }

    public function recreationalFacilities()
    {
        return $this->belongsToMany(RecreationalFacilities::class, 'general_liability_facilities_table', 'general_liabilities_id', 'recreational_facilities_id');
    }

    // public function coverageLimit()
    // {
    //     return $this->hasOne(CoverageLimit::class, 'id', 'coverage_limit_id');
    // }

}
