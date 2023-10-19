@extends('layouts.website')


@section('meta-seo')
    <title>{{ $product->getTranslatedAttribute('name', App::getLocale(), 'en') }}</title>
    <meta name="description" content="{{ $product->description }}">
@endsection

@section('headerlinks')
    <style>
        .more-button-custom{
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
            transform: translate(-50%,-50%) !important;
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
    </style>
@endsection


@section('content')
    @section('mainclass')
        mt-6 single-product
    @endsection
<div class="container">
    <div class="page-content mb-10 pb-6">
        <div class="container">
            <div class="product product-single row mb-7">

                <div class="col-md-7 hidden-sm hidden-md hidden-lg">
                    <div class="product-details">
                        <div class="product-navigation">
                            <ul class="breadcrumb breadcrumb-lg">
                                <li><a href="{{ route('welcome') }}"><i class="d-icon-home"></i></a></li>
                                <li><a href="{{ route('products') }}" class="active">Products</a></li>
                                <li>{{ $product->productsubcategory->name }}</li>
                            </ul>

                            <ul class="product-nav">
                                @isset($previous)
                                    @if (!empty($previous))
                                    <li class="product-nav-prev">
                                        <a href="{{ route('product.slug', ['slug' => $previous->slug]) }}">
                                            <i class="d-icon-arrow-left"></i> Prev
                                            <span class="product-nav-popup">
                                                <img src="{{ Voyager::image($previous->image) }}" alt="{{ $previous->name }} thumbnail" width="110" height="123">
                                                <span class="product-name">
                                                    {{ Str::limit($previous->getTranslatedAttribute('name', App::getLocale(), 'en'), 10) }}
                                                </span>
                                            </span>
                                        </a>
                                    </li>
                                    @endif
                                @endisset
                                @isset($next)
                                    @if (!empty($next))
                                    <li class="product-nav-next">
                                        <a href="{{ route('product.slug', ['slug' => $next->slug]) }}">
                                            Next <i class="d-icon-arrow-right"></i>
                                            <span class="product-nav-popup">
                                                <img src="{{ Voyager::image($next->image) }}" alt="{{ $next->name }} thumbnail" width="110" height="123">
                                                <span class="product-name">
                                                    {{ Str::limit($next->getTranslatedAttribute('name', App::getLocale(), 'en'), 10) }}
                                                </span>
                                            </span>
                                        </a>
                                    </li>
                                    @endif
                                @endisset
                            </ul>
                        </div>

                        <h1 class="product-name">
                            <a href="{{ route('product.slug', ['slug' => $product->slug]) }}">
                                {{ $product->getTranslatedAttribute('name', App::getLocale(), 'en') }}
                            </a>
                        </h1>
                        <div class="product-meta">
                            SKU: <span class="product-sku">{{ strtoupper($product->sku )}}</span>
                            BRAND: <span class="product-brand">{{ ucwords($product->brand_id) }}</span>
                            @if (Config::get('icrm.site_package.multi_vendor_store') == 1)
                                Vendor: <span class="product-brand">
                                    <a href="{{ route('products.vendor', ['slug' => $product->seller_id]) }}" target="_blank">
                                        {{ ucwords($product->vendor->brand_name) }}
                                    </a>
                                </span>
                            @endif
                        </div>



                    </div>
                </div>

                {{-- Product Images Livewire --}}
                @livewire('product.productimages', [
                    'product' => $product
                ])


                <div class="col-md-7">
                    <div class="product-details">
                        <div class="product-navigation hidden-xs">
                            <ul class="breadcrumb breadcrumb-lg">
                                <li><a href="{{ route('welcome') }}"><i class="d-icon-home"></i></a></li>
                                <li><a href="{{ route('products') }}" class="active">Products</a></li>
                                <li>{{ $product->productsubcategory->name }}</li>
                            </ul>

                            <ul class="product-nav">
                                @isset($previous)
                                    @if (!empty($previous))
                                    <li class="product-nav-prev">
                                        <a href="{{ route('product.slug', ['slug' => $previous->slug]) }}">
                                            <i class="d-icon-arrow-left"></i> Prev
                                            <span class="product-nav-popup">
                                                <img src="{{ Voyager::image($previous->image) }}" alt="{{ $previous->name }} thumbnail" width="110" height="123">
                                                <span class="product-name">
                                                    {{ Str::limit($previous->getTranslatedAttribute('name', App::getLocale(), 'en'), 10) }}
                                                </span>
                                            </span>
                                        </a>
                                    </li>
                                    @endif
                                @endisset
                                @isset($next)
                                    @if (!empty($next))
                                    <li class="product-nav-next">
                                        <a href="{{ route('product.slug', ['slug' => $next->slug]) }}">
                                            Next <i class="d-icon-arrow-right"></i>
                                            <span class="product-nav-popup">
                                                <img src="{{ Voyager::image($next->image) }}" alt="{{ $next->name }} thumbnail" width="110" height="123">
                                                <span class="product-name">
                                                    {{ Str::limit($next->getTranslatedAttribute('name', App::getLocale(), 'en'), 10) }}
                                                </span>
                                            </span>
                                        </a>
                                    </li>
                                    @endif
                                @endisset
                            </ul>
                        </div>

                        <h1 class="product-name hidden-xs">
                            <a href="{{ route('product.slug', ['slug' => $product->slug]) }}">
                                {{ $product->getTranslatedAttribute('name', App::getLocale(), 'en') }}
                            </a>
                        </h1>
                        <div class="product-meta hidden-xs">
                            SKU: <span class="product-sku">{{ strtoupper($product->sku )}}</span>
                            BRAND: <span class="product-brand">{{ ucwords($product->brand_id) }}</span>
                            @if (Config::get('icrm.site_package.multi_vendor_store') == 1)
                                Vendor: <span class="product-brand">
                                    <a href="{{ route('products.vendor', ['slug' => $product->seller_id]) }}" target="_blank">
                                        {{ ucwords($product->vendor->brand_name) }}
                                    </a>
                                </span>
                            @endif
                        </div>


                        @livewire('addskutobag', [
                            'product' => $product
                        ])

                        <hr class="product-divider mb-3">

                        <div class="product-footer">
                            {{-- <div class="social-links mr-4">
                                <a href="#" class="social-link social-facebook fab fa-facebook-f"></a>
                                <a href="#" class="social-link social-twitter fab fa-twitter"></a>
                                <a href="#" class="social-link social-pinterest fab fa-pinterest-p"></a>
                            </div> --}}
                            {!! $shareComponent !!}
                            {{-- <span class="divider d-lg-show"></span> --}}
                            {{-- <a href="#" class="btn-product btn-wishlist mr-6"><i class="d-icon-heart"></i>Add to
                                wishlist</a> --}}
                            @livewire('wishlist', [
                                'wishlistproductid' => $product->id,
                                'view' => 'product-page',
                            ])

                            {{-- <span class="divider d-lg-show"></span> --}}

                            @if (!empty($product->brochure))
                                @foreach (json_decode($product->brochure) as $key => $brochure)
                                    <a href="{{ asset('/storage/'.$brochure->download_link) }}" target="_blank" class="btn-product btn-product-down mr-6 link"><i class="fa fa-download"></i>Download {{ Config::get('icrm.frontend.brochure.name') }} {{ number_format($key+1, 0) }}</a>
                                @endforeach
                            @endif

                        </div>
                    </div>
                </div>
            </div>

            <div class="tab tab-nav-simple product-tabs">
                <ul class="nav nav-tabs justify-content-center" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" href="#product-tab-description">Description</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#product-tab-additional">Additional information</a>
                    </li>
                    @if (!empty($product->size_guide))
                    <li class="nav-item">
                        <a class="nav-link" href="#product-tab-size-guide">Size Guide</a>
                    </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link" href="#product-tab-reviews">Reviews ( @if($product->productreviews()) {{ $product->productreviews()->count() }} @else 0 @endif)</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active in" id="product-tab-description">
                        <div class="row mt-6">
                            <div class="col-md-6">
                                <h5 class="description-title mb-4 font-weight-semi-bold ls-m">Features</h5>
                                {!! $product->features !!}
                                <br>
                                <h5 class="description-title mb-3 font-weight-semi-bold ls-m">Specifications
                                </h5>
                                <table class="table">
                                    <tbody>
                                        @if (!empty($product->type_id))
                                            <tr>
                                                <th class="font-weight-semi-bold text-dark pl-0">Type</th>
                                                <td class="pl-4">{{ $product->type_id }}</td>
                                            </tr>
                                        @endif

                                        @if (!empty($product->mount_id))
                                        <tr>
                                            <th class="font-weight-semi-bold text-dark pl-0">Mount</th>
                                            <td class="pl-4">{{ $product->mount_id }}</td>
                                        </tr>
                                        @endif

                                        @if (!empty($product->modellist_id))
                                        <tr>
                                            <th class="font-weight-semi-bold text-dark pl-0">Model</th>
                                            <td class="pl-4">{{ $product->modellist_id }}</td>
                                        </tr>
                                        @endif

                                        @if (!empty($product->voltage_id))
                                        <tr>
                                            <th class="font-weight-semi-bold text-dark pl-0">Voltage</th>
                                            <td class="pl-4">{{ $product->voltage_id }}</td>
                                        </tr>
                                        @endif

                                        @if (!empty($product->interface_id))
                                        <tr>
                                            <th class="font-weight-semi-bold text-dark pl-0">Interface</th>
                                            <td class="pl-4">{{ $product->interface_id }}</td>
                                        </tr>
                                        @endif

                                        @if (!empty($product->displaytype_id))
                                        <tr>
                                            <th class="font-weight-semi-bold text-dark pl-0">Display Type</th>
                                            <td class="pl-4">{{ $product->displaytype_id }}</td>
                                        </tr>
                                        @endif

                                        @if (!empty($product->displaycolor_id))
                                        <tr>
                                            <th class="font-weight-semi-bold text-dark pl-0">Display Color</th>
                                            <td class="pl-4">{{ $product->displaycolor_id }}</td>
                                        </tr>
                                        @endif

                                        @if (!empty($product->pb_id))
                                        <tr>
                                            <th class="font-weight-semi-bold text-dark pl-0">PB</th>
                                            <td class="pl-4">{{ $product->pb_id }}</td>
                                        </tr>
                                        @endif

                                        @if (!empty($product->max_g))
                                        <tr>
                                            <th class="font-weight-semi-bold text-dark pl-0">Maximum G+</th>
                                            <td class="pl-4">{{ $product->max_g }}</td>
                                        </tr>
                                        @endif

                                        @if (!empty($product->gender_id))
                                        <tr>
                                            <th class="font-weight-semi-bold text-dark border-no pl-0">
                                                Gender</th>
                                            <td class="border-no pl-4">{{ $product->gender_id }}</td>
                                        </tr>
                                        @endif

                                        @if (!empty($product->style_id))
                                        <tr>
                                            <th class="font-weight-semi-bold text-dark border-no pl-0">
                                                Style</th>
                                            <td class="border-no pl-4">{{ $product->style_id }}</td>
                                        </tr>
                                        @endif

                                        @if (!empty($product->brand_id))
                                        <tr>
                                            <th class="font-weight-semi-bold text-dark border-no pl-0">
                                                Brand</th>
                                            <td class="border-no pl-4">{{ $product->brand_id }}</td>
                                        </tr>
                                        @endif

                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-6 pl-md-6 pt-4 pt-md-0">
                                {{-- <h5 class="description-title font-weight-semi-bold ls-m mb-5">Video Description
                                </h5>
                                <figure class="p-relative d-inline-block mb-2">
                                    <img src="{{ asset('images/product/product.jpg') }}" alt="Product" width="559" height="370">
                                    <a class="btn-play btn-iframe" href="https://www.youtube.com/embed/e0sl9rp8Ny0">
                                        <i class="d-icon-play-solid"></i>
                                    </a>
                                </figure> --}}
                                <div class="icon-box-wrap d-flex flex-wrap">
                                    <div class="icon-box icon-box-side icon-border pt-2 pb-2 mb-4 mr-10">
                                        <div class="icon-box-icon">
                                            <i class="d-icon-lock"></i>
                                        </div>
                                        <div class="icon-box-content">
                                            <h4 class="icon-box-title lh-1 pt-1 ls-s text-normal">Secured Payment</h4>
                                            <p>Guarantee with no doubt</p>
                                        </div>
                                    </div>
                                    {{-- <div class="divider d-xl-show mr-10"></div> --}}
                                    <div class="icon-box icon-box-side icon-border pt-2 pb-2 mb-4">
                                        <div class="icon-box-icon">
                                            <i class="d-icon-truck"></i>
                                        </div>
                                        <div class="icon-box-content">
                                            <h4 class="icon-box-title lh-1 pt-1 ls-s text-normal">Fastest Shipping
                                            </h4>
                                            <p>Secured</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="product-tab-additional">
                        <ul class="list-none">

                            @if (Config::get('icrm.site_package.multi_vendor_store') == 1)
                                <li><label>Vendor:</label>
                                    <p>
                                        <a href="{{ route('products.vendor', ['slug' => $product->seller_id]) }}" style="color: blue;">
                                            {{ $product->vendor->name }}
                                        </a>
                                    </p>
                                </li>
                            @endif


                            <li><label>Brand:</label>
                                <p>{{ $product->brand_id }}</p>
                            </li>
{{--
                            @if (count($product->productcolors) > 0)
                                <li><label>Color:</label>
                                    <p>
                                        @foreach ($product->productcolors as $key => $color)
                                            {{ $color->color }},
                                        @endforeach
                                    </p>
                                </li>
                            @endif

                            @if (count($product->productskus) > 0)
                                <li><label>Size:</label>
                                    <p>
                                        @foreach ($product->productskus as $key => $size)
                                            {{ $size->size }},
                                        @endforeach
                                    </p>
                                </li>
                            @endif --}}

                            @if (!empty($product->max_g))
                                <li><label>Maximum G+:</label>
                                    <p>{{ $product->max_g }}</p>
                                </li>
                            @endif

                            @if (!empty($product->cost_per_g))
                                <li><label>Cost per G:</label>
                                    <p>{{ Config::get('icrm.currency.icon') }}{{ $product->cost_per_g }}</p>
                                </li>
                            @endif

                            <li><label>Length:</label>
                                <p>{{ $product->length }}</p>
                            </li>

                            <li><label>Breadth:</label>
                                <p>{{ $product->breadth }}</p>
                            </li>

                            <li><label>Height:</label>
                                <p>{{ $product->height }}</p>
                            </li>

                            <li><label>Weight:</label>
                                <p>{{ $product->weight }}</p>
                            </li>

                        </ul>
                    </div>

                    @if (!empty($product->size_guide))
                        <div class="tab-pane" id="product-tab-size-guide">
                            <figure class="mt-4 mb-4" style="margin: auto;">
                                <img src="{{ Voyager::image($product->size_guide) }}" alt="Size Guide {{ $product->name }}" class="img-responsive">
                            </figure>
                        </div>
                    @endif

                    <div class="tab-pane" id="product-tab-reviews">
                        @livewire('product.reviews', [
                            'product' => $product
                        ])
                    </div>
                </div>
            </div>

            @isset($relatedproducts)
                @if (count($relatedproducts) > 0)
                    <section class="pt-3 mt-10">
                        <h1 class="title justify-content-center" style="font-size: 4.8rem;">Similar Products</h1>

{{--                        <div class="owl-carousel owl-theme owl-nav-full owl-loaded owl-drag home-product mt-4" data-owl-options="{--}}
{{--                            'items': 5,--}}
{{--                            'nav': false,--}}
{{--                            'loop': true,--}}
{{--                            'dots': true,--}}
{{--                            'autoplayTimeout': 3000,--}}
{{--                            'margin': 20,--}}
{{--                            'responsive': {--}}
{{--                                '0': {--}}
{{--                                    'items': 2--}}
{{--                                },--}}
{{--                                '768': {--}}
{{--                                    'items': 3--}}
{{--                                },--}}
{{--                                '992': {--}}
{{--                                    'items': 4,--}}
{{--                                    'dots': true,--}}
{{--                                    'nav': false--}}
{{--                                }--}}
{{--                            }--}}
{{--                        }">--}}



                        <div class="row cols-2 cols-sm-5 justify-content-center product-wrapper box-mode">
{{--                            <div class="owl-stage" style="transform: translate3d(0px, 0px, 0px); transition: all 0s ease 0s; width: 1200px;">--}}
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
                                                    <img class="product-image" src="{{ Voyager::image($firstcolorimage) }}" alt="{{ $product->name }}"/>

                                                    @if($product->productreviews && $product->productreviews()->count())
                                                        <div class="product-rating-horizontal">
                                                            <div class="star">
                                                                @if ($product->productreviews)
                                                                    {{ ($product->productreviews()->where('status', 1)->sum('rate') /($product->productreviews()->where('status', 1)->count() *5)) * 5 }}
                                                                @else
                                                                    0
                                                                @endif &nbsp;
                                                                <img src="{{ asset('/images/icons/star.svg') }}" alt="star">
                                                            </div>
                                                            <span class="dash">|</span>
                                                            <div class="book">
                                                                {{ $product->productreviews()->count()  }} &nbsp;
                                                                <img src="{{ asset('/images/icons/book.svg') }}" alt="book">
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>

                                                <div class="content">
                                                    <div class="brand-name">{{ $product->brand_id }}</div>
                                                    <div class="product-name">{{ Str::limit($product->getTranslatedAttribute('name', App::getLocale(), 'en'), 45) }}</div>
                                                    <div class="product-price">
                                                        <span class="mrp">{{ Config::get('icrm.currency.icon') }}{{ $product->offer_price }}/- </span>
                                                        <span class="sp">{{ Config::get('icrm.currency.icon') }}{{ $product->mrp }} <br/></span>
                                                    </div>
                                                    @if($product->mrp > $product->offer_price)
                                                        @php
                                                            $discount = $product->mrp - $product->offer_price;
                                                            $discountPercent = ($discount / $product->mrp) * 100;
                                                        @endphp
                                                        <div class="off">({{ round($discountPercent)  }}% off)</div>
                                                    @endif
                                                </div>

                                                <div class="product-action-vertical-new">
                                                    {{--                                            <a href="#" class="wishlist">--}}
                                                    {{--                                                <img src="{{ asset('/images/icons/wishlist.svg') }}" alt="wishlist">--}}
                                                    {{--                                            </a>--}}
                                                    {{--                                            <a class="cart">--}}
                                                    {{--                                                <img src="{{ asset('/images/icons/cart.svg') }}" alt="cart">--}}
                                                    {{--                                            </a>--}}
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
{{--                            </div>--}}
                        </div>
{{--                            <div class="owl-nav disabled">--}}
{{--                                <button type="button" title="presentation" class="owl-prev disabled">--}}
{{--                                    <i class="d-icon-angle-left"></i>--}}
{{--                                </button>--}}
{{--                                <button type="button" title="presentation" class="owl-next disabled">--}}
{{--                                    <i class="d-icon-angle-right"></i>--}}
{{--                                </button>--}}
{{--                            </div>--}}
{{--                            <div class="owl-dots disabled"></div>--}}
{{--                    </div>--}}
                    </section>
                @endif
            @endisset
            <section style="display: flex;gap: 10px;margin-top: 2rem;">
                <a href="{{ $brandLink  }}" class="btn-product btn-cart text-normal ls-normal font-weight-semi-bold more-button-custom  ">
                    {{ $brandMoreText  }}
                    <div class="badge-count">{{ $brandCount }}</div>
                </a>
                <a href="{{ $styleLink  }}" class="btn-product btn-cart text-normal ls-normal font-weight-semi-bold more-button-custom">
                    {{ $moreStyleText  }}
                    <div class="badge-count">{{ $styleCount }}</div>
                </a>
                <a href="{{ $colourLink  }}" class="btn-product btn-cart text-normal ls-normal font-weight-semi-bold more-button-custom">
                    {{ $moreColourText  }}
                    <div class="badge-count">{{ $colourCount }}</div>
                </a>
            </section>
        </div>
    </div>
</div>
@endsection
