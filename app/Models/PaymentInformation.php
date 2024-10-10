<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentInformation extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'payment_information_table';

    protected $fillable = [
        'quote_comparison_id',
        'payment_type',
        'payment_method',
        'compliance_by',
        'amount_to_charged',
        'note'
    ];

    public function QuoteComparison()
    {
        return $this->belongsTo(SelectedQuote::class, 'selected_quote_id');
    }

    public function SelectedQuote()
    {
        return $this->belongsTo(SelectedQuote::class, 'selected_quote_id');
    }

    public function PaymentCharged()
    {
        return $this->hasOne(PaymentCharged::class, 'payment_information_id');
    }

    public function AccountsForPayable()
    {
        $paymentInformation = $this->get();
        $accountsForPayable = [];
        foreach($paymentInformation as $data){
             $accountsForPayable[] = [
                'data' => $data,
                'quote_comparison_status' => $data->QuoteComparison->recommended,
             ];
        }
        $data = array_filter($accountsForPayable, function($item){
            return $item['quote_comparison_status'] == 2;
        });
        // dd($data);
        return $data;
    }

    public function getPaymentInformationByLeadId($id)
    {
        $quoteInformationData = [];
        foreach($this->get() as $data){
            $selectedQuote = SelectedQuote::find($data->selected_quote_id);
            $leadId = QuotationProduct::find($selectedQuote->quotation_product_id)->QuoteInformation->QuoteLead->leads->id;
            $quoteStatus = $data->status;
            $quoteInformationData[] = [
                'lead_id' => $leadId,
                'data' => $data,
                'status' => $quoteStatus
            ];
        }


        $data = array_filter($quoteInformationData, function($item) use($id){
            return $item['lead_id'] == $id;
        });

        return $data ? $data : [];
        // $quoteInformation = $this-
    }
    public function getTrashedPaymentInformationByLeadId($id)
    {
        $quoteInformationData = [];

        // Fetch all trashed payment information
        $trashedPayments = $this->onlyTrashed()->get();

        foreach ($trashedPayments as $data) {
            $selectedQuote = SelectedQuote::find($data->selected_quote_id);

            // Continue to next iteration if selected quote is not found
            if (!$selectedQuote) {
                continue;
            }

            $quotationProduct = QuotationProduct::find($selectedQuote->quotation_product_id);

            // Continue to next iteration if quotation product is not found
            if (!$quotationProduct || !$quotationProduct->QuoteInformation || !$quotationProduct->QuoteInformation->QuoteLead) {
                continue;
            }

            $lead = $quotationProduct->QuoteInformation->QuoteLead->leads;

            // Continue to next iteration if lead is not found
            if (!$lead) {
                continue;
            }

            $quoteInformationData[] = [
                'lead_id' => $lead->id,
                'data' => $data,
                'status' => $data->status
            ];
        }

        // Filter the results based on the provided lead ID
        $data = array_filter($quoteInformationData, function ($item) use ($id) {
            return $item['lead_id'] == $id;
        });

        return $data; // No need for additional ternary check
    }
}