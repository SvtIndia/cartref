@extends('layouts.website')

@section('meta-seo')
    <title>{{ Config::get('seo.forgot_password.title') }}</title>
    <meta name="keywords" content="{{ Config::get('seo.forgot_password.keywords') }}">
    <meta name="description" content="{{ Config::get('seo.forgot_password.description') }}">
@endsection

@section('css')

@endsection

@section('content')
<div class="login-popup" style="margin: auto;">
    <div class="form-box">
        <div class="tab tab-nav-simple tab-nav-boxed form-tab">
            <ul class="nav nav-tabs nav-fill align-items-center border-no justify-content-center mb-5" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active border-no lh-1 ls-normal" href="#signin">Forgot Password</a>
                </li>
                {{-- <li class="delimiter">or</li>
                <li class="nav-item">
                    <a class="nav-link border-no lh-1 ls-normal" href="#register">Register</a>
                </li> --}}
            </ul>
            
            <p style="color: rgba(0, 0, 0, 0.511);">
                Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.
            </p>
            
            @if (session('status'))
                <div class="alert alert-success alert-simple alert-inline">
                    <h4 class="alert-title">Success :</h4>
                    {{ session('status') }}
                    <button type="button" class="btn btn-link btn-close">
                        <i class="d-icon-times"></i>
                    </button>
                </div>
                <br>
            @endif

    
            <div class="tab-content">
                <!-- Login start -->
                <div class="tab-pane active" id="signin">

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
            
                        <!-- Email Address -->
                        <div class="form-group mb-3">
                            <input type="text" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="Username or Email Address *" required autofocus>
                        </div>
                        
                        <button class="btn btn-dark btn-block btn-rounded" type="submit">Email Password Reset Link</button>
                    </form>

                    <p>Don't have an account? <a href="{{ route('login') }}" style="color: blue;">Signup Now</a></p>


                    <div class="form-choice text-center">
                        <label class="ls-m">Or Register With</label>
                        <div class="social-links">
                            @if (Config::get('icrm.social_auth.google') == true)
                                <a href="{{ route('auth.redirect', ['client' => 'google']) }}" class="social-link social-google fab fa-google border-no"></a>    
                            @endif
                            
                            @if (Config::get('icrm.social_auth.facebook') == true)
                                <a href="{{ route('auth.redirect', ['client' => 'facebook']) }}" class="social-link social-facebook fab fa-facebook-f border-no"></a>
                            @endif
                            {{-- <a href="#" class="social-link social-twitter fab fa-twitter border-no"></a> --}}
                        </div>
                    </div>
                </div>
                <!-- Login end -->
            </div>
        </div>
    </div>
</div>
@endsection

@section('bottomscripts')

@endsection
