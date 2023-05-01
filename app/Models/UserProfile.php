<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
      return $this->belongsToMany(Lead::class);
  }

}
