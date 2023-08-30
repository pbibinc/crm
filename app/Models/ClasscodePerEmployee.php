<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClasscodePerEmployee extends Model
{
    use HasFactory;

    protected $table = 'classcode_per_employee_table';
     
    public $timestamps = false;

    protected $fillablle = [
        'workers_compensation_id',
        'employee_description',
        'number_of_employee'
    ];
}