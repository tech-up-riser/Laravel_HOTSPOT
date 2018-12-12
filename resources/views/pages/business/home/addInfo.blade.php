@extends('layouts.default')

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
            <div class="col-lg-6 offset-lg-3 col-xs-12">
                <div class="card mt-5">
                    <div class="card-body mt-2">
                        <div class="col-md-12">
                            {!! Form::open(array('route' => ['bzuser.store', $bzname], 'method' => 'POST', 'role' => 'form', 'class' => 'needs-validation')) !!}

                            {!! csrf_field() !!}
                            @if($missing)
                            <div class="form-group has-feedback row {{ $errors->has('email') ? ' has-error ' : '' }}">
                                {!! Form::label('email', 'Email', array('class' => 'col-md-3 col-form-label')) !!}
                                <div class="col-md-9">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Email" name="email">
                                    </div>
                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            @endif
                            <div class="form-group has-feedback row {{ $errors->has('gender') ? ' has-error ' : '' }}">
                                {!! Form::label('gender', 'Gender', array('class' => 'col-md-3 col-form-label')) !!}
                                <div class="col-md-9">
                                    <div class="input-group">
                                        <select class="form-control" name="gender" id="gender">
                                            <option value="">Select Gender</option>
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                        </select>
                                    </div>
                                    @if ($errors->has('gender'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('gender') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group has-feedback row {{ $errors->has('years') ? ' has-error ' : '' }}">
                                {!! Form::label('year', 'Birth of Year', array('class' => 'col-md-3 col-form-label')) !!}
                                <div class="col-md-9">
                                    <div class="input-group">
                                        <select class="form-control" name="year" id="year">
                                        </select>
                                    </div>
                                    @if ($errors->has('year'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('year') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group has-feedback row {{ $errors->has('country') ? ' has-error ' : '' }}">
                                {!! Form::label('country', 'Country', array('class' => 'col-md-3 col-form-label')) !!}
                                <div class="col-md-9">
                                    <div class="input-group">
                                        <select class="form-control" name="country" id="country">
                                        </select>
                                    </div>
                                    @if ($errors->has('country'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('country') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            {!! Form::button('Save', array('class' => 'btn btn-success margin-bottom-1 mb-1 float-right','type' => 'submit' )) !!}
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('footer_scripts')
    @include('partials.js')
    <script type="text/javascript">
        get_years();
        get_countries();
    </script>
@endsection