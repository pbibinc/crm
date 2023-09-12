<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralInformation extends Model
{
    use HasFactory;

    protected $table = 'general_information_table';

    protected $fillable = [
        'firstname',
        'lastname',
        'job_position',
        'address',
        'zipcode',
        'state',
        'sub_out',
        'contact_num',
        'alt_num',
        'email_address',
        'fax',
        'website',
        'gross_receipt',
        'full_time_employee',
        'part_time_employee',
        'employee_payroll',
        'all_trade_work',
        'owners_payroll',
        'leads_id',
    ];

    public static function getIdByLeadId($leadId)
    {
        $generalInformation =  self::where('leads_id', $leadId)->first()->id;

        if($generalInformation){
            return $generalInformation;
        }
        return null;
    }

    public function generalLiabilities()
    {
        return $this->hasOne(GeneralLiabilities::class);
    }

    public function workersCompensation()
    {
        return $this->hasOne(WorkersCompensation::class, 'general_information_id', 'id');
    }

    public function commercialAuto()
    {
        return $this->hasOne(CommercialAuto::class, 'general_information_id', 'id');
    }


}
