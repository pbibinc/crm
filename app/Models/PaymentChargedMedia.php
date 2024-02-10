<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentChargedMedia extends Model
{
    use HasFactory;

    protected $table = 'payment_charged_media_table';

    protected $fillable = [
        'payment_charged_id',
        'metadata_id',
    ];
}