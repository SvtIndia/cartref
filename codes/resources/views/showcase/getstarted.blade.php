@if (\Request::route()->getName() == 'showcase.getstarted')
@extends('layouts.website')

@section('meta-seo')
    <title>Showroom At Home</title>
    <meta name="keywords" content="HTML5 Template">
    <meta name="description" content="Riode - Ultimate eCommerce Template">
@endsection

@section('content')

@endif

<section class="pt-6 pb-6" style="background: #101221; height: 100vh;" id="getstarted">
    <div class="banner banner-background parallax text-center" data-option="{'offset': -60}" style="background-color: #101221; position: relative; overflow: hidden;"><div class="parallax-background" style="background-size: cover; position: absolute; top: 0px; left: 0px; width: 100%; height: 180%; transform: translate3d(0px, -263.495px, 0px); background-position-x: 50%;"></div>
        <div class="container">
            <div class="banner-content">
                <img src="{{ Voyager::image(setting('site.logo')) }}" alt="{{ setting('site.title') }}" style="max-height: 100px;">
                <br><br><br><br><br>
                <h3 class="banner-title font-weight-bold text-white"><span style="color: #00B48E">Activate</span> Showroom At Home</h3>
                <br>
                <p class="text-lights ls-s" style="margin: 0; color: #ccc;">Enter your delivery pin code to <span style="color: rgb(56, 142, 234);">check the availibity of this service in your area</span> and activate showcase at home on your catalog</p>
                <p class="text-lights ls-s" style="color: #ccc;">After successful activation you will only see products from vendors who offer showcase at home</p>
                <div class="col-lg-6 d-lg-block d-flex justify-content-center mx-auto">
                    @if (empty(Session::get('showcasecity')))
                        <form action="{{ route('showcase.activate') }}" method="post" class="input-wrapper input-wrapper-round input-wrapper-inline ml-lg-auto">
                            @csrf
                            <input type="text" class="form-control font-primary form-solid" name="showcasepincode" id="showcasepincode" placeholder="Delivery pincode..." required="">
                            <button class="btn btn-sm btn-primary" type="submit">Activate<i class="d-icon-arrow-right"></i></button>
                        </form>
                    @else
                        <form action="{{ route('showcase.deactivate') }}" method="post" class="input-wrappers input-wrapper-rounds input-wrapper-inlines ml-lg-auto">
                            @csrf
                            <input type="hidden" class="form-control font-secondary form-solid" name="showcasepincode" id="showcasepincode" placeholder="Delivery pincode..." required="">
                            <button class="btn btn-sm btn-secondary" type="submit">Deactivate<i class="d-icon-arrow-right"></i></button>
                        </form>
                    @endif
                </div>
                <br><br><br>
                @if (empty(Session::get('showcasecity')))
                    <a href="{{ route('products') }}" class="btn btn-default btn-sm"><i class="d-icon-arrow-left"></i> Back</a>
                @else
                    <a href="{{ route('products') }}" class="btn btn-default btn-sm"><i class="d-icon-arrow-left"></i> View Stores</a>
                @endif
                {{-- @if (Config::get('icrm.frontend.socialpagelinks.feature') == 1)
                    <div class="social-links mt-4 text-white">
                        @if (!empty(Config::get('icrm.frontend.socialpagelinks.facebook')))
                            <a href="{{ Config::get('icrm.frontend.socialpagelinks.facebook') }}" class="social-link social-facebook fab fa-facebook-f"></a>
                        @endif
                        @if (!empty(Config::get('icrm.frontend.socialpagelinks.instagram')))
                            <a href="{{ Config::get('icrm.frontend.socialpagelinks.instagram') }}" class="social-link social-instagram fab fa-instagram"></a>
                        @endif
                        @if (!empty(Config::get('icrm.frontend.socialpagelinks.twitter')))
                            <a href="{{ Config::get('icrm.frontend.socialpagelinks.twitter') }}" class="social-link social-twitter fab fa-twitter"></a>
                        @endif
                        @if (!empty(Config::get('icrm.frontend.socialpagelinks.linkedin')))
                            <a href="{{ Config::get('icrm.frontend.socialpagelinks.linkedin') }}" class="social-link social-linkedin fab fa-linkedin-in"></a>
                        @endif
                        @if (!empty(Config::get('icrm.frontend.socialpagelinks.googleplus')))
                            <a href="{{ Config::get('icrm.frontend.socialpagelinks.googleplus') }}" class="social-link social-google fab fa-google-plus-g"></a>
                        @endif
                    </div>
                @endif --}}
            </div>
        </div>
    </div>
</section>

@if (\Request::route()->getName() == 'showcase.getstarted')
@endsection
@endif
