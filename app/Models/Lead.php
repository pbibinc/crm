<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

;

class Lead extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'leads';

    protected $fillable = [
        'company_name',
        'tel_num',
        'state_abbr',
        'class_code',
        'website_originated',
        'disposition_name',
    ];

    // public function userProfile()
    // {
    //     return $this->belongsTo(UserProfile::class);
    // }

    public function dispositions()
    {
        return $this->belongsTo(Disposition::class);
    }

    public function userProfile()
    {
        return $this->belongsToMany(UserProfile::class, 'leads_user_profile')
        ->withPivot('assigned_at', 'reassigned_at', 'current_user_id')
        ->withTimestamps();
    }

    // protected static function booted()
    // {
    //     static::pivotAttached(function ($lead, $relationName, $pivotIds, $pivotIdsAttributes){
    //         if($relationName == 'userProfile'){
    //             foreach($pivotIdsAttributes as $attributes){
    //                 LeadHistory::create([
    //                     'lead_id' => $lead->id,
    //                     'user_profile_id' => $attributes['current_user_id'],
    //                     'changes' => json_encode(['assigned_at' => $attributes['assigned_at']]),
    //                 ]);
    //             }
    //         }
    //     });

    //     static::pivotUpdated(function ($lead, $relationName, $pivotIds, $pivotIdsAttributes){
    //         if($relationName == 'userProfile'){
    //             foreach ($pivotIdsAttributes as $attributes){
    //                 LeadHistory::create([
    //                     'lead_id' => $lead->id,
    //                     'user_profile_id' => $attributes['current_user_id'],
    //                     'changes' => json_encode(['reassigned_at' => $attributes['reassigned_at']]),
    //                 ]);
    //             }
    //         }
    //     });
    // }


}
