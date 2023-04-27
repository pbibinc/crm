<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StandardIndustrialClassification extends Model
{
    use HasFactory;

    protected $table = 'standard_industrial_classification';

    protected $fillable = [
        'sic_classcode',
        'sic_code',
        'workers_comp_code',
        'description'
    ];
}
