<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;

    protected $table = 'leads';

    protected $fillable = [
        'company_name',
        'tel_num',
        'state_abbr',
        'website_originated',
        'disposition_name',
    ];
    public function userProfile()
    {
        return $this->belongsTo(UserProfile::class);
    }

    public function dispositions()
    {
        return $this->belongsTo(Disposition::class);
    }
}
