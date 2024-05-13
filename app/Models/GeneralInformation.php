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

    public function customerFullName()
    {
        return $this->firstname . ' ' . $this->lastname;
    }

    public function generalLiabilities()
    {
        return $this->hasOne(GeneralLiabilities::class, 'general_information_id', 'id');
    }

    public function workersCompensation()
    {
        return $this->hasOne(WorkersCompensation::class, 'general_information_id', 'id');
    }

    public function commercialAuto()
    {
        return $this->hasOne(CommercialAuto::class, 'general_information_id', 'id');
    }

    public function lead()
    {
        return $this->belongsTo(Lead::class, 'leads_id', 'id');
    }

    public function excessLiability()
    {
        return $this->hasOne(ExcessLiability::class, 'general_information_id', 'id');
    }

    public function toolsEquipment()
    {
        return $this->hasOne(ToolsEquipment::class, 'general_information_id', 'id');
    }

    public function buildersRisk()
    {
        return $this->hasOne(BuildersRisk::class, 'general_information_id', 'id');
    }

    public function businessOwners()
    {
        return $this->hasOne(BusinessOwnersPolicy::class, 'general_information_id', 'id');
    }

    public static function getProductByGeneralInformationId($generalInformationId)
    {
        $generalInfo = self::find($generalInformationId);

        $product = [];
        if($generalInfo->generalLiabilities){
            array_push($product, 'General Liability');
        }
        if($generalInfo->workersCompensation){
            array_push($product, 'Workers Compensation');
        }
        if($generalInfo->commercialAuto){
            array_push($product, 'Commercial Auto');
        }
        if($generalInfo->excessLiability){
            array_push($product, 'Excess Liability');
        }
        if($generalInfo->toolsEquipment){
            array_push($product, 'Tools Equipment');
        }
        if($generalInfo->buildersRisk){
            array_push($product, 'Builders Risk');
        }
        if($generalInfo->businessOwners){
            array_push($product, 'Business Owners');
        }

        return $product;
    }

}
