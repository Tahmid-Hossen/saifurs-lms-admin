<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class UserAccessDeniedMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->user('web') && !$request->ajax()) {
            /**
             * @var User $authUser
             */
            $requestUser = auth()->user();
            //var_dump("Permission: " . $request->route()->getName() . " => " . ($requestUser->can($request->route()->getName()) ? "true" : "false"));
            if ($requestUser->can($request->route()->getName())) {
                return $next($request);
            }
            abort(401, 'Unauthorized, You don\'t have permission');
        }

        return $next($request);
    }
}
