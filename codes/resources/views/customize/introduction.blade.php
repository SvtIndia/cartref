@extends('layouts.website')

@section('meta-seo')
    <title>{{ Config::get('seo.customization.title') }}</title>
    <meta name="keywords" content="{{ Config::get('seo.customization.keywords') }}">
    <meta name="description" content="{{ Config::get('seo.customization.description') }}">
@endsection

@section('content')
<nav class="breadcrumb-nav">
    <div class="container">
        <ul class="breadcrumb">
            <li><a href="{{ route('welcome') }}"><i class="d-icon-home"></i></a></li>
            <li>{{ Config::get('seo.customization.title') }}</li>
        </ul>
    </div>
</nav>
<div class="page-header pl-4 pr-4" style="background-image: url(images/page-header/about-us.jpg)">
    <h3 class="page-subtitle font-weight-bold">Introducing</h3>
    <h1 class="page-title font-weight-bold lh-1 text-white text-capitalize">Product Customization</h1>
    <p class="page-desc text-white mb-0">The new way of online buying by ordering customized products.</p>
</div>
<div class="page-content mt-10 pt-10">

    <section class="about-section pb-10 appear-animate fadeIn appear-animation-visible" style="animation-duration: 1.2s;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-4 mb-10 mb-lg-4">
                    {{-- <h5 class="section-subtitle lh-2 ls-md font-weight-normal">01. What We Do</h5> --}}
                    <h3 class="section-title lh-1 font-weight-bold">Get use to the new way
                    </h3>
                    <p class="section-desc">5000+ customers find this service offered by Inditech is very helpful.</p>
                </div>
                <div class="col-lg-8 ">
                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <div class="counter text-center text-dark">
                                <span class="count-to" data-fromvalue="0" data-tovalue="34" data-duration="900" data-delimiter=",">34</span>
                                <h5 class="count-title font-weight-bold text-body ls-md">Available In Cities</h5>
                                <p class="text-grey mb-0">Lorem ipsum dolor sit<br>amet, conctetur adipisci
                                    elit. viverra erat orci.</p>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="counter text-center text-dark">
                                <span class="count-to" data-fromvalue="0" data-tovalue="50" data-duration="900" data-delimiter=",">50</span>
                                <h5 class="count-title font-weight-bold text-body ls-md">Products</h5>
                                <p class="text-grey mb-0">Lorem ipsum dolor sit<br>amet, conctetur adipisci
                                    elit. viverra erat orci.</p>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="counter text-center text-dark">
                                <span class="count-to" data-fromvalue="0" data-tovalue="130" data-duration="900" data-delimiter=",">130</span>
                                <h5 class="count-title font-weight-bold text-body ls-md">Categories</h5>
                                <p class="text-grey mb-0">Lorem ipsum dolor sit<br>amet, conctetur adipisci
                                    elit. viverra erat orci.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End About Section-->

    <section class="customer-section pb-10 appear-animate fadeIn appear-animation-visible" style="animation-duration: 1.2s;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 mb-4">
                    <figure>
                        <img src="{{ Voyager::image(setting('customize-product-intro.widget1_image')) }}" alt="Happy Customer" class="banner-radius" style="background-color: #BDD0DE;" width="580" height="507">
                    </figure>
                </div>
                <div class="col-md-6 mb-4">
                    <h5 class="section-subtitle lh-2 ls-md font-weight-normal">Step 01</h5>
                    <h3 class="section-title lh-1 font-weight-bold">Customize your favourite product</h3>
                    <p class="section-desc text-grey">
                       Click on the customize button on product page or quick view and you will be redirected to customization tool. <br>
                       Enjoy the customization process by uploading your brand images on the product.
                    </p>
                    <a href="#getstarted" class="btn btn-dark btn-link btn-underline ls-m">Get Started<i class="d-icon-arrow-right"></i></a>
                </div>
            </div>
        </div>
    </section>
    <!-- End Customer Section -->

    <section class="store-section pb-10 appear-animate fadeIn appear-animation-visible" style="animation-duration: 1.2s;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 order-md-first mb-4">
                    <h5 class="section-subtitle lh-2 ls-md font-weight-normal mb-1">Step 02</h5>
                    <h3 class="section-title lh-1 font-weight-bold">Upload Original Files</h3>
                    <p class="section-desc text-grey">
                        After successfully customizing product upload the brand images cdr file which you used while customizing. <br>
                        We recommend using clear and small images for better printing.
                    </p>
                    <a href="#getstarted" class="btn btn-dark btn-link btn-underline ls-m">Get Started<i class="d-icon-arrow-right"></i></a>
                </div>
                <div class="col-md-6 mb-4">
                    <figure>
                        <img src="{{ Voyager::image(setting('customize-product-intro.widget2_image')) }}" alt="Our Store" class="banner-radius" style="background-color: #DEE6E8;" width="580" height="507">
                    </figure>
                </div>
            </div>
        </div>
    </section>
    <!-- End Store-section -->



    <section class="customer-section pb-10 appear-animate fadeIn appear-animation-visible" style="animation-duration: 1.2s;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 mb-4">
                    <figure>
                        <img src="{{ Voyager::image(setting('customize-product-intro.widget3_image')) }}" alt="Happy Customer" class="banner-radius" style="background-color: #BDD0DE;" width="580" height="507">
                    </figure>
                </div>
                <div class="col-md-6 mb-4">
                    <h5 class="section-subtitle lh-2 ls-md font-weight-normal">Step 03</h5>
                    <h3 class="section-title lh-1 font-weight-bold">Approve and move to cart</h3>
                    <p class="section-desc text-grey">
                        Now when you're done customizing your product just click on the approve checkbox and move product to bag.
                    </p>
                    <a href="#getstarted" class="btn btn-dark btn-link btn-underline ls-m">Get Started<i class="d-icon-arrow-right"></i></a>
                </div>
            </div>
        </div>
    </section>


    <section class="store-section pb-10 appear-animate fadeIn appear-animation-visible" style="animation-duration: 1.2s;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 order-md-first mb-4">
                    <h5 class="section-subtitle lh-2 ls-md font-weight-normal mb-1">Step 04</h5>
                    <h3 class="section-title lh-1 font-weight-bold">Make payment and checkout</h3>
                    <p class="section-desc text-grey">
                        Follow the shopping cart process and fill out all the required information and complete the order. <br>
                    </p>
                    <a href="#getstarted" class="btn btn-dark btn-link btn-underline ls-m">Get Started<i class="d-icon-arrow-right"></i></a>
                </div>
                <div class="col-md-6 mb-4">
                    <figure>
                        <img src="{{ Voyager::image(setting('customize-product-intro.widget4_image')) }}" alt="Our Store" class="banner-radius" style="background-color: #DEE6E8;" width="580" height="507">
                    </figure>
                </div>
            </div>
        </div>
    </section>



</div>

@endsection