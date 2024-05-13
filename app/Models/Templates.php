<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Templates extends Model
{
    use HasFactory;

    protected $table = 'templates';

    protected $fillable = [
        'user_profile_id',
        'name',
        'type',
        'design',
        'html',
    ];

    protected $casts = [
        'attributes' => 'json',
    ];

    public function userProfile()
    {
        return $this->belongsTo(UserProfile::class);
    }

}