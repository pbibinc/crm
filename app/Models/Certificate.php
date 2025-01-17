<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    use HasFactory;

    protected $table = 'certificate';

    protected $fillable = [
        'lead_id',
        'media_id',
        'status',
        'approved_by',
        'email',
        'phone_number',
        'requested_date',
        'cert_holder'
    ];

    public function PolicyDetail()
    {
        return $this->belongsTo(PolicyDetail::class, 'policy_details_id');
    }

    public function Media()
    {
        return $this->belongsTo(Metadata::class, 'media_id');
    }

    public function UserProfile()
    {
        return $this->belongsTo(UserProfile::class, 'approved_by');
    }

    public function Lead()
    {
        return $this->belongsTo(Lead::class, 'lead_id');
    }
}