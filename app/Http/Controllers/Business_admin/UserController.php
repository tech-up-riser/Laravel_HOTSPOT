<?php

namespace App\Http\Controllers\Business_admin;
use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\BusinessAdmin;
use App\Models\BusinessUser;
use Illuminate\Http\Request;

use App\Models\Profile;
use App\Models\User;
use jeremykenedy\LaravelRoles\Models\Role;
use Auth;
use Response;
use Validator;
class UserController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($bzname)
    {
        $user = Auth::guard('business')->user();
        $business_admin= BusinessAdmin::where('user_id', $user->id)->first();

        $users = User::join('business_users', 'users.id', '=', 'business_users.user_id')
            ->leftJoin('user_login_times', 'users.id', '=', 'user_login_times.user_id')
            ->leftJoin('social_logins', 'users.id', '=', 'social_logins.user_id')
            ->where('business_users.business_id', $business_admin->business_id)
            ->select('users.*', 'social_logins.provider', 'social_logins.social_id', 'user_login_times.login_time')
            ->orderBy('id', 'desc')->get();

        $users = $users->unique('id');

        // Get User Roles
        $roles = Role::all();

        $current_year = date('Y');

        $data = [
            'user' => $user,
            'users' => $users,
            'roles' => $roles,
            'bzname' => $bzname,
            'current_year' => $current_year,
        ];

        return View('pages.business_admin.users.show-users', $data);
    }

    /**
     * Edit a existing User
     */
    public function edit($bzname, $id)
    {
        $roles = Role::all();
        $user = User::findOrFail($id);

        $data = [
            'roles' => $roles,
            'user' => $user,
            'bzname' => $bzname
        ];

        return view('pages.business_admin.users.edit-user', $data);
    }

    /**
     * Update a existing user resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function update($bzname, $id, Request $request)
    {
        $user = User::find($id);
        $emailCheck = ($request->input('email') != '') && ($request->input('email') != $user->email) && ($request->input('name') != $user->name);

        if ($emailCheck) {
            $validator = Validator::make($request->all(), [
                'name'     => 'required|max:255|unique:users',
                'email'    => 'email|max:255|unique:users',
                'password' => 'present|confirmed|min:6',
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'password' => 'nullable|confirmed|min:6',
            ]);
        }

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user->name = $request->input('name');
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->gender = $request->input('gender');
        $user->year = $request->input('year');
        $user->country = $request->input('country');

        if ($emailCheck) {
            $user->email = $request->input('email');
        }

        if ($request->input('password') != null) {
            $user->password = bcrypt($request->input('password'));
        }

        $userRole = $request->input('role');
        if ($userRole != null) {
            $user->detachAllRoles();
            $user->attachRole($userRole);
        }

        $user->save();

        return redirect()->route('business.admin.users', ['bzname' => $bzname])->with('success', 'User updated successfully !');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($bzname, $id)
    {
        $user = User::find($id);

        $data = [
            'user' => $user,
            'bzname' => $bzname
        ];

        return view('pages.business_admin.users.show-user', $data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($bzname, $id)
    {
        $currentUser = Auth::guard('business')->user();
        $user = User::findOrFail($id);

        if ($user->id != $currentUser->id) {
            $user->save();
            $user->delete();

            return redirect()->route('business.admin.users', ['bzname' => $bzname])->with('success', trans('usersmanagement.deleteSuccess'));
        }

        return back()->with('error', trans('usersmanagement.deleteSelfError'));
    }

    // Users Search
    public function search($bzname, Request $request)
    {
        $gender = $request->gender;
        $min_age = $request->min_age;
        $max_age = $request->max_age;
        $login_type = $request->login_type;
        $country = $request->country;

        if($gender == null) {
            $gender_search = ['male', 'female'];
        }else {
            $gender_search = [$gender];
        }

        $user = Auth::guard('business')->user();
        $business_admin= BusinessAdmin::where('user_id', $user->id)->first();

        $current_year = date('Y');
        $users = User::join('business_users', 'users.id', '=', 'business_users.user_id')
            ->leftJoin('user_login_times', 'users.id', '=', 'user_login_times.user_id')
            ->leftJoin('social_logins', 'users.id', '=', 'social_logins.user_id')
            ->where('business_users.business_id', $business_admin->business_id)
            ->whereIn('users.gender', $gender_search)
            ->where('users.year', '<=', $current_year - $min_age)
            ->where('users.year', '>=', $current_year - $max_age)
            ->select('users.*', 'social_logins.provider', 'social_logins.social_id', 'user_login_times.login_time')
            ->orderBy('id', 'desc');

        if($country != null) {
            $users = $users->where('country', $country);
        }

        if($login_type != null) {
            $users = $users->where('provider', $login_type);
        }

        $users = $users->get()->unique();

        // Get User Roles
        $roles = Role::all();

        $data = [
            'user' => $user,
            'users' => $users,
            'roles' => $roles,
            'bzname' => $bzname,
            'current_year' => $current_year,
        ];

        return View('pages.business_admin.users.show-users', $data);
    }

    public function viewLogin($bzname) {
        return view('pages.business_admin.login', ['bzname' => $bzname]);
    }

    // authenticate user
    public function authenticate(Request $request, $bzname)
    {
        $business = Business::where('business_name', $bzname)->first();
        $business_admin = BusinessAdmin::where('business_id', $business->id)->first();
        if(isset($business_admin))
        {
            $user = User::findOrFail($business_admin->user_id);

            if($user->email === $request->input('email'))
            {
                if (Auth::guard('business')->attempt(['email'=>$request->input('email'), 'password'=>$request->input('password')]))
                {
                    $permissions = [];
                    session(['permissions' => $permissions]);
                    return redirect()->route('business.admin.dashboard', ['bzname' => $bzname]);

                }
                else
                {
                    return redirect()->route('business.admin.login', ['bzname' => $bzname])->with('errorLogin', 'Ooops! Invalid Email or Password')->withInput();
                }
            }
            else
            {
                return redirect()->route('business.admin.login', ['bzname' => $bzname])->with('errorLogin', 'Ooops! Pls Enter Correct Business')->withInput();
            }
        }
    }

    // logging out user from admin panel
    public function logout(Request $request, $bzname)
    {
        if (Auth::guard('business')->check()) {

            Auth::guard('business')->logout();
            $request->session()->flush();
            return redirect()->route('business.admin.login', ['bzname' => $bzname]);
        }
    }
}
