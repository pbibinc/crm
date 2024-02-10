<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BindingDocs extends Model
{
    use HasFactory;

    public function getBindingLeadsId($quotationProductId)
    {
        $lead = Lead::find($quotationProductId);
        $medias = $lead->quoteLead->QuoteInformation->QuotationProduct->medias;
        return $medias;
    }
}