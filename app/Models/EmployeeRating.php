<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeRating extends Model
{
    use HasFactory;
    
    protected $table = 'employee_rating';


    public function userProfile()
    {
        return $this->belongsTo(UserProfile::class);
    }
}
