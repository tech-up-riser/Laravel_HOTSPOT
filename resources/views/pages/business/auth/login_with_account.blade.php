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
                <div class="auth-form-light p-5">
                    <div class="business_logo text-center">
                        @if(isset($logo))
                            <img src="{{ $logo->path }}" width="250px">
                        @else
                            <img src="/images/logo.png" width="250px">
                        @endif
                    </div>
                    <h4 class="text-center mt-4">Welcome To Our Wifi</h4>
                    <form action="{{ route('bzuser.authenticate', ['bzname' => $bzname]) }}" method="post" >
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label class="label">Email</label>
                            <div class="input-group">
                                <input type="hidden" name="mac" value="{{ $mac_address }}">
                                <input type="text" class="form-control" placeholder="Email" name="email">
                                <div class="input-group-append">
                                  <span class="input-group-text">
                                    <i class="mdi mdi-check-circle-outline"></i>
                                  </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="label">Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" placeholder="*********" name="password">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="mdi mdi-check-circle-outline"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary submit-btn btn-block">Login</button>
                        </div>
                        <div class="form-group">
                            <div class="row">
                            <div class="col-md-12 d-inline-flex">
                                <div class="col-md-6">
                                    <a href="{{ route('bzuser.login', ['bzname' => $bzname, 'mac' => $mac_address]) }}" class="text-small forgot-password text-black">Log In With Social</a>
                                </div>
                                <div class="col-md-6 text-right">
                                    <a href="{{ route('bzuser.register', ['bzname' => $bzname, 'mac' => $mac_address]) }}" class="text-small forgot-password text-black">Register Here</a>
                                </div>
                            </div>
                            </div>
                        </div>
                    </form>
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
    <script src="/js/device-uuid.js" type="text/javascript"></script>
    <script type="text/javascript">

        var mac_address = "{{ $mac_address }}";

        if(mac_address) {
            $.ajax({
                url: '{{ route("bzuser.mac.check", ['bzname' => $bzname]) }}',
                data: {_token: '{!! csrf_token() !!}', mac: mac_address},
                dataType: 'json',
                cache: false,
                type: 'POST', // For jQuery < 1.9
                success: function (data) {
                    if(data.success == 1) {
                        location.href = 'http://dev.chimplinks.com/business/' + data.bzname + '/home';
                    }
                },
                error: function (xhr, status, error) {

                }
            });
        }
    </script>
@endsection
