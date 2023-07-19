<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LeadResource extends JsonResource
{
    public function toArray($request)
    {
        return[
            'id' => $this->id,
            'company_name' => $this->company_name,
            'tel_num' => $this->tel_num,
            'state_abbr' => $this->state_abbr,
            'class_code' => $this->class_code,
            'website_originated' => $this->website_originated,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'prime_lead' => $this->prime_lead,
        ]
    }
}

?>