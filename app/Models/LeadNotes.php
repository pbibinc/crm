<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadNotes extends Model
{
    use HasFactory;

    protected $table = 'lead_notes_table';

    protected $fillable = [
        'lead_id',
        'user_profile_id',
        'title',
        'description',
    ];
}
