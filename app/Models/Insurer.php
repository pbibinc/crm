<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Insurer extends Model
{
    use HasFactory;
    protected $table = 'insurer_table';

    protected $fillable = [
        'name',
    ];
}