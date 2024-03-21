<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RenewalQuote extends Model
{
    use HasFactory;

    protected $table = 'renewal_quote';

    protected $fillable = [
        'quote_comparison_id',
        'status'
    ];

    public function QuoteComparison()
    {
        return $this->belongsTo(QuoteComparison::class, 'quote_comparison_id');
    }
}