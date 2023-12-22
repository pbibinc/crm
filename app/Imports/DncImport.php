<?php

namespace App\Imports;

use App\Http\Controllers\LeadController;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class DncImport implements ToCollection
{
    protected $importedData;
    /**
    * @param Collection $collection
    */

    public function collection(Collection $collection)
    {
        $this->importedData = $collection;
    }

    public function getImportedData()
    {
        return $this->importedData;
    }
}