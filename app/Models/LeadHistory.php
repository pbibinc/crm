<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class LeadHistory extends Model
{
    use HasFactory;

    protected $table = 'lead_histories';

    protected $fillable =  [
        'lead_id',
        'user_profile_id',
        'changes',
    ];

    public function userProfile()
    {
        return $this->belongsTo(UserProfile::class, 'user_profile_id', 'id');
    }

    public static function getAppointerUserProfile($leadId)
    {
        $leadHistory = self::where('lead_id', $leadId)
                            ->where('changes', 'like', '%appointed_by%')
                            ->first();

        return $leadHistory ? $leadHistory->userProfile : null;
    }

    public function getProductByProductId($id)
    {
        $product = QuotationProduct::find($id);
        return $product;
    }
}