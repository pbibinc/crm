<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarpentryWoodworking extends Model
{
    use HasFactory;

    protected $table = 'carpentry_woodworking_table';

    public $timestamps = false;

    protected $fillable = [
        'classcode_leads_id',
        'playground_equipment_manufacture_install',
    ];
}