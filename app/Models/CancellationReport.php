<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CancellationReport extends Model
{
    use HasFactory;

    protected $table = 'cancellation_report';

    protected $fillable = [
        'policy_details_id',
        'type_of_cancellation',
        'agent_remarks',
        'recovery_action',
        'reinstated_date',
        'reinstated_eligibility_date'
    ];

    public function PolicyDetail()
    {
        return $this->belongsTo(PolicyDetail::class, 'policy_details_id');
    }

}