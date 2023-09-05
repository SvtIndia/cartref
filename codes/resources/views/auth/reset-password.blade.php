@extends('layouts.website')

@section('meta-seo')
    <title>{{ Config::get('seo.reset_password.title') }}</title>
    <meta name="keywords" content="{{ Config::get('seo.reset_password.keywords') }}">
    <meta name="description" content="{{ Config::get('seo.reset_password.description') }}">
@endsection

@section('css')

@endsection

@section('content')
<div class="login-popup" style="margin: auto;">
    <div class="form-box">
        <div class="tab tab-nav-simple tab-nav-boxed form-tab">
            <ul class="nav nav-tabs nav-fill align-items-center border-no justify-content-center mb-5" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active border-no lh-1 ls-normal" href="#signin">Reset Password</a>
                </li>
                {{-- <li class="delimiter">or</li>
                <li class="nav-item">
                    <a class="nav-link border-no lh-1 ls-normal" href="#register">Register</a>
                </li> --}}
            </ul>
                    

    
            <div class="tab-content">
                <!-- Login start -->
                <div class="tab-pane active" id="signin">

                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ $request->route('token') }}">

                        
                        <!-- Email Address -->
                        <div class="form-group mb-3">
                            <input type="text" class="form-control" id="email" name="email" value="{{ old('email', $request->email) }}" placeholder="Username or Email Address *" required autofocus>
                        </div>

                        <div class="form-group mb-3">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Password *" required>
                        </div>

                        <div class="form-group mb-3">
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password *" required>
                        </div>
                        

                        <button class="btn btn-dark btn-block btn-rounded" type="submit">Reset Password</button>
                    </form>

                </div>
                <!-- Login end -->
            </div>
        </div>
    </div>
</div>
@endsection

@section('bottomscripts')

@endsection
