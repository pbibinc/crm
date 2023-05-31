<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyHandbook extends Model
{
    use HasFactory;

    protected $table = "company_handbook";

    protected $fillable = [
        'description',
        'user_profile_id',
    ];
}
