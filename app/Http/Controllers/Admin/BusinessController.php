<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\AdminSetting;
use App\Models\BusinessAdmin;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Business;
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
        $this->middleware('admin.auth');
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pagintaionEnabled = true;
        if ($pagintaionEnabled) {
            $businesses = Business::paginate(config('usersmanagement.paginateListSize'));
        } else {
            $businesses = Business::all();
        }


        return View('pages.admin.business.show-businesses', ['businesses' => $businesses]);
    }
    /**
     * Create a new User
     */
    public function create()
    {
        return view('pages.admin.business.create-business');
    }

    /**
     * Create a new User
     */
    public function edit($id)
    {
        $business = Business::findOrFail($id);
        $business_admin = BusinessAdmin::where('business_id', $id)->first();
        $user = User::find($business_admin->user_id);
        $setting = AdminSetting::where('business_id', $business->id)->first();

        $data = [
            'business' => $business,
            'user' => $user,
            'setting' => $setting,
        ];
        return view('pages.admin.business.edit-business', $data);
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
        $validator = Validator::make($request->all(),
            [
                'business_name'         => 'required|max:255|unique:businesses',
                'email'                 => 'required|email|max:255|unique:users',
            ],
            [
                'business_name.unique'         => 'Please enter unique name for your company link.',
                'email.email'                  => 'Pls enter valid email',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['success'=> 0, 'msg'=>'Business Unique Name or Email is already Taken']);
        }

        $input = $request->except('_token');

        $business = Business::create($input);
        $business->save();

        $business_setting = AdminSetting::create([
            'business_id' => $business->id,
            'upload_promotion' => 'on',
            'redirect_url' => "http://www.chimplinks.com/business"
        ]);

        $business_setting->save();

        return response()->json(['success'=> 1, 'msg'=>'Business has been created successfully', 'business'=>$business]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $currentUser = Auth::guard('admin')->user();
        $business = Business::findOrFail($id);

        if (isset($business)) {
            $business->save();
            $business->delete();

            return redirect()->route('admin.business.index')->with('success', 'Business deleted successfully !');
        }

        return back()->with('error', trans('usersmanagement.deleteSelfError'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function storeUser(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'name'         => 'required|max:255|unique:users',
                'email'         => 'required|email|max:255|unique:users',
            ],
            [
                'name.unique'         => 'Please enter unique Username',
                'email.email'         => 'Pls enter valid email',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['success'=> 0, 'msg'=>'Username or Email is already Taken']);
        }
        $input = $request->all();
        $business_id = $input['business_id'];
        $input['password'] = bcrypt($input['password']);
        $input['token'] = str_random(64);
        $input['activated'] = 1;

        $business_admin = User::create($input);
        $business_admin->save();

        $role = Role::where('name', 'Business_Admin')->first()->id;
        $business_admin->attachRole($role);
        $business_admin->save();


        //Create and Save Business User
        $businessUser = BusinessAdmin::create([
            'business_id' => $business_id,
            'user_id' => $business_admin->id
        ]);
        $businessUser->save();

        return response()->json(['success'=> 1, 'msg'=>'Business has been created successfully', 'business_admin'=>$business_admin]);
    }

    /**
     * Update the specified Room in storage.
     * @param  int              $id
     * @param UpdateRoomRequest $request
     * @return Response
     */
    public function update($id, Request $request)
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
     * Update the specified Room in storage.
     * @param  int              $id
     * @param UpdateRoomRequest $request
     * @return Response
     */
    public function updateUser($id, Request $request)
    {
        $input = $request->except('_token', '_method', 'password_confirmation', 'business_id');
        $user = User::find($id);

        if(empty($user)) {
            $success = 0;
            $msg = "User not found";
        }else {
            $input['password'] = bcrypt($input['password']);
            $user = User::whereId($user->id)->update($input);
            $success = 1;
            $msg = "User has been updated successfully";
        }

        return response()->json(['success'=>$success, 'msg'=>$msg, 'user'=>$user]);
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

    //Setting Update
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
