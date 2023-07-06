<?php

namespace App\Imports;

use App\Events\LeadImportEvent;
use App\Models\Lead;
use App\Models\leads;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;

class LeadsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public $rows = 0;
  
    public function model(array $row)
    {
        ++$this->rows;

        $user = Auth::user();
        $id = $user->id;
        $adminData = User::find($id);
        $leadGenerator = $user->userProfile;
        $lead = Lead::firstOrCreate(
            ['tel_num' => $row[1]],
            [
                'company_name' => $row[0],
                'state_abbr' => strtoupper($row[2]),
                'class_code' => $row[3],
                'website_originated' => $row[4]
            ]
        );
        event(new LeadImportEvent($lead, $leadGenerator->id, now()));

        return $lead;
    }
}
