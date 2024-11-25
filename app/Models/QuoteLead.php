<?php

namespace App\Models;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
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



    public static function getAppointedProductByLeads($perPage = 10)
    {
        $quoteProducts = []; // Initialize array to store product details

        // Your existing query and array building logic
        $query = self::orderBy('created_at')->get();
        foreach ($query as $quote) {
            $products = $quote->quoteInformation->quotationProduct()
                ->whereNull('user_profile_id')
                ->whereIn('status', [7, 29])
                ->orderBy('created_at')
                ->get();

            foreach ($products as $product) {
                $quoteProducts[] = [
                    'company' => $product->quoteInformation->quoteLead->leads->company_name ?? 'N/A',
                    'leadId' => $product->quoteInformation->quoteLead->leads->id ?? 'N/A',
                    'product' => $product,
                    'sent_out_date' => $product->sent_out_date,
                    'status' => $product->status,
                    'telemarketer' => UserProfile::find($product->quoteInformation->telemarket_id)?->fullAmericanName() ?? 'N/A',
                ];
            }
        }

        // Convert the array to a Laravel Collection
        $quoteProductsCollection = collect($quoteProducts);

        // Get the current page using the Paginator class
        $currentPage = Paginator::resolveCurrentPage();

        // Slice the collection for the items of the current page
        $currentPageItems = $quoteProductsCollection->slice(($currentPage - 1) * $perPage, $perPage)->values();

        // Create a LengthAwarePaginator instance and set the correct path
        $paginator = new LengthAwarePaginator(
            $currentPageItems,
            $quoteProductsCollection->count(),
            $perPage,
            $currentPage,
            [
                'path' => route('appointed-product-list.index'), // Set the correct path here
            ]
        );

        return $paginator;
    }


    public static function requestForQuoteAppointedProductByLeads($leads)
    {
        $quoteProducts = [];
        foreach($leads as $lead)
        {
            $query = self::where('leads_id', $lead->id)->first();
            if($query){
                $products = $query->QuoteInformation->QuotationProduct()->where('user_profile_id', null)->where('status', 30)->get();
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