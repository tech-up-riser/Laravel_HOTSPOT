<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\BusinessUser;
use App\Models\Business;
use App\Models\User;
use App\Models\BusinessAdmin;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use jeremykenedy\LaravelRoles\Models\Role;
use Auth;

class DashboardController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($bzname = 'coava_coffee_shp')
    {
        $user = Auth::guard('admin')->user();
        $total_users = User::count();

        $man_count = User::where('gender', '=', 'male')->count();

        $users = User::leftJoin('social_logins', 'users.id', '=', 'social_logins.user_id')
            ->select('users.*', 'social_logins.provider', 'social_logins.social_id')
            ->orderBy('id', 'desc')->take(10)->get();
        $roles = Role::all();

        //Get Regional data by country
        $sqlQuery = "SELECT country,COUNT(*) as count FROM users  GROUP BY country";
        $region = DB::select(DB::raw($sqlQuery));
        $region_data = [['Country', 'Popularity']];
        foreach ($region as $obj) {
            array_push($region_data, [$obj->country, $obj->count]);
        }
        $region_data = json_encode($region_data);

        //Get Age Data
        $now = date('Y');
        $ageData = User::join('business_users', 'users.id', '=', 'business_users.user_id')
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
        $sqlQuery = "SELECT provider,COUNT(*) as count FROM social_logins INNER JOIN users ON users.id = social_logins.user_id INNER JOIN business_users ON users.id = business_users.user_id  GROUP BY provider";
        $userlist = DB::select(DB::raw($sqlQuery));
        $user_data = [0, 0, 0, 0, 0];

        foreach ($userlist as $obj) {
            if($obj->provider == 'facebook') {
                $user_data[0] = $obj->count;
            }else if($obj->provider == 'twitter') {
                $user_data[1] = $obj->count;
            }
            else if($obj->provider == 'instagram') {
                $user_data[2] = $obj->count;
            }
            else if($obj->provider == 'linkedin') {
                $user_data[3] = $obj->count;
            }
        }

        $user_data[4] = User::join('business_users', 'users.id', '=', 'business_users.user_id')->count() - count($userlist);
        $user_data = json_encode($user_data);

        //New vs Returning User Chart Data
        $start_date = Carbon::create('2018', '1', '1', '0', '0', '1');
        $end_date = Carbon::create('2018', '12', '31', '23', '59', '59');
        $oldQuery = "SELECT COUNT(*) AS login_num, DATE_FORMAT(users.created_at, '%m') AS login_month FROM users INNER JOIN business_users ON users.id = business_users.user_id WHERE users.created_at >= '$start_date' AND users.created_at <= '$end_date' AND users.is_new = 'no' GROUP BY login_month";
        $newQuery = "SELECT COUNT(*) AS login_num, DATE_FORMAT(users.created_at, '%m') AS login_month FROM users INNER JOIN business_users ON users.id = business_users.user_id WHERE users.created_at >= '$start_date' AND users.created_at <= '$end_date' AND users.is_new = 'yes' GROUP BY login_month";
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
        $month_data = json_encode($month_data);
        $new_user_data = json_encode($new_user_data);
        $old_user_data = json_encode($old_user_data);

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
        ];

        return view('pages.admin.dashboard.dashboard', $data);
    }

}
