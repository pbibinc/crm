<?php

namespace App\Models;

use Carbon\Carbon;
use DGvai\BladeAdminLTE\Components\Card;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancingAgreement extends Model
{
    use HasFactory;

    protected $table = 'financing_agreement';

    protected $fillable = [
        'selected_quote_id',
        'financing_company_id',
        'is_auto_pay',
        'media_id',
    ];

    public function QuoteComparison()
    {
        return $this->belongsTo(SelectedQuote::class, 'selected_quote_id');
    }
    public function media()
    {
        return $this->belongsTo(Metadata::class, 'media_id');
    }

    public function PaymentOption()
    {
        return $this->hasOne(PaymentOption::class, 'financing_agreement_id');
    }

    public function getNewFinancingAgreement()
    {
        $today = Carbon::now()->format('Y-m-d h:i:s');
        $thirtyDaysAgo = Carbon::now()->subDays(30)->format('Y-m-d h:i:s');

        $data = self::whereDate('created_at', '>=', $thirtyDaysAgo)->whereDate('created_at', '<=', $today)->get();

        return $data->isEmpty() ? []: $data;
    }

    public function getCustomersPfa($leadId)
    {
        foreach($this->get() as $data)
        {
            $financingAgreement = [];
            $selectedQuote = SelectedQuote::find($data->selected_quote_id);
            $leadId = QuotationProduct::find($selectedQuote->quotation_product_id)->QuoteInformation->QuoteLead->leads->id;
            $financingAgreement[] = [
                'lead_id' => $leadId,
                'data' => $data,
            ];
        }
        $data = array_filter($financingAgreement, function($item) use($leadId){
            return $item['lead_id'] == $leadId;
        });
        return $data ? $data : [];
    }
}