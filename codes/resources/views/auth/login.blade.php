@extends('layouts.website')

@section('meta-seo')
    <title>{{ Config::get('seo.login.title') }}</title>
    <meta name="keywords" content="{{ Config::get('seo.login.keywords') }}">
    <meta name="description" content="{{ Config::get('seo.login.description') }}">
@endsection

@section('headerlinks')
    <style>
        .page-content {
            background-image: url('/images/auth.png');
            background-size: 100% 100%;
            width: 100vw;
            height: 100vh;
            /* background-position: center; */
            background-repeat: no-repeat;
            /* opacity: 0.5; */
            padding-top: 11rem;
        }

        .text-danger {
            color: red;
        }
    </style>
@endsection

@section('content')
    <div class="login-popup" style="margin: auto; background: white;">
        <div class="form-box">
            <div class="tab tab-nav-simple tab-nav-boxed form-tab">
                <ul class="nav nav-tabs nav-fill align-items-center border-no justify-content-center mb-5" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link @if (Session::get('login') == true or Session::get('register') == false) active @endif border-no lh-1 ls-normal"
                            href="#signin">Login</a>
                    </li>
                    <li class="delimiter">or</li>
                    <li class="nav-item">
                        <a class="nav-link @if (Session::get('register') == true) active @endif border-no lh-1 ls-normal"
                            href="#register">Register</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <!-- Login start -->
                    <div class="tab-pane @if (Session::get('login') == true or Session::get('register') == false) active in @endif" id="signin">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="form-group mb-3">
                                <input type="text" class="form-control" name="email" value="{{ old('email') }}"
                                    placeholder="Username or Email Address *" required>
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" name="password" autocomplete="current-password"
                                    placeholder="Password *" required />
                            </div>
                            <div class="form-footer">
                                <div class="form-checkbox">
                                    <input type="checkbox" class="custom-checkbox" id="signin-remember"
                                        name="signin-remember" />
                                    <label class="form-control-label" for="signin-remember">Remember
                                        me</label>
                                </div>
                                <a href="{{ route('password.request') }}" class="lost-link">Forgot password?</a>
                            </div>
                            <div class="form-footer">
                                <a href="{{ route('otp.login') }}" class="lost-link"
                                    style="color: black;font-size: 13px;font-weight: 500;">Login with OTP</a>
                            </div>
                            <button class="btn btn-dark btn-block btn-rounded" type="submit">Login</button>
                        </form>
                        <div class="form-choice text-center">
                            <label class="ls-m">or Login With</label>
                            <div class="social-links">
                                @if (Config::get('icrm.social_auth.google') == true)
                                    <a href="{{ route('auth.redirect', ['client' => 'google']) }}"
                                        class="social-link social-google fab fa-google border-no"></a>
                                @endif

                                @if (Config::get('icrm.social_auth.facebook') == true)
                                    <a href="{{ route('auth.redirect', ['client' => 'facebook']) }}"
                                        class="social-link social-facebook fab fa-facebook-f border-no"></a>
                                @endif
                            </div>
                        </div>
                        {{-- <div class="form-choice text-center mt-2">
                        <label class="ls-m">or Login With</label>
                        <button class="btn btn-dark btn-rounded" style="padding: 10px;">Login with OTP</button>
                    </div> --}}
                    </div>
                    <!-- Login end -->

                    <!-- Register start -->
                    <div class="tab-pane @if (Session::get('register') == true) active in @endif" id="register">
                        <form action="{{ route('register') }}" method="post">
                            @csrf

                            <div class="form-group mb-3">
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}"
                                    placeholder="Your Full Name *" required autofocus />
                            </div>

                            <div class="form-group mb-3">
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}"
                                    placeholder="Your Email Address *" required />
                            </div>

                            <div class="form-group mb-3">
                                <input type="text" class="form-control" name="mobile" value="{{ old('mobile') }}"
                                    placeholder="Your Contact Number *" required />
                            </div>


                            @if (Config::get('icrm.auth.fields.companyinfo') == true)
                                <div class="form-group mb-3">
                                    <input type="text" class="form-control" name="company_name"
                                        value="{{ old('company_name') }}" placeholder="Your Company Name *" required />
                                </div>

                                <div class="form-group mb-3">
                                    <input type="text" class="form-control" name="gst_number"
                                        value="{{ old('gst_number') }}" placeholder="Your Company GST Number *" required />
                                </div>
                            @endif


                            <div class="form-group">
                                <input type="password" class="form-control" name="password" placeholder="Password *"
                                    required autocomplete="new-password" />
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" name="password_confirmation"
                                    placeholder="Confirm Password *" required />
                            </div>
                            <div class="form-footer">
                                <div class="form-checkbox">
                                    <input type="checkbox" class="custom-checkbox" id="register-agree"
                                        name="register-agree" required />
                                    <label class="form-control-label" for="register-agree">I agree to the
                                        privacy policy</label>
                                </div>
                            </div>
                            <button class="btn btn-dark btn-block btn-rounded" type="submit">Register</button>
                        </form>
                        <div class="form-choice text-center">
                            <label class="ls-m">or Register With</label>
                            <div class="social-links">
                                {{-- <a href="{{ route('auth.redirect', ['client' => 'google']) }}"
                                class="social-link social-google fab fa-google border-no"></a>
                            <a href="{{ route('auth.redirect', ['client' => 'facebook']) }}"
                                class="social-link social-facebook fab fa-facebook-f border-no"></a> --}}

                                @if (Config::get('icrm.social_auth.google') == true)
                                    <a href="{{ route('auth.redirect', ['client' => 'google']) }}"
                                        class="social-link social-google fab fa-google border-no"></a>
                                @endif

                                @if (Config::get('icrm.social_auth.facebook') == true)
                                    <a href="{{ route('auth.redirect', ['client' => 'facebook']) }}"
                                        class="social-link social-facebook fab fa-facebook-f border-no"></a>
                                @endif

                                {{-- <a href="#" class="social-link social-twitter fab fa-twitter border-no"></a> --}}
                            </div>
                        </div>
                    </div>
                    <!-- Register end -->
                </div>
            </div>
        </div>
    </div>
@endsection

@section('bottomscripts')
@endsection
