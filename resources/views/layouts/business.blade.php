<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- CSRF Token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@if (trim($__env->yieldContent('template_title')))@yield('template_title') | @endif {{ config('app.name', Lang::get('titles.app')) }}</title>
    <meta name="description" content="">
    <meta name="author" content="Heng Sokom">
    <link rel="shortcut icon" href="/favicon.ico">

    {{-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries --}}
        <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    {{-- Fonts --}}
    @yield('template_linked_fonts')

    {{-- Styles --}}
    <link href="{{ mix('/css/app.css') }}" rel="stylesheet">
    <link href="/css/style.css" rel="stylesheet">
    <link href="/css/materialdesignicons.min.css" rel="stylesheet">

    @yield('template_linked_css')

    <style type="text/css">
        @yield('template_fastload_css')

            @if (Auth::User() && (Auth::User()->profile) && (Auth::User()->profile->avatar_status == 0))
                .user-avatar-nav {
            background: url({{ Gravatar::get(Auth::user()->email) }}) 50% 50% no-repeat;
            background-size: auto 100%;
        }
        @endif

    </style>

    {{-- Scripts --}}
    <script>
        window.Laravel = {!! json_encode([
                'csrfToken' => csrf_token(),
            ]) !!};
    </script>

    @yield('head')

</head>

<body>
<div class="container-scroller" id="app">
    <!-- partial:partials/_navbar.html -->
    <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
        <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
            <a class="navbar-brand brand-logo" href="{{ route('business.admin.dashboard', ['bzname' => $bzname]) }}"><img src="/images/logo.png" style="width: 200px; height: 50px;" alt="logo"/></a>
            <a class="navbar-brand brand-logo-mini" href="{{ route('business.admin.dashboard', ['bzname' => $bzname]) }}"><img src="/images/logo-mini.png" style="width: 200px; height: 50px;" alt="logo"/></a>
        </div>
        <div class="navbar-menu-wrapper d-flex align-items-stretch">
            <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize" id="sidebar_minimizer">
                <span class="mdi mdi-menu"></span>
            </button>
            <div class="search-field d-none d-md-block">
                <form class="d-flex align-items-center h-100" action="#">
                    <div class="input-group">
                        <div class="input-group-prepend bg-transparent">
                            <i class="input-group-text border-0 mdi mdi-magnify"></i>
                        </div>
                        <input type="text" class="form-control bg-transparent border-0" placeholder="Search projects">
                    </div>
                </form>
            </div>
            <ul class="navbar-nav navbar-nav-right">
                <li class="nav-item nav-profile dropdown">
                    <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
                        <div class="nav-profile-img">
                            <img src="/images/faces/face1.jpg" alt="image">
                            <span class="availability-status online"></span>
                        </div>
                        <div class="nav-profile-text">
                            <p class="mb-1 text-black">Hello, {{ $user->first_name.' '.$user->last_name }} !</p>
                        </div>
                    </a>
                    <div class="dropdown-menu navbar-dropdown" aria-labelledby="profileDropdown">
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('business.admin.logout', ['bzname' => $bzname]) }}">
                            <i class="mdi mdi-logout mr-2 text-primary"></i>
                            Signout
                        </a>
                    </div>
                </li>
            </ul>
            <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
                <span class="mdi mdi-menu"></span>
            </button>
        </div>
    </nav>

    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_sidebar.html -->
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
            <ul class="nav">
                <li class="nav-item nav-profile">
                    <a href="#" class="nav-link">
                        <div class="nav-profile-image">
                            <img src="/images/faces/face1.jpg" alt="profile">
                            <span class="login-status online"></span> <!--change to offline or busy as needed-->
                        </div>
                        <div class="nav-profile-text d-flex flex-column">
                            <span class="font-weight-bold mb-2">{{ $user->first_name.' '.$user->last_name }} </span>
                            <span class="text-secondary text-small">Business Admin</span>
                        </div>
                        <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('business.admin.dashboard', ['bzname' => $bzname]) }}">
                        <span class="menu-title">Dashboard</span>
                        <i class="mdi mdi-home menu-icon"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
                        <span class="menu-title">My Business</span>
                        <i class="menu-arrow"></i>
                        <i class="mdi mdi-content-copy menu-icon"></i>
                    </a>
                    <div class="collapse" id="auth">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('business.admin.business.logo', ['bzname' => $bzname]) }}">Logo Setting</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('business.admin.business.login_setting', ['bzname' => $bzname]) }}">Login Setting</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('business.admin.business.promotion', ['bzname' => $bzname]) }}">Promotion Image Upload</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('business.admin.business.edit', ['bzname' => $bzname]) }}">Edit My Business</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('business.admin.business.preview', ['bzname' => $bzname]) }}">Home Page Mobile View</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('business.admin.business.setting', ['bzname' => $bzname]) }}">Promotion Image Setting</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('business.admin.users', ['bzname' => $bzname]) }}">
                        <span class="menu-title">Users</span>
                        <i class="menu-icon mdi mdi-account"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- partial -->
        <div class="main-panel">
            @yield('content')

            <footer class="footer">
                <div class="container-fluid clearfix">
                    <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © 2018
                      <a href="http://www.bootstrapdash.com/" target="_blank">Bootstrapdash</a>. All rights reserved.</span>
                            <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted & made with
                      <i class="mdi mdi-heart text-danger"></i>
                    </span>
                </div>
            </footer>
        </div>
    </div>
</div>

{{-- Scripts --}}
<script src="{{ mix('/js/app.js') }}"></script>
<script src="/js/off-canvas.js"></script>
<script src="/js/hoverable_collapse.js"></script>
<script src="/js/misc.js"></script>
<script src="/js/settings.js"></script>
<script src="/js/todolist.js"></script>
@yield('footer_scripts')
</body>

</html>