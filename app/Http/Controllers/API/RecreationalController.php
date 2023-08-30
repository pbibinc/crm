<?php
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\RecreationalFacilities;

class RecreationalController extends BaseController
{
    public function recreationalFactilies()
    {
        $recreationalFactilies = RecreationalFacilities::all();
        return $this->sendResponse($recreationalFactilies->toArray(), 'Recreational Factilies retrieved successfully.');
    }
}
?>