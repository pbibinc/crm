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
        'is_compliance_officer'
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
        return $this->american_name;
    }

    public static function getFullName($id)
    {
        $userProfile = self::find($id);
        if($userProfile){
            return $userProfile->fullName();
        }
        return null;
    }

    public function complianceOfficer()
    {
        $userProfile = self::where('is_compliance_officer', 1)->get();
        return $userProfile;
    }

    public function apptaker()
    {
        return self::where('position_id', 26)->get();
    }

    public function qouter()
    {
        return self::where('position_id', 33)->get();
    }

    public function brokerAssistant()
    {
        return self::where('position_id', 15)->get();
    }

    public function renewal()
    {
        return self::where('position_id', 10)->get();
    }

    public function quoationLeads()
    {
        return $this->hasMany(quoationLeads::class);
    }

    public function quoteInformation()
    {
        return $this->hasMany(QuotationProduct::class);
    }

    public function RecoverCancelledPolicy()
    {
        return $this->hasOne(RecoverCancelledPolicy::class, 'user_profile_id');
    }

    public function renewalPolicy()
    {
        return $this->belongsToMany(PolicyDetail::class, 'renewal_user_profile', 'user_profile_id', 'policy_details_id')->withTimestamps();
    }

    public function renewalQuotedPolicy()
    {
        return $this->belongsToMany(PolicyDetail::class, 'renewal_quoted_user_profile', 'user_profile_id', 'policy_details_id')->withTimestamps();
    }

    public function CancelledPolicyForRecall()
    {
        return $this->hasMany(CancelledPolicyForRecall::class, 'last_touch_user_profile_id');
    }

    public function handledQuotePolicyRenewal($statuses)
    {
        return $this->renewalPolicy()->whereNotIn('status', $statuses);
    }

    public function brokersAssist()
    {
        return $this->belongsToMany(BrokerHandle::class, 'broker_handle', 'agent_userprofile_id', 'broker_userprofile_id');
    }

    public function CancellationEndorsement()
    {
        return $this->hasOne(CancellationEndorsement::class, 'cancelled_by_id');
    }

    public function AssignedForRewritePolicy()
    {
        return $this->belongsToMany(PolicyDetail::class, 'assigned_rewrite_policy', 'user_profile_id', 'policy_details_id')
        ->withPivot('assigned_at')
        ->withTimestamps();
    }

    public function AuditInformation()
    {
        return $this->hasMany(AuditInformation::class, 'processed_by');
    }

    public function assignedToTasks()
    {
        return $this->hasMany(LeadTaskScheduler::class, 'assigned_to');
    }

    public function assignedByTasks()
    {
        return $this->hasMany(LeadTaskScheduler::class, 'assigned_by');
    }

}