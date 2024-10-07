<?php

namespace App\Models;

use Carbon\Carbon;
use Amp\Http\Client\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BrokerQuotation extends Model
{
    use HasFactory;

    protected $table = 'broker_quotation_table';

    protected $fillable = [
        'user_profile_id',
        'quote_product_id',
        'assign_date',
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
       if(is_array($status)){
          $quotationProducts = BrokerQuotation::where('user_profile_id', $userProfileId)->whereHas('quotationProduct', function ($query) use ($status) {
            $query->whereIn('status', $status);
          })->with('quotationProduct')->get()->pluck('quotationProduct')->unique('id');
        }else{
           $quotationProducts = BrokerQuotation::where('user_profile_id', $userProfileId)->whereHas('quotationProduct', function ($query) use ($status) {
            $query->where('status', $status);
           })->with('quotationProduct')->get()->pluck('quotationProduct')->unique('id');
        }
       return $quotationProducts->isEmpty() ? [] : $quotationProducts;
    }

    // public function getAssigQuotedLeadByDate($userProfileId, $status, $startDate = null, $endDate = null)
    // {
    //     // If $startDate is null and $endDate is provided, fetch leads older than $endDate
    //  if ($startDate === null && $endDate !== null) {
    //     $quotationProducts = BrokerQuotation::where('user_profile_id', $userProfileId)
    //         ->whereDate('assign_date', '<=', $endDate) // Fetch records where assign_date is less than or equal to $endDate
    //         ->whereHas('quotationProduct', function ($query) use ($status) {
    //             $query->whereIn('status', (array)$status); // Ensure it works for both array and single value statuses
    //         })
    //         ->with('quotationProduct')
    //         ->get()
    //         ->pluck('quotationProduct')
    //         ->unique('id');
    //  }
    //     // Handle the case where both startDate and endDate are provided
    //  else {
    //     $quotationProducts = BrokerQuotation::where('user_profile_id', $userProfileId)
    //         ->whereBetween('assign_date', [$startDate, $endDate ?? Carbon::now()->toDateString()]) // Fetch between the start and end dates
    //         ->whereHas('quotationProduct', function ($query) use ($status) {
    //             $query->whereIn('status', (array)$status); // Ensure it works for both array and single value statuses
    //         })
    //         ->with('quotationProduct')
    //         ->get()
    //         ->pluck('quotationProduct')
    //         ->unique('id');
    //   }

    //   return $quotationProducts->isEmpty() ? [] : $quotationProducts;
    // }

    public function getAssigQuotedLeadByDate($userProfileId, $status, $startDate = null, $endDate = null)
    {
        // If $startDate is null and $endDate is provided, fetch leads older than $endDate
     if ($startDate === null && $endDate !== null) {
        $quotationProducts = BrokerQuotation::where('user_profile_id', $userProfileId)
            ->whereHas('quotationProduct', function ($query) use ($status, $endDate) {
                $query->whereIn('status', (array)$status) // Ensure it works for both array and single value statuses
                      ->whereDate('created_at', '<=', $endDate); // Compare product creation date
            })
            ->with('quotationProduct')
            ->get()
            ->pluck('quotationProduct')
            ->unique('id');
     }
      // Handle the case where both $startDate and $endDate are provided
     else {
        $quotationProducts = BrokerQuotation::where('user_profile_id', $userProfileId)
            ->whereHas('quotationProduct', function ($query) use ($status, $startDate, $endDate) {
                $query->whereIn('status', (array)$status) // Ensure it works for both array and single value statuses
                      ->whereBetween('created_at', [$startDate, $endDate ?? Carbon::now()->toDateString()]); // Compare product creation date
            })
            ->with('quotationProduct')
            ->get()
            ->pluck('quotationProduct')
            ->unique('id');
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

    public function recentBoundInformation($userProfileId)
    {
        // Retrieve the agent user profile IDs associated with the broker
        $agentIds = BrokerHandle::where('broker_userprofile_id', $userProfileId)->pluck('agent_userprofile_id');
        $status = [11, 8]; // Define the status for the boundInformation
        // Prepare the query to retrieve the quotation products with filtering
        $quotationProductsQuery = BrokerQuotation::whereIn('user_profile_id', $agentIds)
            ->whereHas('quotationProduct', function ($query) use ($status) {
                if (is_array($status)) {
                    $query->whereIn('status', $status);
                } else {
                    $query->where('status', $status);
                }
            })
            ->with(['quotationProduct.boundInformation' => function ($query) {
                $query->where('bound_date', '>=', now()->subDays(30)); // Filter the boundInformation by date
            }]);

        // Execute the query and get the results
        $quotationProducts = $quotationProductsQuery->get()->pluck('quotationProduct')->unique('id')->flatten();

        return $quotationProducts->isEmpty() ? [] : $quotationProducts;
    }




}