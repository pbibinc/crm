<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PricingBreakdown extends Model
{
    use HasFactory;

    protected $table = 'pricing_breakdown_table';

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

    public function QuoteComparison()
    {
        return $this->hasOne(QuoteComparison::class, 'pricing_breakdown_id');
    }


}
