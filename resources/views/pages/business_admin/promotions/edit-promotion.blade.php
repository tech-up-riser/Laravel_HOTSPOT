@extends('layouts.business')

@section('template_linked_css')
    <style type="text/css" media="screen">
        .help-block {
            font-size: 13px;
            color: #e65251;
            font-weight: 300;
        }
    </style>
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <div>
                            Edit {{ ($promotion->default) ?  "Default Promotion" : $promotion->title }}
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="col-md-10 offset-md-1">
                            {!! Form::open(array('route' => ['business.admin.promotions.update', $bzname, $promotion->id], 'method' => 'PUT', 'role' => 'form', 'class' => 'needs-validation')) !!}

                            {!! csrf_field() !!}

                            @if ($promotion->title)
                            <div class="form-group has-feedback row {{ $errors->has('title') ? ' has-error ' : '' }}">
                                {!! Form::label('title', 'Title' , array('class' => 'col-md-3 col-form-label')) !!}
                                <div class="col-md-9">
                                    <div class="input-group">
                                        {!! Form::text('title', $promotion->title, array('id' => 'title', 'class' => 'form-control', 'placeholder' => 'Chrismas Promotion')) !!}
                                    </div>
                                    @if ($errors->has('title'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('title') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            @endif

                            @if ($promotion->start_date)
                            <div class="form-group has-feedback row {{ $errors->has('start_date') ? ' has-error ' : '' }}">
                                {!! Form::label('start_date', 'Start Date' , array('class' => 'col-md-3 col-form-label')) !!}
                                <div class="col-md-9">
                                    <div class="input-group">
                                        {!! Form::date('start_date', date('Y-m-d', strtotime($promotion->start_date)), array('id' => 'start_date', 'class' => 'form-control')) !!}
                                    </div>
                                    @if ($errors->has('start_date'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('start_date') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            @endif

                            @if ($promotion->end_date)
                            <div class="form-group has-feedback row {{ $errors->has('end_date') ? ' has-error ' : '' }}">
                                {!! Form::label('end_date', 'End Date' , array('class' => 'col-md-3 col-form-label')) !!}
                                <div class="col-md-9">
                                    <div class="input-group">
                                        {!! Form::date('end_date', date('Y-m-d', strtotime($promotion->end_date)), array('id' => 'title', 'class' => 'form-control')) !!}
                                    </div>
                                    @if ($errors->has('end_date'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('end_date') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            @endif

                            @if ($promotion->start_date)
                                <div class="form-group has-feedback row {{ $errors->has('start_date') ? ' has-error ' : '' }}">
                                    {!! Form::label('start_time', 'Start Time' , array('class' => 'col-md-3 col-form-label')) !!}
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            {!! Form::time('start_time', date('H:i', strtotime($promotion->start_date)), array('id' => 'start_time', 'class' => 'form-control')) !!}
                                        </div>
                                        @if ($errors->has('start_time'))
                                            <span class="help-block">
                                            <strong>{{ $errors->first('start_time') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            @if ($promotion->end_date)
                                <div class="form-group has-feedback row {{ $errors->has('start_date') ? ' has-error ' : '' }}">
                                    {!! Form::label('end_time', 'End Time' , array('class' => 'col-md-3 col-form-label')) !!}
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            {!! Form::time('end_time', date('H:i', strtotime($promotion->end_date)), array('id' => 'end_time', 'class' => 'form-control')) !!}
                                        </div>
                                        @if ($errors->has('end_time'))
                                            <span class="help-block">
                                            <strong>{{ $errors->first('end_time') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            <div class="form-group has-feedback row">
                                @foreach($promotions as $index => $image)
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input type="radio" class="form-check-input"
                                                           name="promotion_id" id="promotion_radio_{{ $index }}"
                                                           value="{{ $image->id }}"
                                                           @if($image->id == $promotion->promotion_id) checked @else @endif>
                                                    Image {{$index}}
                                                </label>
                                                <img src="{{ $image->path }}" width="100%">
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            {!! Form::button("Update Promotion", array('class' => 'btn btn-success margin-bottom-1 mb-1 float-right','type' => 'submit' )) !!}
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
