<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempDnc extends Model
{
    use HasFactory;
    protected $table = 'temp_dnc_table';
    protected $fillable = [
        'company_name',
        'tel_num',
    ];


}