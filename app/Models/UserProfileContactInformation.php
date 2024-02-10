<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfileContactInformation extends Model
{
    use HasFactory;

    protected $fillable = [
        'skype_profile',
        'streams_number',
    ];

    protected $table = 'user_porfile_contact_information_table';
}