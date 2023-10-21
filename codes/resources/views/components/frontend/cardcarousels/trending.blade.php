@if(isset($trendings))

    @if (count($trendings) > 0)
    <section class="appear-animate fadeIn appear-animation-visible home-product" data-animation-options="{
        'delay': '.2s'
    }" style="animation-duration: 1.2s;">
        <div class="container">
            <h2 class="title title-center">BE A SHOWSTOPPER</h2>
            <div class="owl-carousel owl-theme owl-nav-full owl-shadow-carousel owl-loaded owl-drag" data-owl-options="{
                'items': 4,
                'nav': false,
                'dots': true,
                'autoplayTimeout': 3000,
                'loop': false,
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
                        'nav': false,
                        'dots': true
                    }
                }
            }">


    <div class="owl-stage-outer">
    <div class="owl-stage" style="transform: translate3d(0px, 0px, 0px); transition: all 0s ease 0s; width: 1460px;">
        @foreach ($trendings as $product)
        <div class="owl-item active" style="width: 345px; margin-right: 20px;">
                <div class="product text-center">
                    <figure class="product-media">
                        <a href="{{ route('product.slug', ['slug' => $product->slug]) }}">
                            <img src="{{ Voyager::image($product->image) }}" alt="{{ $product->name }}">
                        </a>
                        @include('product.badges')
                        <div class="product-action-vertical">
                            {{-- <a href="#" class="btn-product-icon btn-cart" data-toggle="modal" data-target="#addCartModal" title="Add to cart"><i class="d-icon-bag"></i></a> --}}
                            {{-- <a href="#" class="btn-product-icon btn-wishlist" title="Add to wishlist"><i class="d-icon-heart"></i></a> --}}
                            @livewire('wishlist', [
                                    'wishlistproductid' => $product->id,
                                    'view' => 'product-card',
                                ], key($product->id.time()))
                            @livewire('quickview', [
                                'product' => $product,
                                'view' => 'old-product-card',
                            ], key($product->id.time()))
                        </div>
                        <div class="product-action">
                            {{-- <a href="#" class="btn-product btn-quickview" title="Quick View">Quick View</a> --}}
                            @livewire('quickview', [
                                'product' => $product
                            ], key($product->id.time()))
                        </div>
                    </figure>
                    <div class="product-details">
                        <div class="product-cat" style="font-size: 12px">
{{--                            <a href="{{ route('products.subcategory', ['subcategory' => $product->productsubcategory->slug]) }}">{{ $product->productsubcategory->name }}</a>--}}
                            <a href="javascript:void(0)">{{ $product->brand_id }}</a>
                        </div>
                        <h3 class="product-name">
                            <a href="{{ route('product.slug', ['slug' => $product->slug]) }}">{{ $product->getTranslatedAttribute('name', App::getLocale(), 'en') }}</a>
                        </h3>
                        <div class="product-price">
                            <ins class="new-price">{{ Config::get('icrm.currency.icon') }}{{ $product->offer_price }}</ins><del class="old-price">{{ Config::get('icrm.currency.icon') }}{{ $product->mrp }}</del>
{{--                            @if (Config::get('icrm.site_package.multi_vendor_store'))--}}
{{--                                <span class="product-name"> by {{ $product->vendor->brand_name }}</span>--}}
{{--                            @endif--}}
                        </div>
                        @if($product->productreviews()->count() > 0)
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
                                <a href="{{ route('product.slug', ['slug' => $product->slug]) }}" class="link-to-tab rating-reviews">( @if($product->productreviews) {{ $product->productreviews()->count() }} @else 0 @endif reviews )</a>
                            </div>
                        @endif
                        {{-- @if (isset($product->productcolors))
                            @if (count($product->productcolors) > 0)
                                <div class="product-variations">
                                    @foreach ($product->productcolors as $key => $productcolor)
                                        <a class="color @if($key == 0) @endif" data-src="{{ Voyager::image($productcolor->main_image) }}" href="{{ route('product.slug', ['slug' => $product->slug, 'color' => $productcolor->color]) }}" style="background-color: {{ $productcolor->color }}"></a>
                                    @endforeach
                                </div>
                            @endif
                        @endif --}}
                    </div>
                </div>
        </div>
        @endforeach
    </div></div>
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
    </div>
    </section>
    @endif

@endisset
