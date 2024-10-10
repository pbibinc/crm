<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CancelledPolicyForRecall extends Model
{
    use HasFactory;

    protected $table = 'cancelled_policy_for_recall';

    protected $fillable = [
        'policy_details_id',
        'status',
        'remarks',
        'number_of_touches',
        'date_to_call',
        'last_touch_user_profile_id'
    ];

    public function PolicyDetail()
    {
        return $this->belongsTo(PolicyDetail::class, 'policy_details_id');
    }

    public function UserProfile()
    {
        return $this->belongsTo(UserProfile::class, 'last_touch_user_profile_id');
    }

    public function PolicyForRecallFirstTouched()
    {
       $data = $this->where('number_of_touches', 1)->where('status', 'pending')->where('date_to_call', '<=', now());
       return $data ? $data->get() : null;
    }

    public function PolicyForRecallSecondTouched()
    {
        $data = $this->where('number_of_touches', 2)->where('status', 'pending')->where('date_to_call', '>=', now())->whereHas('PolicyDetail',function($query){
            $query->whereIn('status', ['Cancelled']);
        });
        return $data ? $data->get() : null;
    }

    public function TouchedPolicy()
    {
        $data = $this->where('number_of_touches', '>=', 3)->where('status', 'pending')->where('date_to_call', '>=', now());
        return $data ? $data->get() : null;
    }
}
