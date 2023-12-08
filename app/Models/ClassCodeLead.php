<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassCodeLead extends Model
{
    use HasFactory;

    protected $table = 'class_code_leads_table';

    public static function sortByName($classCodeLeads)
    {
        return $classCodeLeads->sortBy('name');
    }

    public function generalLiabilities()
    {
        return $this->belongsToMany(GeneralLiabilities::class, 'classcode_percentage_table', 'classcode_id', 'general_liabilities_id');
    }

    public function classCodeAlphabetical()
    {
        return $this->sortBy('name');
    }

}
