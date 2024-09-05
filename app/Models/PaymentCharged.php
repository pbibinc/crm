<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class PaymentCharged extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'payment_charged_table';

    protected $fillable = [
        'payment_information_id',
        'user_profile_id',
        'invoice_number',
        'charged_date',
    ];

    public function medias()
    {
        return $this->belongsToMany(Metadata::class, 'payment_charged_media_table', 'payment_charged_id', 'metadata_id');
    }
    public function userProfile()
    {
        return $this->belongsTo(UserProfile::class, 'user_profile_id', 'id');
    }

    public function paymentInformation()
    {
        return $this->belongsTo(PaymentInformation::class, 'payment_information_id', 'id');
    }

    // public function getMedias($id)
    // {
    //     $paymentCharged = $;
    //     $media = $this->medias()->where('metadata_id', $id)->first();
    //     if($media){
    //         return $media->metadata_value;
    //     }
    //     return null;
    // }
}