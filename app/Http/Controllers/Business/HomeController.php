<?php

namespace App\Http\Controllers\Business;
use App\Http\Controllers\Controller;
use App\Models\PromotionSetting;
use App\Models\Social;
use Carbon\Carbon;
use Faker\Provider\DateTime;
use Illuminate\Http\Request;

use App\Models\BusinessLogo;
use App\Models\BusinessPromotion;
use App\Models\Business;
use App\Models\BusinessUser;
use Auth;
use Validator;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $param = $request->route()->parameters();
        $bzname = $param['bzname'];
        $user = Auth::guard('user')->user();

        $business = Business::where('business_name', $bzname)->first();
        $logo = BusinessLogo::where('business_id', $business->id)->first();
        $current_date = Carbon::now('Asia/Irkutsk');
        $current_time = Carbon::now('Asia/Irkutsk')->format('H:i:s');

        $setting = PromotionSetting::where('business_id', $business->id)
            ->where('start_date', '<=', $current_date)
            ->where('end_date', '>=', $current_date)
            ->whereTime('start_date', '<=', $current_time)
            ->whereTime('end_date', '>=',$current_time)
            ->first();

        if($setting == null) {
            $setting = PromotionSetting::where('business_id', $business->id)->where('default', 1)->first();
        }
        if($setting == null) {
            $setting = PromotionSetting::where('business_id', $business->id)->first();
        }

        if($setting == null) {
            $promotion = null;
        }else {
            $promotion = BusinessPromotion::find($setting->promotion_id);
        }

        if(empty($user->gender)) {
            return redirect()->route('bzuser.addInfo', ['bzname' => $bzname]);
        }

        $bzCheck = Business::where('business_name', $bzname)->first();
        $bzUser = BusinessUser::where('user_id', $user->id)->where('business_id', $bzCheck->id)->first();

        if(empty($bzUser)) {
            $businessUser = BusinessUser::create([
                'business_id' => $bzCheck->id,
                'user_id' => $user->id
            ]);
            $businessUser->save();
        }

        $social_user = Social::where('user_id', $user->id)->first();
        $social_provider = 'facebook';
        if(isset($social_user)) {
            $social_provider = $social_user->provider;
        }

        $data = [
            'bzname' => $bzname,
            'mac' => $user->mac_address,
            'logo' => $logo,
            'promotion' => $promotion,
            'business' => $business->business_fullname,
            'user' => $user->first_name,
            'provider' => $social_provider
        ];

        return view('pages.business.home.home', $data);
    }

    public function addInfo(Request $request)
    {
        $param = $request->route()->parameters();
        $bzname = $param['bzname'];
        $user = Auth::guard('user')->user();

        $missing = false;
        if(substr($user->email, 0, 7) == 'missing')
            $missing = true;
        return view('pages.business.home.addInfo', ['user' => $user, 'bzname' => $bzname, 'missing' => $missing]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::guard('user')->user();
        $param = $request->route()->parameters();
        $bzname = $param['bzname'];

        if(substr($user->email, 0, 7) == 'missing')
        {
            $validator = Validator::make($request->all(),
                [
                    'email'             => 'required',
                    'gender'            => 'required',
                    'year'              => 'required',
                    'country'           => 'required',
                ],
                [
                    'email.required'        => 'Email is required',
                    'gender.required'       => 'Gender is required',
                    'year.required'         => 'Year is required',
                    'country.required'      => 'Country is required',
                ]
            );
        }else {
            $validator = Validator::make($request->all(),
                [
                    'gender'            => 'required',
                    'year'              => 'required',
                    'country'           => 'required',
                ],
                [
                    'gender.required'       => 'Gender is required',
                    'year.required'         => 'Year is required',
                    'country.required'      => 'Country is required',
                ]
            );
        }

        if(substr($user->email, 0, 7) == 'missing')
            $user->email = $request->input('email');

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user->gender = $request->input('gender');
        $user->year = $request->input('year');
        $user->country = $request->input('country');

        $user->save();

        return redirect()->route('bzuser.home', ['bzname' => $bzname]);
    }
}
