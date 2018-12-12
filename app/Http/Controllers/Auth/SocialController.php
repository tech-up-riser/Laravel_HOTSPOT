<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\Profile;
use App\Models\Social;
use App\Models\User;
use App\Models\UserLoginTime;
use App\Models\BusinessUser;
use App\Models\UserMacaddress;
use App\Traits\ActivationTrait;
use App\Traits\CaptureIpTrait;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Input;
use jeremykenedy\LaravelRoles\Models\Role;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Http\File;
use Session;

class SocialController extends Controller
{
    use ActivationTrait;

    /**
     * Gets the social redirect.
     *
     * @param string $provider The provider
     *
     * @return Redirect
     */
    public function getSocialRedirect($bzname, $provider, Request $request)
    {
        $providerKey = Config::get('services.'.$provider);

        if (empty($providerKey)) {
            return view('pages.status')
                ->with('error', trans('socials.noProvider'));
        }

        config([
            "services.$provider.redirect" => config("services.$provider.redirect")
        ]);

        Session::put('bzname', $bzname);
        Session::put('mac', $request->input('mac'));

        return Socialite::driver($provider)->redirect();
    }

    /**
     * Gets the social handle.
     *
     * @param string $provider The provider
     *
     * @return Redirect
     */
    public function getSocialHandle($provider, Request $request)
    {
        $bzname = Session::get('bzname');
        $mac_address = Session::get('mac');

        if (Input::get('denied') != '') {
            return redirect()->to('login')
                ->with('status', 'danger')
                ->with('message', trans('socials.denied'));
        }

        $socialUserObject = Socialite::driver($provider)->user();

        $user_image = $socialUserObject->getAvatar();

        $socialUser = null;

        // Check if email is already registered
        $userCheck = User::where('email', '=', $socialUserObject->email)->first();

        //Check if business exist
        $bzCheck = Business::where('business_name', $bzname)->first();

        $email = $socialUserObject->email;

        if (!$socialUserObject->email) {
            $email = 'missing'.str_random(10).'@'.str_random(10).'.example.org';
        }

        if (empty($userCheck) && isset($bzCheck)) {
            $sameSocialId = Social::where('social_id', '=', $socialUserObject->id)
                ->where('provider', '=', $provider)
                ->first();

            if (empty($sameSocialId)) {
                $ipAddress = new CaptureIpTrait();
                $socialData = new Social();
                $profile = new Profile();
                $role = Role::where('slug', '=', 'user')->first();
                $fullname = explode(' ', $socialUserObject->name);
                if (count($fullname) == 1) {
                    $fullname[1] = '';
                }
                $username = $socialUserObject->nickname;

                if ($username == null) {
                    foreach ($fullname as $name) {
                        $username .= $name;
                    }
                }

                // Check to make sure username does not already exist in DB before recording
                $username = $this->checkUserName($username, $email);

                $user = User::create([
                    'name'                 => $username,
                    'first_name'           => $fullname[0],
                    'last_name'            => $fullname[1],
                    'email'                => $email,
                    'password'             => bcrypt(str_random(40)),
                    'token'                => str_random(64),
                    'activated'            => true,
                    'signup_sm_ip_address' => $ipAddress->getClientIp(),
                    'mac_address' => $mac_address,
                    'image_url' => $user_image,
                    'profile_url' => 'https://twitter.com/'.$username

                ]);

                $socialData->social_id = $socialUserObject->id;
                $socialData->provider = $provider;
                $user->social()->save($socialData);
                $user->attachRole($role);
                $user->activated = true;

                $user->profile()->save($profile);
                $user->save();

                //Save Mac address
                $user_mac = UserMacaddress::create([
                    'user_id' => $user->id,
                    'mac_address' => $mac_address
                ]);
                $user_mac->save();

                if ($socialData->provider == 'github') {
                    $user->profile->github_username = $socialUserObject->nickname;
                }

                // Twitter User Object details: https://developer.twitter.com/en/docs/tweets/data-dictionary/overview/user-object
                if ($socialData->provider == 'twitter') {
                    $user->profile()->twitter_username = $socialUserObject->id;
                }
                $user->profile->save();

                //Create and Save Business User
                $businessUser = BusinessUser::create([
                    'business_id' => $bzCheck->id,
                    'user_id' => $user->id
                ]);
                $businessUser->save();

                $socialUser = $user;
            } else {
                $bzUser = BusinessUser::where('user_id', $sameSocialId->user_id)->where('business_id', $bzCheck->id)->first();

                if(empty($bzUser)) {
                    $businessUser = BusinessUser::create([
                        'business_id' => $bzCheck->id,
                        'user_id' => $sameSocialId->user_id
                    ]);
                    $businessUser->save();
                }

                $user_mac = UserMacaddress::where('user_id', $sameSocialId->user_id)->where('mac_address', $mac_address)->first();
                if(empty($user_mac)) {
                    $user_mac = UserMacaddress::create([
                        'user_id' => $sameSocialId->user_id,
                        'mac_address' => $mac_address
                    ]);
                    $user_mac->save();
                }

                $socialUser = $sameSocialId->user;
            }

            //Save login time
            $login_time = UserLoginTime::create([
                'user_id' => $socialUser->id,
                'login_time' => Carbon::now('GMT')
            ]);
            $login_time->save();

            Auth::guard('user')->login($socialUser, true);

            return redirect()->route('bzuser.home', ['bzname' => $bzname]);
        }

        // Check Mac Address
        $user_mac = UserMacaddress::where('user_id', $userCheck->id)->where('mac_address', $mac_address)->first();
        if(empty($user_mac)) {
            $user_mac = UserMacaddress::create([
                'user_id' => $userCheck->id,
                'mac_address' => $mac_address
            ]);
            $user_mac->save();
        }

        $socialUser = $userCheck;

        //Save login time
        $login_time = UserLoginTime::create([
            'user_id' => $socialUser->id,
            'login_time' => Carbon::now('GMT')
        ]);
        $login_time->save();

        Auth::guard('user')->login($socialUser, true);

        return redirect()->route('bzuser.home', ['bzname' => $bzname]);
    }

    /**
     * Check if username against database and return valid username.
     * If username is not in the DB return the username
     * else generate, check, and return the username.
     *
     * @param string $username
     * @param string $email
     *
     * @return string
     */
    public function checkUserName($username, $email)
    {
        $userNameCheck = User::where('name', '=', $username)->first();

        if ($userNameCheck) {
            $i = 1;
            do {
                $username = $this->generateUserName($username);
                $newCheck = User::where('name', '=', $username)->first();

                if ($newCheck == null) {
                    $newCheck = 0;
                } else {
                    $newCheck = count($newCheck);
                }
            } while ($newCheck != 0);
        }

        return $username;
    }

    /**
     * Generate Username.
     *
     * @param string $username
     *
     * @return string
     */
    public function generateUserName($username)
    {
        return $username.'_'.str_random(10);
    }
}
