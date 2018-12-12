<div class="col-md-12">
    {!! Form::open(array('route' => 'admin.business.store', 'method' => 'PUT', 'role' => 'form', 'class' => 'needs-validation', 'id' => 'business_form')) !!}

    {!! csrf_field() !!}

    <div class="form-group has-feedback row {{ $errors->has('business_name') ? ' has-error ' : '' }}">
        {!! Form::label('business_name', 'Business Unique Name', array('class' => 'col-md-3 col-form-label')) !!}
        <div class="col-md-9">
            <div class="input-group">
                {!! Form::text('', $business->business_name, array('id' => 'business_name', 'class' => 'form-control', 'placeholder' => 'coava_coffee_shop', 'disabled')) !!}
            </div>
            <label id="business_name-error" class="error" for="business_name"></label>
            @if ($errors->has('business_name'))
                <span class="help-block">
                    <strong>{{ $errors->first('business_name') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group has-feedback row {{ $errors->has('business_fullname') ? ' has-error ' : '' }}">
        {!! Form::label('business_fullname', 'Business Full Name', array('class' => 'col-md-3 col-form-label')) !!}
        <div class="col-md-9">
            <div class="input-group">
                {!! Form::text('business_fullname', $business->business_fullname, array('id' => 'business_fullname', 'class' => 'form-control', 'placeholder' => 'Coava Coffee Shop')) !!}
            </div>
            <label id="business_fullname-error" class="error" for="business_fullname"></label>
            @if ($errors->has('business_fullname'))
                <span class="help-block">
                    <strong>{{ $errors->first('business_fullname') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group has-feedback row {{ $errors->has('owner_name') ? ' has-error ' : '' }}">
        {!! Form::label('owner_name', 'Business Full Name', array('class' => 'col-md-3 col-form-label')) !!}
        <div class="col-md-9">
            <div class="input-group">
                {!! Form::text('owner_name', $business->owner_name, array('id' => 'owner_name', 'class' => 'form-control', 'placeholder' => 'John William')) !!}
            </div>
            <label id="owner_name-error" class="error" for="owner_name"></label>
            @if ($errors->has('owner_name'))
                <span class="help-block">
                    <strong>{{ $errors->first('owner_name') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group has-feedback row {{ $errors->has('email') ? ' has-error ' : '' }}">
        {!! Form::label('email', trans('forms.create_user_label_email'), array('class' => 'col-md-3 col-form-label')) !!}
        <div class="col-md-9">
            <div class="input-group">
                {!! Form::text('business_email', $business->email, array('class' => 'form-control', 'placeholder' => 'Business Email')) !!}
            </div>
            <label id="business_email-error" class="error" for="business_email"></label>
            @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group has-feedback row {{ $errors->has('address1') ? ' has-error ' : '' }}">
        {!! Form::label('address1', 'Address 1', array('class' => 'col-md-3 col-form-label')) !!}
        <div class="col-md-9">
            <div class="input-group">
                {!! Form::text('address1', $business->address1, array('id' => 'address1', 'class' => 'form-control', 'placeholder' => '140 Yonge St')) !!}
            </div>
            <label id="address1-error" class="error" for="address1"></label>
            @if ($errors->has('address1'))
                <span class="help-block">
                    <strong>{{ $errors->first('address1') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group has-feedback row {{ $errors->has('address2') ? ' has-error ' : '' }}">
        {!! Form::label('address2', 'Address 2', array('class' => 'col-md-3 col-form-label')) !!}
        <div class="col-md-9">
            <div class="input-group">
                {!! Form::text('address2', $business->address2, array('id' => 'address2', 'class' => 'form-control', 'placeholder' => 'Ap 204')) !!}
            </div>
            <label id="address2-error" class="error" for="address2"></label>
            @if ($errors->has('address2'))
                <span class="help-block">
                    <strong>{{ $errors->first('address2') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group has-feedback row {{ $errors->has('city') ? ' has-error ' : '' }}">
        {!! Form::label('city', 'City', array('class' => 'col-md-3 col-form-label')) !!}
        <div class="col-md-9">
            <div class="input-group">
                {!! Form::text('city', $business->city, array('id' => 'city', 'class' => 'form-control', 'placeholder' => 'Toronto')) !!}
            </div>
            <label id="city-error" class="error" for="city"></label>
            @if ($errors->has('city'))
                <span class="help-block">
                    <strong>{{ $errors->first('city') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group has-feedback row {{ $errors->has('country') ? ' has-error ' : '' }}">
        {!! Form::label('country', 'Country', array('class' => 'col-md-3 col-form-label')) !!}
        <div class="col-md-9">
            <div class="input-group">
                {!! Form::text('business_country', $business->country, array('id' => 'business_country', 'class' => 'form-control', 'placeholder' => 'Canada')) !!}
            </div>
            <label id="business_country-error" class="error" for="business_country"></label>
            @if ($errors->has('country'))
                <span class="help-block">
                    <strong>{{ $errors->first('country') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group has-feedback row {{ $errors->has('postcode') ? ' has-error ' : '' }}">
        {!! Form::label('postcode', 'Post Code', array('class' => 'col-md-3 col-form-label')) !!}
        <div class="col-md-9">
            <div class="input-group">
                {!! Form::text('postcode', $business->postcode, array('id' => 'postcode', 'class' => 'form-control', 'placeholder' => 'M4C 5K7')) !!}
            </div>
            <label id="postcode-error" class="error" for="postcode"></label>
            @if ($errors->has('postcode'))
                <span class="help-block">
                    <strong>{{ $errors->first('postcode') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group has-feedback row {{ $errors->has('facebook_link') ? ' has-error ' : '' }}">
        {!! Form::label('facebook_link', 'Facebook Link', array('class' => 'col-md-3 col-form-label')) !!}
        <div class="col-md-9">
            <div class="input-group">
                {!! Form::text('facebook_link', $business->facebook_link, array('id' => 'facebook_link', 'class' => 'form-control', 'placeholder' => 'Please Enter your company Facebook link')) !!}
            </div>
            @if ($errors->has('facebook_link'))
                <span class="help-block">
                    <strong>{{ $errors->first('facebook_link') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group has-feedback row {{ $errors->has('twitter_link') ? ' has-error ' : '' }}">
        {!! Form::label('twitter_link', 'Twitter Link', array('class' => 'col-md-3 col-form-label')) !!}
        <div class="col-md-9">
            <div class="input-group">
                {!! Form::text('twitter_link', $business->twitter_link, array('id' => 'twitter_link', 'class' => 'form-control', 'placeholder' => 'Please Enter your company Twitter link')) !!}
            </div>
            @if ($errors->has('twitter_link'))
                <span class="help-block">
                    <strong>{{ $errors->first('twitter_link') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group has-feedback row {{ $errors->has('instagram_link') ? ' has-error ' : '' }}">
        {!! Form::label('instagram_link', 'Instagram Link', array('class' => 'col-md-3 col-form-label')) !!}
        <div class="col-md-9">
            <div class="input-group">
                {!! Form::text('instagram_link', $business->instagram_link, array('id' => 'instagram_link', 'class' => 'form-control', 'placeholder' => 'Please Enter your company Instagram link')) !!}
            </div>
            @if ($errors->has('instagram_link'))
                <span class="help-block">
                    <strong>{{ $errors->first('instagram_link') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group has-feedback row {{ $errors->has('linkedin_link') ? ' has-error ' : '' }}">
        {!! Form::label('linkedin_link', 'Linkedin Link', array('class' => 'col-md-3 col-form-label')) !!}
        <div class="col-md-9">
            <div class="input-group">
                {!! Form::text('linkedin_link', $business->linkedin_link, array('id' => 'linkedin_link', 'class' => 'form-control', 'placeholder' => 'Please Enter your company Linkedin link')) !!}
            </div>
            @if ($errors->has('linkedin_link'))
                <span class="help-block">
                    <strong>{{ $errors->first('linkedin_link') }}</strong>
                </span>
            @endif
        </div>
    </div>

    {!! Form::button('Update Business', array('id' => "business_submit", 'class' => 'btn btn-success margin-bottom-1 mb-1 float-right','type' => 'submit' )) !!}
    {!! Form::close() !!}
</div>