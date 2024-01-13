<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Traits\ExceptionTrait;
use Illuminate\Support\Facades\Route;

use Symfony\Component\HttpFoundation\Response;

class CheckPermissionMiddleware
{
    use ExceptionTrait;

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // GET CURRENT ROUTE NAME
        $route = Route::currentRouteName();

        // CHECK IF EXCEMPTED ROUTE
        if(in_array($route, config('permission_exemption')) || strpos($route, '.option') !== false) {
            return $next($request);
        }

        // AUTH USER REQUIREMENT
        if(request()->user()) {
            // GET USER ROLE
            $role = request()->user()->role;

            // CHECK ROLE
            if($role) {
                // GET USER PERMISSIONS
                $permissions = $role->permissions->pluck('route')->toArray();

                // CHECK IF IN ARRAY
                if(in_array($route, $permissions)) {
                    return $next($request);
                }
            }
        }

        $this->throwException('401', 'Unauthorized Access');
    }
}
