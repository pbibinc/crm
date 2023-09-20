<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UserProfile extends Model
{
    // use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'id_num',
        'position_id',
        'status',
        'user_id',

    ];

    public function userProfiles()
    {
        return self::all();
    }

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function leads()
    {
        return $this->belongsToMany(Lead::class, 'leads_user_profile')
        ->withPivot('assigned_at', 'reassigned_at', 'current_user_id')
        ->withTimestamps();
    }

    public function ratings()
    {
        return $this->hasMany(EmployeeRating::class);
    }

    public function media()
    {
        return $this->belongsTo(Metadata::class);
    }

    public function getLeadCountByState()
    {
        return $this->leads()
           ->select('state_abbr', DB::raw('count(*) as total'))
           ->groupBy('state_abbr')
           ->pluck('total', 'state_abbr')
           ->toArray();
    }
    public function fullName()
    {
        return $this->firstname . ' ' . $this->lastname;
    }

    public function fullAmericanName()
    {
        return $this->firstname . ' ' . $this->american_surname;
    }

    public static function getFullName($id)
    {
        $userProfile = self::find($id);
        if($userProfile){
            return $userProfile->fullName();
        }
        return null;
    }

    public function apptaker()
    {
        return self::where('position_id', 26)->get();
    }

    public function qouter()
    {
        return self::where('position_id', 33)->get();
    }

    public function quoationLeads()
    {
        return $this->hasMany(quoationLeads::class);
    }

}
