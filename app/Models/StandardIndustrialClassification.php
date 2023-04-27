<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StandardIndustrialClassification extends Model
{
    use HasFactory;

    protected $table = 'standard_industrial_classification';

    protected $fillable = [
        'sic_classcode',
        'sic_code',
        'workers_comp_code',
        'description'
    ];

    public function classCodetoSIC()
    {
        return $this->belongsTo(Classcode::class);
    }

    public function scopeWithData($query)
    {
        return $query->select(
            'standard_industrial_classification.id',
            'sic_classcode',
            'sic_code',
            'workers_comp_code',
            'description',
            'standard_industrial_classification.created_at',
            'standard_industrial_classification.updated_at',
            'class_codes.classcode_name'
        )
            ->leftJoin('class_codes', 'standard_industrial_classification.sic_classcode', '=', 'class_codes.id');
    }
}
