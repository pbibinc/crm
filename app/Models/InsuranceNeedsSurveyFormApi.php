<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InsuranceNeedsSurveyFormApi extends Model
{
    use HasFactory;
    protected $table = 'insurance_needs_survey_api_table';
    protected $guarded = [];
    public function getCurrentApiKey() {
        return self::pluck('key')->first();
    }
}