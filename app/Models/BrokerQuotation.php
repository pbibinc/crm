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

    public function getAssignQoutedLead($userProfileId)
    {
    // Get the broker quotations with the given user profile ID
    $brokerQuotations = self::where('user_profile_id', $userProfileId)->get();

    // Collect the related QuotationProduct models
    $quotationProducts = collect();
    foreach ($brokerQuotations as $brokerQuotation) {
        if($brokerQuotation->quotationProduct->status == 3 || $brokerQuotation->quotationProduct->status == 4) {
            $quotationProducts->push($brokerQuotation->quotationProduct);
        }
    }
    return $quotationProducts->isEmpty() ? null : $quotationProducts;
    }

    public function getApprovedProduct($userProfileId)
    {
        $brokerQuotations = self::where('user_profile_id', $userProfileId)->with(['quotationProduct' => function($query){
            $query->select('id', 'product', 'status', 'quote_information_id');
        }])->whereHas('quotationProduct', function($query){
            $query->where('status', 6);
        })->orderBy('id')->get();
        $quotationProducts = $brokerQuotations->pluck('quotationProduct');
        return $quotationProducts->isEmpty() ? null : $quotationProducts;
    }
}