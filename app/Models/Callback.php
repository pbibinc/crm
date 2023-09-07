<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
