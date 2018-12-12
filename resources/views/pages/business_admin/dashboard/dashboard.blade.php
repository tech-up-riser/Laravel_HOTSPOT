@extends('layouts.business')

@section('template_title')
    Welcome {{ Auth::guard('business')->user()->name }}
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 grid-margin stretch-card">
                <div class="card card-statistics">
                    <div class="card-body">
                        <div class="clearfix">
                            <div class="float-left">
                                <i class="mdi mdi-facebook text-danger icon-lg"></i>
                            </div>
                            <div class="float-right">
                                <p class="mb-0 text-right">Facebook Users</p>
                                <div class="fluid-container">
                                    <h3 class="font-weight-medium text-right mb-0">{{ $facebook_user_count }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 grid-margin stretch-card">
                <div class="card card-statistics">
                    <div class="card-body">
                        <div class="clearfix">
                            <div class="float-left">
                                <i class="mdi mdi-twitter text-warning icon-lg"></i>
                            </div>
                            <div class="float-right">
                                <p class="mb-0 text-right">Twitter Users</p>
                                <div class="fluid-container">
                                    <h3 class="font-weight-medium text-right mb-0">{{ $twitter_user_count }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 grid-margin stretch-card">
                <div class="card card-statistics">
                    <div class="card-body">
                        <div class="clearfix">
                            <div class="float-left">
                                <i class="mdi mdi-instagram text-success icon-lg"></i>
                            </div>
                            <div class="float-right">
                                <p class="mb-0 text-right">Instagram Users</p>
                                <div class="fluid-container">
                                    <h3 class="font-weight-medium text-right mb-0">{{ $instagram_user_count }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 grid-margin stretch-card">
                <div class="card card-statistics">
                    <div class="card-body">
                        <div class="clearfix">
                            <div class="float-left">
                                <i class="mdi mdi-linkedin text-success icon-lg"></i>
                            </div>
                            <div class="float-right">
                                <p class="mb-0 text-right">Linkedin Users</p>
                                <div class="fluid-container">
                                    <h3 class="font-weight-medium text-right mb-0">{{ $linkedin_user_count }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 grid-margin stretch-card">
                <div class="card card-statistics">
                    <div class="card-body">
                        <div class="clearfix">
                            <div class="float-left">
                                <i class="mdi mdi-account-location text-info icon-lg"></i>
                            </div>
                            <div class="float-right">
                                <p class="mb-0 text-right">Total Users</p>
                                <div class="fluid-container">
                                    <h3 class="font-weight-medium text-right mb-0">{{ $total_users }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Gender chart</h4>
                        <canvas id="pieChart" style="height:250px"></canvas>
                        <div id="gender-chart-legend" class="rounded-legend legend-vertical legend-bottom-left pt-4"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Country Regional Chart</h4>
                        <input type="hidden" id="region_chart_id" value="{{ isset($region_data) ? $region_data : [] }}">
                        <div class="google-chart-container">
                            <div id="regions-chart" class="google-charts"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Time of Login Chart</h4>
                        <canvas id="loginChart" style="height:250px"></canvas>
                        <input type="hidden" id="login_title" value="{{ isset($login_title) ? $login_title : [0] }}">
                        <input type="hidden" id="login_value" value="{{ isset($login_value) ? $login_value : [0] }}">
                    </div>
                </div>
            </div>
            <div class="col-lg-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Age chart</h4>
                        <input type="hidden" id="age_chart_id" value="{{ isset($age_data) ? $age_data : [] }}">
                        <canvas id="barChart" style="height:250px"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="clearfix">
                            <h4 class="card-title float-left">New vs Returning Users Chart</h4>
                            <input type="hidden" id="vs_month_data" value="{{ isset($month_data) ? $month_data : ['Jan'] }}">
                            <input type="hidden" id="vs_new_user_data" value="{{ isset($new_user_data) ? $new_user_data : [0] }}">
                            <input type="hidden" id="vs_old_user_data" value="{{ isset($old_user_data) ? $old_user_data : [0] }}">
                            <div id="new-returning-chart-legend" class="rounded-legend legend-horizontal legend-top-right float-right"></div>
                        </div>
                        <canvas id="new-returning-chart" class="mt-4"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">List of Users chart</h4>
                        <input type="hidden" id="userlist_chart_id" value="{{ isset($user_data) ? $user_data : [] }}">
                        <canvas id="list-users-chart"></canvas>
                        <div id="list-users-chart-legend" class="rounded-legend legend-vertical legend-bottom-left pt-4"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4>Recent Users</h4>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>@lang('usersmanagement.users-table.name')</th>
                                    <th class="hidden-xs">@lang('usersmanagement.users-table.email')</th>
                                    <th class="hidden-xs">@lang('usersmanagement.users-table.fname')</th>
                                    <th class="hidden-xs">@lang('usersmanagement.users-table.lname')</th>
                                    <th>What Platform User LoggedIn</th>
                                    <th>Social Link</th>
                                    <th>Created At</th>
                                </tr>
                                </thead>
                                <tbody id="users_table">
                                @foreach($users as $oneUser)
                                    <tr>
                                        <td>{{$loop->index + 1}}</td>
                                        <td><img src="@if($oneUser->image_url) {{ $oneUser->image_url }} @else /images/faces/empty.png @endif" class="mr-2" alt="image">{{$user->name}}</td>
                                        <td class="hidden-xs" width="100px"><a href="mailto:{{ $oneUser->email }}"
                                                                               title="email {{ $oneUser->email }}">{{ $oneUser->email }}</a>
                                        </td>
                                        <td class="hidden-xs">{{$oneUser->first_name}}</td>
                                        <td class="hidden-xs">{{$oneUser->last_name}}</td>
                                        <td>
                                            @if($oneUser->provider == null)
                                                Email
                                            @else
                                                {{ $oneUser->provider }}
                                            @endif
                                        </td>
                                        <td>
                                            @if($oneUser->provider == 'facebook')
                                                https://www.facebook.com/profile.php?id={{ $oneUser->social_id }}
                                            @elseif($oneUser->provider == 'twitter')
                                                https://twitter.com/{{ $oneUser->first_name }}
                                            @elseif($oneUser->provider == 'instagram')
                                                https://twitter.com/{{ $oneUser->social_id }}
                                            @elseif($oneUser->provider == 'linkedin')
                                                https://twitter.com/{{ $oneUser->social_id }}
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td>{{ $oneUser->created_at }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer_scripts')
    @include('pages.business_admin.dashboard.js')
@endsection