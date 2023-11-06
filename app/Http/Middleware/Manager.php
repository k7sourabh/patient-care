<?php

namespace App\Http\Middleware;
use Auth;
use Closure;
use Illuminate\Http\Request;

class Manager
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
        if (Auth::check() && auth()->user()->role()->first()->name=='Manager') {
            // $user_detail=User::with('roles_admin')->find(Auth()->user()->id);
            // if(in_array($user_detail->roles_admin->role_id,[1,2])){
            //     return $next($request);
            // }else{
            //     return redirect('/');
            // }
            return $next($request);
        }
        return $next($request);
    }
}
