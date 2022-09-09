@extends('layouts.authentication.master')
@section('title', 'Login')

@section('css')
@endsection

@section('style')
@endsection

@section('content')
    <div class="container-fluid p-0">
        <div class="row m-0">
            <div class="col-12 p-0">
                <div class="login-card">
                    <div>
                        <div>
                            <a class="logo" href="{{ url('index') }}">
                                <h3 class="txt-primary ">{{config('global.project_name')}} </h3>
                                <h5 class="txt-primary ">{{config('global.project_shortname')}} </h5>
                            </a>
                        </div>
                        <div class="login-main">
                                <form method="POST" class="theme-form" action="{{ route('login') }}">
                                    @csrf
                                <h4>Sign in to account</h4>
                                <p>Enter your email & password to login</p>
                                    <!-- Session Status -->
                                    <x-auth-session-status class="mb-4 txt-danger" :status="session('status')" />
                                    <!-- Validation Errors -->
                                    <x-auth-validation-errors class="mb-4 txt-danger" :errors="$errors" />

                                <div class="form-group">
                                    <label class="col-form-label" for="email">Email Address</label>
                                    <input class="form-control" type="email" name="email" id="email"
                                           required="" autofocus placeholder="test@aku.edu">
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label" for="password">Password</label>
                                    <input class="form-control" id="password" type="password" name="password" required=""
                                           placeholder="*********"  autocomplete="current-password">
                                    <div class="show-hide"><span class="show"></span></div>
                                </div>
                                    <input type="hidden" name="recaptcha" id="recaptcha">
                                <div class="form-group mb-0">
                                    <div class="checkbox p-0">
                                        <input id="remember_me" type="checkbox" name="remember">
                                        <label class="text-muted" for="remember_me">{{ __('Remember me') }}</label>
                                    </div>
                                    <!-- @if (Route::has('password.request'))
                                    <a class="link" href="{{ route('password.request') }}"> {{ __('Forgot your password?') }}</a>
                                    @endif -->
                                    <button class="btn btn-primary w-100" type="submit"
                                    >Sign in</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.sitekey') }}"></script>
    <script>
        grecaptcha.ready(function() {
            grecaptcha.execute('{{ config('services.recaptcha.sitekey') }}', {action: 'contact'}).then(function(token) {
                if (token) {
                    document.getElementById('recaptcha').value = token;
                }
            });
        });
    </script>
@endsection
