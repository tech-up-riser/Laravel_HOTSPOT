@extends('layouts.default')

@section('template_linked_css')
    <link rel="stylesheet" type="text/css" href="/css/mobile.css">
    <style type="text/css" media="screen">
        h4 {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .auth-footer li{
            list-style: none;
        }
    </style>
@endsection

@section('content')
    <div class="content-wrapper d-flex align-items-center auth auth-bg-1 theme-one">
        <div class="row w-100">
            <div class="col-lg-4 col-xs-12 mx-auto">
                <div class="auth-form-light p-3">
                    <div class="business_logo text-center mt-3">
                        @if(isset($logo))
                            <img src="{{ $logo->path }}" width="250px">
                        @else
                            <img src="/images/logo.png" width="250px">
                        @endif
                    </div>
                    <h4 class="text-center mt-4">Welcome To Our Wifi</h4>
                    @if($setting->facebook == 'on')
                    <div class="col-sm-12 mb-2 mt-4">
                        {!! HTML::icon_link(route('social.redirect',['provider' => 'facebook', 'bzname' => $bzname, 'mac' => $mac_address]), 'fa fa-facebook', $setting->facebook_text , array('class' => 'btn btn-block btn-social btn-facebook')) !!}
                    </div>
                    @endif
                    @if($setting->twitter == 'on')
                    <div class="col-sm-12 mb-2">
                        {!! HTML::icon_link(route('social.redirect',['provider' => 'twitter', 'bzname' => $bzname, 'mac' => $mac_address]), 'fa fa-twitter', $setting->twitter_text, array('class' => 'btn btn-block btn-social btn-twitter')) !!}
                    </div>
                    @endif
                    @if($setting->instagram == 'on')
                    <div class="col-sm-12 mb-2">
                        {!! HTML::icon_link(route('social.redirect',['provider' => 'instagram', 'bzname' => $bzname, 'mac' => $mac_address]), 'fa fa-instagram', $setting->instagram_text, array('class' => 'btn btn-block btn-social btn-instagram')) !!}
                    </div>
                    @endif
                    @if($setting->linkedin == 'on')
                    <div class="col-sm-12 mb-2">
                        {!! HTML::icon_link(route('social.redirect',['provider' => 'linkedin', 'bzname' => $bzname, 'mac' => $mac_address]), 'fa fa-linkedin', $setting->linkedin_text, array('class' => 'btn btn-block btn-social btn-primary')) !!}
                    </div>
                    @endif
                    @if($setting->wechat == 'on')
                        <div class="col-sm-12 mb-2">
                            {!! HTML::icon_link(route('social.redirect',['provider' => 'linkedin', 'bzname' => $bzname, 'mac' => $mac_address]), 'fa fa-wechat', $setting->wechat_text, array('class' => 'btn btn-block btn-social btn-success')) !!}
                        </div>
                    @endif
                    @if($setting->vkontakte == 'on')
                        <div class="col-sm-12 mb-2">
                            {!! HTML::icon_link(route('social.redirect',['provider' => 'linkedin', 'bzname' => $bzname, 'mac' => $mac_address]), 'fa fa-vk', $setting->vkontakte_text, array('class' => 'btn btn-block btn-social btn-info')) !!}
                        </div>
                    @endif
                    <div class="col-sm-12 mb-5">
                        <a href="{{ route('bzuser.login.account', ['bzname' => $bzname, 'mac' => $mac_address]) }}" class="btn btn-block btn-social btn-google">
                            <i aria-hidden="true" class="fa fa-google"></i>
                            Sign In With Account
                        </a>
                    </div>
                    <ul class="auth-footer text-black text-center">
                        <li>
                            <span>Powered by ChimpLinks</span>
                        </li>
                    </ul>
                    <p class="text-center"><span>By proceeding you agree to the following <br/><a href="#">Terms and Conditions</a></span></p>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('footer_scripts')
    <script type="text/javascript">

        var mac_address = "{{ $mac_address }}";

        if(mac_address) {
            console.log("called by ");
            $.ajax({
                url: '{{ route("bzuser.mac.check", ['bzname' => $bzname]) }}',
                data: {_token: '{!! csrf_token() !!}', mac: mac_address},
                dataType: 'json',
                cache: false,
                type: 'POST', // For jQuery < 1.9
                success: function (data) {
                    if(data.success == 1) {
                        location.href = 'https://chimplinkswifi.com/business/' + data.bzname + '/home';
                    }
                },
                error: function (xhr, status, error) {

                }
            });
        }
    </script>
@endsection
