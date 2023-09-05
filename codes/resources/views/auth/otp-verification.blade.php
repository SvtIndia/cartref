@extends('layouts.website')

@section('css')

@endsection

@section('content')
{{-- @include('partials.breadcrumb') --}}
    <div class="signup-page">
        <div class="title">
            <span>Mobile Verification</span>
            <p>We have sent you OTP on your registered mobile to verify</p>
        </div>
        <div class="form">
            <form action="" method="post">
                @csrf
                <div class="form-row">
                    <label for="" class="required">OTP</label>
                    <input type="text" name="otp">
                </div>
                
                <div class="form-row">
                    <button type="submit" class="btn btn-primary">Continue</button>
                </div>
                <div class="form-row">
                    <span>Din't received? <a href="{{ route('login') }}">Resend now</a></span>
                </div>
            </form>
        </div>
    </div>
    <br><br><br><br><br><br><br><br>
@endsection

@section('bottomscripts')

@endsection