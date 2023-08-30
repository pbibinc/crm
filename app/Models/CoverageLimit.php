<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoverageLimit extends Model
{
    use HasFactory;

    protected $table = 'coverage_limit_table';
    public $timestamps = false;

    protected $fillable = [
        'limit',
        'medical',
        'fire_damage',
        'deductible',
    ];
}