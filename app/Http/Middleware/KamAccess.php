<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KamAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $role = null;
        if (Auth::id()){
            $user = User::with('role')->where('id',Auth::id())->first();
            $role = $user->role?$user->role->name:'';
        }

        if (Auth::guard('api')->check()) {
            if ($role == 'KAM' || $role == 'Admin'){
                return $next($request);
            }else {
                $message = [
                    "status" => "error",
                    "message" => "Permission Denied"
                ];
                return response($message, 401);
            }

        } else {
            $message = [
                "status" => "error",
                "message" => "Permission Denied"
            ];
            return response($message, 401);
        }
    }
}
