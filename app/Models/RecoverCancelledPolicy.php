<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecoverCancelledPolicy extends Model
{
    use HasFactory;

    protected $table = 'recover_cancelled_policy';

    protected $fillable = [
        'user_profile_id',
        'policy_detail_id',
        'bound_date',
    ];

    public function policyDetail()
    {
        return $this->belongsTo(PolicyDetail::class, 'policy_detail_id');
    }

    public function userProfile()
    {
        return $this->belongsTo(UserProfile::class, 'user_profile_id');
    }

    public static function getRecoverCancelledPolicyByUserProfileId($userProfileId)
    {
        return self::where('user_profile_id', $userProfileId);
    }

}
