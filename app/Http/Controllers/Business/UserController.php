<?php

namespace App\Http\Controllers\Business;
use App\Http\Controllers\Controller;
use App\Models\AdminSetting;
use App\Models\BusinessLogo;
use App\Models\BusinessPromotion;
use App\Models\UserMacaddress;
use App\Models\UserLoginTime;
use Carbon\Carbon;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

use App\Models\Profile;
use App\Models\User;
use App\Models\Business;
use App\Models\BusinessUser;
use jeremykenedy\LaravelRoles\Models\Role;
use Auth;
use Response;
use Validator;
class UserController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $param = $request->route()->parameters();
        $bzname = $param['bzname'];

        //Check Email using Neverbounce
        $data = $request->all();

        $validator = Validator::make($data,
            [
                'name'                  => 'required|max:255|unique:users',
                'first_name'            => 'required',
                'last_name'             => 'required',
                'email'                 => 'required|email|max:255|unique:users',
                'password'              => 'required|min:6|max:20',
            ],
            [
                'name.unique'         => trans('auth.userNameTaken'),
                'name.required'       => trans('auth.userNameRequired'),
                'first_name.required' => trans('auth.fNameRequired'),
                'last_name.required'  => trans('auth.lNameRequired'),
                'email.required'      => trans('auth.emailRequired'),
                'email.email'         => trans('auth.emailInvalid'),
                'password.required'   => trans('auth.passwordRequired'),
            ]
        );

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $profile = new Profile();

        $user = User::create([
            'name'             => $request->input('name'),
            'first_name'       => $request->input('first_name'),
            'last_name'        => $request->input('last_name'),
            'email'            => $request->input('email'),
            'password'         => bcrypt($request->input('password')),
            'token'            => str_random(64),
            'activated'        => 1,
            'mac_address'      => $request->input('mac'),
            'is_new'           => 'yes',
        ]);

        $user->profile()->save($profile);

        $role = Role::where('name', 'User')->first()->id;
        $user->attachRole($role);
        $user->save();

        //Save login time
        $login_time = UserLoginTime::create([
            'user_id' => $user->id,
            'login_time' => Carbon::now('GMT')
        ]);
        $login_time->save();

        //Save Mac address
        $user_mac = UserMacaddress::create([
            'user_id' => $user->id,
            'mac_address' => $request->input('mac')
        ]);
        $user_mac->save();

        $bzCheck = Business::where('business_name', $bzname)->first();
        //Create and Save Business User
        $businessUser = BusinessUser::create([
            'business_id' => $bzCheck->id,
            'user_id' => $user->id
        ]);
        $businessUser->save();

        Auth::guard('user')->login($user, true);

        return redirect()->route('bzuser.home', ['bzname' => $bzname])->with('success', 'Registration Success !');
    }

    public function viewLogin(Request $request)
    {
        $param = $request->route()->parameters();
        $bzname = $param['bzname'];
        $mac_address = $request->input('mac');

        $business = Business::where('business_name', $bzname)->first();
        $logo = BusinessLogo::where('business_id', $business->id)->first();
        $setting = AdminSetting::where('business_id', $business->id)->first();

        $data = [
            'bzname' => $bzname,
            'mac_address' => $mac_address,
            'logo' => $logo,
            'setting' => $setting,

        ];

        return view('pages.business.auth.login', $data);
    }

    public function viewRegister(Request $request)
    {
        $param = $request->route()->parameters();
        $bzname = $param['bzname'];
        $mac_address = $request->input('mac');

        $business = Business::where('business_name', $bzname)->first();
        $logo = BusinessLogo::where('business_id', $business->id)->first();

        $data = [
            'bzname' => $bzname,
            'mac_address' => $mac_address,
            'logo' => $logo
        ];

        return view('pages.business.auth.register', $data);
    }

    public function viewLoginAccount(Request $request)
    {
        $param = $request->route()->parameters();
        $bzname = $param['bzname'];
        $mac_address = $request->input('mac');

        $business = Business::where('business_name', $bzname)->first();
        $logo = BusinessLogo::where('business_id', $business->id)->first();

        $data = [
            'bzname' => $bzname,
            'mac_address' => $mac_address,
            'logo' => $logo
        ];

        return view('pages.business.auth.login_with_account', $data);
    }



    // authenticate user
    public function authenticate(Request $request)
    {
        $param = $request->route()->parameters();
        $bzname = $param['bzname'];

        // authenticate business user
        if (Auth::guard('user')->attempt(['email'=>$request->input('email'), 'password'=>$request->input('password')]))
        {
            $permissions = [];
            session(['permissions' => $permissions]);
            $business = Business::where('business_name', $bzname)->first();
            $user = User::where('email', $request->input('email'))->first();
            $bzUser = BusinessUser::where('user_id', $user->id)->where('business_id', $business->id)->first();

            if(empty($bzUser)) {
                $businessUser = BusinessUser::create([
                    'business_id' => $business->id,
                    'user_id' => $user->id
                ]);
                $businessUser->save();
            }

            // Update User Status
            $user->is_new = 'no';
            $user->save();

            // Check Mac Address
            $user_mac = UserMacaddress::where('user_id', $user->id)->where('mac_address', $request->input('mac'))->first();
            if(empty($user_mac)) {
                $user_mac = UserMacaddress::create([
                    'user_id' => $user->id,
                    'mac_address' => $request->input('mac')
                ]);
                $user_mac->save();
            }

            //Save login time
            $login_time = UserLoginTime::create([
                'user_id' => $user->id,
                'login_time' => Carbon::now('GMT')
            ]);
            $login_time->save();

            return redirect()->route('bzuser.home', ['bzname' => $bzname]);

        }
        else
        {
            return redirect()->route('bzuser.login.account', ['bzname' => $bzname])->with('errorLogin', 'Ooops! Invalid Email or Password')->withInput();
        }
    }

    //Check Mac Address

    public function checkMacAddress(Request $request)
    {
        $param = $request->route()->parameters();
        $bzname = $param['bzname'];

        $input = $request->all();
        $mac_address = $input['mac'];

        $user_mac = UserMacaddress::where('mac_address', $mac_address)->first();
        $user = User::find($user_mac->user_id);

        if(isset($user)) {
            Auth::guard('user')->login($user, true);

            $user->is_new = 'no';
            $user->save();

            //Save login time
            $login_time = UserLoginTime::create([
                'user_id' => $user->id,
                'login_time' => Carbon::now('GMT')
            ]);
            $login_time->save();

            //Save Business User
            $bzCheck = Business::where('business_name', $bzname)->first();
            $bzUser = BusinessUser::where('user_id', $user->id)->where('business_id', $bzCheck->id)->first();

            if(empty($bzUser)) {
                $businessUser = BusinessUser::create([
                    'business_id' => $bzCheck->id,
                    'user_id' => $user->id
                ]);
                $businessUser->save();
            }

            return response()->json(['success'=> 1, 'bzname' => $bzname]);
        }
    }

    // logging out user from business panel
    public function logout(Request $request)
    {
        $param = $request->route()->parameters();
        $bzname = $param['bzname'];

        if (Auth::guard('user')->check()) {

            Auth::guard('user')->logout();
            $request->session()->flush();
            return redirect()->route('bzuser.login', ['bzname' => $bzname]);
        }
    }

    public function not_exist()
    {
        return view('pages.business.not_exist');
    }
}
