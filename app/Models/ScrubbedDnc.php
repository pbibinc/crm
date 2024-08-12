<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScrubbedDnc extends Model
{
    use HasFactory;
    protected $table = 'scrubbed_dnc_table';
    protected $fillable = [
        'lead_id',
    ];

    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }

}