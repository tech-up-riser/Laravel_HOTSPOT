@extends('layouts.business')

@section('template_linked_css')
    <style type="text/css" media="screen">
        .help-block {
            font-size: 13px;
            color: #e65251;
            font-weight: 300;
        }

        #div_logo_edit {
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.3);
            border-radius: 4px;
            border: 1px solid rgba(0, 0, 0, 0.07)
        }
    </style>
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header bg-gradient-primary text-white">
                        @if(isset($logo))
                            <h4>Business Logo Image</h4>
                        @else
                            <h4>Upload Logo</h4>
                        @endif
                    </div>

                    <div class="card-body">
                        @if(isset($logo))
                            <div class="col-md-12">
                                <img src="{{ $logo->path }}" width="250px">
                                <button type="button" class="btn btn-gradient-primary pull-right" id="edit_logo">Edit Logo</button>
                                <button type="button" class="btn btn-gradient-info pull-right" id="cancel_logo" style="display: none;">Cancel</button>
                            </div>
                        @endif
                        <div class="col-md-8 pull-right" id="div_logo_edit" style="display: @if(isset($logo)) none @else block @endif">
                            {!! Form::open(array('route' => ['business.admin.business.logo', 'bzname' => $bzname], 'method' => 'POST', 'role' => 'form', 'class' => 'needs-validation', 'enctype' =>"multipart/form-data")) !!}

                            {!! csrf_field() !!}

                            <div class="form-group mt-4 has-feedback row {{ $errors->has('email') ? ' has-error ' : '' }}">
                                {!! Form::label('logo_image', 'Upload Logo', array('class' => 'col-md-3 control-label')) !!}
                                <div class="col-md-9">
                                    <div class="input-group">
                                        {!! Form::file('logo_image', NULL, array('id' => 'logo_image', 'class' => 'form-control')) !!}
                                    </div>
                                    @if ($errors->has('logo_image'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('logo_image') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>


                            {!! Form::button('Upload', array('class' => 'btn btn-success margin-bottom-1 mb-1 float-right','type' => 'submit' )) !!}
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('footer_scripts')
    <script type="text/javascript">
        $('#edit_logo').click(function(){
            document.getElementById('edit_logo').style.display = 'none';
            document.getElementById('cancel_logo').style.display = 'block';
            document.getElementById('div_logo_edit').style.display = 'block';
        });

        $('#cancel_logo').click(function(){
            document.getElementById('edit_logo').style.display = 'block';
            document.getElementById('cancel_logo').style.display = 'none';
            document.getElementById('div_logo_edit').style.display = 'none';
        });
    </script>
@endsection
