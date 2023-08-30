<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MultipleState extends Model
{
    use HasFactory;

    protected $table = 'multistate_table';

    public $timestamps = false;

    protected $fillable = [
        'state',
        'percentage',
        'general_liabilities_id'
    ];
}