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
        'selected_quote_id',
        'quotation_product_id',
        'policy_number',
        'carrier',
        'market',
        'payment_mode',
        'media_id',
        'status'
    ];

    public function medias()
    {
        return $this->belongsTo(Metadata::class, 'media_id');
    }

    public function GeneralLiabilitiesPolicyDetails()
    {
        return $this->belongsTo(GeneralLiabilitiesPolicyDetails::class, 'policy_details_id');
    }

    public function QuotationProduct()
    {
        return $this->belongsTo(QuotationProduct::class, 'quotation_product_id');
    }

    public function SelectedQuote()
    {
        return $this->hasOne(SelectedQuote::class, 'selected_quote_id');
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
         // Today's date
         $today = Carbon::now()->format('Y-m-d');

         // Date 60 days from now
         $dateRange = Carbon::now()->addDays(60)->format('Y-m-d');

          // Fetch policies with expiration dates between today and the next 60 days
          $recentPolicies = self::whereBetween('expiration_date', [$today, $dateRange])->get();

         return $recentPolicies;
    }

    public function getPolicyQuotedRenewal()
    {
        $dataPolicies = $this->where('status', 'Renewal Quoted')->get();
        $policies = [];
        foreach($dataPolicies as $policy)
        {
            $quoteComparison = SelectedQuote::where('quotation_product_id', $policy->quotation_product_id)->first();
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

    public function quotedRenewalUserprofile()
    {
        return $this->belongsToMany(UserProfile::class, 'renewal_quoted_user_profile', 'policy_details_id', 'user_profile_id')->withTimestamps();
    }

    public function CancellationReport()
    {
        return $this->belongsTo(CancellationReport::class, 'policy_details_id');
    }

    public function CancellationEndorsement()
    {
        return $this->hasOne(CancellationEndorsement::class, 'policy_details_id');
    }

    public function AssignedForRewritePolicy()
    {

        return $this->belongsToMany(UserProfile::class, 'assigned_rewrite_policy', 'policy_details_id', 'user_profile_id')
        ->withPivot('assigned_at')
        ->withTimestamps();
    }

    public function CancelledPolicyForRecall()
    {
        return $this->hasOne(CancelledPolicyForRecall::class, 'policy_details_id');
    }

    public function PolicyDetail()
    {
        return $this->hasMany(PolicyDetail::class, 'policy_details_id');
    }

    public function RecoverCancelledPolicy()
    {
        return $this->hasOne(RecoverCancelledPolicy::class, 'policy_details_id');
    }

    public function getIntentList()
    {
        return $this->where('status', 'Intent')->get();
    }

    public function getRequestedByCustomerCancellationPolicyList()
    {
        return $this->where('status', 'Cancellation Request By Customer')->get();
    }

    public function getPolicyForRenewalProcess()
    {
        $data = self::where('status', 'Process Renewal')->get();
        return $data ? $data : null;
    }

    public function handledForQuoteRenewalPolicy()
    {
        $this->quotedRenewalUserprofile()->get();
    }

    public static function getPolicyDetailByLeadId($leadId)
    {
        $lead = Lead::find($leadId);
        if (!$lead) {
            return [];
        }

        $quoteInformationId = optional($lead->quoteLead)->QuoteInformation->id;
        if (!$quoteInformationId) {
            return [];
        }

        $quoteProducts = QuotationProduct::where('quote_information_id', $quoteInformationId)->get();
        $policies = [];

        foreach ($quoteProducts as $product) {
            $productPolicies = self::where('quotation_product_id', $product->id)->get();
                // ->whereIn('status', ['issued', 'Cancelled', 'Declined', 'Endorsing', 'Notice of Cancellation', 'old policy', 'renewal issued', 'Renewal Notice of Cancellation', 'Intent', 'Potential For Rewrite', 'Rewrite', 'Not Interested', 'Process Renewal', 'Renewal Quote', 'Renewal Quoted', ''])


            if ($productPolicies->isNotEmpty()) {
                // Push each policy individually
                foreach ($productPolicies as $policy) {
                    $policies[] = $policy;
                }
            }
        }

        return $policies;
    }

    public function getActivePolicyDetailByLeadId($leadId)
    {
        $lead = Lead::find($leadId);
        if (!$lead) {
            return [];
        }

        $quoteInformationId = optional($lead->quoteLead)->QuoteInformation->id;
        if (!$quoteInformationId) {
            return [];
        }

        $quoteProducts = QuotationProduct::where('quote_information_id', $quoteInformationId)->get();
        $policies = [];

        foreach ($quoteProducts as $product) {
            $productPolicies = self::where('quotation_product_id', $product->id)->whereNotIn('status', ['Dead policy', 'Cancelled', 'Declined', 'Not Interested', 'old policy'])->get();


            if ($productPolicies->isNotEmpty()) {
                // Push each policy individually
                foreach ($productPolicies as $policy) {
                    $policies[] = $policy;
                }
            }
        }

        return $policies;
    }

    public function getTotalSales()
    {
        $totalSales = 0;
        $startOfMonth = now()->startOfMonth();
        $endOfMonth = now()->endOfMonth();


        $policies = $this->whereIn('status', ['issued', 'renewal issued'])
        ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
        ->get();

       // Calculate the total sales
        foreach ($policies as $policy) {
          if ($policy->QuotationProduct) {
             $totalSales += $policy->QuotationProduct->total_cost;
           }
        }
        return $totalSales;
    }

    public function getRequestForCancellation()
    {
        return $this->whereIn('status', ['Request For Cancellation', 'Request For Cancellation Pending', 'Request For Cancellation Declined', 'Request For Cancellation Resend', 'Request For Cancellation Approved', 'Cancellation Endorsement']);
    }

    public function getPendingForCancellation()
    {
        return $this->whereIn('status', ['Request For Cancellation', 'Request For Cancellation Pending', 'Request For Cancellation Declined', 'Request For Cancellation Resend', 'Cancellation Endorsement']);
    }

    public function getSubjectForRewriteList()
    {
        return $this->whereIn('status', ['Subject For Rewrite', 'Rewrite']);
    }

    public function getCancelledPolicyList()
    {
        return $this->whereIn('status', ['Cancelled'])->doesntHave('cancelledPolicyForRecall');
    }

    public static function getForRewritePolicyByStatusAndUserProfileId($status, $userProfileId)
    {
        $statueses = is_array($status) ? $status : [$status];
        return self::whereIn('status', $statueses)->whereHas('AssignedForRewritePolicy', function ($query) use ($userProfileId) {
            $query->where('user_profile_id', $userProfileId);
        });
    }

    public static function getForRewritePolicyByProductStatusAndUserProfileId($status, $userProfileId)
    {
        $statueses = is_array($status) ? $status : [$status];
        return self::whereHas('AssignedForRewritePolicy', function ($query) use ($userProfileId) {
            $query->where('user_profile_id', $userProfileId);
        })->whereHas('QuotationProduct', function ($query) use ($statueses) {
            $query->whereIn('status', $statueses);
        });
    }

}