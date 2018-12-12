@extends('layouts.business')

@section('content')

    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header text-white bg-success">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            @lang('usersmanagement.showing-user-title', ['name' => ($promotion->default) ?  "Default Promotion" : $promotion->title])
                            <div class="float-right">
                                <a href="{{ route('business.admin.promotions', ['bzname' => $bzname]) }}" class="btn btn-light btn-sm float-right"
                                   data-toggle="tooltip" data-placement="left"
                                   title="@lang('usersmanagement.tooltips.back-users')">
                                    <i class="fa fa-fw fa-mail-reply" aria-hidden="true"></i>
                                    Back To Promotions
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        @if ($promotion->title)
                            <div class="col-sm-5 col-6 text-larger">
                                <strong>
                                    Title
                                </strong>
                            </div>

                            <div class="col-sm-7">
                                @if($promotion->default) Default Promotion @else {{$promotion->title}} @endif
                            </div>

                            <div class="clearfix"></div>
                            <div class="border-bottom"></div>
                        @endif
                        @if ($promotion->start_date)
                            <div class="col-sm-5 col-6 text-larger">
                                <strong>
                                    Start Date
                                </strong>
                            </div>

                            <div class="col-sm-7">
                                @if($promotion->default) @else  {{ date('M d Y', strtotime($promotion->start_date)) }} @endif
                            </div>

                            <div class="clearfix"></div>
                            <div class="border-bottom"></div>
                        @endif
                        @if ($promotion->end_date)
                            <div class="col-sm-5 col-6 text-larger">
                                <strong>
                                    End Date
                                </strong>
                            </div>

                            <div class="col-sm-7">
                                @if($promotion->default) @else  {{ date('M d Y', strtotime($promotion->end_date)) }} @endif
                            </div>

                            <div class="clearfix"></div>
                            <div class="border-bottom"></div>
                        @endif
                            @if ($promotion->start_date)
                                <div class="col-sm-5 col-6 text-larger">
                                    <strong>
                                        Start Time
                                    </strong>
                                </div>

                                <div class="col-sm-7">
                                    @if($promotion->default) @else  {{ date('H:i', strtotime($promotion->start_date)) }} @endif
                                </div>

                                <div class="clearfix"></div>
                                <div class="border-bottom"></div>
                            @endif
                            @if ($promotion->end_date)
                                <div class="col-sm-5 col-6 text-larger">
                                    <strong>
                                        End Time
                                    </strong>
                                </div>

                                <div class="col-sm-7">
                                    @if($promotion->default) @else  {{ date('H:i', strtotime($promotion->end_date)) }} @endif
                                </div>

                                <div class="clearfix"></div>
                                <div class="border-bottom"></div>
                            @endif
                        @if ($image->path)
                            <div class="col-sm-5 col-6 text-larger">
                                <strong>
                                    Promotion Image
                                </strong>
                            </div>

                            <div class="col-sm-7">
                                <img width="250px" src="{{ $image->path }}" />
                            </div>

                            <div class="clearfix"></div>
                            <div class="border-bottom"></div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

