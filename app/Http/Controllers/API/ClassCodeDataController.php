<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\ClassCodeLead;

class ClassCodeDataController extends BaseController
{
    public function index()
    {
        $classCodeData = ClassCodeLead::all();
        return $this->sendResponse($classCodeData->toArray(), 'Class Code Data retrieved successfully.');
    }
    public function show($id)
    {
        $classCodeData = ClassCodeLead::find($id);
        if (is_null($classCodeData)) {
            return $this->sendError('Class Code Data not found.');
        }
        return $this->sendResponse($classCodeData->toArray(), 'Class Code Data retrieved successfully.');
    }
}

?>