<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessOwnersPolicyDetails extends Model
{
    use HasFactory;

    protected $table = 'business_owners_policy_details';

    protected $fillable = [
        'policy_details_id',
        'is_subr_wvd',
        'is_addl_insd',
    ];
}