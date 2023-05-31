<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $table = "attendance_records_footprints";

    protected $fillable = [
        'user_id',
        'login_type',
        'log_in',
        'log_out',
    ];

    public function userProfile(){
        return $this->belongsTo(UserProfile::class, 'user_id');
    }
}
