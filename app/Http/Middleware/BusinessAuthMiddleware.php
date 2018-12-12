<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\Models\Business;
use App\Models\BusinessAdmin;

class BusinessAuthMiddleware
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
            $user = Auth::guard('business')->user();
            $business_admin = BusinessAdmin::where('user_id', $user->id)->first();

            if (Auth::guard('business')->user()->hasRole('business') && $business->id == $business_admin->business_id)
            {
                return $next($request);
            }
            else
            {
                $request->session()->flush();
                return redirect()->route('business.admin.login', ['bzname' => $bzname]);
            }

        }
        else
        {
            return redirect()->route('business.admin.login', ['bzname' => $bzname]);
        }
    }
}
