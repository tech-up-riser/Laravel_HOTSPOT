<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\Models\Business;

class BusinessGuestMiddleware
{
    /**
     * Handle an incoming guest user request to access admin panel.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $param = $request->route()->parameters();
        if(isset($param['bzname'])) {
            $bzname = $param['bzname'];
        } else {
            $bzname = $request->query->get('bzname');
        }

        $business = Business::where('business_name', $bzname)->first();

        if(empty($business)) {
            return redirect()->route('business.not_exist');
        }

        if(Auth::guard('business')->check())
        {
            if (Auth::guard('business')->user()->hasRole('business')) {
                return redirect()->route('business.admin.dashboard', ['bzname' => $bzname]);
            } else {
                return $next($request);
            }
            
        } else {
            return $next($request);
        }
    }
}
