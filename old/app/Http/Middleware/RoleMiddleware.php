<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param                           $role
     * @param                           $permission
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $role, $permission = null)
    {
        if (Auth::guest()) {
            return redirect('/');
        }

        if (!$request->user()->hasRole($role)) {
            //abort(403, 'Insufficient permissions');
            return redirect('backend/404');
        }

        if ($permission && !$request->user()->can($permission)) {
            //abort(403, 'Insufficient permissions');
            return redirect('backend/404');
        }

        return $next($request);
    }
}
