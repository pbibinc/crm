<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use League\CommonMark\Extension\SmartPunct\Quote;

class PolicyDetail extends Model
{
    use HasFactory;

    protected $table = 'policy_details_table';

    protected $fillable = [
        'quotation_product_id',
        'policy_number',
        'carrier',
        'insurer',
        'payment_mode'
    ];

    public function GeneralLiabilitiesPolicyDetails()
    {
        return $this->belongsTo(GeneralLiabilitiesPolicyDetails::class, 'policy_details_id');
    }

    public function QuotationProduct()
    {
        return $this->belongsTo(QuotationProduct::class, 'quotation_product_id');
    }


    public function getPolicyDetailByLeadsId($leadsId)
    {
        $lead = Lead::find($leadsId);
        $quoteLead = QuoteLead::where('leads_id', $leadsId)->first();
        $quoteInformation = QuoteInformation::where('quoting_lead_id', $quoteLead->id)->first();
        $quotationProduct = QuotationProduct::where('quote_information_id', $quoteInformation->id)->where('status', 8)->get();
        return $quotationProduct;
    }

}