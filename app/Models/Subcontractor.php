<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subcontractor extends Model
{
    use HasFactory;

    protected $table = 'subcontractor_table';
    public $timestamps = false;

    protected $fillable = [
        'general_liabilities_id',
        'blasting_operation',
        'hazardous_waste',
        'asbestos_mold',
        'three_stories_height'
    ];
}