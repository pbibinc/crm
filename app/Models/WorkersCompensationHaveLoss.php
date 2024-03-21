<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkersCompensationHaveLoss extends Model
{
    use HasFactory;

    protected $table = 'workers_comp_have_losses_table';

    public $timestamps = false;

    protected $fillable = [
        'workers_compensation_id',
        'date_of_claim',
        'loss_amount'
    ];
}