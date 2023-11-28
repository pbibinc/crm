<?php

namespace App\Policies;

use App\Models\Lead;
use App\Models\Role;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\User;

class ApptakerPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */

      /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\Lead  $user
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function __construct()
    {
        //
    }

    public function viewAny(Lead $lead, Role $role)
    {
        return $lead->userProfile->user->role->hasPermission('view_any_apptaker');
    }

    public function view(Lead $lead, Role $role)
    {
        return $lead->userProfile->user->role->hasPermission('view_apptaker_lead_list');
    }

    public function viewAppointed(Lead $lead, Role $role)
    {
        return $lead->userProfile->user->role->hasPermission('view_apptaker_appointed_lead_list');
    }


}
