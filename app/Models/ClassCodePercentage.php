<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassCodePercentage extends Model
{
    use HasFactory;
    protected $table = 'classcode_percentage_table';

    public $timestamps = false;

    protected $fillable = [
        'general_liabilities_id',
        'classcode_id',
    ];

    public function classCodeLead()
    {
        return $this->hasOne(ClassCodeLead::class, 'id', 'classcode_id');
    }


}
