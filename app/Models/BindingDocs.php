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
        $docs = $lead->getLeadMedias()->get();
        // foreach($quotationProductIds as $quotationProductId){
        //     $productMedia = QuotationProduct::find($quotationProductId)->medias();
        //     $medias[] = $productMedia;
        // }
        return $docs;
    }

    public function getMediaByProductId($quotationProductId)
    {
        $productMedia = QuotationProduct::find($quotationProductId)->medias();
        return $productMedia;
    }


}
