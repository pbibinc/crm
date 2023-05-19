<?php

namespace App\Imports;

use App\Models\Lead;
use App\Models\leads;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;

class LeadsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $lead = Lead::firstOrCreate(
            ['tel_num' => $row[1]],
            [
                'company_name' => $row[0],
                'state_abbr' => strtoupper($row[2]),
                'class_code' => $row[3],
                'website_originated' => $row[4]
            ]
        );
        return $lead;
    }
}
