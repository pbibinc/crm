<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Messages extends Model
{
    use HasFactory;

    protected $table = 'messages';

    protected $fillable = [
        'quotation_product_id',
        'receiver_email',
        'name',
        'sending_date',
        'template_id',
        'sender_id',
        'status',
    ];

    public function template()
    {
        return $this->belongsTo(Templates::class, 'template_id', 'id');
    }

    public function getMessageByLeadId($leadId)
    {

        $quoteInformationId = Lead::find($leadId)->quoteLead->QuoteInformation->id;
        $quotationProductIds = QuotationProduct::where('quote_information_id', $quoteInformationId)->pluck('id');
        $messages = self::whereIn('quotation_product_id', $quotationProductIds)->get();

        return $messages ? $messages : [];

    }

}
