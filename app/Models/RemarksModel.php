<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RemarksModel extends Model
{
    use HasFactory;

    protected $table = 'remarks_lead';

    protected $fillable = [
        'lead_id',
        'remarks',
    ];



}
