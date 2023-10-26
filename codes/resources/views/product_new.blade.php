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
        .fancybox-content{
            transform: translate(0px, 0px) !important;
            width:100% !important;
            height:100% !important;
        }
        .fancybox-image{
            object-fit: contain;
        }
        .container{
            padding-left: 5px; !important;
            padding-right: 5px; !important;
            margin-top: 10px;
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
                    'product' => $product
                    ])

                    <div class="col-md-6 right-container">
                        <div style="display: block;">
                            <div class="brand-div">
                                <a tabindex="0" class="brand-a" href="https://www.zalando.be/pepe-jeans/" rel="">
                                    <span>
                                        <h3 class="brand-h3">Pepe Jeans</h3>
                                    </span>
                                </a>
                            </div>
                            <h1 class="title-h1">
                                <span>PEPE JEANS X RITA ORA LUCY - T-shirt print</span>
                            </h1>
                            <div class="price-div">
                                <div class="price-div2">
                                    <div class="price-div3">
                                        <p class="price-p">
                                            <span class="price-span">{{ Config::get('icrm.currency.icon') }} 44,95</span>
                                            <span class="price-inc">inclusief btw</span>
                                        </p>
                                    </div>
                                    <p></p>
                                </div>
                            </div>
                            <div class="color-container">
                                <div class="selected-color-div">
                                    <p class="color-p">
                                        <span class="color-span">
                                            <span class="color-span2" aria-hidden="true">Color :</span>
                                        </span>
                                        &nbsp;<span class="color-selected">white</span>
                                    </p>
                                </div>
                                <div>
                                    <div class="all-color-container">
                                        <ul class="colors-ul">
                                            <li class="colors-li">
                                                <div class="colors-li-div">
                                                    <div class="color-img-container">
                                                        <div class="color-img-div">
                                                            <img class="color-image" alt="Geselecteerd, black"
                                                                src="https://img01.ztat.net/article/spp-media-p1/ef27f54df2764a14a25eb2072fb4995d/b69897ea68304f8abfce040103bb5eca.jpg?imwidth=156&amp;filter=packshot"
                                                            />
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="colors-li">
                                                <div class="colors-li-div">
                                                    <div class="color-img-container">
                                                        <div class="color-img-div">
                                                            <img class="color-image" alt="Geselecteerd, black"
                                                                 src="https://img01.ztat.net/article/spp-media-p1/49d51fb086c54fe6b8864c37b9d6d395/25a77f9376b64ff190f78b3de8aa88e8.jpg?imwidth=156&filter=packshot"
                                                            />
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="colors-li">
                                                <div class="colors-li-div">
                                                    <div class="color-img-container">
                                                        <div class="color-img-div">
                                                            <img class="color-image" alt="Geselecteerd, black"
                                                                 src="https://img01.ztat.net/article/spp-media-p1/50a90e78d18841e0974ee6d78f91dd46/e91a1fae696941388c2b338715a6fe45.jpg?imwidth=156&filter=packshot"
                                                            />
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="colors-li">
                                                <div class="colors-li-div">
                                                    <div class="color-img-container">
                                                        <div class="color-img-div">
                                                            <img class="color-image" alt="Geselecteerd, black"
                                                                 src="https://img01.ztat.net/article/spp-media-p1/ef27f54df2764a14a25eb2072fb4995d/b69897ea68304f8abfce040103bb5eca.jpg?imwidth=156&amp;filter=packshot"
                                                            />
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="colors-li">
                                                <div class="colors-li-div">
                                                    <div class="color-img-container">
                                                        <div class="color-img-div">
                                                            <img class="color-image" alt="Geselecteerd, black"
                                                                 src="https://img01.ztat.net/article/spp-media-p1/8a0252e527bc4631a101fd4983225845/30b53d2971d64fdca92fb09d7afee8e5.jpg?imwidth=156&filter=packshot"
                                                            />
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="colors-li">
                                                <div class="colors-li-div">
                                                    <div class="color-img-container">
                                                        <div class="color-img-div">
                                                            <img class="color-image" alt="Geselecteerd, black"
                                                                 src="https://img01.ztat.net/article/spp-media-p1/b89ac0f9ad194719abb198350c197538/7c7a093fa5bd4aed9aca9e98f3bb5150.jpg?imwidth=156&filter=packshot"
                                                            />
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="colors-li">
                                                <div class="colors-li-div">
                                                    <div class="color-img-container">
                                                        <div class="color-img-div">
                                                            <img class="color-image" alt="Geselecteerd, black"
                                                                 src="https://img01.ztat.net/article/spp-media-p1/a49e44909c364e2bb3add566e3204feb/8a823c49f47f481a8a04644c87b9a573.jpg?imwidth=156&filter=packshot"
                                                            />
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-5">
                            <div class="d-block">
                                <div class="color-dropdown-wrapper">
                                    <div class="color-dropdown-container">
                                        <div class="color-dropdown-container2">
                                            <div class="color-dropdown-border"></div>
                                            <button class="color-dropdown-button" type="button" tabindex="0" id="picker-trigger">
                                                <span class="color-dropdown-span">Maat kiezen</span>
                                                <div class="color-dropdown-div">
                                                    <svg viewBox="0 0 24 24" width="1em" height="1em" fill="currentColor" class="color-dropdown-svg" focusable="false" aria-hidden="true">
                                                        <path d="M2.859 7.475a.75.75 0 0 1 1.06 0l7.55 7.55a.751.751 0 0 0 1.06 0l7.551-7.55a.75.75 0 1 1 1.061 1.06l-7.55 7.55a2.252 2.252 0 0 1-3.182 0l-7.55-7.55a.748.748 0 0 1 0-1.06z"></path>
                                                    </svg>
                                                </div>
                                            </button>

                                            <div class="size-list-wrapper">
                                                <div class="size-list-container">
                                                    <div class="size-div" >
                                                        <input type="checkbox" class="size-input" name="size-picker" value="" />
                                                        <div class="size-div2">
                                                            <label class="size-label">
                                                                <span class="size-span">
                                                                    <div class="size-span-div">
                                                                        <span class="size-name">XS</span>
                                                                    </div>
                                                                </span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="size-div" >
                                                        <input type="checkbox" class="size-input" name="size-picker" value="" />
                                                        <div class="size-div2">
                                                            <label class="size-label">
                                                                <span class="size-span">
                                                                    <div class="size-span-div">
                                                                        <span class="size-name">S</span>
                                                                    </div>
                                                                </span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="size-div" >
                                                        <input type="checkbox" class="size-input" name="size-picker" value="" />
                                                        <div class="size-div2">
                                                            <label class="size-label">
                                                                <span class="size-span">
                                                                    <div class="size-span-div">
                                                                        <span class="size-name">M</span>
                                                                    </div>
                                                                </span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="size-div" >
                                                        <input type="checkbox" class="size-input" name="size-picker" value="" />
                                                        <div class="size-div2">
                                                            <label class="size-label">
                                                                <span class="size-span">
                                                                    <div class="size-span-div">
                                                                        <span class="size-name">XL</span>
                                                                    </div>
                                                                </span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="size-div" >
                                                        <input type="checkbox" class="size-input" name="size-picker" value="" />
                                                        <div class="size-div2">
                                                            <label class="size-label">
                                                                <span class="size-span">
                                                                    <div class="size-span-div">
                                                                        <span class="size-name">XS</span>
                                                                    </div>
                                                                </span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="size-div" >
                                                        <input type="checkbox" class="size-input" name="size-picker" value="" />
                                                        <div class="size-div2">
                                                            <label class="size-label">
                                                                <span class="size-span">
                                                                    <div class="size-span-div">
                                                                        <span class="size-name">S</span>
                                                                    </div>
                                                                </span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="size-div" >
                                                        <input type="checkbox" class="size-input" name="size-picker" value="" />
                                                        <div class="size-div2">
                                                            <label class="size-label">
                                                                <span class="size-span">
                                                                    <div class="size-span-div">
                                                                        <span class="size-name">M</span>
                                                                    </div>
                                                                </span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="size-div" >
                                                        <input type="checkbox" class="size-input" name="size-picker" value="" />
                                                        <div class="size-div2">
                                                            <label class="size-label">
                                                                <span class="size-span">
                                                                    <div class="size-span-div">
                                                                        <span class="size-name">XL</span>
                                                                    </div>
                                                                </span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="buy-wrapper" data-testid="pdp-add-to-cart">
                                    <button class="add-to-cart-btn" type="button">
                                        <span class="add-to-cart-span">Add To Cart!</span>
                                    </button>
                                    <div class="new-wishlist-wrapper">
                                        <button class="new-wishlist-btn" type="button">
                                            <span class="new-wishlist-span">
                                                <svg viewBox="0 0 24 24" style="font-size: 24px;" width="1em" height="1em" fill="currentColor" aria-labelledby="wishlist-:R4k:" focusable="false" aria-hidden="false" role="img">
                                                    <title>Wishlist</title>
                                                    <path d="M17.488 1.11h-.146a6.552 6.552 0 0 0-5.35 2.81A6.57 6.57 0 0 0 6.62 1.116 6.406 6.406 0 0 0 .09 7.428c0 7.672 11.028 15.028 11.497 15.338a.745.745 0 0 0 .826 0c.47-.31 11.496-7.666 11.496-15.351a6.432 6.432 0 0 0-6.42-6.306zM12 21.228C10.018 19.83 1.59 13.525 1.59 7.442c.05-2.68 2.246-4.826 4.934-4.826h.088c2.058-.005 3.93 1.251 4.684 3.155.226.572 1.168.572 1.394 0 .755-1.907 2.677-3.17 4.69-3.16h.02c2.7-.069 4.96 2.118 5.01 4.817 0 6.089-8.429 12.401-10.41 13.8z"                                                    ></path>
                                                </svg>
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="sell-wrapper">
                            <div class="sell-wrapper2">
                                <div class="sell-and-shipped">
                                    <span class="sell-and-shipped-span">
                                        <p class="sell-and-shipped-p">Sell and shipped by </p>
                                    </span>
                                </div>
                                <div class="delivery-wrapper">
                                    <div class="delivery-conatiner">
                                        <div class="delivery-conatiner2">
                                            <p class="working-days">2-4 working days</p>
                                            <p class="standard-delivery">Standard delivery</p>
                                        </div>
                                        {{-- <div class="">--}}
                                        {{--   <p class="sDq_FX lystZ1 dgII7d HlZ_Tf">Free of charge</p>--}}
                                        {{-- </div>--}}
                                    </div>
                                </div>
                                <div class="free-shipping-return">
                                    <div class="free-shipping-return-wrapper">
                                        <svg viewBox="0 0 24 24" width="1em" height="1em" fill="currentColor" class="free-shipping-return-svg" focusable="false" aria-hidden="true">
                                            <path d="m16.5 14.5-4.2-1.9c-.2-.1-.4-.1-.6 0l-4.2 1.9V6.9l2-5.6h5l2 5.9v7.3zM9 7.3v4.9l2.1-.9c.6-.3 1.2-.3 1.8 0l2.1.9V7.3l-1.6-4.5h-2.9L9 7.3z"></path>
                                            <path
                                                    d="M20.5 22.8h-17c-1.2 0-2.2-1-2.2-2.2V19c0-.4.3-.8.8-.8s.8.3.8.8v1.5c0 .4.3.8.8.8h17c.4 0 .8-.3.8-.8V7.3c0-.1 0-.2-.1-.3l-1.5-3.8c-.1-.3-.4-.5-.7-.5H5c-.3 0-.6.2-.7.5L2.8 7c0 .1-.1.2-.1.3V10c0 .4-.3.8-.8.8s-.7-.4-.7-.8V7.3c0-.3.1-.6.2-.8l1.5-3.8c.4-.9 1.2-1.5 2.1-1.5h14c.9 0 1.7.6 2.1 1.4l1.5 3.8c.1.3.2.5.2.8v13.2c0 1.3-1.1 2.4-2.3 2.4z"
                                            ></path>
                                            <path d="M2 7h20v1.5H2zm2.8 6.8h-4c-.5 0-.8-.4-.8-.8s.3-.8.8-.8h4c.4 0 .8.3.8.8s-.4.8-.8.8zm0 3h-4c-.5 0-.8-.4-.8-.8s.3-.8.8-.8h4c.4 0 .8.3.8.8-.1.4-.4.8-.8.8z"></path>
                                        </svg>
                                        <p class="free-shipping-return-p">Free shipping and returns</p>
                                    </div>
                                </div>
                                <div class="seven-day-return">
                                    <div class="seven-day-return-wrapper">
                                        <svg viewBox="0 0 24 24" width="1em" height="1em" fill="currentColor" class="seven-day-return-svg" focusable="false" aria-hidden="true">
                                            <path
                                                    d="M14.25 4.33H1.939l3.056-3.055A.75.75 0 0 0 3.934.215L.658 3.49a2.252 2.252 0 0 0 0 3.182l3.276 3.275a.75.75 0 0 0 1.06-1.06L1.94 5.83h12.31c4.557 0 8.251 3.694 8.251 8.25s-3.695 8.42-8.251 8.42h-12a.75.75 0 0 0 0 1.5h12c5.385 0 9.75-4.534 9.75-9.919s-4.365-9.75-9.75-9.75z"
                                            ></path>
                                        </svg>
                                        <p class="seven-day-return-p">100 days right of return</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="XKeLfu">
                            <style data-trckng-component="F7vKnWK0eUjkhmWYUwTAc">
                                @media (max-width: 767px) {
                                    .z-pdp__escape-grid {
                                        margin: 0 -24px;
                                    }
                                }
                            </style>
                            <div class="z-pdp__escape-grid">
                                <div class="QsQR-j NN8L-8 JT3_zV _8sTSoF MxUWj-" data-testid="pdp-accordion-material_care">
                                    <h2 class="heWLCX">
                                        <button
                                                class="_ZDS_REF_SCOPE_ SX0LGY DJxzzA u9KIT8 uEg2FS U_OhzR ZkIJC- Vn-7c- FCIprz heWLCX Wu1CzW Md_Vex NN8L-8 _d3F40 P3OKTW mo6ZnF K82if3 VWL_Ot HlZ_Tf _13ipK_ LyRfpJ Z1Xqqm _8xiD-i sKmkSN pMa0tB"
                                                type="button"
                                                tabindex="0"
                                                aria-expanded="false"
                                        >
                                            <span class="JCuRr_">
                                                <span class="_0xLoFW _78xIQ- P3OKTW">
                                                    <span class="sDq_FX _2kjxJ6 dgII7d"><h5 class="sDq_FX EKH5rj FxZV-M HlZ_Tf">Materiaal &amp; wasvoorschrift</h5></span>
                                                </span>
                                            </span>
                                            <svg viewBox="0 0 24 24" width="1em" height="1em" fill="currentColor" class="zds-icon RC794g X9n9TI DlJ4rT _5Yd-hZ _4GmiZN nXkCf3 I_qHp3" focusable="false" aria-hidden="true">
                                                <path d="M2.859 7.475a.75.75 0 0 1 1.06 0l7.55 7.55a.751.751 0 0 0 1.06 0l7.551-7.55a.75.75 0 1 1 1.061 1.06l-7.55 7.55a2.252 2.252 0 0 1-3.182 0l-7.55-7.55a.748.748 0 0 1 0-1.06z"></path>
                                            </svg>
                                        </button>
                                    </h2>
                                    <div class="ZDZONQ ZkIJC- i8_8W0" style="max-height: 0px;">
                                        <div class="Z1Xqqm sb1S7G sKmkSN pMa0tB">
                                            <div class="" style="white-space: pre-line;">
                                                <dl>
                                                    <div class="qMOFyE">
                                                        <dt class="sDq_FX lystZ1 dgII7d HlZ_Tf zN9KaA" role="term">Materiaal buitenlaag:</dt>
                                                        &nbsp;
                                                        <dd class="sDq_FX lystZ1 FxZV-M HlZ_Tf zN9KaA" role="definition">100% katoen</dd>
                                                    </div>
                                                    <div class="qMOFyE">
                                                        <dt class="sDq_FX lystZ1 dgII7d HlZ_Tf zN9KaA" role="term">Materiaalverwerking:</dt>
                                                        &nbsp;
                                                        <dd class="sDq_FX lystZ1 FxZV-M HlZ_Tf zN9KaA" role="definition">Jersey</dd>
                                                    </div>
                                                    <div class="">
                                                        <dt class="sDq_FX lystZ1 dgII7d HlZ_Tf zN9KaA" role="term">Wasvoorschrift:</dt>
                                                        &nbsp;
                                                        <dd class="sDq_FX lystZ1 FxZV-M HlZ_Tf zN9KaA" role="definition">Machinewas tot 30 °C, niet geschikt voor de droger, niet bleken</dd>
                                                    </div>
                                                </dl>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="QsQR-j NN8L-8 JT3_zV _8sTSoF MxUWj-" data-testid="pdp-accordion-details">
                                    <h2 class="heWLCX">
                                        <button
                                                class="_ZDS_REF_SCOPE_ SX0LGY DJxzzA u9KIT8 uEg2FS U_OhzR ZkIJC- Vn-7c- FCIprz heWLCX Wu1CzW Md_Vex NN8L-8 _d3F40 P3OKTW mo6ZnF K82if3 VWL_Ot HlZ_Tf _13ipK_ LyRfpJ Z1Xqqm _8xiD-i sKmkSN pMa0tB"
                                                type="button"
                                                tabindex="0"
                                                aria-expanded="false"
                                        >
                                            <span class="JCuRr_">
                                                <span class="_0xLoFW _78xIQ- P3OKTW">
                                                    <span class="sDq_FX _2kjxJ6 dgII7d"><h5 class="sDq_FX EKH5rj FxZV-M HlZ_Tf">Alles over dit product</h5></span>
                                                </span>
                                            </span>
                                            <svg viewBox="0 0 24 24" width="1em" height="1em" fill="currentColor" class="zds-icon RC794g X9n9TI DlJ4rT _5Yd-hZ _4GmiZN nXkCf3 I_qHp3" focusable="false" aria-hidden="true">
                                                <path d="M2.859 7.475a.75.75 0 0 1 1.06 0l7.55 7.55a.751.751 0 0 0 1.06 0l7.551-7.55a.75.75 0 1 1 1.061 1.06l-7.55 7.55a2.252 2.252 0 0 1-3.182 0l-7.55-7.55a.748.748 0 0 1 0-1.06z"></path>
                                            </svg>
                                        </button>
                                    </h2>
                                    <div class="ZDZONQ ZkIJC- i8_8W0" style="max-height: 0;">
                                        <div class="Z1Xqqm sb1S7G sKmkSN pMa0tB">
                                            <div class="" style="white-space: pre-line;">
                                                <dl>
                                                    <div class="qMOFyE">
                                                        <dt class="sDq_FX lystZ1 dgII7d HlZ_Tf zN9KaA" role="term">Halslijn:</dt>
                                                        &nbsp;
                                                        <dd class="sDq_FX lystZ1 FxZV-M HlZ_Tf zN9KaA" role="definition">Ronde hals</dd>
                                                    </div>
                                                    <div class="qMOFyE">
                                                        <dt class="sDq_FX lystZ1 dgII7d HlZ_Tf zN9KaA" role="term">Transparant:</dt>
                                                        &nbsp;
                                                        <dd class="sDq_FX lystZ1 FxZV-M HlZ_Tf zN9KaA" role="definition">Licht</dd>
                                                    </div>
                                                    <div class="qMOFyE">
                                                        <dt class="sDq_FX lystZ1 dgII7d HlZ_Tf zN9KaA" role="term">Patroon:</dt>
                                                        &nbsp;
                                                        <dd class="sDq_FX lystZ1 FxZV-M HlZ_Tf zN9KaA" role="definition">Print</dd>
                                                    </div>
                                                    <div class="">
                                                        <dt class="sDq_FX lystZ1 dgII7d HlZ_Tf zN9KaA" role="term">Artikelnummer:</dt>
                                                        &nbsp;
                                                        <dd class="sDq_FX lystZ1 FxZV-M HlZ_Tf zN9KaA" role="definition">PE121D0TO-A11</dd>
                                                    </div>
                                                </dl>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="QsQR-j NN8L-8 JT3_zV _8sTSoF MxUWj-" data-testid="pdp-accordion-size_fit">
                                    <h2 class="heWLCX">
                                        <button
                                                class="_ZDS_REF_SCOPE_ SX0LGY DJxzzA u9KIT8 uEg2FS U_OhzR ZkIJC- Vn-7c- FCIprz heWLCX Wu1CzW Md_Vex NN8L-8 _d3F40 P3OKTW mo6ZnF K82if3 VWL_Ot HlZ_Tf _13ipK_ LyRfpJ Z1Xqqm _8xiD-i sKmkSN pMa0tB"
                                                type="button"
                                                tabindex="0"
                                                aria-expanded="false"
                                        >
                                            <span class="JCuRr_">
                                                <span class="_0xLoFW _78xIQ- P3OKTW">
                                                    <span class="sDq_FX _2kjxJ6 dgII7d">
                                                        <div class="_0xLoFW FCIprz"><h5 class="sDq_FX EKH5rj FxZV-M HlZ_Tf">Fitting</h5></div>
                                                    </span>
                                                </span>
                                            </span>
                                            <svg viewBox="0 0 24 24" width="1em" height="1em" fill="currentColor" class="zds-icon RC794g X9n9TI DlJ4rT _5Yd-hZ _4GmiZN nXkCf3 I_qHp3" focusable="false" aria-hidden="true">
                                                <path d="M2.859 7.475a.75.75 0 0 1 1.06 0l7.55 7.55a.751.751 0 0 0 1.06 0l7.551-7.55a.75.75 0 1 1 1.061 1.06l-7.55 7.55a2.252 2.252 0 0 1-3.182 0l-7.55-7.55a.748.748 0 0 1 0-1.06z"></path>
                                            </svg>
                                        </button>
                                    </h2>
                                    <div class="ZDZONQ ZkIJC- i8_8W0" style="max-height: 0;">
                                        <div class="Z1Xqqm sb1S7G sKmkSN pMa0tB">
                                            <div class="" style="white-space: pre-line;">
                                                <dl>
                                                    <div class="qMOFyE">
                                                        <dt class="sDq_FX lystZ1 dgII7d HlZ_Tf zN9KaA" role="term">Lichaamslengte model:</dt>
                                                        &nbsp;
                                                        <dd class="sDq_FX lystZ1 FxZV-M HlZ_Tf zN9KaA" role="definition">Ons model is 177 cm lang en draagt maat S</dd>
                                                    </div>
                                                    <div class="qMOFyE">
                                                        <dt class="sDq_FX lystZ1 dgII7d HlZ_Tf zN9KaA" role="term">Pasvorm:</dt>
                                                        &nbsp;
                                                        <dd class="sDq_FX lystZ1 FxZV-M HlZ_Tf zN9KaA" role="definition">Regular Fit</dd>
                                                    </div>
                                                    <div class="qMOFyE">
                                                        <dt class="sDq_FX lystZ1 dgII7d HlZ_Tf zN9KaA" role="term">Vorm:</dt>
                                                        &nbsp;
                                                        <dd class="sDq_FX lystZ1 FxZV-M HlZ_Tf zN9KaA" role="definition">Tapered</dd>
                                                    </div>
                                                    <div class="qMOFyE">
                                                        <dt class="sDq_FX lystZ1 dgII7d HlZ_Tf zN9KaA" role="term">Lengte:</dt>
                                                        &nbsp;
                                                        <dd class="sDq_FX lystZ1 FxZV-M HlZ_Tf zN9KaA" role="definition">Normaal</dd>
                                                    </div>
                                                    <div class="qMOFyE">
                                                        <dt class="sDq_FX lystZ1 dgII7d HlZ_Tf zN9KaA" role="term">Mouwlengte:</dt>
                                                        &nbsp;
                                                        <dd class="sDq_FX lystZ1 FxZV-M HlZ_Tf zN9KaA" role="definition">Extra korte mouw</dd>
                                                    </div>
                                                    <div class="">
                                                        <dt class="sDq_FX lystZ1 dgII7d HlZ_Tf zN9KaA" role="term">Totale lengte:</dt>
                                                        &nbsp;
                                                        <dd class="sDq_FX lystZ1 FxZV-M HlZ_Tf zN9KaA" role="definition">54 cm bij maat S</dd>
                                                    </div>
                                                </dl>
                                            </div>
                                            <div class="DJxzzA Ymx2h-">
                                                <button
                                                        class="_ZDS_REF_SCOPE_ _4HcdR8 DJxzzA u9KIT8 uEg2FS U_OhzR ZkIJC- Vn-7c- FCIprz heWLCX LyRfpJ NN8L-8 K82if3 Md_Vex HlZ_Tf VWL_Ot _13ipK_ OGTPbw EKabf7 aX2-iv r9BRio _2wi8M3 Md_Vex Wy3rmK"
                                                        type="button"
                                                        aria-haspopup="true"
                                                        aria-expanded="false"
                                                        tabindex="0"
                                                >
                                                    <span class="JGtyGq heWLCX ZkIJC- r9BRio qXofat sDq_FX _2kjxJ6 dgII7d">Maattabel</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="_0xLoFW EJ4MLB O4Aj42 svLiZt ykb2t2 q84f1m snL7ze sKmkSN pMa0tB">
                                    <h5 class="sDq_FX EKH5rj FxZV-M HlZ_Tf q84f1m snL7ze">Pepe Jeans</h5>
                                    <div class="_0xLoFW FCIprz">
                                        <button
                                                class="_ZDS_REF_SCOPE_ mROyo1 Pn5Px2 zcfRTH _2iCVgy DJxzzA u9KIT8 uEg2FS U_OhzR ZkIJC- Vn-7c- FCIprz heWLCX LyRfpJ Md_Vex NN8L-8 VWL_Ot _13ipK_ MaAr8t K82if3 HlZ_Tf gcK-9K EKabf7 aX2-iv r9BRio oIVdPD XfNx0j"
                                                type="button"
                                                aria-pressed="false"
                                                aria-label="Volg Pepe Jeans"
                                        >
                                            <svg
                                                    viewBox="0 0 24 24"
                                                    width="1em"
                                                    height="1em"
                                                    fill="currentColor"
                                                    class="zds-icon RC794g X9n9TI DlJ4rT _5Yd-hZ fo5HXp qbFh83 QVz7Pz _9l1hln iXbgaG nXkCf3 DlJ4rT _9l1hln _65i7kZ QfLC_c Ik4W2Q"
                                                    focusable="false"
                                                    aria-hidden="true"
                                            >
                                                <path d="M20.25 11.2h-7.5V3.7a.75.75 0 0 0-1.5 0v7.5h-7.5a.75.75 0 0 0 0 1.5h7.5v7.5a.75.75 0 0 0 1.5 0v-7.5h7.5a.75.75 0 0 0 0-1.5z"></path>
                                            </svg>
                                            <span class="_9l1hln heWLCX ZkIJC- r9BRio qXofat sDq_FX lystZ1 FxZV-M">Volg</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="XKeLfu">
                            <button type="button" color="interactive" class="Rt7sMf _6-WsK3 Md_Vex Nk_Omi _MmCDa NN8L-8 K82if3 _0xLoFW vSgP6A" data-trckng-component="gN2F28XmLDQV-gRR9BmEz">
                                <i aria-hidden="true" role="presentation" translate="no" class="OXFOVc font-1srjmmp _7_FqPM _65i7kZ HG8yY9">flag</i>
                                <h5 class="sDq_FX _2kjxJ6 FxZV-M _7_FqPM">Meld een juridisch probleem</h5>
                            </button>
                        </div>
                    </div>

                </div>

                @php
                    function isMobile()
                    {
                    return is_numeric(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'mobile'));
                    }
                @endphp

                @isset($relatedproducts)
                    @if (count($relatedproducts) > 0)
                        @if(!isMobile())
                            <section class="pt-3 mt-10">
                                <h1 class="title justify-content-center" style="font-size: 4.8rem;">Similar
                                    Products</h1>
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
                                        <div class="new-product-wrap owl-item @if($key == 0) active @endif">
                                            <a href="{{ route('product.slug', ['slug' => $product->slug]) }}">
                                                <div class="new-product">
                                                    <div class="image">
                                                        <img class="product-image"
                                                             src="{{ Voyager::image($firstcolorimage) }}"
                                                             alt="{{ $product->name }}"/>

                                                        @if($product->productreviews && $product->productreviews()->count())
                                                            <div class="product-rating-horizontal">
                                                                <div class="star">
                                                                    @if ($product->productreviews)
                                                                        {{ ($product->productreviews()->where('status', 1)->sum('rate')
                                                                        /($product->productreviews()->where('status', 1)->count() *5)) * 5
                                                                        }}
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
                                                        <div class="product-name">{{
                                        Str::limit($product->getTranslatedAttribute('name', App::getLocale(),
                                        'en'), 45) }}</div>
                                                        <div class="product-price">
                                        <span class="mrp">{{ Config::get('icrm.currency.icon') }}{{
                                            $product->offer_price }}/- </span>
                                                            <span class="sp">{{ Config::get('icrm.currency.icon') }}{{ $product->mrp
                                            }} <br/></span>
                                                        </div>
                                                        @if($product->mrp > $product->offer_price)
                                                            @php
                                                                $discount = $product->mrp - $product->offer_price;
                                                                $discountPercent = ($discount / $product->mrp) * 100;
                                                            @endphp
                                                            <div class="off">({{ round($discountPercent) }}% off)</div>
                                                        @endif
                                                    </div>

                                                    <div class="product-action-vertical-new">
                                                        {{-- <a href="#" class="wishlist">--}}
                                                        {{-- <img src="{{ asset('/images/icons/wishlist.svg') }}" alt="wishlist">--}}
                                                        {{-- </a>--}}
                                                        {{-- <a class="cart">--}}
                                                        {{-- <img src="{{ asset('/images/icons/cart.svg') }}" alt="cart">--}}
                                                        {{-- </a>--}}
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
                                <h2 class="title justify-content-center">Similar Products</h2>

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
                                                <div class="owl-item @if($key == 0) active @endif"
                                                     style="width: 280px; margin-right: 20px;">
                                                    <div class="product">
                                                        <figure class="product-media">
                                                            <a href="{{ route('product.slug', ['slug' => $product->slug]) }}">
                                                                <img src="{{ Voyager::image($product->image) }}"
                                                                     alt="{{ $product->name }}"
                                                                     width="280" height="315">
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
                                                                @livewire('wishlist', [
                                                                'wishlistproductid' => $product->id,
                                                                'view' => 'product-card',
                                                                ], key($product->id.time()))
                                                                @livewire('quickview', [
                                                                'product' => $product,
                                                                'view' => 'old-product-card',
                                                                ], key($product->id.time()))
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
                                                                        href="{{ route('products.subcategory', ['subcategory' => $product->productsubcategory->slug]) }}">{{
                                                $product->productsubcategory->name }}</a>
                                                            </div>
                                                            <h3 class="product-name">
                                                                <a href="{{ route('product.slug', ['slug' => $product->slug]) }}">{{
                                                $product->getTranslatedAttribute('name', App::getLocale(), 'en') }}</a>
                                                            </h3>
                                                            <div class="product-price">
                                                                <ins class="new-price">{{ config::get('icrm.currency.icon') }}{{
                                                $product->offer_price }}</ins>
                                                                <del class="old-price">{{ Config::get('icrm.currency.icon') }}{{
                                                $product->mrp }}</del>

                                                            </div>
                                                            <div class="ratings-container">
                                                                <div class="ratings-full">
                                                <span class="ratings" style="width:
                                                @if($product->productreviews)
                                                {{ $product->productreviews()->sum('rate') / ($product->productreviews()->count() * 5) * 100 }}%
                                                @else
                                                0%
                                                @endif"></span>
                                                                    <span class="tooltiptext tooltip-top"></span>
                                                                </div>
                                                                <a href="{{ route('product.slug', ['slug' => $product->slug]) }}"
                                                                   class="link-to-tab rating-reviews">( @if($product->productreviews)
                                                                        {{
                                                                                                                       $product->productreviews()->count() }}
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
                    <a href="{{ $brandLink  }}"
                       class="btn-product btn-cart text-normal ls-normal font-weight-semi-bold more-button-custom">
                        {{ $brandMoreText }}
                        <div class="badge-count">{{ $brandCount }}</div>
                    </a>
                    <a href="{{ $styleLink  }}"
                       class="btn-product btn-cart text-normal ls-normal font-weight-semi-bold more-button-custom">
                        {{ $moreStyleText }}
                        <div class="badge-count">{{ $styleCount }}</div>
                    </a>
                    <a href="{{ $colourLink  }}"
                       class="btn-product btn-cart text-normal ls-normal font-weight-semi-bold more-button-custom">
                        {{ $moreColourText }}
                        <div class="badge-count">{{ $colourCount }}</div>
                    </a>
                </section>
            </div>
        </div>
    </div>
@endsection
