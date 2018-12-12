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
        html{
            height: 100% !important;
        }
        body, #app, .content-wrapper{
            min-height: 100vh;
        }
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
    @yield('content')
</div>
<!-- container-scroller -->
{{-- Scripts --}}
<script src="{{ mix('/js/app.js') }}"></script>
@yield('footer_scripts')
</body>

</html>