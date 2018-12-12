@extends('layouts.admin')

@section('template_title')
    Welcome {{ Auth::user()->name }}
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-12 col-lg-10 offset-lg-1">

                @include('panels.welcome-panel')

            </div>
        </div>
    </div>

@endsection
