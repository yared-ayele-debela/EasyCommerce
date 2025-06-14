<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
   public function handle(Request $request, Closure $next, $permission)
    {
        $user = Auth::guard('admin')->user();
        // dd($user->hasPermissionByRole($permission));

        if (!$user->hasPermissionByRole($permission)) {
            return response()->view('admin.errors.unauthorized');
        }

        return $next($request);
    }
}