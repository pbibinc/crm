<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PolicyAdditionalValue extends Model
{
    use HasFactory;

    protected $table = 'policy_additional_value';

    protected $fillable = [
        'policy_details_id',
        'name',
        'value',
    ];
}