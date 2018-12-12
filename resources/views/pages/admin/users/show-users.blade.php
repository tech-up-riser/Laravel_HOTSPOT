@extends('layouts.admin')

@section('template_linked_css')
    @if(config('laravelusers.enabledDatatablesJs'))
        <link rel="stylesheet" type="text/css" href="{{ config('laravelusers.datatablesCssCDN') }}">
    @endif
    <style type="text/css" media="screen">
        .table th, .table td {
            padding: 15px 18px;
        }

        .actions {
            padding: 15px 4px !important;
        }

        .actions button {
            margin-right: 4px;
        }

        .btn i {
            margin-right: 0px;
        }

        .dropdown-menu a {
            padding: 10px 20px;
            font-size: 14px;
        }
    </style>
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span id="card_title">
                            @lang('usersmanagement.showing-all-users')
                        </span>

                            <div class="btn-group pull-right btn-group-xs">
                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-ellipsis-v fa-fw" aria-hidden="true"></i>
                                    <span class="sr-only">
                                        @lang('usersmanagement.users-menu-alt')
                                    </span>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="/admin/users/create">
                                        <i class="fa fa-fw fa-user-plus" aria-hidden="true"></i>
                                        @lang('usersmanagement.buttons.create-new')
                                    </a>
                                    <a class="dropdown-item" href="/admin/users/deleted">
                                        <i class="fa fa-fw fa-group" aria-hidden="true"></i>
                                        @lang('usersmanagement.show-deleted-users')
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
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
                                    <th>@lang('usersmanagement.users-table.actions')</th>
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
                                        <td class="actions" width="180px">
                                            {!! Form::open(array('url' => '/admin/users/' . $user->id, 'class' => 'float-left', 'data-toggle' => 'tooltip', 'title' => 'Delete')) !!}
                                            {!! Form::hidden('_method', 'DELETE') !!}
                                            {!! Form::button(trans('usersmanagement.buttons.delete'), array('class' => 'btn btn-danger btn-sm','type' => 'button' ,'data-toggle' => 'modal', 'data-target' => '#confirmDelete', 'data-title' => 'Delete User', 'data-message' => 'Are you sure you want to delete this user ?')) !!}
                                            {!! Form::close() !!}

                                            <a class="btn btn-sm btn-success" href="{{ URL::to('/admin/users/' . $user->id) }}"
                                               data-toggle="tooltip" title="Show">
                                                @lang('usersmanagement.buttons.show')
                                            </a>

                                            <a class="btn btn-sm btn-info"
                                               href="{{ URL::to('/admin/users/' . $user->id . '/edit') }}"
                                               data-toggle="tooltip" title="Edit">
                                                @lang('usersmanagement.buttons.edit')
                                            </a>
                                        </td>
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

    @include('modals.modal-delete')

@endsection

@section('footer_scripts')
    @include('scripts.delete-modal-script')
@endsection
