@extends('layouts.website')

@section('css')

@endsection

@section('content')
{{-- @include('partials.breadcrumb') --}}
    <div class="signup-page">
        <div class="left">
            <div class="title">
                <span>Sign Up</span>
                <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Eaque, reiciendis!</p>
            </div>
            
            <div class="form">
                <form action="{{  route('register') }}" method="post">
                    @csrf
    
                    <div class="form-row">
                        <label for="" class="required">Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" required autofocus>
                    </div>
                    <div class="form-row">
                        <label for="" class="required">Email</label>
                        <input type="text" name="email" value="{{ old('email') }}" required>
                        @if (Config::get('icrm.auth.email_verification'))
                            <small>We will send you activation link for verification.</small>
                        @endif
                    </div>
                    <div class="form-row">
                        <label for="" class="required">Mobile Number</label>
                        <input type="text" name="mobile" value="{{ old('mobile') }}" required>
                        @if (Config::get('icrm.auth.otp_verification'))
                            <small>We will send you OTP for verification.</small>
                        @endif
                    </div>
                    
                    <div class="form-row">
                        <label for="" class="required">Password</label>
                        <input type="password" name="password" required autocomplete="new-password">
                    </div>
                    <div class="form-row">
                        <label for="" class="required">Confirm Password</label>
                        <input type="password" name="password_confirmation" required>
                    </div>
                    
                    <div class="form-row">
                        <button type="submit" class="btn btn-primary">Continue</button>
                    </div>
                    <div class="form-row">
                        <span>Already a user? <a href="{{ route('login') }}">Login</a></span>
                    </div>
                </form>
            </div>
        </div>

        <div class="right">
            <div class="title">
                Or sign up using
            </div>
            <div class="socials">
                
                <a href="">
                    <div class="social facebook">
                        <span class="fa fa-facebook"></span>
                        <p>Sign Up With Facebook</p>
                    </div>
                </a>

                <a href="">
                    <div class="social google">
                        <span class="fa fa-google"></span>
                        <p>Sign Up With Google</p>
                    </div>
                </a>

            </div>
        </div>
    </div>
@endsection

@section('bottomscripts')

@endsection