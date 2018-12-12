@extends('layouts.business')

@section('template_linked_css')
    <style type="text/css" media="screen">
        h4 {
            color: #dddddd;
        }

        #toggle_event_editing {
            border: 1px solid #ebedf2;
            display: inline-block;
        }

        #toggle_event_editing #facebook_on_button, #twitter_on_button, #linkedin_on_button, #instagram_on_button, #wechat_on_button, #vkontakte_on_button{
            margin-left: 50px;
        }

        #toggle_event_editing i {
            font-size: 30px !important;
            position: absolute;
            padding: 6px 10px;
        }

        .login-texts {
            display: inline-block;
            margin-left: 30px;
        }
    </style>
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Facebook Setting</h4>
                        <div class="btn-group ml-5" id="toggle_event_editing">
                            <i class="mdi mdi-facebook text-info icon-lg"></i>
                            <button type="button" id="facebook_on_button" class="btn @if(isset($setting)) @if($setting->facebook == 'on') ? btn-info locked_active : btn-default unlocked_inactive @endif @else btn-info locked_active @endif">ON</button>
                            <button type="button" id="facebook_off_button" class="btn @if(isset($setting)) @if($setting->facebook == 'off') ? btn-info locked_active : btn-default unlocked_inactive @endif @else btn-default unlocked_inactive @endif">OFF</button>
                        </div>
                        <div class="login-texts">
                            <div class="row">
                                <label for="facebook_text" class="col-sm-3 col-form-label">Texts</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="facebook_text" placeholder="Facebook" value="{{ isset($setting) ? $setting->facebook_text : '' }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <h4 class="card-title">Twitter Setting</h4>
                        <div class="btn-group ml-5" id="toggle_event_editing">
                            <i class="mdi mdi-twitter text-warning"></i>
                            <button type="button" id="twitter_on_button" class="btn @if(isset($setting)) @if($setting->twitter == 'on') ? btn-info locked_active : btn-default unlocked_inactive @endif @else btn-info locked_active @endif">ON</button>
                            <button type="button" id="twitter_off_button" class="btn @if(isset($setting)) @if($setting->twitter == 'off') ? btn-info locked_active : btn-default unlocked_inactive @endif @else btn-default unlocked_inactive @endif">OFF</button>
                        </div>
                        <div class="login-texts">
                            <div class="row">
                                <label for="twitter_text" class="col-sm-3 col-form-label">Texts</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="twitter_text" placeholder="Twitter" value="{{ isset($setting) ? $setting->twitter_text : '' }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <h4 class="card-title">Instagram Setting</h4>
                        <div class="btn-group ml-5" id="toggle_event_editing">
                            <i class="mdi mdi-instagram text-primary"></i>
                            <button type="button" id="instagram_on_button" class="btn @if(isset($setting)) @if($setting->instagram == 'on') ? btn-info locked_active : btn-default unlocked_inactive @endif @else btn-info locked_active @endif">ON</button>
                            <button type="button" id="instagram_off_button" class="btn @if(isset($setting)) @if($setting->instagram == 'off') ? btn-info locked_active : btn-default unlocked_inactive @endif @else btn-default unlocked_inactive @endif">OFF</button>
                        </div>
                        <div class="login-texts">
                            <div class="row">
                                <label for="instagram_text" class="col-sm-3 col-form-label">Texts</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="instagram_text" placeholder="Instagram" value="{{ isset($setting) ? $setting->instagram_text : '' }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <h4 class="card-title">Linkedin Setting</h4>
                        <div class="btn-group ml-5" id="toggle_event_editing">
                            <i class="mdi mdi-linkedin text-info"></i>
                            <button type="button" id="linkedin_on_button" class="btn @if(isset($setting)) @if($setting->linkedin == 'on') ? btn-info locked_active : btn-default unlocked_inactive @endif @else btn-info locked_active @endif">ON</button>
                            <button type="button" id="linkedin_off_button" class="btn @if(isset($setting)) @if($setting->linkedin == 'off') ? btn-info locked_active : btn-default unlocked_inactive @endif @else btn-default unlocked_inactive @endif">OFF</button>
                        </div>
                        <div class="login-texts">
                            <div class="row">
                                <label for="linkedin_text" class="col-sm-3 col-form-label">Texts</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="linkedin_text" placeholder="Linkedin" value="{{ isset($setting) ? $setting->linkedin_text : '' }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <h4 class="card-title">Wechat Setting</h4>
                        <div class="btn-group ml-5" id="toggle_event_editing">
                            <i class="mdi mdi-wechat text-success"></i>
                            <button type="button" id="wechat_on_button" class="btn @if(isset($setting)) @if($setting->wechat == 'on') ? btn-info locked_active : btn-default unlocked_inactive @endif @else btn-info locked_active @endif">ON</button>
                            <button type="button" id="wechat_off_button" class="btn @if(isset($setting)) @if($setting->wechat == 'off') ? btn-info locked_active : btn-default unlocked_inactive @endif @else btn-default unlocked_inactive @endif">OFF</button>
                        </div>
                        <div class="login-texts">
                            <div class="row">
                                <label for="wechat_text" class="col-sm-3 col-form-label">Texts</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="wechat_text" placeholder="Wechat" value="{{ isset($setting) ? $setting->wechat_text : '' }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <h4 class="card-title">Vkontakte Setting</h4>
                        <div class="btn-group ml-5" id="toggle_event_editing">
                            <i class="mdi mdi-vk text-info"></i>
                            <button type="button" id="vkontakte_on_button" class="btn @if(isset($setting)) @if($setting->vkontakte == 'on') ? btn-info locked_active : btn-default unlocked_inactive @endif @else btn-info locked_active @endif">ON</button>
                            <button type="button" id="vkontakte_off_button" class="btn @if(isset($setting)) @if($setting->vkontakte == 'off') ? btn-info locked_active : btn-default unlocked_inactive @endif @else btn-default unlocked_inactive @endif">OFF</button>
                        </div>
                        <div class="login-texts">
                            <div class="row">
                                <label for="vkontakte_text" class="col-sm-3 col-form-label">Texts</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="vkontakte_text" placeholder="Vkontakte" value="{{ isset($setting) ? $setting->vkontakte_text : '' }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="text-right mr-5">
                            <button type="button" id="save_texts" class="btn btn-gradient-success btn-fw">Save Texts</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('footer_scripts')
    @include('pages.business_admin.partials.js')
@endsection
