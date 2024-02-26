<?php

namespace App\Providers;

use App\Http\Controllers\AssignLeadController;
use App\Models\Attendance;
use App\Policies\LeadPolicy;
use App\Policies\LeadsPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Lead;
use App\Policies\AttendancePolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        Lead::class => LeadPolicy::class,
        Attendance::class => AttendancePolicy::class,

    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        //
    }
}