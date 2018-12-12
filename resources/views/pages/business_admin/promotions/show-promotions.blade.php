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
                            Show All Promotion Settings
                            <div class="float-right">
                                <a href="{{ route('business.admin.business.setting', ['bzname' => $bzname]) }}" class="btn btn-light btn-sm float-right"
                                   data-toggle="tooltip" data-placement="left"
                                   title="@lang('usersmanagement.tooltips.back-users')">
                                    <i class="fa fa-fw fa-mail-reply" aria-hidden="true"></i>
                                    Back To Calendar
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Title</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Start Time</th>
                                    <th>End Time</th>
                                    <th>Thumbnail</th>
                                    <th>@lang('usersmanagement.users-table.actions')</th>
                                </tr>
                                </thead>
                                <tbody id="users_table">
                                @foreach($promotions as $promotion)
                                    <tr>
                                        <td>{{$loop->index + 1}}</td>
                                        <td>@if($promotion->default) Default Promotion @else {{$promotion->title}} @endif</td>
                                        <td>@if($promotion->default) @else  {{ date('M d Y', strtotime($promotion->start_date)) }} @endif</td>
                                        <td>@if($promotion->default) @else  {{ date('M d Y', strtotime($promotion->end_date)) }} @endif</td>
                                        <td>@if($promotion->default) @else  {{ date('H:i:s', strtotime($promotion->start_date)) }} @endif</td>
                                        <td>@if($promotion->default) @else  {{ date('H:i:s', strtotime($promotion->end_date)) }} @endif</td>
                                        <td><img src="{{ $promotion->path }}" width="50px" height="50px" style="-webkit-border-radius: 4px;-moz-border-radius: 4px;border-radius: 4px;"></td>
                                        <td class="actions" width="180px">
                                            {!! Form::open(array('url' => 'business/'.$bzname.'/admin/promotions/' . $promotion->id, 'class' => 'float-left', 'data-toggle' => 'tooltip', 'title' => 'Delete')) !!}
                                            {!! Form::hidden('_method', 'DELETE') !!}
                                            {!! Form::button(trans('usersmanagement.buttons.delete'), array('class' => 'btn btn-danger btn-sm','type' => 'button' ,'data-toggle' => 'modal', 'data-target' => '#confirmDelete', 'data-title' => 'Delete Promotion', 'data-message' => 'Are you sure you want to delete this promotion ?')) !!}
                                            {!! Form::close() !!}

                                            <a class="btn btn-sm btn-success" href="{{ URL::to('business/'.$bzname.'/admin/promotions/' . $promotion->id) }}"
                                               data-toggle="tooltip" title="Show">
                                                @lang('usersmanagement.buttons.show')
                                            </a>

                                            <a class="btn btn-sm btn-info"
                                               href="{{ URL::to('business/'.$bzname.'/admin/promotions/' . $promotion->id . '/edit') }}"
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
