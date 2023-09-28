<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BrokerQuotation extends Model
{
    use HasFactory;

    protected $table = 'broker_quotation_table';

    protected $fillable = [
        'user_profile_id',
        'lead_id',
        'status',
        'remarks',
    ];

    public $timestamps = false;

}
