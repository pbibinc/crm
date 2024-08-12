<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditRequiredFile extends Model
{
    use HasFactory;

    protected $table = 'audit_required_file';

    protected $fillable = [
        'audit_information_id',
        'media_id',
    ];
}