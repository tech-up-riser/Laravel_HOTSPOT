<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\Models\Business;

class UserAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $param = $request->route()->parameters();
        $bzname = $param['bzname'];

        $business = Business::where('business_name', $bzname)->first();
        if(empty($business)) {
            return redirect()->route('business.not_exist');
        }

        if(Auth::guard('user')->check())
        {
            if (Auth::guard('user')->user()->hasRole('user'))
            {
                return $next($request);
            }
            else
            {
                $request->session()->flush();
                return redirect()->route('bzuser.login', ['bzname' => $bzname]);
            }

        }
        else
        {
            return redirect()->route('bzuser.login', ['bzname' => $bzname]);
        }
    }
}
