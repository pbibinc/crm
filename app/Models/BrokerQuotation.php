<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class BrokerQuotation extends Model
{
    use HasFactory;

    protected $table = 'broker_quotation_table';

    protected $fillable = [
        'user_profile_id',
        'lead_id',
        'status',
        'remarks',
    ];

    public $timestamps = false;

    public function QuotationProduct()
    {
        return $this->belongsTo(QuotationProduct::class, 'quote_product_id');
    }

    public function fullAmericanName()
    {
        $fullName = UserProfile::find($this->user_profile_id);
        return $fullName->fullAmericanName();
    }

    public function getAssignQoutedLead($userProfileId, $status)
    {
    // Get the broker quotations with the given user profile ID
    $brokerQuotations = self::where('user_profile_id', $userProfileId)->get();
    if(is_array($status)){
            // $quotationProducts = collect();
    $quotationProducts = BrokerQuotation::where('user_profile_id', $userProfileId)
    ->whereHas('quotationProduct', function ($query) use ($status) {
        $query->whereIn('status', $status);
    })->with('quotationProduct')->get()->pluck('quotationProduct')->unique('id');
    }else{
        $quotationProducts = BrokerQuotation::where('user_profile_id', $userProfileId)
        ->whereHas('quotationProduct', function ($query) use ($status) {
            $query->where('status', $status);
        })->with('quotationProduct')->get()->pluck('quotationProduct')->unique('id');
    }

    return $quotationProducts->isEmpty() ? [] : $quotationProducts;
    }

    public function getProductToBind($userProfileId)
    {
        $brokerQuotations = self::where('user_profile_id', $userProfileId)->with(['quotationProduct' => function($query){
            $query->select('id', 'product', 'status', 'quote_information_id');
        }])->whereHas('quotationProduct', function($query){
            $query->where('status', 6 )->orWhere('status', 11)->orWhere('status', 13)->orWhere('status', 14)->orWhere('status', 15);
        })->orderBy('id')->get();
        $quotationProducts = $brokerQuotations->pluck('quotationProduct');

        return $quotationProducts->isEmpty() ? [] : $quotationProducts;
    }

    public function getAgentProductByBrokerUserprofileId($userProfileId, $status)
    {

        $agentIds = BrokerHandle::where('broker_userprofile_id', $userProfileId)->pluck('agent_userprofile_id');
        $agentIds = $agentIds;
        $quotationProductsQuery = BrokerQuotation::whereIn('user_profile_id', $agentIds)
        ->whereHas('quotationProduct', function ($query) use ($status) {
            if (is_array($status)) {
                $query->whereIn('status', $status);
            } else {
                $query->where('status', $status);
            }
        })
        ->with('quotationProduct');
        $quotationProducts = $quotationProductsQuery->get()->pluck('quotationProduct')->unique('id')->flatten();
        return $quotationProducts->isEmpty() ? [] : $quotationProducts;
    }
}