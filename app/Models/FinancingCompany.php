<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancingCompany extends Model
{
    use HasFactory;

    protected $table = 'financing_company';

    protected $fillable = [
        'name',
    ];
}