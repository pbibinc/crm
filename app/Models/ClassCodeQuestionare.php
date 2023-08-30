<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassCodeQuestionare extends Model
{
    use HasFactory;

    protected $table = 'classcode_questionare_table';

    public $timestamps = false;

    protected $fillable = [
        'lead_id',
        'classcode_id',
        'question',
        'answer',
    ];
}