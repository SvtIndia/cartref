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
        padding-top: 16rem;
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
                    <a class="nav-link active border-no lh-1 ls-normal" href="#">Enter OTP</a>
                </li>
            </ul>
            <div class="tab-content">
                <!-- Register start -->
                <div class="tab-pane active in" id="register">
                    <form action="{{  route('otp_verification') }}" method="post">
                        @csrf
                        <input type="hidden" name="otp_id" value="{{ $otp_id }}">
                        <div class="form-group mb-3">
                            <input type="num" class="form-control" name="otp" min="6" max="6"
                                placeholder="Enter the OTP" required />
                        </div>
                        @if(isset($error))
                        <p class="text-danger">{{ $error }}</p>
                        @endif
                        <button class="btn btn-dark btn-block btn-rounded" type="submit">Submit</button>
                    </form>
                </div>
                <!-- Register end -->
            </div>
        </div>
    </div>
</div>
@endsection

@section('bottomscripts')
@endsection
