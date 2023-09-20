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

}
