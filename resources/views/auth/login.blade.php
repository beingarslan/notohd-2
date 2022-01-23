@php
$configData = Helper::applClasses();
@endphp
@extends('layouts/fullLayoutMaster')

@section('title', 'Login')

@section('page-style')
{{-- Page Css files --}}
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('css/base/pages/authentication.css')) }}">
@endsection

@section('content')
<div class="auth-wrapper auth-cover">
    <div class="auth-inner row m-0">
        <!-- Brand logo-->
        <a class="brand-logo" href="#">

            <h2 class="brand-text text-primary ms-1">{{env('APP_NAME')}}</h2>
        </a>
        <!-- /Brand logo-->

        <!-- Left Text-->
        <div class="d-none d-lg-flex col-lg-8 align-items-center p-5">
            <div class="w-100 d-lg-flex align-items-center justify-content-center px-5">
                @if($configData['theme'] === 'dark')
                <img class="img-fluid" src="{{asset('images/pages/login-v2-dark.svg')}}" alt="Login V2" />
                @else
                <img class="img-fluid" src="{{asset('images/pages/login-v2.svg')}}" alt="Login V2" />
                @endif
            </div>
        </div>
        <!-- /Left Text-->

        <!-- Login-->
        <div class="d-flex col-lg-4 align-items-center auth-bg px-2 p-lg-5">
            <div class="col-12 col-sm-8 col-md-6 col-lg-12 px-xl-2 mx-auto">
                <h2 class="card-title fw-bold mb-1">Welcome to {{env('APP_NAME')}}! 👋</h2>
                <p class="card-text mb-2">Please sign-in to your account and start the adventure</p>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-1">
                        <label class="form-label" for="login-email">Email</label>
                        <input class="form-control @error('email') is-invalid @enderror" id="login-email" type="text" name="email" placeholder="Email" aria-describedby="login-email" autofocus="" tabindex="1" />
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="mb-1">
                        <div class="d-flex justify-content-between">
                            <label class="form-label" for="login-password">Password</label>
                            <a href="{{ route('password.request') }}">
                                <small>Forgot Password?</small>
                            </a>
                        </div>
                        <div class="input-group input-group-merge form-password-toggle">
                            <input class="form-control form-control-merge  @error('password') is-invalid @enderror" id="login-password" type="password" name="password" placeholder="············" aria-describedby="login-password" tabindex="2" />
                            <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>

                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-1">
                        <div class="form-check">
                            <input class="form-check-input" name="remember" id="remember-me" type="checkbox" tabindex="3" />
                            <label class="form-check-label" for="remember-me"> Remember Me</label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100" tabindex="4">Sign in</button>
                </form>
                <p class="text-center mt-2">
                    <span>New on our platform?</span>
                    <a href="/register"><span>&nbsp;Create an account</span></a>
                </p>

            </div>
        </div>
        <!-- /Login-->
    </div>
</div>
@endsection

@section('vendor-script')
<script src="{{asset(mix('vendors/js/forms/validation/jquery.validate.min.js'))}}"></script>
@endsection

@section('page-script')
<script src="{{asset(mix('js/scripts/pages/auth-login.js'))}}"></script>
@endsection
