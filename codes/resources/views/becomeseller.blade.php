@extends('layouts.website')

@section('meta-seo')
    <title>{{ Config::get('seo.becomeseller.title') }}</title>
    <meta name="keywords" content="{{ Config::get('seo.becomeseller.keywords') }}">
    <meta name="description" content="{{ Config::get('seo.becomeseller.description') }}">
@endsection

@section('css')

@endsection

@section('content')
{{-- <div class="login-popup" style="margin: auto;">
    <div class="form-box">
        <div class="tab tab-nav-simple tab-nav-boxed form-tab">
            <ul class="nav nav-tabs nav-fill align-items-center border-no justify-content-center mb-5" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active border-no lh-1 ls-normal" href="#register">Become Seller</a>
                    <p>Fill this form to request a call from our vendor management team.</p>
                </li>
            </ul>
            <div class="tab-content">
                
                <!-- Register start -->
                <div class="tab-pane active" id="register">
                    <form action="{{  route('vendorsignup') }}" method="post">
                        @csrf

                        <div class="form-group mb-3">
                            <input type="text" class="form-control" name="brand_name" value="{{ old('brand_name') }}" placeholder="Brand Name *"
                                required autofocus/>
                        </div>

                        <div class="form-group mb-3">
                            <input type="text" class="form-control" name="contact_name" value="{{ old('contact_name') }}" placeholder="Contact Name *"
                                required />
                        </div>

                        <div class="form-group mb-3">
                            <input type="text" class="form-control" name="contact_number" value="{{ old('contact_number') }}" placeholder="Contact Number *"
                                required />
                        </div>

                        <div class="form-group mb-3">
                            <input type="email" class="form-control" name="email_address" value="{{ old('email_address') }}" placeholder="Email Address *"
                                required />
                        </div>
                    

                        <div class="form-group mb-3">
                            <input type="text" class="form-control" name="registered_company_name" value="{{ old('registered_company_name') }}" placeholder="Registered Company Name "/>
                        </div>

                        <div class="form-group mb-3">
                            <input type="text" class="form-control" name="gst_number" value="{{ old('gst_number') }}" placeholder="Company GST Number "/>
                        </div>

                        <div class="form-group mb-3">
                            <label for="">Listed on any marketplaces?</label>
                            <textarea name="marketplaces" id="marketplaces" cols="30" rows="5"></textarea>
                        </div>

                        <div class="form-footer">
                            <div class="form-checkbox">
                                <input type="checkbox" class="custom-checkbox" id="register-agree" name="register-agree"
                                    required />
                                <label class="form-control-label" for="register-agree">I agree to the <a href="/page/privacy-policy" style="color: blue">privacy policy</a></label>
                            </div>
                        </div>
                        <button class="btn btn-dark btn-block btn-rounded" type="submit">Register</button>
                    </form>
                </div>
                <!-- Register end -->
            </div>
        </div>
    </div>
</div> --}}
    {{-- @include('components.frontend.layouts.component005') --}}
    @include('components.frontend.layouts.component001')
    @include('components.frontend.layouts.component002')
    @include('components.frontend.layouts.component003')
    @include('components.frontend.layouts.component004')
@endsection

@section('bottomscripts')

@endsection

