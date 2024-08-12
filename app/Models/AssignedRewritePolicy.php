<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignedRewritePolicy extends Model
{
    use HasFactory;

    protected $table = 'assigned_rewrite_policy';

    protected $fillable = [
        'policy_id',
        'user_profile_id',
        'assigned_date',
    ];

}
