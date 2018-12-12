@extends('layouts.business')

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
                            Showing All Businesses
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
                                    <a class="dropdown-item" href="/admin/business/create">
                                        <i class="fa fa-fw fa-user-plus" aria-hidden="true"></i>
                                        Create Business
                                    </a>
                                    <a class="dropdown-item" href="/admin/business/deleted">
                                        <i class="fa fa-fw fa-group" aria-hidden="true"></i>
                                        Show Deleted Businesses
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
                                    <th>Business Name</th>
                                    <th>Owner Name</th>
                                    <th>Email</th>
                                    <th>City</th>
                                    <th>Country</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody id="users_table">
                                @foreach($businesses as $business)
                                    <tr>
                                        <td>{{$loop->index + 1}}</td>
                                        <td>{{$business->business_fullname}}</td>
                                        <td>{{$business->owner_name}}</td>
                                        <td>{{$business->email}}</td>
                                        <td>{{$business->city}}</td>
                                        <td>{{$business->country}}</td>
                                        <td class="actions" width="180px">
                                            {!! Form::open(array('url' => '/admin/business' . $business->id, 'class' => 'float-left', 'data-toggle' => 'tooltip', 'title' => 'Delete')) !!}
                                            {!! Form::hidden('_method', 'DELETE') !!}
                                            {!! Form::button(trans('usersmanagement.buttons.delete'), array('class' => 'btn btn-danger btn-sm','type' => 'button' ,'data-toggle' => 'modal', 'data-target' => '#confirmDelete', 'data-title' => 'Delete User', 'data-message' => 'Are you sure you want to delete this user ?')) !!}
                                            {!! Form::close() !!}

                                            <a class="btn btn-sm btn-success" href="{{ URL::to('/admin/business/' . $business->id) }}"
                                               data-toggle="tooltip" title="Show">
                                                @lang('usersmanagement.buttons.show')
                                            </a>

                                            <a class="btn btn-sm btn-info"
                                               href="{{ URL::to('/admin/business/' . $business->id . '/edit') }}"
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

@endsection
