<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuoteForm extends Model
{
    use HasFactory;

    protected $table = 'quote_form_table';
    protected $guarded = [];

    // public function fetchAllQuotationRecords() {
    //     return
    // }

}
