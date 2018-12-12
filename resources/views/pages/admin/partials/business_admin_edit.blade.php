<div class="col-md-12">
    {!! Form::open(array('route' => 'admin.users.store', 'method' => 'PUT', 'role' => 'form', 'class' => 'needs-validation', 'id' => 'business_admin_form')) !!}

    {!! csrf_field() !!}

    <div class="form-group has-feedback row {{ $errors->has('email') ? ' has-error ' : '' }}">
        {!! Form::label('email', trans('forms.create_user_label_email'), array('class' => 'col-md-3 col-form-label')) !!}
        <div class="col-md-9">
            <div class="input-group">
                {!! Form::text('email', $user->email, array('id' => 'email', 'class' => 'form-control', 'placeholder' => trans('forms.create_user_ph_email'))) !!}
            </div>
            <label id="email-error" class="error" for="email"></label>
            @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group has-feedback row {{ $errors->has('name') ? ' has-error ' : '' }}">
        {!! Form::label('name', trans('forms.create_user_label_username'), array('class' => 'col-md-3 col-form-label')) !!}
        <div class="col-md-9">
            <div class="input-group">
                {!! Form::text('name', $user->name, array('id' => 'name', 'class' => 'form-control', 'placeholder' => trans('forms.create_user_ph_username'))) !!}
            </div>
            <label id="name-error" class="error" for="name"></label>
            @if ($errors->has('name'))
                <span class="help-block">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group has-feedback row {{ $errors->has('first_name') ? ' has-error ' : '' }}">
        {!! Form::label('first_name', trans('forms.create_user_label_firstname'), array('class' => 'col-md-3 col-form-label')) !!}
        <div class="col-md-9">
            <div class="input-group">
                {!! Form::text('first_name', $user->first_name, array('id' => 'first_name', 'class' => 'form-control', 'placeholder' => trans('forms.create_user_ph_firstname'))) !!}
            </div>
            <label id="first_name-error" class="error" for="first_name"></label>
            @if ($errors->has('first_name'))
                <span class="help-block">
                    <strong>{{ $errors->first('first_name') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group has-feedback row {{ $errors->has('last_name') ? ' has-error ' : '' }}">
        {!! Form::label('last_name', trans('forms.create_user_label_lastname'), array('class' => 'col-md-3 col-form-label')) !!}
        <div class="col-md-9">
            <div class="input-group">
                {!! Form::text('last_name', $user->last_name, array('id' => 'last_name', 'class' => 'form-control', 'placeholder' => trans('forms.create_user_ph_lastname'))) !!}
            </div>
            <label id="last_name-error" class="error" for="last_name"></label>
            @if ($errors->has('last_name'))
                <span class="help-block">
                <strong>{{ $errors->first('last_name') }}</strong>
            </span>
        @endif
        </div>
    </div>

    <div class="form-group has-feedback row {{ $errors->has('gender') ? ' has-error ' : '' }}">
        {!! Form::label('gender', 'Gender', array('class' => 'col-md-3 col-form-label')) !!}
        <div class="col-md-9">
            <div class="input-group">
                <select class="form-control" name="gender" id="gender">
                    <option value="">Select Gender</option>
                    @if ($user->gender)
                        <option value="{{ $user->gender }}" selected>{{ $user->gender }}</option>
                    @endif
                    <option value="male">Man</option>
                    <option value="female">Woman</option>
                </select>
            </div>
            <label id="gender-error" class="error" for="gender"></label>
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
            <label id="year-error" class="error" for="year"></label>
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
            <label id="country-error" class="error" for="country"></label>
            @if ($errors->has('country'))
                <span class="help-block">
                    <strong>{{ $errors->first('country') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group has-feedback row {{ $errors->has('password') ? ' has-error ' : '' }}">
        {!! Form::label('password', trans('forms.create_user_label_password'), array('class' => 'col-md-3 col-form-label')) !!}
        <div class="col-md-9">
            <div class="input-group">
                {!! Form::password('password', array('id' => 'password', 'class' => 'form-control ', 'placeholder' => trans('forms.create_user_ph_password'))) !!}
            </div>
            <label id="password-error" class="error" for="password"></label>
            @if ($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group has-feedback row {{ $errors->has('password_confirmation') ? ' has-error ' : '' }}">
        {!! Form::label('password_confirmation', trans('forms.create_user_label_pw_confirmation'), array('class' => 'col-md-3 col-form-label')) !!}
        <div class="col-md-9">
            <div class="input-group">
                {!! Form::password('password_confirmation', array('id' => 'password_confirmation', 'class' => 'form-control', 'placeholder' => trans('forms.create_user_ph_pw_confirmation'))) !!}
            </div>
            <label id="password_confirmation-error" class="error" for="password_confirmation"></label>
            @if ($errors->has('password_confirmation'))
                <span class="help-block">
                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                </span>
            @endif
        </div>
    </div>
    {!! Form::button('Update User', array('class' => 'btn btn-success margin-bottom-1 mb-1 float-right','type' => 'submit', 'id' => 'business_admin_submit')) !!}
    {!! Form::close() !!}
</div>
