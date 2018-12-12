@extends('layouts.business')

@section('template_linked_css')
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">
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

        .sorting-asc:before {
            content: "" !important;
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
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="">
                            {!! Form::open(array('route' => ['business.admin.users', $bzname], 'method' => 'POST', 'role' => 'form', 'class' => 'needs-validation')) !!}

                            {!! csrf_field() !!}
                            <div class="row">
                                <div class="col-sm-4 row">
                                    {!! Form::label('gender', 'Gender', array('class' => 'col-md-4 col-form-label')) !!}
                                    <div class="col-md-8">
                                        <div class="input-group">
                                            <select class="form-control" name="gender" id="gender">
                                                <option value="">Select Gender</option>
                                                <option value="male">Male</option>
                                                <option value="female">Female</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4 row">
                                    {!! Form::label('country', 'Country', array('class' => 'col-md-5 col-form-label')) !!}
                                    <div class="col-md-7">
                                        <div class="input-group">
                                            <select class="form-control" name="country" id="country">
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4 row">
                                    {!! Form::label('login_type', 'Login Type', array('class' => 'col-md-6 col-form-label')) !!}
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <select class="form-control" name="login_type" id="login_type">
                                                <option value="">Select One</option>
                                                <option value="facebook">Facebook</option>
                                                <option value="twitter">Twitter</option>
                                                <option value="instagram">Instagram</option>
                                                <option value="linkedin">Linkedin</option>
                                                <option value="wechat">Wechat</option>
                                                <option value="vkontakte">Vkontakte</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 row">
                                    {!! Form::label('min_age', 'Min Age', array('class' => 'col-md-3 col-form-label')) !!}
                                    <div class="col-md-3">
                                        <div class="input-group">
                                            {!! Form::number('min_age', 17, array('id' => 'min_age', 'class' => 'form-control', 'placeholder' => 'Min Age')) !!}
                                        </div>
                                    </div>
                                    {!! Form::label('max_age', 'Max Age', array('class' => 'col-md-3 col-form-label')) !!}
                                    <div class="col-md-3">
                                        <div class="input-group">
                                            {!! Form::number('max_age', 60, array('id' => 'min_age', 'class' => 'form-control', 'placeholder' => 'Min Age')) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    {!! Form::button('Search', array('class' => 'btn btn-success margin-bottom-1 mb-1 float-right','type' => 'submit' )) !!}
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                        <div class="table-responsive mt-4">
                            <table id="user-listing" class="table table-hover">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>@lang('usersmanagement.users-table.name')</th>
                                    <th class="hidden-xs">@lang('usersmanagement.users-table.email')</th>
                                    <th class="hidden-xs">@lang('usersmanagement.users-table.fname')</th>
                                    <th class="hidden-xs">@lang('usersmanagement.users-table.lname')</th>
                                    <th>Gender</th>
                                    <th>Age</th>
                                    <th>Platform</th>
                                    <th>Social Link</th>
                                    <th>Login Time</th>
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
                                        <td style="text-transform: capitalize;">{{ $user->gender }}</td>
                                        <td>{{ $current_year - $user->year }}</td>
                                        <td>
                                            @if($user->provider == null)
                                                Email
                                            @else
                                                {{ $user->provider }}
                                            @endif
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
                                                N/A
                                            @endif
                                        </td>
                                        <td>{{ $user->login_time }}</td>
                                        <td class="actions" width="180px">
                                            {!! Form::open(array('url' => '/business/'.$bzname.'/admin/users/' . $user->id, 'class' => 'float-left', 'data-toggle' => 'tooltip', 'title' => 'Delete')) !!}
                                            {!! Form::hidden('_method', 'DELETE') !!}
                                            {!! Form::button(trans('usersmanagement.buttons.delete'), array('class' => 'btn btn-danger btn-sm','type' => 'button' ,'data-toggle' => 'modal', 'data-target' => '#confirmDelete', 'data-title' => 'Delete User', 'data-message' => 'Are you sure you want to delete this user ?')) !!}
                                            {!! Form::close() !!}

                                            <a class="btn btn-sm btn-success" href="{{ URL::to('/business/'.$bzname.'/admin/users/' . $user->id) }}"
                                               data-toggle="tooltip" title="Show">
                                                @lang('usersmanagement.buttons.show')
                                            </a>

                                            <a class="btn btn-sm btn-info"
                                               href="{{ URL::to('/business/'.$bzname.'/admin/users/' . $user->id . '/edit') }}"
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
    <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
    @include('partials.js')
    <script type="text/javascript">
        get_countries();

        $(function() {
            $('#user-listing').dataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copyHtml5', 'excelHtml5', 'pdfHtml5', 'csvHtml5'
                ],
                "iDisplayLength": 10,
            });
            $('#user-listing_filter').attr('style', 'display: none');
        });
    </script>
@endsection
