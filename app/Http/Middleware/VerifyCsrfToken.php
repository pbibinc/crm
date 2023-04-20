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
        // 'admin/*'
        'admin/positions/*',
        'admin/departments/*',
        'admin/user-profiles/*',
        'admin/permissions/*',
        'admin/users/*'
    ];

    protected function shouldPassThrough($request)
    {
       if ($request->is('admin/positions/*') && $request->isMethod('delete')) {
        return true;
       }


       if ($request->is('admin/departments/*') && $request->isMethod('delete')) {
        return true;
       }

       if ($request->is('admin/user-profiles/*') && $request->isMethod('delete')) {
        return true;
       }

       if ($request->is('admin/permissions/*') && $request->isMethod('delete')) {
        return true;
       }
        if ($request->is('admin/users/*') && $request->isMethod('delete')) {
            return true;
        }


       return false;
    }

}
