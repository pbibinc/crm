<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuoteInformation extends Model
{
    use HasFactory;

    protected $table = 'quote_information_table';

    protected $fillable = [
        'telemarket_id',
        'quoting_lead_id',
        'status',
        'remarks',
    ];

    public function QuoteLead()
    {
        return $this->belongsTo(QuoteLead::class, 'quoting_lead_id');
    }

    public function QuotationProduct()
    {
        return $this->hasOne(QuotationProduct::class, 'quote_information_id');
    }

    public static function getInformationByLeadId($leadId)
    {
        $quoteLeadId = QuoteLead::where('leads_id', $leadId)->first();
        if($quoteLeadId){
            return self::where('quoting_lead_id', $quoteLeadId->id)->first();
        }
        return null;
    }
}