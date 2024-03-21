<?php
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\UnitedState;

class StateAddressController extends BaseController
{
    public function states()
    {
        $states = UnitedState::all();
        return $this->sendResponse($states->toArray(), 'States retrieved successfully.');
    }
}

?>
