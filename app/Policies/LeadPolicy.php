<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Lead;
use App\Models\User;

class LeadPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Lead  $lead
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Lead $lead)
    {
        //
        return $user->role->hasPermission('view_leads_nav');

    }

    public function viewImport(User $user, Lead $lead)
    {
        return $user->role->hasPermission('view_import_leads');
    }

    public function viewLeadsFunnel(User $user, Lead $lead)
    {
        return $user->role->hasPermission('view_leads_funnel');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Lead  $lead
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Lead $lead)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Lead  $lead
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Lead $lead)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Lead  $lead
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Lead $lead)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Lead  $lead
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Lead $lead)
    {
        //
    }

    public function viewAnyApptaker(User $user, Lead $lead)
    {
        return $user->role->hasPermission('view_any_apptaker');
    }

    public function viewApptakerLeadList(User $user, Lead $lead)
    {
        return $user->role->hasPermission('view_apptaker_lead_list');
    }

    public function viewApptakerLeadListAppointed(User $user, Lead $lead)
    {
        return $user->role->hasPermission('view_apptaker_appointed_lead_list');
    }

    public function viewAnySales(User $user, Lead $lead)
    {
        return $user->role->hasPermission('view_any_sales');
    }

    public function viewAnyQuotation(User $user, Lead $lead)
    {
        return $user->role->hasPermission('view_any_quotation');
    }

    public function viewForQouteLeads(User $user, Lead $lead)
    {
        return $user->role->hasPermission('view_for_qoute_leads');
    }

    public function viewAssignApppointedLeads(User $user, Lead $lead)
    {
        return $user->role->hasPermission('view_assign_apppointed_leads');
    }

    public function viewAssignQuotedLeads(User $user, Lead $lead)
    {
        return $user->role->hasPermission('view_assign_quoted_leads');
    }

    public function viewAnyBrokerAssistant(User $user, Lead $lead)
    {
        return $user->role->hasPermission('view_any_broker_assistant');
    }

    public function viewBrokerAssistantLeadList(User $user, Lead $lead)
    {
        return $user->role->hasPermission('view_broker_assistant_lead_list');
    }

    public function viewAnyCustomerService(User $user, Lead $lead)
    {
        return $user->role->hasPermission('view_any_customer_service');
    }

    public function viewCallBackLeadList(User $user, Lead $lead)
    {
        return $user->role->hasPermission('view_call_back_lead_list');
    }

}
