<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentOption extends Model
{
    use HasFactory;

    protected $table = 'payment_option_table';

    protected $fillable = [
        'financing_agreement_id',
        'payment_option',
    ];

    public function FinancingAgreement()
    {
        return $this->belongsTo(FinancingAgreement::class, 'financing_agreement_id');
    }
}
