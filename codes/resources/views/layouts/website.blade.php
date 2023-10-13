<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">

    @if (Config::get('icrm.seo.feature') == true)
        @include('components.frontend.seo.seo')
    @endif

    {{-- @yield('meta-seo') --}}
    <meta name="author" content="https://icrmsoftware.com/service/ecommerce-website">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ Voyager::image(setting('site.site_icon')) }}">
    <!-- Preload Font -->
    {{-- <link rel="preload" href="{{ asset('fonts/riode.ttf?5gap68') }}" as="font" type="font/woff2" crossorigin="anonymous"> --}}
    <link rel="preload" href="{{ asset('vendor/fontawesome-free/webfonts/fa-solid-900.woff2') }}" as="font"
        type="font/woff2" crossorigin="anonymous">
    <link rel="preload" href="{{ asset('vendor/fontawesome-free/webfonts/fa-brands-400.woff2') }}" as="font"
        type="font/woff2" crossorigin="anonymous">

    <script src="{{ asset('js/webfont.js') }}" async=""></script>
    <script>
        WebFontConfig = {
            google: {
                families: ['Poppins:400,500,600,700,800,900']
            }
        };
        (function(d) {
            var wf = d.createElement('script'),
                s = d.scripts[0];
            wf.src = '{{ asset('js/webfont.js') }}';
            wf.async = true;
            s.parentNode.insertBefore(wf, s);
        })(document);
    </script>


    @if (Config::get('icrm.auth.otp_verification') == true)
        @auth
            @if (Session::get('otpverified') == false)
                @if (\Request::route()->getName() != 'otp.login' and \Request::route()->getName() != 'otp.verification')
                    <script>
                        window.location = "/otp/login";
                    </script>
                @endif
            @endif
        @endauth
    @endif


    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/animate/animate.min.css') }}">

    <!-- Plugins CSS File -->
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/magnific-popup/magnific-popup.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/owl-carousel/owl.carousel.min.css') }}">
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('vendor/nouislider/nouislider.min.css') }}"> --}}

    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/sticky-icon/stickyicon.css') }}">

    <!-- Main CSS File -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/icrm.min.css?version=1') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('css/inditech.min.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('css/cartrefs.min.css') }}">

    @if (env('#APP_URL') == 'https://hawkwings.in')
        <link rel="stylesheet" type="text/css" href="{{ asset('css/hawkwings.css') }}">
    @endif


    @yield('headerlinks')

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:400,500,600,700,800,900"
        media="all">

    {!! setting('online-chat.customer_support') !!}
    {{-- <script src="https://kit.fontawesome.com/e0e6094db3.js" crossorigin="anonymous"></script> --}}

    {!! setting('scripts.header_scripts') !!}

    @php
        $gorderid = request('id');
    @endphp

    @if (\Request::route()->getName() == 'ordercomplete')
        {!! setting('site.conversion_complete_script') !!}
    @endif

    <style>
        @media screen and (max-width: 480px) {
            .header-center {
                display: none;
            }
        }
    </style>

    <style>
        @media screen and (max-width: 768px) {
            .cart .shop-table tr {
                padding: 1rem 0 0rem !important;
            }

            .cart .product-thumbnail {
                padding: 0rem 2rem 1.5rem 0 !important;
            }

            .cart .product-thumbnail figure {
                width: 100%;
                height: 100%;
            }

            .cart .product-thumbnail figure a {
                width: 100% !important;
                height: 100% !important;
            }

            .cart .product-thumbnail figure img {
                width: inherit !important;
                height: 190px !important;
                max-width: inherit !important;
                max-height: inherit !important;
            }

            .cart .cart-tr {
                display: flex !important;
                flex-wrap: wrap;
            }

            .cart .product-thumbnail {
                max-width: 50%;
                flex: 0 0 50%;
            }

            .cart .product-name {
                max-width: 50%;
                flex: 0 0 50%;
                text-align: left;
            }

            .cart .product-quantity {
                max-width: 25%;
                flex: 0 0 50%;
            }

            .cart .product-price {
                max-width: 40%;
                flex: 0 0 50%;
                text-align: left !important;
                margin-top: 5px;
                margin-left: 4rem;
            }

            .cart .product-price .amount {
                color: blue;
                font-size: 2rem;
            }

            .cart .product-close {
                margin-bottom: 5px;
                align-items: center;
            }
            .cart .product-close .product-remove{
                position: unset !important;
                display: flex !important;
            }

            .cart .save_text {
                font-size: 14px;
                color: green;
            }

            .cart .input-group {
                width: 9rem !important;
            }

            .no-mobile {
                display: none !important;
            }
        }

        .cart .save_text {
            font-size: 14px;
            color: green;
        }

        .cart .product-name {
            width: 25% !important;
        }

        .alert-body .available-coupons{
            margin-bottom: 10px;
            border-bottom: 0.1px solid gray;
        }
        .alert-body .available-coupons .coupon-body{
            width: 100%;
            display: flex;
            /*justify-content: space-between;*/
            /*gap: 4rem;*/
            margin-bottom: 5px;
            align-items: center;
        }
        .alert-body .available-coupons .coupon-body .info{
            display: flex;
            justify-content: flex-start;
            width: 100%;
            gap: 2rem;
        }
        .alert-body .available-coupons .coupon-body .code {
            font-size: 18px;
            font-weight: 500;
            color: black;
            border: 1px solid;
            padding: 5px;
            display: block;
            width: fit-content;
        }
        .alert-body .available-coupons .coupon-body .apply-btn{
            padding: 5px;
            font-size: 15px;
            font-weight: 200;
            text-transform: unset;
        }
        .alert-body .available-coupons .coupon-body .applicable {
            color: green;
            text-align: end;
            font-size: 16px;
        }
        .alert-body .available-coupons .coupon-body .not-applicable {
            color: red;
            text-align: start;
            font-size: 12px;
        }
        @font-face {
            font-family: 'Benedict-Regular';
            src: url('/fonts/Benedict Regular.otf');
        }
        @font-face {
            font-family: 'BenguiatStd-Bold';
            src: url('/fonts/BenguiatStd-Bold.otf');
        }

        .checkout .you-save{
            color:#57a1f0;
            font-size: 2rem;
            font-weight: 550;
            font-family: 'BenguiatStd-Bold';
        }
        .checkout .happy-shopping{
            display: flex;
            justify-content: center;
            margin-top: 5px;
        }
        .checkout .happy-shopping .keep{
            font-size: 35px;
            margin-right: 2rem;
            font-family:'Benedict-Regular';
        }
        .checkout .happy-shopping .shopping{
           color: red;
        }
        .checkout .happy-shopping .smiling{
           color: black;
        }
        .checkout .happy-shopping .saving{
           color: green;
        }
        @media screen and (max-width: 481px) {
            .checkout .you-save{
                font-size: 14px;
            }
        }
        @media screen and (max-width: 768px) {
            .checkout .happy-shopping .keep{
                font-size: 24px;
                margin-right: 1rem;
            }
        }
        @media screen and (max-width: 481px) {
            .checkout .happy-shopping .keep{
                font-size: 20px;
                margin-right: 1rem;
            }
        }
        @media screen and (min-width: 1000px) {
            .checkout .checkout-form{
                max-width: 58.3333%;
                flex: 0 0 45.333%;
            }
            .custom-checkout-form{
                max-width: 58.3333%;
                flex: 0 0 55.333%;
            }
            .checkout .sticky-sidebar-wrapper{
                max-width: 50.667%;
                flex: 0 0 50.667%;
            }
            .custom-sticky-sidebar-wrapper{
                max-width: 50%;
                flex: 0 0 42%;
            }
        }

        /*  Showcase Form Checkout  */
        .custom-total .you-save{
            color:#57a1f0;
            font-size: 2rem;
            font-weight: 550;
            font-family: 'BenguiatStd-Bold';
        }
        .custom-total .happy-shopping{
            display: flex;
            justify-content: center;
            margin-top: 5px;
        }
        .custom-total .happy-shopping .keep{
            font-size: 34px;
            margin-right: 2rem;
            font-family:'Benedict-Regular';
        }
        .custom-total .happy-shopping .shopping{
            color: red;
        }
        .custom-total .happy-shopping .smiling{
            color: black;
        }
        .custom-total .happy-shopping .saving{
            color: green;
        }
        .custom-total .alert.card-header {
            padding-top: 1.2rem;
            padding-bottom: 1.3rem;
            background-color: #fff;
            border: 1px dashed #cacbcc;
            text-transform: none;
        }
        .custom-total .accordion .card-header a {
            padding: 0 !important;
            padding-top: 2rem !important;
        }
        @media screen and (max-width: 481px) {
            .custom-total .you-save{
                font-size: 14px;
            }
        }
        @media screen and (max-width: 768px) {
            .custom-total .happy-shopping .keep{
                font-size: 24px;
                margin-right: 1rem;
            }
        }
        @media screen and (max-width: 481px) {
            .custom-total .happy-shopping .keep{
                font-size: 20px;
                margin-right: 1rem;
            }
        }
    </style>

    <style>
        #loader {
        -webkit-animation: spin 1s infinite linear;
        }

        @-webkit-keyframes spin {
            0% {
                -webkit-transform: rotate(0deg)
            }

            100% {
                -webkit-transform: rotate(360deg)
            }
        }
    </style>
    @livewireStyles
    <script src="{{ asset('php_ua/assets/js/scripts/phpUaJS.js') }}"></script>
