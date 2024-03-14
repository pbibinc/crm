<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecurringAchMedia extends Model
{
    use HasFactory;

    protected $table = 'recurring_ach_media';

    protected $fillable = [
        'financing_aggreement_id',
        'media_id'
    ];
}