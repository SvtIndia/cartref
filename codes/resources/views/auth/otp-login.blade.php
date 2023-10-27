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
        background-size: cover;
        /* background-position: center; */
        background-repeat: no-repeat;
        /* opacity: 0.5; */
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
                    <a class="nav-link active border-no lh-1 ls-normal" href="#">Login With OTP</a>
                </li>
            </ul>
            <div class="tab-content">
                <!-- Register start -->
                <div class="tab-pane active in" id="register">
                    <form action="{{  route('otp_login') }}" method="post">
                        @csrf
                        <div class="form-group mb-3 d-flex">
                            <span class="mt-1">+91</span>
                            <input type="text" class="form-control ml-1" name="mobile_no" minlength=10
                                placeholder="Your Contact Number *" required />
                        </div>
                        @if(isset($error))
                        <p class="text-danger">{{ $error }}</p>
                        @endif
                        <div class="form-footer">
                            <a href="{{ route('login') }}" class="lost-link" style="color: black;font-size: 12px;">Login
                                with Email</a>
                        </div>
                        <button class="btn btn-dark btn-block btn-rounded" type="submit">Request For OTP</button>
                    </form>

                    {{-- <div class="form-choice text-center mt-2">
                        <label class="ls-m">or Login With</label>
                        <button class="btn btn-dark btn-rounded" style="padding: 10px;">Login with Email</button>
                    </div> --}}
                </div>
                <!-- Register end -->
            </div>
        </div>
    </div>
</div>
@endsection

@section('bottomscripts')

@endsection
