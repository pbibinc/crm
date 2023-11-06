<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralLiabilitiesHaveLoss extends Model
{
    use HasFactory;

    protected $table = 'general_liabilities_have_losses';

    protected $fillable = [
        'general_liabilities_id',
        'date_of_claim',
        'loss_amount'
    ];
}