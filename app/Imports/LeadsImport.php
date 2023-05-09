<?php

namespace App\Imports;

use App\Models\Lead;
use App\Models\leads;
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
        return new Lead([
            'company_name' => $row[0],
            'tel_num' => $row[1],
            'state_abbr' => strtoupper($row[2]),
//            'disposition_name' => $row[3],
            'website_originated' => $row[4]

        ]);
    }
}
