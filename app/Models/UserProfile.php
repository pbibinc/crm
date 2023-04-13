<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    // use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'id_num',
        'position_id',
        'status',
        'user_id',

    ];
}
