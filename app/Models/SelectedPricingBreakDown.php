<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SelectedPricingBreakDown extends Model
{
    use HasFactory;
    protected $table = 'selected_pricing_breakdown';

    protected $fillable = [
        'premium',
        'endorsements',
        'policy_fee',
        'inspection_fee',
        'stamping_fee',
        'surplus_lines_tax',
        'placement_fee',
        'broker_fee',
        'miscellaneous_fee',
    ];
}