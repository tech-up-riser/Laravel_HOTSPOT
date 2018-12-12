@extends('layouts.business')

@php
    $levelAmount = trans('usersmanagement.labelUserLevel');
    if ($user->level() >= 2) {
      $levelAmount = trans('usersmanagement.labelUserLevels');
    }
@endphp

@section('content')

    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header text-white bg-success">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            @lang('usersmanagement.showing-user-title', ['name' => $user->name])
                            <div class="float-right">
                                <a href="{{ route('business.admin.users', ['bzname' => $bzname]) }}" class="btn btn-light btn-sm float-right"
                                   data-toggle="tooltip" data-placement="left"
                                   title="@lang('usersmanagement.tooltips.back-users')">
                                    <i class="fa fa-fw fa-mail-reply" aria-hidden="true"></i>
                                    @lang('usersmanagement.buttons.back-to-users')
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-4 offset-sm-2 col-md-2 offset-md-3">
                                <img src="@if ($user->profile && $user->profile->avatar_status == 1) {{ $user->profile->avatar }} @else {{ Gravatar::get($user->email) }} @endif"
                                     alt="{{ $user->name }}" class="rounded-circle center-block mb-3 mt-4 user-image">
                            </div>
                            <div class="col-sm-4 col-md-6">
                                <h4 class="text-muted margin-top-sm-1 text-center text-left-tablet">
                                    {{ $user->name }}
                                </h4>
                                <p class="text-center text-left-tablet">
                                    <strong>
                                        {{ $user->first_name }} {{ $user->last_name }}
                                    </strong>
                                    @if($user->email)
                                        <br/>
                                        <span class="text-center" data-toggle="tooltip" data-placement="top"
                                              title="@lang('usersmanagement.tooltips.email-user', ['user' => $user->email])">
                                              {{ Html::mailto($user->email, $user->email) }}
                                        </span>
                                    @endif
                                </p>
                                @if ($user->profile)
                                    <div class="text-center text-left-tablet mb-4">
                                        <a href="/business/{{ $bzname }}/admin/users/{{$user->id}}/edit" class="btn btn-sm btn-warning"
                                           data-toggle="tooltip" data-placement="top"
                                           title="{{ trans('usersmanagement.editUser') }}">
                                            <i class="fa fa-pencil fa-fw" aria-hidden="true"></i> <span
                                                    class="hidden-xs hidden-sm hidden-md"> {{ trans('usersmanagement.editUser') }} </span>
                                        </a>
                                        {!! Form::open(array('url' => '/business/'.$bzname.'/admin/users/' . $user->id, 'class' => 'form-inline', 'data-toggle' => 'tooltip', 'data-placement' => 'right', 'title' => trans('usersmanagement.deleteUser'))) !!}
                                        {!! Form::hidden('_method', 'DELETE') !!}
                                        {!! Form::button('<i class="fa fa-trash-o fa-fw" aria-hidden="true"></i> <span class="hidden-xs hidden-sm hidden-md">' . trans('usersmanagement.deleteUser') . '</span>' , array('class' => 'btn btn-danger btn-sm','type' => 'button', 'data-toggle' => 'modal', 'data-target' => '#confirmDelete', 'data-title' => 'Delete User', 'data-message' => 'Are you sure you want to delete this user?')) !!}
                                        {!! Form::close() !!}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="clearfix"></div>
                        <div class="border-bottom"></div>

                        @if ($user->name)
                            <div class="col-sm-5 col-6 text-larger">
                                <strong>
                                    {{ trans('usersmanagement.labelUserName') }}
                                </strong>
                            </div>

                            <div class="col-sm-7">
                                {{ $user->name }}
                            </div>

                            <div class="clearfix"></div>
                            <div class="border-bottom"></div>
                        @endif

                        @if ($user->email)
                            <div class="col-sm-5 col-6 text-larger">
                                <strong>
                                    {{ trans('usersmanagement.labelEmail') }}
                                </strong>
                            </div>
                            <div class="col-sm-7">
                              <span data-toggle="tooltip" data-placement="top"
                                    title="@lang('usersmanagement.tooltips.email-user', ['user' => $user->email])">
                                {{ HTML::mailto($user->email, $user->email) }}
                              </span>
                            </div>
                            <div class="clearfix"></div>
                            <div class="border-bottom"></div>
                        @endif

                        @if ($user->first_name)
                            <div class="col-sm-5 col-6 text-larger">
                                <strong>
                                    {{ trans('usersmanagement.labelFirstName') }}
                                </strong>
                            </div>
                            <div class="col-sm-7">
                                {{ $user->first_name }}
                            </div>

                            <div class="clearfix"></div>
                            <div class="border-bottom"></div>
                        @endif

                        @if ($user->last_name)
                            <div class="col-sm-5 col-6 text-larger">
                                <strong>
                                    {{ trans('usersmanagement.labelLastName') }}
                                </strong>
                            </div>
                            <div class="col-sm-7">
                                {{ $user->last_name }}
                            </div>

                            <div class="clearfix"></div>
                            <div class="border-bottom"></div>

                        @endif

                        @if ($user->gender)
                            <div class="col-sm-5 col-6 text-larger">
                                <strong>
                                    Gender
                                </strong>
                            </div>
                            <div class="col-sm-7">
                                {{ $user->gender }}
                            </div>

                            <div class="clearfix"></div>
                            <div class="border-bottom"></div>

                        @endif

                        @if ($user->year)
                            <div class="col-sm-5 col-6 text-larger">
                                <strong>
                                    Year of Birth
                                </strong>
                            </div>
                            <div class="col-sm-7">
                                {{ $user->year }}
                            </div>

                            <div class="clearfix"></div>
                            <div class="border-bottom"></div>

                        @endif

                        @if ($user->country)
                            <div class="col-sm-5 col-6 text-larger">
                                <strong>
                                    Country
                                </strong>
                            </div>
                            <div class="col-sm-7">
                                {{ $user->country }}
                            </div>

                            <div class="clearfix"></div>
                            <div class="border-bottom"></div>

                        @endif

                        <div class="col-sm-5 col-6 text-larger">
                            <strong>
                                {{ trans('usersmanagement.labelRole') }}
                            </strong>
                        </div>

                        <div class="col-sm-7">
                            @foreach ($user->roles as $user_role)

                                @if ($user_role->name == 'User')
                                    @php $badgeClass = 'primary' @endphp

                                @elseif ($user_role->name == 'Admin')
                                    @php $badgeClass = 'warning' @endphp

                                @elseif ($user_role->name == 'Business_Admin')
                                    @php $badgeClass = 'info' @endphp

                                @else
                                    @php $badgeClass = 'default' @endphp

                                @endif

                                <span class="badge badge-{{$badgeClass}}">{{ $user_role->name }}</span>

                            @endforeach
                        </div>

                        <div class="clearfix"></div>
                        <div class="border-bottom"></div>

                        <div class="col-sm-5 col-6 text-larger">
                            <strong>
                                {{ trans('usersmanagement.labelStatus') }}
                            </strong>
                        </div>

                        <div class="col-sm-7">
                            @if ($user->activated == 1)
                                <span class="badge badge-success">
                  Activated
                </span>
                            @else
                                <span class="badge badge-danger">
                  Not-Activated
                </span>
                            @endif
                        </div>

                        <div class="clearfix"></div>
                        <div class="border-bottom"></div>

                        <div class="col-sm-5 col-6 text-larger">
                            <strong>
                                {{ trans('usersmanagement.labelAccessLevel')}} {{ $levelAmount }}:
                            </strong>
                        </div>

                        <div class="col-sm-7">

                            @if($user->level() >= 5)
                                <span class="badge badge-primary margin-half margin-left-0">5</span>
                            @endif

                            @if($user->level() >= 4)
                                <span class="badge badge-info margin-half margin-left-0">4</span>
                            @endif

                            @if($user->level() >= 3)
                                <span class="badge badge-success margin-half margin-left-0">3</span>
                            @endif

                            @if($user->level() >= 2)
                                <span class="badge badge-warning margin-half margin-left-0">2</span>
                            @endif

                            @if($user->level() >= 1)
                                <span class="badge badge-default margin-half margin-left-0">1</span>
                            @endif

                        </div>

                        <div class="clearfix"></div>
                        <div class="border-bottom"></div>

                        @if ($user->mac_address)

                            <div class="col-sm-5 col-6 text-larger">
                                <strong>
                                    Mac Address
                                </strong>
                            </div>

                            <div class="col-sm-7">
                                {{ $user->mac_address }}
                            </div>

                            <div class="clearfix"></div>
                            <div class="border-bottom"></div>

                        @endif

                        @if ($user->created_at)

                            <div class="col-sm-5 col-6 text-larger">
                                <strong>
                                    {{ trans('usersmanagement.labelCreatedAt') }}
                                </strong>
                            </div>

                            <div class="col-sm-7">
                                {{ $user->created_at }}
                            </div>

                            <div class="clearfix"></div>
                            <div class="border-bottom"></div>

                        @endif

                        @if ($user->updated_at)

                            <div class="col-sm-5 col-6 text-larger">
                                <strong>
                                    {{ trans('usersmanagement.labelUpdatedAt') }}
                                </strong>
                            </div>

                            <div class="col-sm-7">
                                {{ $user->updated_at }}
                            </div>

                            <div class="clearfix"></div>
                            <div class="border-bottom"></div>

                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('modals.modal-delete')

@endsection

@section('footer_scripts')
    @include('scripts.delete-modal-script')
@endsection
