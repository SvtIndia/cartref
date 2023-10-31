@extends('layouts.website')


@section('meta-seo')
    <title>{{ $product->getTranslatedAttribute('name', App::getLocale(), 'en') }}</title>
    <meta name="description" content="{{ $product->description }}">
@endsection

@section('headerlinks')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/product-page.css') }}">
    <style>
        .more-button-custom {
            position: relative;
            text-align: center;
            border-radius: 15px;
            font-size: 16px !important;
            letter-spacing: 2px !important;
            box-shadow: 5px 5px 10px rgb(128, 128, 128);
            display: flex;
            align-items: center;
            justify-content: center;
            flex: 1;
            padding: 1.14em 0;
            background-color: black;
            color: #fff;
            font-family: Poppins, sans-serif;
            text-decoration: none;
        }

        .more-button-custom:hover {
            color: #fff;
        }

        .badge-count {
            position: absolute;
            top: 0;
            border-radius: 50rem !important;
            background-color: #e6003a !important;
            transform: translate(-50%, -50%) !important;
            left: 98% !important;
            display: inline-block;
            padding: .35em .65em;
            font-size: .75em;
            font-weight: 700;
            line-height: 1;
            color: #fff;
            text-align: center;
            white-space: nowrap;
        }

        .prod-content {
            margin-left: 0;
        }

        .pdp-promotion {
            text-align: center;
            width: 400px;
            /* padding-top: 22px; */
            padding-bottom: 22px;
        }

        .pdp-promo-block {
            padding: 5px 8px;
            border: 1px dashed #000000;
        }

        .pdp-promo-block,
        .plp-promo-block {
            display: block;
            position: relative;
            width: 100%;
            height: auto;
            margin-bottom: 8px;
        }

        .ic-offer-tag {
            display: inline;
        }

        [class*=" ic-"],
        [class^=ic-] {
            font-family: jioicons !important;
            speak: none;
            font-style: normal;
            font-weight: 400;
            font-variant: normal;
            text-transform: none;
            line-height: 1;
            display: inline-block;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        .ic-offer-tag::before {
            content: "\e914";
            display: inline-block;
            position: absolute;
            top: -8px;
            left: 15px;
            background-color: #fff;
            font-size: 16px;
            color: #b19975;
        }

        .promo-blck {
            width: 100%;
        }

        .promo-title-blck {
            width: 25%;
            padding-right: 2px;
            border-right: 1px solid #d8d8d8;
            word-wrap: break-word;
            /* font-size: 12px; */
            text-align: center;
            display: inline-block;
        }

        .promo-title {
            font-weight: 600;
            color: #b19975;
        }

        .main-view.product-view a {
            color: #176d93;
        }

        .promo-desc-block {
            width: 73%;
            word-wrap: break-word;
            display: inline-block;
            vertical-align: super;
        }

        .promo-desc-block .promo-discounted-price {
            font-size: 15px;
            position: absolute;
            border: 1px dashed #000000;
            /* width: 73%; */
            top: -12px;
            background-color: #fff8eb;
            padding: 1px 10px;
            text-align: left;
            font-weight: bold
        }

        .promo-desc-block .promo-discounted-price span {
            color: #39b54a;
            font-family: SourceSansProSemiBold;
        }

        .promo-desc-block .promo-desc {
            display: block;
            color: #939393;
            font-size: 12px;
            text-align: left;
            padding-left: 10px;
            margin-top: 10px;
        }

        .promo-desc-block .promo-desc a {
            color: #176d93;
            text-decoration: none;
        }

        @media only screen and (max-width: 400px) {
            .pdp-promotion {
                width: 300px;
                padding-top: 0;
                padding-bottom: 0;
            }
        }

        @media (min-width: 400px) and (max-width: 600px) {
            .pdp-promotion {
                width: 350px;
                padding-top: 0;
                padding-bottom: 0;
            }
        }
    </style>
    <style>
        .product-btn {
            display: flex;
            gap: 10px;
            margin-top: 2rem;
        }

        @media only screen and (max-width: 480px) {
            .product-btn {
                display: block;
                gap: 10px;
                margin-top: 2rem;
            }

            .more-button-custom {
                position: relative;
                text-align: center;
                border-radius: 15px;
                font-size: 14px !important;
                letter-spacing: 2px !important;
                box-shadow: 5px 5px 10px rgb(128, 128, 128);
                margin-inline: 40px;
                margin-bottom: 10px;
            }
        }
    </style>
    <style>
        .product-gallery {
            position: sticky;
            top: 0px !important;
        }

        .fancybox-content {
            transform: translate(0px, 0px) !important;
            width: 100% !important;
            height: 100% !important;
        }

        .fancybox-image {
            object-fit: contain;
        }

        .container {
            padding-left: 5px;
            !important;
            padding-right: 5px;
            !important;
            margin-top: 10px;
        }

        .title {
            font-size: 3rem !important;
            font-family: HelveticaNow, Helvetica, sans-serif;
        }
    </style>
@endsection


@section('content')
@section('mainclass')
@endsection
<div class="container">
    <div class="page-content mb-10 pb-6">
        <div class="container">
            <div class="product product-single row mb-7">

                {{-- Product Images Livewire --}}
                @livewire('product.productimages', [
                    'product' => $product,
                ])

                @livewire('addskutobag', [
                    'product' => $product,
                    'view' => 'new-product-page',
                ])


            </div>

            @php
                function isMobile()
                {
                    return is_numeric(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'mobile'));
                }
            @endphp

            @isset($relatedproducts)
                @if (count($relatedproducts) > 0)
                    @if (!isMobile())
                        <section class="pt-3 mt-10">
                            <h1 class="similar-title justify-content-center" style="font-size: 4rem; !important;">Make the
                                look complete</h1>
                            <h1 class="similar-title2 justify-content-center">Outfit inspiration by Cartrefs</h1>
                            <div class="row cols-2 cols-sm-5 justify-content-center product-wrapper box-mode">
                                @foreach ($relatedproducts as $key => $product)
                                    @php
                                        $firstcolorimage = App\Productcolor::where('status', 1)
                                            ->where('product_id', $product->id)
                                            ->first();

                                        if (isset($firstcolorimage)) {
                                            if (!empty($firstcolorimage->main_image)) {
                                                $firstcolorimage = $firstcolorimage->main_image;
                                                // $firstcolorimage = $product->image;
                                            } else {
                                                $firstcolorimage = $product->image;
                                            }
                                        } else {
                                            $firstcolorimage = $product->image;
                                        }
                                    @endphp
                                    <div class="new-product-wrap owl-item @if ($key == 0) active @endif">
                                        <a href="{{ route('product.slug', ['slug' => $product->slug]) }}">
                                            <div class="new-product">
                                                <div class="image">
                                                    <img class="product-image" src="{{ Voyager::image($firstcolorimage) }}"
                                                        alt="{{ $product->name }}" />

                                                    @if ($product->productreviews && $product->productreviews()->count())
                                                        <div class="product-rating-horizontal">
                                                            <div class="star">
                                                                @if ($product->productreviews)
                                                                    {{ ($product->productreviews()->where('status', 1)->sum('rate') /
                                                                        ($product->productreviews()->where('status', 1)->count() *
                                                                            5)) *
                                                                        5 }}
                                                                @else
                                                                    0
                                                                @endif &nbsp;
                                                                <img src="{{ asset('/images/icons/star.svg') }}"
                                                                    alt="star">
                                                            </div>
                                                            <span class="dash">|</span>
                                                            <div class="book">
                                                                {{ $product->productreviews()->count() }} &nbsp;
                                                                <img src="{{ asset('/images/icons/book.svg') }}"
                                                                    alt="book">
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>

                                                <div class="content">
                                                    <div class="brand-name">{{ $product->brand_id }}</div>
                                                    <div class="product-name">
                                                        {{ Str::limit($product->getTranslatedAttribute('name', App::getLocale(), 'en'), 45) }}
                                                    </div>
                                                    <div class="product-price">
                                                        <span
                                                            class="mrp">{{ Config::get('icrm.currency.icon') }}{{ $product->offer_price }}/-
                                                        </span>
                                                        <span
                                                            class="sp">{{ Config::get('icrm.currency.icon') }}{{ $product->mrp }}
                                                            <br /></span>
                                                    </div>
                                                    @if ($product->mrp > $product->offer_price)
                                                        @php
                                                            $discount = $product->mrp - $product->offer_price;
                                                            $discountPercent = ($discount / $product->mrp) * 100;
                                                        @endphp
                                                        <div class="off">({{ round($discountPercent) }}% off)</div>
                                                    @endif
                                                </div>

                                                <div class="product-action-vertical-new">
                                                    {{-- <a href="#" class="wishlist"> --}}
                                                    {{-- <img src="{{ asset('/images/icons/wishlist.svg') }}" alt="wishlist"> --}}
                                                    {{-- </a> --}}
                                                    {{-- <a class="cart"> --}}
                                                    {{-- <img src="{{ asset('/images/icons/cart.svg') }}" alt="cart"> --}}
                                                    {{-- </a> --}}
                                                    <div>
                                                        @livewire(
                                                            'quickview',
                                                            [
                                                                'product' => $product,
                                                                'view' => 'product-card',
                                                            ],
                                                            key($product->id . time())
                                                        )
                                                    </div>

                                                    <div>
                                                        @livewire(
                                                            'wishlist',
                                                            [
                                                                'wishlistproductid' => $product->id,
                                                                'view' => 'new-product-card',
                                                            ],
                                                            key($product->id . time())
                                                        )
                                                    </div>

                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </section>
                    @else
                        <section class="pt-3 mt-10">
                            <h1 class="similar-title justify-content-center" style="font-size: 4rem; !important;">Make the
                                look complete</h1>
                            <h2 class="similar-title2 justify-content-center">Outfit inspiration by Cartrefs</h2>

                            <div class="owl-carousel owl-theme owl-nav-full owl-loaded owl-drag home-product"
                                data-owl-options="{
                    'items': 5,
                    'nav': false,
                    'loop': true,
                    'dots': true,
                    'autoplayTimeout': 3000,
                    'margin': 20,
                    'responsive': {
                        '0': {
                            'items': 2
                        },
                        '768': {
                            'items': 3
                        },
                        '992': {
                            'items': 4,


                            'dots': true,
                            'nav': false
                        }
                    }
                }">


                                <div class="owl-stage-outer">
                                    <div class="owl-stage"
                                        style="transform: translate3d(0px, 0px, 0px); transition: all 0s ease 0s; width: 1200px;">
                                        @foreach ($relatedproducts as $key => $product)
                                            <div class="owl-item @if ($key == 0) active @endif"
                                                style="width: 280px; margin-right: 20px;">
                                                <div class="product">
                                                    <figure class="product-media">
                                                        <a href="{{ route('product.slug', ['slug' => $product->slug]) }}">
                                                            <img src="{{ Voyager::image($product->image) }}"
                                                                alt="{{ $product->name }}" width="280" height="315">
                                                        </a>
                                                        @include('product.badges')
                                                        <div class="product-action-vertical"
                                                            style="width: 29px height:29px">
                                                            {{-- <a href="#" class="btn-product-icon btn-cart" data-toggle="modal"
                                                                    data-target="#addCartModal" title="Add to cart"><i
                                                                        class="d-icon-bag"></i></a>
                                                                --}}
                                                            {{-- <a href="#" class="btn-product-icon btn-wishlist"
                                                                    title="Add to wishlist"><i class="d-icon-heart"></i></a> --}}
                                                            @livewire(
                                                                'wishlist',
                                                                [
                                                                    'wishlistproductid' => $product->id,
                                                                    'view' => 'product-card',
                                                                ],
                                                                key($product->id . time())
                                                            )
                                                            @livewire(
                                                                'quickview',
                                                                [
                                                                    'product' => $product,
                                                                    'view' => 'old-product-card',
                                                                ],
                                                                key($product->id . time())
                                                            )
                                                        </div>
                                                        {{-- <div class="product-action"> --}}
                                                        {{-- <a href="#" class="btn-product btn-quickview" title="Quick View">Quick
                                                                View</a> --}}
                                                        {{-- @livewire('quickview', [
                                                            'product' => $product
                                                            ], key($product->id.time()))
                                                        </div> --}}
                                                    </figure>
                                                    <div class="product-details">
                                                        <div class="product-cat">
                                                            <a
                                                                href="{{ route('products.subcategory', ['subcategory' => $product->productsubcategory->slug]) }}">{{ $product->productsubcategory->name }}</a>
                                                        </div>
                                                        <h3 class="product-name">
                                                            <a
                                                                href="{{ route('product.slug', ['slug' => $product->slug]) }}">{{ $product->getTranslatedAttribute('name', App::getLocale(), 'en') }}</a>
                                                        </h3>
                                                        <div class="product-price">
                                                            <ins
                                                                class="new-price">{{ config::get('icrm.currency.icon') }}{{ $product->offer_price }}</ins>
                                                            <del
                                                                class="old-price">{{ Config::get('icrm.currency.icon') }}{{ $product->mrp }}</del>

                                                        </div>
                                                        <div class="ratings-container">
                                                            <div class="ratings-full">
                                                                <span class="ratings"
                                                                    style="width:
                                                @if ($product->productreviews) {{ ($product->productreviews()->sum('rate') / ($product->productreviews()->count() * 5)) * 100 }}%
                                                @else
                                                0% @endif"></span>
                                                                <span class="tooltiptext tooltip-top"></span>
                                                            </div>
                                                            <a href="{{ route('product.slug', ['slug' => $product->slug]) }}"
                                                                class="link-to-tab rating-reviews">( @if ($product->productreviews)
                                                                    {{ $product->productreviews()->count() }}
                                                                @else
                                                                    0
                                                                @endif reviews )</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="owl-nav disabled">
                                    <button type="button" title="presentation" class="owl-prev disabled">
                                        <i class="d-icon-angle-left"></i>
                                    </button>
                                    <button type="button" title="presentation" class="owl-next disabled">
                                        <i class="d-icon-angle-right"></i>
                                    </button>
                                </div>
                                <div class="owl-dots disabled"></div>
                            </div>
                        </section>
                    @endif
                @endif
            @endisset
            <section class="product-btn">
                <a href="{{ $brandLink }}"
                    class="btn-cart text-normal ls-normal font-weight-semi-bold more-button-custom">
                    {{ $brandMoreText }}
                    <div class="badge-count">{{ $brandCount }}</div>
                </a>
                <a href="{{ $styleLink }}"
                    class="btn-cart text-normal ls-normal font-weight-semi-bold more-button-custom">
                    {{ $moreStyleText }}
                    <div class="badge-count">{{ $styleCount }}</div>
                </a>
                <a href="{{ $colourLink }}"
                    class="btn-cart text-normal ls-normal font-weight-semi-bold more-button-custom">
                    {{ $moreColourText }}
                    <div class="badge-count">{{ $colourCount }}</div>
                </a>
            </section>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    function slideDown(id) {
        if ($("#" + id))
            $("#" + id).slideDown(300);
    }

    function slideUp(id) {
        if ($("#" + id))
            $("#" + id).slideUp(300);
    }

    function slideToggle(id) {
        if ($("#" + id)) {
            $("#" + id).slideToggle(300, function() {
                if ($("#" + id).is(':visible')) {
                    $("#" + id + '-chevron-down').show();
                    $("#" + id + '-chevron-up').hide();
                } else {
                    $("#" + id + '-chevron-down').hide();
                    $("#" + id + '-chevron-up').show();
                }
            });
        }
    }
</script>
@endpush
