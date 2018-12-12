@extends('layouts.business')

@section('template_linked_css')
    <style type="text/css" media="screen">
        #mobile_preview, #login_preview {
            width: 299.6px;
            height: 622.3px;
            overflow: hidden;
            transform-origin: 0px 0px 0px;
            margin: 0 auto;
        }

        #mobile_preview_div, #login_preview_div {
            position: relative;
            top: 0px;
            left: 0px;
            width: 428px;
            height: 889px;
            background: none;
            transform-origin: 0px 0px 0px; transform: scale(0.7);
        }

        #mobile_img, #login_img {
            position: absolute;
            top: 0px;
            left: 0px;
            width: 100%;
            height: 100%;
        }

        #mobile_frame, #login_frame {
            position: absolute;
            top: 109px;
            left: 26.5px;
            width: 375px;
            height: 669px;
            border: 0px;
        }
    </style>
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header bg-gradient-primary text-white">
                        <h4>Home Preview on Mobile</h4>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 col-xs-12">
                                <div id="login_preview">
                                    <div id="login_preview_div">
                                        <img src="http://beeker.io/images/posts/3/iphone6_front_white.png" id="login_img">
                                        <iframe src="https://chimplinkswifi.com/business/{{ $bzname }}/login" class="bio-mp-screen" id="login_frame"></iframe>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-xs-12">
                                <div id="mobile_preview">
                                    <div id="mobile_preview_div">
                                        <img src="http://beeker.io/images/posts/3/iphone6_front_white.png" id="mobile_img">
                                        <iframe src="https://chimplinkswifi.com/business/{{ $bzname }}/admin/business/home" class="bio-mp-screen" id="mobile_frame"></iframe>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer_scripts')
    <script type="text/javascript">
    </script>
@endsection
