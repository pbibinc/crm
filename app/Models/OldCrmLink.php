<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OldCrmLink extends Model
{
    use HasFactory;

    protected $table = 'old_crm_link_table';

    protected $fillable = [
        'lead_id',
        'hyperlink',
    ];


    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }
}