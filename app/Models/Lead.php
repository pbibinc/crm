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

    public static function getAppointedLeads()
    {
        $leads = self::where('disposition_id', 1)->with('userProfile')->get();

        if($leads){
            return $leads;
        }
        return null;
    }


    public static function getLeads($id)
    {
        $lead = self::find($id);

        if($lead){
            return $lead;
        }
        return null;
    }

    public function GeneralInformation()
    {
        return $this->hasOne(GeneralInformation::class, 'leads_id');
    }

    public function commercialAutoExpirationProduct()
    {
        return $this->hasOne(ExpirationProduct::class, 'lead_id')->where('product', 3);
    }

    public function toolsEquipmentExpirationProduct()
    {
        return $this->hasOne(ExpirationProduct::class, 'lead_id')->where('product', 5);
    }

    public function buildersRiskExpirationProduct()
    {
        return $this->hasOne(ExpirationProduct::class, 'lead_id')->where('product', 6);
    }

    public function businessOwnersExpirationProduct()
    {
        return $this->hasOne(ExpirationProduct::class, 'lead_id')->where('product', 7);
    }

    public function leadHistories()
    {
        return $this->hasMany(LeadHistory::class, 'lead_id');
    }

    public static function getLeadsAppointed($userProfileId)
    {

        $leads = self::where('disposition_id', 1)
        ->where('status', 3)
        ->whereHas('userProfile', function ($query) use ($userProfileId) {
            $query->where('user_id', $userProfileId);
        })
        ->get();

        if(!$leads->isEmpty()){
            return $leads;
        }
        return null;
    }
}
