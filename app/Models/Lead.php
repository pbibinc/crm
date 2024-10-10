<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;


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
        'status',
    ];

    public function dispositions()
    {
        return $this->belongsTo(Disposition::class);
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

    public function getProducts()
    {
        $quoteId = $this->quoteLead->QuoteInformation->id;
        $products = QuotationProduct::where('quote_information_id', $quoteId)->pluck('product');
        return $products ? $products->toArray() : [];
    }

    public function getQuotationProducts()
    {
        $quoteId = $this->quoteLead->QuoteInformation->id;
        $products = QuotationProduct::where('quote_information_id', $quoteId)->get();
        return $products;
    }

    public function leadHistories()
    {
        return $this->hasMany(LeadHistory::class, 'lead_id');
    }

    public function recentLeadHistories()
    {
        return $this->leadHistories()->orderBy('created_at', 'desc')->take(2);
    }

    public function quoteLead()
    {
        return $this->hasOne(QuoteLead::class, 'leads_id');
    }

    public function notes()
    {
        return $this->hasMany(LeadNotes::class, 'lead_id');
    }

    public function recentNotes()
    {
        return $this->notes()->orderBy('created_at', 'desc')->take(2);
    }

    public function classcodeQuestionare()
    {
        return $this->hasMany(ClassCodeQuestionare::class, 'lead_id', 'id');
    }

    public function userProfile()
    {
        return $this->belongsToMany(UserProfile::class, 'leads_user_profile')
        ->withPivot('assigned_at', 'reassigned_at', 'current_user_id')
        ->withTimestamps();
    }

    public function quoterUserProfile()
    {
        return $this->belongsToMany(UserProfile::class, 'quote_lead_table', 'leads_id', 'user_profiles_id');
    }

    public function callback()
    {
        return $this->belongsTo(Callback::class, 'lead_id');
    }

    public static function getAppointedLeads()
    {
        $leads = self::where('disposition_id', 1)->where('status', 3)->with('userProfile')->get();

        if($leads){
            return $leads;
        }
        return null;
    }

    public static function getAppointedLeadsByUserProfileId($userProfileId)
    {
        // $leads = self::where('disposition_id', 1)
        // ->wherehas('userProfile', function($query) use ($userProfileId){
        //     $query->where('user_id', $userProfileId);
        // })->with('generalInformation')->select('id', 'company_name', 'tel_num', 'class_code', 'state_abbr', 'created_at')->orderBy('id');
        // if($leads){
        //     return $leads;
        // }
        // return null;
        return self::where('disposition_id', 1)
        ->whereHas('userProfile', function($query) use ($userProfileId) {
            $query->where('user_id', $userProfileId);
        })
        ->join('general_information_table', 'general_information_table.leads_id', '=', 'leads.id')
        ->select('leads.id', 'company_name', 'tel_num', 'class_code', 'state_abbr', 'leads.created_at', 'general_information_table.created_at as general_created_at')->orderBy('general_created_at', 'desc');
    }

    public static function getLeads($id)
    {
        $lead = self::find($id);

        if($lead){
            return $lead;
        }
        return null;
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

    public static function getAssignQuoteLeadsByUserProfileId($userProfileId)
    {
        $leads = self::where('disposition_id', 1)
        ->where('status', 4)
        ->whereHas('quoterUserProfile', function ($query) use ($userProfileId) {
            $query->where('user_profiles_id', $userProfileId);
        })->get();
        if($leads)
        {
            return $leads;
    }
        return null;
    }

    public static function getDncLead()
    {
        $leadDnc = self::withTrashed()
        ->where('status', 7)
        ->select('company_name', 'tel_num');
        return $leadDnc;
    }

    public static function getDncDispositionCallbackByUserProfileId($userProfileId)
    {
      // Get leads based on conditions
       $leads = self::where('disposition_id', 1)
                 ->whereHas('userProfile', function ($query) use ($userProfileId) {
                     $query->where('user_profile_id', $userProfileId);
                 })->get();

      // Extract the IDs from the leads collection and convert to array
       $leadIds = $leads->pluck('id')->toArray();

       // Ensure non-empty array
       if (empty($leadIds)) {
          return [];
        }

       // Get callbacks based on lead IDs
        $callBack = Callback::whereIn('lead_id', $leadIds)
                        ->select('remarks', 'date_time', 'lead_id')
                        ->get();

        // Debugging
        return $callBack;
    }

    public function getLeadMedias()
    {
        return $this->belongsToMany(Metadata::class, 'lead_media_table', 'lead_id', 'metadata_id');
    }




}