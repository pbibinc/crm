<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentInformation extends Model
{
    use HasFactory;

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
        return $this->belongsTo(QuoteComparison::class, 'quote_comparison_id');
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
            $leadId = $data->QuoteComparison->QuotationProduct->QuoteInformation->QuoteLead->leads->id;
            $quoteStatus = $data->QuoteComparison->recommended;
            $quoteInformationData[] = [
                'lead_id' => $leadId,
                'data' => $data,
                'status' => $quoteStatus
            ];
        }

        $data = array_filter($quoteInformationData, function($item) use($id){
            return $item['lead_id'] == $id && $item['status'] == 3;
        });

        return $data;
        // $quoteInformation = $this-
    }
}