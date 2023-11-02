<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PolicyDetail extends Model
{
    use HasFactory;

    protected $table = 'quotation_market_table';

    protected $fillable = [
        'quotation_product_id',
        'policy_number',
        'carrier',
        'insurer',
        'payment_mode'
    ];
}