<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dashboard extends Model
{
    use HasFactory;

    protected $table = 'attendance_records';

    // public $timestamps = false;

    protected $fillable = [
        'user_id',
        'login_type',
        'log_in',
        'log_out'
    ];

    public function attendanceRecords(){
        return $this->hasMany(Attendance::class, 'user_id');
    }
}
