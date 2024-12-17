<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZeroBounce extends Model
{
    use HasFactory;

    protected $table = "zerobounce_email_validation_results_table";
    protected $guarded = [];
}
