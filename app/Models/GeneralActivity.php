<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralActivity extends Model
{
    use HasFactory;

    protected $table = 'general_activity_table';

    protected $fillable = [
        'activity_date',
        'title',
        'description'
    ];
}