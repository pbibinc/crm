<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Callback extends Model
{
    use HasFactory;

    protected $table = 'callback';

    protected $fillable = [
        'lead_id',
        'status',
        'type',
        'date_time',
        'remarks',
        'created_at',
        'updated_at',
    ];

    public static function getCallBackByLeadIdType($leadId, $type)
    {
        $callback = self::where('lead_id', $leadId)->where('type', $type)->latest('created_at')->first();

        if($callback){
            return $callback;
        }
        return null;
    }

    public function getAppointedLead()
    {
        $user = auth()->user();
        $leads = $user->userProfile->leads;
        $callBack = self::where('status', 3)->where('type', 1)->get();
        $leadsData = $leads->whereIn('id', $callBack->pluck('lead_id'))->get();
        return $leadsData;
    }

    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }

    public function disposition()
    {
        return Disposition::find($this->id);
    }

    public function getCallBackToday()
    {
        $user = auth()->user();
        $leads = $user->userProfile->leads;
        $callBack = self::whereDate('date_time', date('Y-m-d'))->get();
        $leadsData = $leads->whereIn('id', $callBack->pluck('lead_id'))->unique();
        return $leadsData;
    }
}