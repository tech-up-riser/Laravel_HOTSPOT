@extends('layouts.default')

@section('template_linked_css')
    <link rel="stylesheet" type="text/css" href="/css/mobile.css">
    <style type="text/css" media="screen">
        h4 {
            color: #b66dff;
            font-size: 20px;
            font-weight: 500;
            margin-bottom: 20px;
        }

        .auth-footer {
            display: flex;
        }

        .auth-footer li{
            padding-right: 50px;
            list-style: none;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth auth-bg-1 theme-one">
        <div class="row w-100">
            <div class="col-lg-4 mx-auto">
                <div class="auth-form-light p-5">
                    <h4 class="text-center">Admin Login</h4>
                    <form action="{{ route('admin.authenticate') }}" method="post" >
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label class="label">Email</label>
                            <div class="input-group">
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
                            <button type="submit" class="btn btn-gradient-primary submit-btn btn-block">Login</button>
                        </div>
                        <div class="form-group d-flex justify-content-between">
                            <div class="form-check form-check-flat mt-0">
                                <label class="form-check-label">
                                    <input type="checkbox" class="form-check-input" checked> Keep me signed in
                                </label>
                            </div>
                            <a href="#" class="text-small forgot-password text-black">Forgot Password</a>
                        </div>
                    </form>
                    <ul class="auth-footer">
                        <li>
                            <a href="#">Conditions</a>
                        </li>
                        <li>
                            <a href="#">Help</a>
                        </li>
                        <li>
                            <a href="#">Terms</a>
                        </li>
                    </ul>
                    <p class="footer-text text-center">copyright © 2018 Hotspot. All rights reserved.</p>
                </div>
            </div>
        </div>
    </div>
    </div>

@endsection
