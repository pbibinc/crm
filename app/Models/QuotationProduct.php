<?php

namespace App\Models;

use Amp\Http\Client\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use League\CommonMark\Extension\SmartPunct\Quote;

class QuotationProduct extends Model
{
    use HasFactory;

    protected $table = 'quotation_product_table';

    protected $fillable = [
        'quote_information_id',
        'selected_quote_id',
        'product',
        'sent_out_date',
        'call_back_data',
        'status',
        'user_profile_id',
    ];

    public function QouteComparison()
    {
        return $this->hasMany(SelectedQuote::class, 'quotation_product_id');
    }

    // public function SelectedQuote()
    // {
    //     return $this->hasMany(SelectedQuote::class, 'quotation_product_id');
    // }

    public function boundInformation()
    {
        return $this->hasOne(BoundInformation::class, 'quoatation_product_id');
    }

    public function QuoteInformation()
    {
        return $this->belongsTo(QuoteInformation::class, 'quote_information_id');
    }

    public function PolicyDetail()
    {
        return $this->belongsTo(PolicyDetail::class, 'quotation_product_id');
    }

    public function QuotationProductCallback()
    {
        return $this->hasOne(QuotationProductCallback::class, 'quotation_product_id', 'id');
    }

    public function quotedProduct()
    {
        return self::where('status', 1)->get();
    }

    public function pendingProduct()
    {
        return self::where('status', 3)->get();
    }

    public static function quotingProduct()
    {
        return self::where('status', 2)->get();
    }

    public function brokerQuotation()
    {
        return $this->hasOne(BrokerQuotation::class, 'quote_product_id');
    }

    public function medias()
    {
        return $this->belongsToMany(Metadata::class, 'product_media_table', 'quotation_product_id', 'metadata_id');
    }


    public static function getQuotationProductByProduct($product , $quote_information_id)
    {
        $query = self::where('quote_information_id', $quote_information_id)
            ->where('product', $product)
            ->first();
            return $query;

    }

    public static function getAssignedProductByUserProfileId($userProfileId)
    {
        $query = self::where('user_profile_id', $userProfileId)->whereIn('status', [1, 2])->get();
        $products = [];
        if($query){
            foreach($query as $product)
            {
                $products[] = [
                    'company' => $product->QuoteInformation->QuoteLead->leads->company_name,
                    'product' => $product,
                    'sent_out_date' => $product->sent_out_date,
                    'status' => $product->status,
                    'telemarketer' => UserProfile::where('id', $product->QuoteInformation->telemarket_id)->first()->fullAmericanName(),
                ];
            }
            return $products;
        }
        return null;
    }

    public function getQuotedProductFromQuoteProductByUserProfileId($userProfileId)
    {
        if($userProfileId == null){
            return null;
        }
        $query = self::where('user_profile_id', $userProfileId)->whereIn('status', [3, 4, 5, 6, 7, 8, 9, 10, 11, 12])->select('id', 'quote_information_id', 'product', 'sent_out_date', 'status', 'user_profile_id')->orderBy('id')->get();

        $quotationProducts = collect();
        foreach ($query as $quotationProduct) {
            $quotationProducts->push($quotationProduct);
        }
        return $quotationProducts->isEmpty() ? null : $quotationProducts;
    }

    public function userProfile()
    {
        return $this->belongsTo(UserProfile::class, 'user_profile_id');
    }

    public static function getQuotedProductByUserProfile($userProfileId)
    {
        $query = self::where('user_profile_id', $userProfileId)->where('status', 1)->get();
        if($query){
            return $query;
        }
        return null;
    }

    public static function getQuotingProductByUserProfile($userProfileId)
    {
        $query = self::where('user_profile_id', $userProfileId)->where('status', 2)->get();
        if($query){
            return $query;
        }
        return null;
    }

    public static function getQuotedProductByQuotedInformationId($quoteInformationId)
    {
        $product = self::where('quote_information_id', $quoteInformationId)->get();
        if($product){
            return $product;
        }
        return null;
    }

    public static function getProductByUserProfileId($userProfileId)
    {
        $query = self::where('user_profile_id', $userProfileId)->where('status', 2)->get();
        if($query){
            return $query;
        }
        return null;
    }

    public function getRequestToBind()
    {
        $query = $this->whereIn('status', [6, 15, 17, 18, 24, 28])->get();
        return $query ? $query : null;
    }

    public function getBoundList()
    {
        $query = $this->whereIn('status', [11, 20, 26])->get();
        return $query ? $query : null;
    }

    public function getIncompleteBinding()
    {
        $query = $this->whereIn('status', [14, 23, 27])->get();
        return $query ? $query : null;
    }

    public function getBinding()
    {
        $query = $this->whereIn('status', [12, 19, 25])->get();
        return $query ? $query : null;
    }

    public function getQuotedProduct($userProfileId, $status)
    {
        $query = self::where('user_profile_id', $userProfileId);

        if (is_array($status)) {
            $query = $query->whereIn('status', $status);
        } else {
            $query = $query->where('status', $status);
        }

        $quotationProducts = $query->orderBy('created_at')->get();
        return $quotationProducts->isEmpty() ? [] : $quotationProducts;
    }

    public static function getAgentProductByBrokerUserprofileId($status, $brokerUserProfileId)
    {
        $agentId = BrokerHandle::where('broker_userprofile_id', $brokerUserProfileId)->pluck('agent_userprofile_id');
        $query = self::whereIn('user_profile_id', $agentId);
         if(is_array($status)){
            $query = $query->whereIn('status', $status);
         }else{
            $query = $query->where('status', $status);
         }
         $quotationProduct = $query->orderBy('created_at')->get();

         return $quotationProduct->isEmpty() ? null : $quotationProduct;
    }

    public function getAppointedProduct()
    {
        $startOfMonth = now()->startOfMonth();
        $endOfMonth = now()->endOfMonth();
        $product = $this->whereBetween('created_at', [$startOfMonth, $endOfMonth])->get();
        $totalProduct = $product = 0 ? 0 : $product->count();
        return $totalProduct;
    }

    public function appointedProductPercentageFromPreviousMonth()
    {
        $startOfMonth = now()->startOfMonth();
        $endOfMonth = now()->endOfMonth();
        $product = $this->whereBetween('created_at', [$startOfMonth, $endOfMonth])->get();
        $totalProduct = $product = 0 ? 0 : $product->count();
        $previousMonth = now()->subMonth()->startOfMonth();
        $previousMonthEnd = now()->subMonth()->endOfMonth();
        $previousMonthProduct = $this->whereBetween('created_at', [$previousMonth, $previousMonthEnd])->get();
        $previousMonthTotalProduct = $previousMonthProduct = 0 ? 0 : $previousMonthProduct->count();
        $percentage = $totalProduct > 0 && $previousMonthTotalProduct > 0 ? (($totalProduct - $previousMonthTotalProduct) / $previousMonthTotalProduct) * 100 : 0;
        return number_format($percentage, 2);
    }

    // public function getSelectedQuote()
    // {
    //     return $this->hasMany(SelectedQuote::class, 'quotation)
    // }

}
