<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
          if ($brokerQuotation->QuotationProduct && $brokerQuotation->QuotationProduct->status === 3) {
              $quotationProducts->push($brokerQuotation->QuotationProduct);
            }
        }
      return $quotationProducts->isEmpty() ? null : $quotationProducts;
    }
}
