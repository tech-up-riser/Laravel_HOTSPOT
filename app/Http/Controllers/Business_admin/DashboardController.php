<?php

namespace App\Http\Controllers\Business_admin;
use App\Http\Controllers\Controller;

use App\Models\BusinessUser;
use App\Models\Business;
use App\Models\User;
use App\Models\BusinessAdmin;
use App\Models\UserLoginTime;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use jeremykenedy\LaravelRoles\Models\Role;
use Auth;
use Symfony\Component\VarDumper\Caster\DateCaster;

class DashboardController extends Controller
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
        $business = Business::where('business_name', $bzname)->first();
        $business_admin= BusinessAdmin::where('user_id', $user->id)->first();
        $total_users = BusinessUser::where('business_id', $business->id)->count();

        $man_count = User::join('business_users', 'users.id', '=', 'business_users.user_id')
            ->where('business_users.business_id', $business->id)
            ->where('users.gender', 'male')->count();

        $users = User::join('business_users', 'users.id', '=', 'business_users.user_id')
            ->leftJoin('social_logins', 'users.id', '=', 'social_logins.user_id')
            ->where('business_users.business_id', $business_admin->business_id)
            ->select('users.*', 'social_logins.provider', 'social_logins.social_id')->orderBy('id', 'desc')->take(10)->get();
        $roles = Role::all();

        //Get Regional data by country
        $sqlQuery = "SELECT country,COUNT(*) as count FROM users INNER JOIN business_users ON users.id = business_users.user_id AND business_users.business_id = ".$business->id." GROUP BY country";
        $region = DB::select(DB::raw($sqlQuery));
        $region_data = [['Country', 'Popularity']];
        foreach ($region as $obj) {
            array_push($region_data, [$obj->country, $obj->count]);
        }
        $region_data = json_encode($region_data);

        //Get Age Data
        $now = date('Y');
        $ageData = User::join('business_users', 'users.id', '=', 'business_users.user_id')
            ->where('business_users.business_id', $business->id)
            ->select('users.year');
        $query1 = clone $ageData;
        $query2 = clone $ageData;
        $query3 = clone $ageData;
        $query4 = clone $ageData;
        $query5 = clone $ageData;

        $age_data = [$ageData->where('users.year', '>', $now - 18)->count(),
            $query1->where('users.year', '>', $now - 25)->where('users.year', '<=', $now - 18)->count(),
            $query2->where('users.year', '>', $now - 35)->where('users.year', '<=', $now - 25)->count(),
            $query3->where('users.year', '>', $now - 45)->where('users.year', '<=', $now - 35)->count(),
            $query4->where('users.year', '>', $now - 55)->where('users.year', '<=', $now - 45)->count(),
            $query5->where('users.year', '<=', $now - 55)->count(),
            ];
        $age_data = json_encode($age_data);

        //Get User List Data
        $sqlQuery = "SELECT provider,COUNT(*) as count FROM social_logins INNER JOIN users ON users.id = social_logins.user_id INNER JOIN business_users ON users.id = business_users.user_id AND business_users.business_id = ".$business->id." GROUP BY provider";
        $userlist = DB::select(DB::raw($sqlQuery));
        $user_data = [0, 0, 0, 0, 0];

        $facebook_user_count = 0;
        $twitter_user_count = 0;
        $instagram_user_count = 0;
        $linkedin_user_count = 0;

        foreach ($userlist as $obj) {
            if($obj->provider == 'facebook') {
                $user_data[0] = $obj->count;
                $facebook_user_count = $obj->count;
            }else if($obj->provider == 'twitter') {
                $user_data[1] = $obj->count;
                $twitter_user_count = $obj->count;
            }
            else if($obj->provider == 'instagram') {
                $user_data[2] = $obj->count;
                $instagram_user_count = $obj->count;
            }
            else if($obj->provider == 'linkedin') {
                $user_data[3] = $obj->count;
                $linkedin_user_count = $obj->count;
            }
        }

        $user_data[4] = User::join('business_users', 'users.id', '=', 'business_users.user_id')->where('business_users.business_id', $business->id)->count() - count($userlist);
        $user_data = json_encode($user_data);

        //New vs Returning User Chart Data
        $start_date = Carbon::create('2018', '1', '1', '0', '0', '1');
        $end_date = Carbon::create('2018', '12', '31', '23', '59', '59');
        $oldQuery = "SELECT COUNT(DISTINCT users.id) AS login_num, DATE_FORMAT(user_login_times.created_at, '%m') AS login_month FROM users INNER JOIN business_users ON users.id = business_users.user_id AND business_users.business_id = ".$business->id." LEFT JOIN user_login_times ON users.id = user_login_times.user_id WHERE user_login_times.created_at >= '$start_date' AND user_login_times.created_at <= '$end_date' GROUP BY login_month";
        $newQuery = "SELECT COUNT(*) AS login_num, DATE_FORMAT(users.created_at, '%m') AS login_month FROM users INNER JOIN business_users ON users.id = business_users.user_id AND business_users.business_id = ".$business->id." WHERE users.created_at >= '$start_date' AND users.created_at <= '$end_date' GROUP BY login_month";
        $newActivity = DB::select(DB::raw($newQuery));
        $oldActivity = DB::select(DB::raw($oldQuery));
        $current_mon = $now = date('m');
        $new_user_data = [];
        $old_user_data = [];

        $month_data = [];
        for($i = 1; $i<= (int)$current_mon; $i++) {
            array_push($month_data, date('M', mktime(0, 0, 0, $i, 10)));
            array_push($new_user_data, 0);
            array_push($old_user_data, 0);
        }

        foreach($oldActivity as $obj) {
            $old_user_data[(int)$obj->login_month -1] = $obj->login_num;
        }
        foreach($newActivity as $obj) {
            $new_user_data[(int)$obj->login_month -1] = $obj->login_num;
        }

        for($i = 0; $i< (int)$current_mon; $i++) {
            $old_user_data[$i] -= $new_user_data[$i];
        }

        $month_data = json_encode($month_data);
        $new_user_data = json_encode($new_user_data);
        $old_user_data = json_encode($old_user_data);

        //find users by login time
        $login_query = "SELECT COUNT(*) AS login_num, DATE_FORMAT(user_login_times.login_time, '%M %D %H') AS login_hour FROM user_login_times INNER JOIN business_users ON user_login_times.user_id = business_users.user_id AND business_users.business_id = ".$business->id." WHERE user_login_times.login_time >= '$start_date' AND user_login_times.login_time <= '$end_date' GROUP BY login_hour";
        $results = DB::select(DB::raw($login_query));

        $login_title = [];
        $login_value = [];
        foreach($results as $obj) {
            array_push($login_title, $obj->login_hour);
            array_push($login_value, $obj->login_num);
        }
        $login_title = json_encode($login_title);
        $login_value = json_encode($login_value);

        $data = [
            'user' => $user,
            'users' => $users,
            'roles' => $roles,
            'bzname' => $bzname,
            'total_users' => $total_users,
            'man' => $man_count,
            'women' => $total_users - $man_count,
            'region_data' =>$region_data,
            'age_data' =>$age_data,
            'user_data' =>$user_data,
            'month_data' =>$month_data,
            'new_user_data' =>$new_user_data,
            'old_user_data' =>$old_user_data,
            'login_title' =>$login_title,
            'login_value' =>$login_value,
            'facebook_user_count' => $facebook_user_count,
            'twitter_user_count' => $twitter_user_count,
            'instagram_user_count' => $instagram_user_count,
            'linkedin_user_count' => $linkedin_user_count,
        ];

        return view('pages.business_admin.dashboard.dashboard', $data);
    }
}
