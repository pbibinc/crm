<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoundInformation extends Model
{
    use HasFactory;

    protected $table = 'bound_information_table';

    public $timestamps = false;
    protected $fillable = [
        'quotation_product_id',
        'user_profile_id',
        'bound_date',
    ];


}