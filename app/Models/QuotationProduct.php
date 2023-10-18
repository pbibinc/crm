<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use League\CommonMark\Extension\SmartPunct\Quote;

class QuotationProduct extends Model
{
    use HasFactory;

    protected $table = 'quotation_product_table';

    protected $fillable = [
        'quote_information_id',
        'product',
        'sent_out_date',
        'status',
    ];

    public function QouteComparison()
    {
        return $this->hasMany(QouteComparison::class, 'quotation_product_id');
    }

    public function QuoteInformation()
    {
        return $this->belongsTo(QuoteInformation::class, 'quote_information_id');
    }

    public static function getQuotationProductByProduct($product , $quote_information_id)
    {
        $query = self::where('quote_information_id', $quote_information_id)
            ->where('product', $product)
            ->first();
            return $query;
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
        return $this->belongsTo(BrokerQuotation::class, 'quote_product_id');
    }

    public static function getAssignedProductByUserProfileId($userProfileId)
    {
        $query = self::where('user_profile_id', $userProfileId)->get();
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

    public static function getProductByUserProfileId($userProfileId)
    {
        $query = self::where('user_profile_id', $userProfileId)->where('status', 2)->get();
        if($query){
            return $query;
        }
        return null;
    }



}
