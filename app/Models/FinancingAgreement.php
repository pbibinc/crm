<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancingAgreement extends Model
{
    use HasFactory;

    protected $table = 'financing_agreement';

    protected $fillable = [
        'policy_details_id',
        'financing_company_id',
        'is_auto_pay',
        'media_id',
    ];
}
