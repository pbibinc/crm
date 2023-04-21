<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classcode extends Model
{
    use HasFactory;

    protected $table = 'class_codes';

    protected $fillable = [
        'classcode_name',
        'classcode',
        'classcode_description'
    ];
}
