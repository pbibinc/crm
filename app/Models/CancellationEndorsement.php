<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CancellationEndorsement extends Model
{
    use HasFactory;

    protected $table = 'cancellation_endorsement_report';

    protected $fillable = [
        'policy_details_id',
        'type_of_cancellation',
        'media_id',
        'cancelled_by_id',
        'agent_remarks',
        'cancellation_date'
    ];

    public function PolicyDetail()
    {
        return $this->belongsTo(PolicyDetail::class, 'policy_details_id');
    }

    public function UserProfile()
    {
        return $this->belongsTo(UserProfile::class, 'cancelled_by_id');
    }

    public function Medias()
    {
        return $this->belongsTo(Metadata::class, 'media_id');
    }
}