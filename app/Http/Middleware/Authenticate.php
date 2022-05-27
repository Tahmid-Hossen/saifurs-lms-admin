<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param Request $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (in_array('auth:api', $request->route()->action['middleware'])) {
            return route('v1.api-logout');
        } elseif (!$request->expectsJson()) {
            return route('login');
        }
    }
}
