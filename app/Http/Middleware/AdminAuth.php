<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuth
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
        if(!Auth::user()){
        	$request->session()->flash('error', 'Access Denied');
    		return redirect('login');
    	}
        else if(Auth::user()->status == '0'){
            $request->session()->flash('error', 'Access Denied');
    		return redirect('login');
        }
    	else if(Auth::user()->role_id == '0' || Auth::user()->role_id == '1'){ // 0=>superadmin, 1=>subadmin
            return $next($request);
        } 
        else{
            $request->session()->flash('error', 'Access Denied');
    		return redirect('login');
        }
    }
}
