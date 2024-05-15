<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BrokerHandle extends Model
{
    use HasFactory;

    protected $table = 'broker_handle';

    protected $fillable = [
        'broker_userprofile_id',
        'agent_userprofile_id',
    ];


    public function agents()
    {
        return $this->belongsToMany(UserProfile::class, 'broker_handle', 'broker_userprofile_id', 'agent_userprofile_id');
    }

    public function broker()
    {
        return $this->belongsTo(UserProfile::class, 'broker_userprofile_id');
    }
}