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

}
