<div class="header-mini">
    <div class="container">
        <div class="logo">
            <a href="{{ route('welcome') }}">
                <img src="{{ Voyager::image(setting('site.logo')) }}" alt="{{ setting('site.title') }}">
            </a>
        </div>
        <div class="navs">
            @if (\Request::route()->getName() != 'login')
            <ul>
                <li class="@if(\Request::route()->getName() == 'register') active @endif">
                    <a href="{{ route('register') }}">Sign Up</a>
                </li>
                
                @if (Config::get('icrm.auth.otp_verification') == 1)
                    <li class="@if(\Request::route()->getName() == 'register.otpverification') active @endif">
                        <a href="{{ route('register.otpverification') }}">OTP</a>
                    </li>
                @endif

                @if (Config::get('icrm.auth.email_verification') == 1)
                    <li class="@if(\Request::route()->getName() == 'verification.notice') active @endif">
                        <a href="{{ route('verification.notice') }}">Activate</a>
                    </li>
                @endif
                <li>
                    <a href="">Get Started</a>
                </li>
            </ul>
            @endif
        </div>
        <div class="trust">
            <img src="{{ asset('images/secured.png') }}" alt="">
            <span>100% SECURE</span>
        </div>
    </div>
</div>