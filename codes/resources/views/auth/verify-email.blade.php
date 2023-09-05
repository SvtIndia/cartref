@extends('layouts.website')

@section('meta-seo')
    <title>{{ Config::get('seo.verify_email.title') }}</title>
    <meta name="keywords" content="{{ Config::get('seo.verify_email.keywords') }}">
    <meta name="description" content="{{ Config::get('seo.verify_email.description') }}">
@endsection

@section('css')

@endsection

@section('content')
<div class="login-popup" style="margin: auto;">
    <div class="form-box">
        <div class="tab tab-nav-simple tab-nav-boxed form-tab">
            <ul class="nav nav-tabs nav-fill align-items-center border-no justify-content-center mb-5" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active border-no lh-1 ls-normal" href="#signin">Verify Email</a>
                </li>
                {{-- <li class="delimiter">or</li>
                <li class="nav-item">
                    <a class="nav-link border-no lh-1 ls-normal" href="#register">Register</a>
                </li> --}}
            </ul>
            
            <p style="color: rgba(0, 0, 0, 0.511);">Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, we will gladly send you another.</p>
            <p style="color: red;">Request you to open the validation link on this system/browser itself.</p>
            @if (session('status') == 'verification-link-sent')
                <br>
                <div class="alert alert-success alert-dark alert-round alert-inline">
                    <h4 class="alert-title">Success :</h4>
                    A new verification link has been sent to the email address you provided during registration.
                    <button type="button" class="btn btn-link btn-close">
                        <i class="d-icon-times"></i>
                    </button>
                </div>
            @endif
    
            <div class="tab-content">
                <!-- Login start -->
                <div class="tab-pane active" id="signin">

                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
        
                        <div>
                            <button type="submit" class="btn btn-dark btn-block btn-rounded">
                                Resend Verification Email
                            </button>
                            
                        </div>
                    </form>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
        
                        <button type="submit" class="btn btn-link btn-block btn-rounded"">
                            {{ __('Log Out') }}
                        </button>
                    </form>

                    {{-- <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group mb-3">
                            <input type="text" class="form-control" name="email" value="{{ old('email') }}" placeholder="Username or Email Address *" required>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" name="password" autocomplete="current-password" placeholder="Password *"
                                required />
                        </div>
                        <div class="form-footer">
                            <div class="form-checkbox">
                                <input type="checkbox" class="custom-checkbox" id="signin-remember"
                                    name="signin-remember" />
                                <label class="form-control-label" for="signin-remember">Remember
                                    me</label>
                            </div>
                            <a href="#" class="lost-link">Forgot password?</a>
                        </div>
                        <button class="btn btn-dark btn-block btn-rounded" type="submit">Login</button>
                    </form> --}}
                </div>
                <!-- Login end -->
            </div>
        </div>
    </div>
</div>
@endsection

@section('bottomscripts')

@endsection