</head>



<body class="home loaded" style="overflow-x: hidden;">

    @livewire('quickviewmodal')

    @php
        function checkMobile()
        {
            return is_numeric(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'mobile'));
        }
    @endphp

    <div class="page-wrapper">
        <h1 class="d-none">{{ env('APP_NAME') }}</h1>

        @if (\Request::route()->getName() != 'showcase.getstarted')
            @include('components.frontend.headers.01')
        @endif


        <!-- End of Header -->
        <main class="main @yield('mainclass')">
            <div class="page-content">
                @yield('content')
            </div>
        </main>
        <!-- End of Main -->

        @if (Config::get('icrm.frontend.newslettersignup.feature') == 1)
            {{-- show only when user is not signedup for news letter --}}
            @if (empty(Session::get('signedupfornewsletter')))
                {{-- @if (\Request::route()->getName() != 'showcase.introduction') --}}
                @if (\Request::route()->getPrefix() != '/showcase-at-home')
                    @include('components.frontend.ctas.signup01')
                @endif
            @endif
        @endif

        @if (\Request::route()->getName() != 'showcase.getstarted')
            @include('components.frontend.footers.01')
        @endif

        <!-- End of Footer -->
        {{-- <div class="minipopup-area"></div></div> --}}

        @include('components.frontend.footers.stickyfooter')

        <!-- Scroll Top -->
        <a id="scroll-top" href="#top" title="Top" role="button" class="scroll-top"><i
                class="d-icon-arrow-up"></i></a>

        @include('components.frontend.headers.01-mobile')

        {{-- @include('components.frontend.ctas.popupnewsletter') --}}

        <!-- sticky icons-->
        {{-- <div class="sticky-icons-wrapper">
        <div class="sticky-icon-links">
            <ul>
                <li><a href="#" class="demo-toggle"><i class="fas fa-home"></i><span>Demos</span></a></li>
                <li><a href="documentation.html"><i class="fas fa-info-circle"></i><span>Documentation</span></a>
                </li>
                <li><a href="https://icrmsoftware.com"><i class="fas fa-star"></i><span>Reviews</span></a>
                </li>
                <li><a href="https://icrmsoftware.com"><i class="fas fa-shopping-cart"></i><span>Buy
                            now!</span></a></li>
            </ul>
        </div>
        <div class="demos-list">
            <div class="demos-overlay"></div>
            <a class="demos-close" href="#"><i class="close-icon"></i></a>
            <div class="demos-content scrollable scrollable-light">
                <h3 class="demos-title">Demos</h3>
                <div class="demos">
                </div>
            </div>
        </div>
    </div> --}}
        <div style="display: none" id="no_internet">
            <div class="mfp-bg mfp-product mfp-fade mfp-ready quickview" wire:click="displayfalse"></div>
            <div class="mfp-wrap mfp-close-btn-in mfp-auto-cursor mfp-product mfp-fade mfp-ready" tabindex="-1"
                style="overflow: hidden auto;">
                <div class="mfp-container mfp-ajax-holder">
                    <div class="mfp-content">
                        <div class="product product-single row product-popup">
                            <figure class="product-image">
                                <img src="{{ config('app.url') . '/images/error/no-internet.jpeg' }}"
                                    style="display: flex; margin: auto;" alt="No Internet">
                            </figure>
                            <button title="Close (Esc)"
                                onclick="document.getElementById('no_internet').style.display = 'none';" type="button"
                                class="mfp-close"><span>×</span></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
            Launch demo modal
          </button> --}}

        <!-- Plugins JS File -->
        @if (\Request::route()->getName() != 'customize')
            {{-- if current route is not customize.customizeid --}}
            <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
        @endif

        <script src="{{ asset('vendor/sticky/sticky.min.js') }}"></script>
        <script src="{{ asset('vendor/imagesloaded/imagesloaded.pkgd.min.js') }}"></script>
        <script src="{{ asset('vendor/elevatezoom/jquery.elevatezoom.min.js') }}"></script>
        <script src="{{ asset('vendor/magnific-popup/jquery.magnific-popup.min.js') }}"></script>

        <script src="{{ asset('vendor/owl-carousel/owl.carousel.min.js') }}"></script>
        {{-- <script src="{{ asset('vendor/nouislider/nouislider.min.js') }}"></script> --}}

        <script src="{{ asset('vendor/jquery.plugin/jquery.plugin.min.js') }}"></script>
        <script src="{{ asset('vendor/jquery.countdown/jquery.countdown.min.js') }}"></script>

        <script src="{{ asset('vendor/photoswipe/photoswipe.min.js') }}"></script>
        <script src="{{ asset('vendor/photoswipe/photoswipe.min.js') }}"></script>
        <script src="{{ asset('vendor/photoswipe/photoswipe-ui-default.min.js') }}"></script>
        <!-- Main JS File -->
        <script src="{{ asset('js/main.js') }}"></script>


        {{-- <div class="zoomContainer" style="-webkit-transform: translateZ(0);position:absolute;left:3556.833251953125px;top:2974.36669921875px;height:582.917px;width:582.917px;"><div class="zoomLens" style="background-position: 0px 0px;width: 291.4585px;height: 291.4585px;float: right;display: none;overflow: hidden;z-index: 999;-webkit-transform: translateZ(0);opacity:0.4;filter: alpha(opacity = 40); zoom:1;width:291.4585px;height:291.4585px;background-color:white;cursor:default;border: 1px solid #000;background-repeat: no-repeat;position: absolute;">&nbsp;</div><div class="zoomWindowContainer" style="width: 400px;"><div style="overflow: hidden; background-position: 0px 0px; text-align: center; background-color: rgb(255, 255, 255); width: 400px; height: 400px; float: left; background-size: 800px 800px; display: none; z-index: 100; border: 4px solid rgb(136, 136, 136); background-repeat: no-repeat; position: absolute; background-image: url(&quot;images/demos/demo7/products/big2.jpg&quot;);" class="zoomWindow">&nbsp;</div></div></div> --}}

        {{-- If below mentioned jquery is enabled the product images jquery will not work --}}
        {{-- <script src="{{ url('https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js') }}"></script> --}}

        {{-- different jquery for different pages --}}
        @if (\Request::route()->getPrefix() != '/customize-product')
            {{-- <script src="{{ asset('js/jquery-2.1.3.min.js') }}"></script>         --}}
        @endif

        {{-- <script src="{{ asset('owlcarousel/owl.carousel.min.js') }}"></script> --}}
        {{-- @yield('js') --}}

        {{-- @include('components.frontend.footers.footerscriptscode') --}}

        @if (\Request::route()->getPrefix() == '/customization')
            <script src="{{ asset('js/imageMaker.min.js') }}"></script>
        @endif

        @yield('bottomscripts')

        {!! setting('scripts.bottom_scripts') !!}

        @livewireScripts
        <script src="https://cdn.jsdelivr.net/gh/livewire/vue@v0.3.x/dist/livewire-vue.js"></script>
        <script src="{{ config('app.url') }}/vendor/toast/tata.js"></script>

        <script>
            window.addEventListener('showToast', (e) => {
                // console.log(e.detail.status)
                if (e.detail.status == 'success') {
                    tata.success(e.detail.msg, '')
                }
                if (e.detail.status == 'log') {
                    tata.log(e.detail.msg, '')
                }
                if (e.detail.status == 'info') {
                    tata.info(e.detail.msg, '')
                }
                if (e.detail.status == 'warning') {
                    tata.warning(e.detail.msg, '')
                }
                if (e.detail.status == 'error') {
                    tata.error(e.detail.msg, '')
                }

            });
            window.addEventListener('contentChanged', (e) => {
                alert(e.detail.item.name);
            });
        </script>
        <script>
            window.addEventListener("online", function() {
                document.getElementById('no_internet').style.display = 'none';
            });

            window.addEventListener("offline", function() {
                document.getElementById('no_internet').style.display = 'block'
            });

            if (navigator.onLine) {
                document.getElementById('no_internet').style.display = 'none';
            } else {
                document.getElementById('no_internet').style.display = 'block'
            }
        </script>
        @stack('scripts')
</body>

</html>
