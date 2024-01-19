<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        'admin/dashboard',
        'admin/positions/*',
        'admin/departments/*',
        'admin/user-profiles/*',
        'admin/permissions/*',
        'admin/users/*',
        'hrforms/*',
        // 'admin/*',
        'leads/disposition/*',
        'leads/classcodes/*',
        'leads/sic/*',

        'api/main-line-customer-service',

        'webhook-receiving-url'
    ];

    protected function shouldPassThrough($request)
    {
        // if ($request->is('admin/*') && $request->isMethod('delete')) {
        //     return true;
        // }

        if ($request->is('admin/positions/*') && $request->isMethod('delete')) {
            return true;
        }

        if ($request->is('admin/departments/*') && $request->isMethod('delete')) {
            return true;
        }

        if ($request->is('admin/user-profiles/*') && $request->isMethod('delete')) {
            return true;
        }

        // if ($request->is('hrforms/*') && $request->isMethod('delete')) {
        //     return true;
        // }

        if ($request->is('leads/disposition/*') && $request->isMethod('delete')) {
            return true;
        }

        if ($request->is('leads/classcodes/*') && $request->isMethod('delete')) {
            return true;
        }

        if ($request->is('leads/sic/*') && $request->isMethod('delete')) {
            return true;
        }

        return false;
    }
}