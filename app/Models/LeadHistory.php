<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadHistory extends Model
{
    use HasFactory;

    protected $table = 'lead_histories';

    protected $fillable =  [
        'lead_id',
        'user_profile_id',
        'changes',
    ];

    public function userProfile()
    {
        return $this->belongsTo(UserProfile::class, 'user_profile_id', 'id');
    }
}
