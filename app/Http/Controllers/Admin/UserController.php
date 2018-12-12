<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
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
    public function index()
    {
        $pagintaionEnabled = true;
        if ($pagintaionEnabled) {
            $users = User::paginate(config('usersmanagement.paginateListSize'));
        } else {
            $users = User::all();
        }
        $roles = Role::all();

        return View('pages.admin.users.show-users', compact('users', 'roles'));
    }
    /**
     * Create a new User
     */
    public function create()
    {
        $roles = Role::all();

        $data = [
            'roles' => $roles,
        ];

        return view('pages.admin.users.create-user')->with($data);
    }


    /**
     * Edit a existing User
     */
    public function edit($id)
    {
        $roles = Role::all();
        $user = User::findOrFail($id);

        $data = [
            'roles' => $roles,
            'user' => $user,
        ];

        return view('pages.admin.users.edit-user', $data);
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
                'name'                  => 'required|max:255|unique:users',
                'first_name'            => '',
                'last_name'             => '',
                'email'                 => 'required|email|max:255|unique:users',
                'password'              => 'required|min:6|max:20|confirmed',
                'password_confirmation' => 'required|same:password',
                'role'                  => 'required',
            ],
            [
                'name.unique'         => trans('auth.userNameTaken'),
                'name.required'       => trans('auth.userNameRequired'),
                'first_name.required' => trans('auth.fNameRequired'),
                'last_name.required'  => trans('auth.lNameRequired'),
                'email.required'      => trans('auth.emailRequired'),
                'email.email'         => trans('auth.emailInvalid'),
                'password.required'   => trans('auth.passwordRequired'),
                'password.min'        => trans('auth.PasswordMin'),
                'password.max'        => trans('auth.PasswordMax'),
                'role.required'       => trans('auth.roleRequired'),
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
            'gender'           => $request->input('gender'),
            'year'             => $request->input('year'),
            'country'          => $request->input('country'),
            'email'            => $request->input('email'),
            'password'         => bcrypt($request->input('password')),
            'token'            => str_random(64),
            'activated'        => 1,
        ]);

        $user->profile()->save($profile);
        $user->attachRole($request->input('role'));
        $user->save();

        return redirect()->route('admin.users.index')->with('success', trans('usersmanagement.createSuccess'));
    }


    /**
     * Update a existing user resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
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

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully !');
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
        $user = User::findOrFail($id);

        if ($user->id != $currentUser->id) {
            $user->save();
            $user->delete();

            return redirect()->route('admin.users.index')->with('success', trans('usersmanagement.deleteSuccess'));
        }

        return back()->with('error', trans('usersmanagement.deleteSelfError'));
    }

    public function viewLogin() {
        return view('pages.admin.login');
    }

    // authenticate user
    public function authenticate(Request $request)
    {
        // authenticate admin user
        if (Auth::guard('admin')->attempt(['email'=>$request->input('email'), 'password'=>$request->input('password')]))
        {
            $permissions = [];
            session(['permissions' => $permissions]);
            return redirect()->route('admin.dashboard');

        }
        else
        {
            return redirect()->route('admin.login')->with('errorLogin', 'Ooops! Invalid Email or Password')->withInput();
        }
    }

    // logging out user from admin panel
    public function logout(Request $request) {

        if (Auth::guard('admin')->check()) {

            Auth::guard('admin')->logout();
            $request->session()->flush();
            return redirect()->route('admin.login');
        }
    }
}
