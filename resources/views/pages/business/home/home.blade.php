@extends('layouts.default')

@section('template_linked_css')
    <link rel="stylesheet" type="text/css" href="/css/mobile.css">
    <style type="text/css" media="screen">
        .auth-footer li{
            list-style: none;
        }

        .btn-social {
            line-height: 6px !important;
        }
    </style>
@endsection

@section('content')
    <div class="content-wrapper d-flex align-items-center auth auth-bg-1 theme-one">
        <div class="row w-100">
            <div class="col-lg-4 col-xs-12 mx-auto">
                <div class="auth-form-light p-3">
                    <div class="business_logo text-center">
                        @if(isset($logo))
                            <img src="{{ $logo->path }}" width="250px">
                        @else
                            <img src="/images/logo.png" width="250px">
                        @endif
                    </div>

                    <h4 class="text-center">Hi {{ $user }}</h4>
                    <h4 class="text-center">Welcome To <span class="text-primary">{{ $business }}</span></h4>

                    <div class="business_promotion text-center mt-3">
                        @if(isset($promotion))
                            <img src="{{ $promotion->path }}" width="350px" class="promotion-img">
                        @else
                            <img src="/images/promotion.jpg" width="350px" class="promotion-img">
                        @endif
                    </div>

                    <div class="text-center mt-3">
                        @if($provider == 'facebook')
                            <!-- Load Facebook SDK for JavaScript -->
                                <div id="fb-root"></div>
                                <div class="fb-like" data-href="https://developers.facebook.com/docs/plugins/" data-layout="button_count" data-action="like" data-size="large" data-show-faces="true" data-share="true"></div>
                        @elseif($provider == 'twitter')
                                <a class="twitter-follow-button btn btn-social btn-twitter" href="https://twitter.com/chimplinks" data-size="large"><i aria-hidden="true" class="fa fa-twitter"></i>Follow</a>
                                <a class="twitter-share-button btn btn-social btn-twitter" href="https://twitter.com/intent/tweet?text=Hello%20world" data-size="large">Tweet</a>
                        @elseif($provider == 'instagram')
                            <button type="button" class="btn btn-social btn-instagram"><i aria-hidden="true" class="fa fa-instagram"></i>&nbsp;&nbsp;Like</button>
                            &nbsp;&nbsp;<button type="button" class="btn btn-social btn-instagram"><i class="fa fa-share-square"></i>Share</button>
                        @elseif($provider == 'linkedin')
                            <button type="button" class="btn btn-social btn-warning"><i aria-hidden="true" class="fa fa-linkedin"></i>&nbsp;&nbsp;Like</button>
                            &nbsp;&nbsp;<button type="button" class="btn btn-social btn-warning"><i class="fa fa-share-square"></i>Share</button>
                        @endif
                    </div>

                    <div class="text-center mt-3">
                        <form action="{{ route('admin.authenticate') }}" method="post" >
                            {{ csrf_field() }}
                            <input type="hidden" name="username" value="username">
                            <input type="hidden" name="password" value="password">
                            <input type="hidden" name="challenge" value="">
                            <input type="hidden" name="uamip" value="10.1.0.1">
                            <input type="hidden" name="uamport" value="3990">
                            <input type="hidden" name="userurl" value="URL SET FROM ADMIN PANEL">
                            <button type="submit" class="btn btn-success">Continue To Internet</button>
                        </form>
                    </div>
                    <ul class="auth-footer text-black text-center mt-4">
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
        var mac_address = "{{ isset($mac) ? $mac: 0 }}";
        if(mac_address) {
            window.localStorage.setItem('mac_address', mac_address);
        }
    </script>
    <script>
        (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = 100010854484463;
            js.src = 'https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v3.1&appId=228188950921026&autoLogAppEvents=1';
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>
@endsection