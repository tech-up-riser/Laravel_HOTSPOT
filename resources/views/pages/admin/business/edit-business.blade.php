@extends('layouts.admin')

@section('template_linked_css')
    <style type="text/css" media="screen">
        .help-block {
            font-size: 13px;
            color: #e65251;
            font-weight: 300;
        }

        #create_business li {
            width: 33.3%;
            padding: 8px 25px;
            font-size: 18px;
            border-radius: 4px;
            background-color: rgba(255, 175, 0, 0.2);
            border-color: rgba(255, 175, 0, 0);
            border-right: 2px solid rgb(242, 248, 249) !important;
        }

        #create_business li.active {
            background-color: #ffaf00 !important;
            border-color: #ffaf00;
        }

        #create_business a {
            color: #ffaf00;
        }

        #create_business a.active {
            color: #ffffff !important;
        }

        #create_business a:hover {
            cursor: pointer;
            text-decoration: none;
        }

        .error {
            font-size: 13px;
            color: #e65251;
            display: block !important;
        }

        .tab-content {
            border: 0px white !important;
        }
    </style>
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-10 offset-lg-1">
                <ul class="nav nav-tabs m-b-2" id="create_business">
                    <li class="active">
                        <a href="#new_business" id="li_create_business" data-toggle="tab" class="active show">Edit Business</a>
                    </li>
                    <li>
                        <a href="#business_admin" id="li_business_admin" data-toggle="tab">Edit Business Admin</a>
                    </li>
                    <li>
                        <a href="#business_setting" id="li_business_setting" data-toggle="tab">Setting</a>
                    </li>
                </ul>
                <div class="card">
                    <div class="card-body">
                        <div class="tab-content clearfix">
                            <div class="tab-pane active" id="new_business">
                                @include('pages.admin.partials.business_edit')
                            </div>
                            <div class="tab-pane" id="business_admin">
                                @include('pages.admin.partials.business_admin_edit')
                            </div>
                            <div class="tab-pane" id="business_setting">
                                @include('pages.admin.partials.business_admin_setting')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('footer_scripts')
    @include('pages.admin.partials.js')
    @include('partials.js')

    <script type="text/javascript">
        $("#li_create_business").click(function(e) {
            $("#create_business a.active").parent().removeClass('active');
            $("#li_create_business").parent().addClass('active');
        });

        $("#li_business_admin").click(function(e) {
            $("#create_business a.active").parent().removeClass('active');
            $("#li_business_admin").parent().addClass('active');
        });

        $("#li_business_setting").click(function(e) {
            $("#create_business a.active").parent().removeClass('active');
            $("#li_business_setting").parent().addClass('active');
        });

        get_years();
        get_countries();
    </script>
@endsection
