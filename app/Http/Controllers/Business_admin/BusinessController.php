<?php

namespace App\Http\Controllers\Business_admin;
use App\Http\Controllers\Controller;
use App\Models\AdminSetting;
use App\Models\BusinessAdmin;
use Carbon\Carbon;
use Faker\Provider\DateTime;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Business;
use App\Models\BusinessLogo;
use App\Models\BusinessPromotion;
use App\Models\BusinessUser;
use App\Models\Social;
use App\Models\PromotionSetting;
use jeremykenedy\LaravelRoles\Models\Role;
use Auth;
use Response;
use Validator;
class BusinessController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('business.auth');
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($bzname)
    {
        $user = Auth::guard('business')->user();

        $pagintaionEnabled = true;
        if ($pagintaionEnabled) {
            $businesses = Business::paginate(config('usersmanagement.paginateListSize'));
        } else {
            $businesses = Business::all();
        }

        $data = [
            'user' => $user,
            'bzname' => $bzname,
            'businesses' => $businesses
        ];

        return View('pages.business_admin.business.show-businesses', $data);
    }

    /**
     * Create a new User
     */
    public function edit($bzname)
    {
        $user = Auth::guard('business')->user();
        $business = Business::where('business_name', $bzname)->first();

        $data = [
            'business' => $business,
            'bzname' => $bzname,
            'user' => $user
        ];
        return view('pages.business_admin.business.edit-business', $data);
    }

    /**
     * Update the specified Room in storage.
     * @param  int              $id
     * @param UpdateRoomRequest $request
     * @return Response
     */
    public function update($bzname, $id, Request $request)
    {
        $country = $request->input('business_country');
        $input = $request->except('_token', '_method', 'business_email', 'business_country', 'email');
        $input['country'] = $country;

        $business = Business::find($id);
        if(empty($business)) {
            $success = 0;
            $msg = "Business not found";
        }else {
            $business = Business::whereId($id)->update($input);
            $success = 1;
            $msg = "Business has been updated successfully";
        }

        return response()->json(['success'=>$success, 'msg'=>$msg, 'business'=>$business]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);

        return view('pages.admin.users.show-user')->withUser($user);
    }

    //View logo page
    public function view_logo($bzname)
    {
        $user = Auth::guard('business')->user();
        $business = Business::where('business_name', $bzname)->first();
        $logo = BusinessLogo::where('business_id', $business->id)->orderBy('created_at', 'desc')->first();;
        $data = [
            'bzname' => $bzname,
            'user' => $user,
            'logo' => $logo
        ];

        return view('pages.business_admin.business.upload_logo', $data);
    }

    //Store Image to db and logos
    public function store_image($bzname, Request $request)
    {
        $user = Auth::guard('business')->user();
        $business = Business::where('business_name', $bzname)->first();
        $data = [
            'bzname' => $bzname,
            'user' => $user
        ];

        $businessLogo = BusinessLogo::where('business_id', $business->id)->first();

        if($request->logo_image) {
            $photoName = time().'.'.$request->logo_image->getClientOriginalExtension();
            $request->logo_image->move(public_path('images/logos'), $photoName);

            if(empty($businessLogo)) {
                $logo = BusinessLogo::create([
                    'business_id' => $business->id,
                    'path'        => '/images/logos/'.$photoName,
                ]);

                $logo->save();
            }else {
                BusinessLogo::whereId($businessLogo->id)->update(['path' => '/images/logos/'.$photoName,]);
            }

        }

        return redirect()->route('business.admin.business.logo', $data);
    }

    //View Login Setting
    public function view_login_setting($bzname)
    {
        $user = Auth::guard('business')->user();
        $business = Business::where('business_name', $bzname)->first();
        $setting = AdminSetting::where('business_id', $business->id)->first();

        $data = [
            'bzname' => $bzname,
            'user' => $user,
            'business' => $business,
            'setting' => $setting,
        ];

        return view('pages.business_admin.business.login_setting', $data);
    }

    //View logo page
    public function view_promotion($bzname)
    {
        $user = Auth::guard('business')->user();
        $business = Business::where('business_name', $bzname)->first();
        $promotions = BusinessPromotion::where('business_id', $business->id)->get();
        $count = BusinessPromotion::where('business_id', $business->id)->count();
        $status = AdminSetting::where('business_id', $business->id)->first()->upload_promotion;
        $data = [
            'bzname' => $bzname,
            'user' => $user,
            'promotions' => $promotions,
            'status' => $status,
            'count' => $count,
        ];

        return view('pages.business_admin.business.upload_promotion', $data);
    }

    //Store Image to db and logos
    public function store_promotion($bzname, Request $request)
    {
        $user = Auth::guard('business')->user();
        $business = Business::where('business_name', $bzname)->first();
        $data = [
            'bzname' => $bzname,
            'user' => $user
        ];

        if($request->promotion_image) {
            $photoName = time().'.'.$request->promotion_image->getClientOriginalExtension();
            $request->promotion_image->move(public_path('images/promotions'), $photoName);

            $id = $request->input('promotion_id');
            if($id) {
                BusinessPromotion::whereId($id)->update(['path' => '/images/promotions/'.$photoName]);
            }else {
                $promotion = BusinessPromotion::create([
                    'business_id' => $business->id,
                    'path'        => '/images/promotions/'.$photoName,
                ]);

                $promotion->save();
            }
        }

        return redirect()->route('business.admin.business.promotion', $data);
    }

    //Destroy Promotion Image
    public function destroy_promotion($bzname, $id) {
        $promotion = BusinessPromotion::findOrFail($id);
        $user = Auth::guard('business')->user();

        $data = [
            'bzname' => $bzname,
            'user' => $user
        ];

        if (empty($promotion)) {
            return back()->with('error', 'Promotion Image not exist');
        }else {
            $promotion->delete();

            return redirect()->route('business.admin.business.promotion', $data)->with('success', 'Promotion Image Deleted Successfully !');
        }
    }

    //View logo page
    public function preview($bzname)
    {
        $user = Auth::guard('business')->user();
        $data = [
            'bzname' => $bzname,
            'user' => $user,
        ];

        return view('pages.business_admin.business.home_preview', $data);
    }

    //Home pretend
    public function home($bzname)
    {
        $user = Auth::guard('business')->user();
        $business = Business::where('business_name', $bzname)->first();
        $logo = BusinessLogo::where('business_id', $business->id)->first();
        $promotion = BusinessPromotion::where('business_id', $business->id)->first();
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

    //Promotion Image Setting
    public function promotion_setting($bzname)
    {
        $user = Auth::guard('business')->user();
        $business = Business::where('business_name', $bzname)->first();
        $promotions = BusinessPromotion::where('business_id', $business->id)->get();
        $settings = PromotionSetting::join('business_promotions', 'promotion_id', '=', 'business_promotions.id')
            ->select('promotion_settings.*', 'business_promotions.path')
            ->where('promotion_settings.business_id', $business->id)->get();

        $data = [
            'bzname' => $bzname,
            'user' => $user,
            'promotions' => $promotions,
            'settings' => json_encode($settings),
        ];

        return view('pages.business_admin.business.promotion_setting', $data);
    }

    //Store Promotion Image Setting
    public function save_setting($bzname, Request $request)
    {
        $start_time = $request->start_time;
        $end_time = $request->end_time;

        $input = $request->except('_token', '_method', 'business_email', 'business_country', 'email', 'start_time', 'end_time');
        $business = Business::where('business_name', $bzname)->first();
        $input['business_id'] = $business->id;

        if($input['start_date']) {
            $input['start_date'] = Carbon::createFromFormat('Y-m-d H:i', $input['start_date'].' '. $start_time);
            $input['end_date'] = Carbon::createFromFormat('Y-m-d H:i', $input['end_date'].' '. $end_time);
        }

        $default = $request->input('default');

        if(empty($business)) {
            $success = 0;
            $msg = "Business not found";
        }else {
            $promotion_setting = PromotionSetting::where('business_id', $business->id)->where('default', '1');
            if($default && $promotion_setting->exists()) {
                $setting = $promotion_setting->update($input);
            }else {
                $setting = PromotionSetting::create($input);
                $setting->save();
            }

            $success = 1;
            $msg = "Promotion Setting created successfully";
        }

        return response()->json(['success'=>$success, 'msg'=>$msg, 'setting'=>$setting]);
    }

    //Save cBusiness Login Setting
    public function update_setting(Request $request)
    {
        $input = $request->except('_token');
        $business_id = $request->input('business_id');

        $setting = AdminSetting::where('business_id', $business_id)->first();
        if(empty($setting)) {
            $success = 0;
            $msg = "Setting not found";
        }else {
            $setting = AdminSetting::where('business_id', $business_id)->update($input);
            $success = 1;
            $msg = "Setting has been updated successfully";
        }

        return response()->json(['success'=>$success, 'msg'=>$msg, 'setting'=>$setting]);
    }
}
