<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentDate extends Model
{
    use HasFactory;

    protected $table = 'payment_date';

    protected $fillable = [
        'financing_agreement_id',
        'due_date',
        'date_paid',
        'amount_due',
        'amount_paid',
    ];
}