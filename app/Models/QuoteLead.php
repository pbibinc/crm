<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuoteLead extends Model
{
    use HasFactory;

    protected $table = 'quote_lead_table';

    protected $fillable = [
        'user_profile_id',
        'lead_id'
    ];

    public function QuoteInformation()
    {
        return $this->hasOne(QuoteInformation::class, 'quoting_lead_id');
    }

    public function leads()
    {
        return $this->belongsTo(Lead::class, 'leads_id');
    }

    public function userProfile()
    {
        return $this->belongsTo(UserProfile::class, 'user_profiles_id');
    }



    public static function getAppointedProductByLeads($leads)
    {
        $quoteProducts = [];
        foreach($leads as $lead)
        {
            $query = self::where('leads_id', $lead->id)->first();
            if($query){
                $products = $query->QuoteInformation->QuotationProduct()->where('user_profile_id', null)->where('status', 7)->get();
                foreach($products as $product)
                {
                    $quoteProducts[] = [
                        'company' => $product->QuoteInformation->QuoteLead->leads->company_name,
                        'product' => $product,
                        'sent_out_date' => $product->sent_out_date,
                        'status' => $product->status,
                        'telemarketer' => UserProfile::where('id', $product->QuoteInformation->telemarket_id)->first()->fullAmericanName(),
                    ];
                }
            }
        }
        return $quoteProducts;

    }

    public static function requestForQuoteAppointedProductByLeads($leads)
    {
        $quoteProducts = [];
        foreach($leads as $lead)
        {
            $query = self::where('leads_id', $lead->id)->first();
            if($query){
                $products = $query->QuoteInformation->QuotationProduct()->where('user_profile_id', null)->where('status', 29)->get();
                foreach($products as $product)
                {
                    $quoteProducts[] = [
                        'company' => $product->QuoteInformation->QuoteLead->leads->company_name,
                        'product' => $product,
                        'sent_out_date' => $product->sent_out_date,
                        'status' => $product->status,
                        'telemarketer' => UserProfile::where('id', $product->QuoteInformation->telemarket_id)->first()->fullAmericanName(),
                    ];
                }
            }
        }
        return $quoteProducts;

    }

}