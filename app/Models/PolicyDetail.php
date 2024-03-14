<?php

namespace App\Models;

use Carbon\Carbon;
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
        'market',
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

    public function NewPoicyList()
    {
        $dateRange = Carbon::now()->subMonths(3)->format('Y-m-d');
        $recentPolicies = self::where('effective_date', '>=', $dateRange)->get();
        return $recentPolicies;
    }

    public function NewlyBoundList()
    {
        $dateRange = Carbon::now()->subMonths(3)->format('Y-m-d');
        $recentBound = self::where('effective_date', '>=', $dateRange)->get();
        return $recentBound;
    }


    public function getPolicyDetailByLeadsId($leadsId)
    {
        $lead = Lead::find($leadsId);
        $quoteLead = QuoteLead::where('leads_id', $leadsId)->first();
        $quoteInformation = QuoteInformation::where('quoting_lead_id', $quoteLead->id)->first();
        $quotationProduct = QuotationProduct::where('quote_information_id', $quoteInformation->id)->where('status', 8)->get();
        return $quotationProduct;
    }

    public function getPolicyForRenewal()
    {
        $policies = [];
        // Today's date
        $today = Carbon::now()->format('Y-m-d');

        // Date 60 days from now
        $dateRange = Carbon::now()->addDays(60)->format('Y-m-d');

        // Fetch policies with expiration dates between today and the next 60 days
        $recentPolicies = self::where('expiration_date', '>=', $today)->where('expiration_date', '<=', $dateRange)->whereDoesntHave('userProfile')->get();

        foreach($recentPolicies as $policy)
        {
            $quoteComparison = QuoteComparison::where('quotation_product_id', $policy->quotation_product_id)->where('recommended', '3')->first();
            $policies[] = [
                'company' => $policy->QuotationProduct->QuoteInformation->QuoteLead->leads->company_name,
                'product' => $policy->QuotationProduct,
                'policies' => $policy,
                'quote' => $quoteComparison,
            ];
        }
        return $policies;
    }

    public function userProfile()
    {
        return $this->belongsToMany(UserProfile::class, 'renewal_user_profile', 'policy_details_id', 'user_profile_id')->withTimestamps();
    }

    public function CancellationReport()
    {
        return $this->belongsTo(CancellationReport::class, 'policy_details_id');
    }

    public function getIntentList()
    {
        return $this->where('status', 'Intent')->get();
    }

}
