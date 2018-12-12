@extends('layouts.admin')

@section('template_title')
    Welcome {{ Auth::guard('admin')->user()->name }}
@endsection

@section('template_linked_css')
    <style type="text/css" media="screen">
        #redirect_url {
            font-size: 12.5px;
            font-weight: 300;
        }
    </style>
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
                <div class="card card-statistics">
                    <div class="card-body">
                        <div class="clearfix">
                            <div class="float-left">
                                <i class="mdi mdi-cube text-danger icon-lg"></i>
                            </div>
                            <div class="float-right">
                                <p class="mb-0 text-right">Total Revenue</p>
                                <div class="fluid-container">
                                    <h3 class="font-weight-medium text-right mb-0">$65,650</h3>
                                </div>
                            </div>
                        </div>
                        <p class="text-muted mt-3 mb-0">
                            <i class="mdi mdi-alert-octagon mr-1" aria-hidden="true"></i> 65% lower growth
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
                <div class="card card-statistics">
                    <div class="card-body">
                        <div class="clearfix">
                            <div class="float-left">
                                <i class="mdi mdi-receipt text-warning icon-lg"></i>
                            </div>
                            <div class="float-right">
                                <p class="mb-0 text-right">Orders</p>
                                <div class="fluid-container">
                                    <h3 class="font-weight-medium text-right mb-0">3455</h3>
                                </div>
                            </div>
                        </div>
                        <p class="text-muted mt-3 mb-0">
                            <i class="mdi mdi-bookmark-outline mr-1" aria-hidden="true"></i> Product-wise sales
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
                <div class="card card-statistics">
                    <div class="card-body">
                        <div class="clearfix">
                            <div class="float-left">
                                <i class="mdi mdi-poll-box text-success icon-lg"></i>
                            </div>
                            <div class="float-right">
                                <p class="mb-0 text-right">Sales</p>
                                <div class="fluid-container">
                                    <h3 class="font-weight-medium text-right mb-0">5693</h3>
                                </div>
                            </div>
                        </div>
                        <p class="text-muted mt-3 mb-0">
                            <i class="mdi mdi-calendar mr-1" aria-hidden="true"></i> Weekly Sales
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
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
                        <p class="text-muted mt-3 mb-0">
                            <i class="mdi mdi-reload mr-1" aria-hidden="true"></i> Product-wise sales
                        </p>
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
                        <h4 class="card-title">Time of Login Chart</h4>
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
                                    <th>@lang('usersmanagement.users-table.role')</th>
                                    <th>Social Link</th>
                                    <th>Created At</th>
                                </tr>
                                </thead>
                                <tbody id="users_table">
                                @foreach($users as $user)
                                    <tr>
                                        <td>{{$loop->index + 1}}</td>
                                        <td><img src="@if($user->image_url) {{ $user->image_url }} @else /images/faces/empty.png @endif" class="mr-2" alt="image">{{$user->name}}</td>
                                        <td class="hidden-xs" width="100px"><a href="mailto:{{ $user->email }}"
                                                                               title="email {{ $user->email }}">{{ $user->email }}</a>
                                        </td>
                                        <td class="hidden-xs">{{$user->first_name}}</td>
                                        <td class="hidden-xs">{{$user->last_name}}</td>
                                        <td>
                                            @foreach ($user->roles as $user_role)
                                                @if ($user_role->name == 'User')
                                                    @php $badgeClass = 'gradient-primary' @endphp
                                                @elseif ($user_role->name == 'Admin')
                                                    @php $badgeClass = 'gradient-warning' @endphp
                                                @elseif ($user_role->name == 'Business_Admin')
                                                    @php $badgeClass = 'gradient-success' @endphp
                                                @else
                                                    @php $badgeClass = 'default' @endphp
                                                @endif
                                                <span class="badge badge-{{$badgeClass}}">{{ $user_role->name }}</span>
                                            @endforeach
                                        </td>
                                        <td>
                                            @if($user->provider == 'facebook')
                                                https://www.facebook.com/profile.php?id={{ $user->social_id }}
                                            @elseif($user->provider == 'twitter')
                                                https://twitter.com/{{ $user->first_name }}
                                            @elseif($user->provider == 'instagram')
                                                https://twitter.com/{{ $user->social_id }}
                                            @elseif($user->provider == 'linkedin')
                                                https://twitter.com/{{ $user->social_id }}
                                            @else
                                                no have
                                            @endif
                                        </td>
                                        <td>{{ $user->created_at }}</td>
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
    @include('pages.admin.dashboard.js')
@endsection
