@extends('layouts.website')

@section('meta-seo')
<title>{{ Config::get('seo.login.title') }}</title>
<meta name="keywords" content="{{ Config::get('seo.login.keywords') }}">
<meta name="description" content="{{ Config::get('seo.login.description') }}">
@endsection

@section('css')
<style>
    .form-group {
        border: 1px solid #ced4da;
        padding: 5px;
        border-radius: 6px;
        width: auto;
    }

    .form-group:focus {
        color: #212529;
        background-color: #fff;
        border-color: #86b7fe;
        outline: 0;
        box-shadow: 0 0 0 0.25rem rgb(13 110 253 / 25%);
    }

    .form-group input {
        display: inline-block;
        width: auto;
        border: none;
    }

    .form-group input:focus {
        box-shadow: none;
    }
</style>
@endsection

@section('content')
<div class="login-popup" style="margin: auto;">
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
                      
                        <div class="form-footer">
                            <a href="{{ route('login') }}" class="lost-link">Login with Email</a>
                        </div>
                        <button class="btn btn-dark btn-block btn-rounded" type="submit">Request For OTP</button>
                    </form>

                    <div class="form-choice text-center mt-2">
                        <label class="ls-m">or Login With</label>
                        <button class="btn btn-dark btn-rounded" style="padding: 10px;">Login with Email</button>
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
