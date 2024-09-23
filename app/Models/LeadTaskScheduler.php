<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadTaskScheduler extends Model
{
    use HasFactory;

    protected $table = 'lead_task_scheduler_table';

    protected $fillable = [
        'assigned_by',
        'assigned_to',
        'leads_id',
        'description',
        'status',
        'date_schedule'
    ];

    public function assignedBy()
    {
        return $this->belongsTo(UserProfile::class, 'assigned_by');
    }

    public function assignedTo()
    {
        return $this->belongsTo(UserProfile::class, 'assigned_to');
    }

    public function leads()
    {
        return $this->belongsTo(Lead::class, 'leads_id');
    }
}