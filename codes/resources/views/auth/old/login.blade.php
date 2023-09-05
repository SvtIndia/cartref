@extends('layouts.website')

@section('css')

@endsection

@section('content')
{{-- @include('partials.breadcrumb') --}}
    <div class="signup-page">
        <div class="left">
            <div class="title">
                <span>Login</span>
                <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Eaque, reiciendis!</p>
            </div>
            
            <div class="form">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
    
                    <div class="form-row">
                        <label class="required">Email</label>
                        <input type="text" name="email" value="{{ old('email') }}" required>
                    </div>
                    
                    <div class="form-row">
                        <label class="required">Password</label>
                        <input type="password" name="password" autocomplete="current-password">
                        
                        @if (Route::has('password.request'))
                            <a class="underline text-sm text-gray-600 hover:text-gray-900" style="font-size: 0.9em; margin-top: 5px; text-decoration: none;" href="{{ route('password.request') }}">
                                {{ __('Forgot your password?') }}
                            </a>
                        @endif
                    </div>
                    
                    <div class="form-row">
                        <button type="submit" class="btn btn-primary">Login</button>
                    </div>
                    <div class="form-row">
                        <span>Don't have account? <a href="{{ route('register') }}">Register</a></span>
                    </div>
                </form>
            </div>
        </div>

        <div class="right">
            <div class="title">
                Or login using
            </div>
            <div class="socials">
                
                <a href="{{ route('auth.redirect', ['client' => 'google']) }}">
                    <div class="social google">
                        <span class="fa fa-google"></span>
                        <p>Sign Up With Google</p>
                    </div>
                </a>

                <a href="{{ route('auth.redirect', ['client' => 'facebook']) }}">
                    <div class="social facebook">
                        <span class="fa fa-facebook"></span>
                        <p>Sign Up With Facebook</p>
                    </div>
                </a>

            </div>
        </div>
    </div>
@endsection

@section('bottomscripts')

@endsection
