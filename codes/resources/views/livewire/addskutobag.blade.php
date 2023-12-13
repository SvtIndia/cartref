@if ($this->view == 'new-product-page')
    <div class="col-md-6 right-container">
        <div style="display: block;">
            <div class="brand-div">
                <a class="brand-a"
                   href="{{ route('products', ['brands[' . $product->brand_id . ']' => $product->brand_id]) }}"
                   target="_blank">
                    <span class="brand-span">
                        <h3 class="brand-h3">{{ ucwords($product->brand_id) }}</h3>
                    </span>
                </a>
            </div>
            <h1 class="title-h1">
                <span>{{ $product->getTranslatedAttribute('name', App::getLocale(), 'en') }}</span>
            </h1>
            <div class="price-div">
                <div class="price-div2">
                    <div class="price-div3">
                        <p class="price-p">
                            <span class="price-span">{{ Config::get('icrm.currency.icon') }}
                                <strong>{{ number_format($offer_price, 0) }}</strong>/-</span>
                            <del class="old-price">{{ Config::get('icrm.currency.icon') }}
                                {{ number_format($mrp, 0) }}</del>
                            <span class="price-inc">Inclusive of all taxes </span>
                        </p>
                    </div>
                    <p></p>
                </div>
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
                <a href="#product-tab-reviews" class="link-to-tab rating-reviews">
                    ( @if ($product->productreviews())
                        {{ $product->productreviews()->count() }}
                    @else
                        0
                    @endif reviews )
                </a>
            </div>
            @php
                $text = $product->getTranslatedAttribute('description', App::getLocale(), 'en');

                function splitText($text, $maxWords = 100)
                {
                    $words = preg_split('/\s+/', $text);
                    $firstPart = implode(' ', array_slice($words, 0, $maxWords));
                    $remainingPart = implode(' ', array_slice($words, $maxWords));

                    return [$firstPart, $remainingPart];
                }

                [$firstPart, $remainingPart] = splitText($text);

                $readMoreBtn = null;
                if (strlen($remainingPart) > 1) {
                    $readMoreBtn = '...<button id="">Read More</button>';
                }
            @endphp
            <p class="product-short-desc">
                {{ $firstPart }}
                @if (strlen($remainingPart) > 1)
                    <span style="cursor: pointer;font-weight: 500;color: black;"
                          onclick="$('#read-more-text').show(); $(this).hide();">... Read More</span>
                    <font style="display: none" id="read-more-text">{{ $remainingPart }}</font>
                @endif
            </p>
            @foreach ($this->offer_coupons as $coupon)
                <div class="pdp-promotion">
                    <div class="pdp-promo-block">
                        {{-- <div class="ic-offer-tag"></div> --}}
                        <div class="promo-blck">
                            <div class="promo-title-blck">
                                <div class="promo-title">Use Code <br>{{ $coupon->code }}</div>
                                <div class="promo-tnc-blck">
                                    <span class="promo-tnc">
                                        <a href="undefined" target="_blank"></a>
                                    </span>
                                </div>
                            </div>
                            <div class="promo-desc-block">
                                <div class="promo-discounted-price">Get it for
                                    <span>{{ Config::get('icrm.currency.icon') }}{{ number_format($coupon->discounted_value, 0) }}/-</span>
                                </div>
                                <div class="promo-desc">{{ $coupon->description }}
                                    <br>
                                    <a href="{{ route('products.vendor', ['slug' => $product->seller_id]) }}"
                                       target="_blank">
                                        View All Products
                                    </a>
                                    {{-- <a target="_blank" href="">View All Products</a> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            <div class="color-container">
                <div class="selected-color-div">
                    <p class="color-p">
                        <span class="color-span">
                            <span class="color-span2" aria-hidden="true">Color :</span>
                        </span>
                        &nbsp;<span class="color-selected">{{ $this->color ?? 'Not Selected' }}</span>
                    </p>
                </div>
                @isset($product->productcolors)
                    @if (count($product->productcolors->where('color', '!=', 'NA')) > 0)
                        <div>
                            <div class="all-color-container">
                                <ul class="colors-ul">
                                    @foreach ($product->productcolors->where('color', '!=', 'NA') as $key => $color)
                                        <li class="colors-li">
                                            <div class="colors-li-div" wire:key="selectcolor.{{ $color->color . $key }}"
                                                 wire:click="selectcolor('{{ $color->color }}')"
                                                 value="{{ $color->color }}" title="{{ $color->color }}">
                                                <div class="color-img-container">
                                                    <div class="color-img-div @if ($this->color == $color->color) active @endif">
                                                        @if(count($product->productcolors) == 1 )
                                                            <img class="color-image" alt="{{ $color->color }}"
                                                                 src="{{ Voyager::image($product->image) }}"/>
                                                        @else
                                                            <img class="color-image" alt="{{ $color->color }}"
                                                                 src="{{ Voyager::image($color->main_image) }}"/>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif
                @endisset
            </div>
        </div>

        <div class="mt-5">
            <div class="d-block">
                @if (Config::get('icrm.product_sku.color') == 1)
                    @if (!empty($this->color))
                        {{-- After selecting color --}}
                        @php
                            $productsizesforcolor = App\Productsku::where('product_id', $product->id)
                                ->where('color', $this->color)
                                ->where('status', 1)
                                ->get();
                        @endphp
                        @isset($productsizesforcolor)
                            @if (count($productsizesforcolor) > 0)
                                <div class="color-dropdown-wrapper">
                                    <div class="color-dropdown-container">
                                        <div class="color-dropdown-container2">
                                            <div class="color-dropdown-border"></div>
                                            <button class="color-dropdown-button" type="button" tabindex="0"
                                                    onclick="slideToggle('sizes-list')">
                                                <span class="color-dropdown-span">{{ $this->size ?? 'Choose Size' }}</span>
                                                <div class="color-dropdown-div">
                                                    <svg viewBox="0 0 24 24" width="1em" height="1em"
                                                         style="display: none;" fill="currentColor"
                                                         class="color-dropdown-svg" id="sizes-list-chevron-down"
                                                         focusable="false" aria-hidden="true">
                                                        <path
                                                                d="M2.64 15.994c0-.192.073-.384.219-.53l7.55-7.55a2.252 2.252 0 0 1 3.181 0l7.551 7.55a.75.75 0 1 1-1.06 1.06l-7.551-7.55a.751.751 0 0 0-1.06 0l-7.55 7.55a.75.75 0 0 1-1.28-.53z">
                                                        </path>
                                                    </svg>

                                                    <svg class="color-dropdown-svg" id="sizes-list-chevron-up"
                                                         viewBox="0 0 24 24" width="1em" height="1em"
                                                         fill="currentColor" focusable="false" aria-hidden="true">
                                                        <path
                                                                d="M2.859 7.475a.75.75 0 0 1 1.06 0l7.55 7.55a.751.751 0 0 0 1.06 0l7.551-7.55a.75.75 0 1 1 1.061 1.06l-7.55 7.55a2.252 2.252 0 0 1-3.182 0l-7.55-7.55a.748.748 0 0 1 0-1.06z">
                                                        </path>
                                                    </svg>
                                                </div>
                                            </button>

                                            <div id="sizes-list" style="display: none;" class="size-list-wrapper">
                                                <div class="size-list-container">
                                                    @foreach ($productsizesforcolor as $key => $size)
                                                        <div class="size-div"
                                                             wire:key="selectsize.{{ $size->size . $key }}"
                                                             wire:click="selectsize('{{ $size->size }}')"
                                                             value="{{ $size->size }}"
                                                             @if ($size->available_stock <= 0) disabled="disabled"
                                                             title="{{ Config::get('icrm.frontend.outofstock.name') }}" @endif>
                                                            <input type="checkbox" class="size-input" name="size-picker"
                                                                   value=""/>
                                                            <div class="size-div2">
                                                                <label class="size-label">
                                                                    <span class="size-span">
                                                                        <div class="size-span-div">
                                                                            <span class="size-name"
                                                                                  @if ($size->available_stock <= 0) style="color:red;" @endif>{{ $size->size }}</span>
                                                                        </div>
                                                                    </span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endisset
                    @else
                        @php
                            $productsizesforcolor = DB::table('productsku')
                                ->select('size')
                                ->where('product_id', $product->id)
                                ->where('status', 1)
                                ->groupBy('size')
                                ->get();

                        @endphp
                        @isset($productsizesforcolor)
                            @if (count($productsizesforcolor) > 0)
                                <div class="color-dropdown-wrapper">
                                    <div class="color-dropdown-container">
                                        <div class="color-dropdown-container2">
                                            <div class="color-dropdown-border"></div>
                                            <button class="color-dropdown-button" type="button" tabindex="0"
                                                    onclick="slideToggle('sizes-list')">
                                                <span
                                                        class="color-dropdown-span">{{ $this->size ?? 'Choose Size' }}</span>
                                                <div class="color-dropdown-div">
                                                    <svg viewBox="0 0 24 24" width="1em" height="1em"
                                                         style="display: none;" fill="currentColor"
                                                         class="color-dropdown-svg" id="sizes-list-chevron-down"
                                                         focusable="false" aria-hidden="true">
                                                        <path
                                                                d="M2.64 15.994c0-.192.073-.384.219-.53l7.55-7.55a2.252 2.252 0 0 1 3.181 0l7.551 7.55a.75.75 0 1 1-1.06 1.06l-7.551-7.55a.751.751 0 0 0-1.06 0l-7.55 7.55a.75.75 0 0 1-1.28-.53z">
                                                        </path>
                                                    </svg>

                                                    <svg class="color-dropdown-svg" id="sizes-list-chevron-up"
                                                         viewBox="0 0 24 24" width="1em" height="1em"
                                                         fill="currentColor" focusable="false" aria-hidden="true">
                                                        <path
                                                                d="M2.859 7.475a.75.75 0 0 1 1.06 0l7.55 7.55a.751.751 0 0 0 1.06 0l7.551-7.55a.75.75 0 1 1 1.061 1.06l-7.55 7.55a2.252 2.252 0 0 1-3.182 0l-7.55-7.55a.748.748 0 0 1 0-1.06z">
                                                        </path>
                                                    </svg>
                                                </div>
                                            </button>

                                            <div id="sizes-list" style="display: none;" class="size-list-wrapper">
                                                <div class="size-list-container">
                                                    @foreach ($productsizesforcolor as $key => $size)
                                                        <div class="size-div"
                                                             @if ($this->size == $size->size) active @endif"
                                                        wire:attr="disabled">
                                                        <input type="checkbox" class="size-input" name="size-picker"
                                                               value=""/>
                                                        <div class="size-div2">
                                                            <label class="size-label">
                                                                    <span class="size-span">
                                                                        <div class="size-span-div">
                                                                            <span class="size-name"
                                                                                  @if ($size->available_stock <= 0) style="color:red;" @endif>{{ $size->size }}</span>
                                                                        </div>
                                                                    </span>
                                                            </label>
                                                        </div>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
            </div>
            @endif
            @endisset
            @endif
            @endif
            <div class="buy-wrapper" data-testid="pdp-add-to-cart">
                <div class="input-group mr-2">
                    <button class="quantity-minus d-icon-minus" wire:click="minusqty"></button>
                    <input class="quantity form-control" type="number" min="1" max="1000000"
                           wire:model="qty" readonly>
                    <button class="quantity-plus d-icon-plus" wire:click="plusqty"
                            @if ($this->availablestock == 0) disabled="disabled" @endif></button>
                </div>
                <button class="add-to-cart-btn" type="button"
                        @if ($this->disablebtn == true) disabled="disabled" title="First select required fields!" @endif
                        wire:click="addtobag">
                    <span class="add-to-cart-span">Add to {{ ucwords(Config::get('icrm.cart.name')) }}</span>
                </button>
            </div>
            @if (Config::get('icrm.showcase_at_home.feature') == 1)
                @if (empty(Session::get('showcasecity')))
                    {{-- activate showcase --}}
                    @if ($this->product->vendor->showcase_at_home == 1)
                        <div class="buy-wrapper" data-testid="pdp-add-to-cart">
                            <button class="add-to-cart-btn" type="button"
                                    @if ($this->disablebtn == true) disabled="disabled" title="First select required fields!" @endif
                                    wire:click="addtoshowcaseathome">
                                <span class="add-to-cart-span">Showroom At Home</span>
                            </button>
                            {{-- <a href="{{ route('showcase.introduction') }}"><span class="fas fa-info-circle" title="What is showroom at home?"></span></a> --}}
                            <div class="new-wishlist-wrapper">
                                @livewire('wishlist', [
                                'wishlistproductid' => $product->id,
                                'view' => 'new-product-page',
                                ])
                            </div>
                        </div>
                    @endif
                @else
                    @if ($this->product->vendor->showcase_at_home == 1)
                        <div class="buy-wrapper" data-testid="pdp-add-to-cart">
                            @if ($this->product->vendor->city == Session::get('showcasecity'))
                                <button class="add-to-cart-btn" type="button"
                                        @if ($this->disablebtn == true) disabled="disabled" title="First select required fields!" @endif
                                        wire:click="addtoshowcaseathome">
                                    <span class="add-to-cart-span">Showroom At Home</span>
                                </button>
                            @else
                                <button class="add-to-cart-btn" type="button" disabled="disabled"
                                        title="Showroom at home not available for this product at {{ Session::get('showcasecity') }} area.">
                                    <span class="add-to-cart-span">Showroom At Home</span>
                                </button>
                            @endif
                            {{--                        <a href="{{ route('showcase.introduction') }}"><span class="fas fa-info-circle" title="What is showroom at home?"></span></a> --}}
                            <div class="new-wishlist-wrapper">
                                @livewire('wishlist', [
                                'wishlistproductid' => $product->id,
                                'view' => 'new-product-page',
                                ])
                            </div>
                        </div>
                    @endif
                @endif
            @endif

            @if (Session::has('qtynotavailable'))
                <span class="outofstock">{{ Session::get('qtynotavailable') }}</span>
            @endif
        </div>
    </div>

    <div class="sell-wrapper">
        <div class="sell-wrapper2">
            <div class="sell-and-shipped">
                    <span class="sell-and-shipped-span">
                        <p class="sell-and-shipped-p">Sold and Shipped by </p>
                        <img src="{{ Voyager::image(setting('site.site_icon')) }}" width="24px" height="24px"
                             style="margin-left: 10px;" alt="">
                    </span>
            </div>
            <div class="delivery-wrapper">
                <div class="delivery-conatiner">
                    <div class="delivery-conatiner2">
                        <p class="working-days">4-7 working days</p>
                        <p class="standard-delivery">Standard delivery</p>
                    </div>
                </div>
            </div>
            <div class="free-shipping-return">
                <div class="free-shipping-return-wrapper">
                    <svg viewBox="0 0 24 24" width="1em" height="1em" fill="currentColor"
                         class="free-shipping-return-svg" focusable="false" aria-hidden="true">
                        <path
                                d="m16.5 14.5-4.2-1.9c-.2-.1-.4-.1-.6 0l-4.2 1.9V6.9l2-5.6h5l2 5.9v7.3zM9 7.3v4.9l2.1-.9c.6-.3 1.2-.3 1.8 0l2.1.9V7.3l-1.6-4.5h-2.9L9 7.3z">
                        </path>
                        <path
                                d="M20.5 22.8h-17c-1.2 0-2.2-1-2.2-2.2V19c0-.4.3-.8.8-.8s.8.3.8.8v1.5c0 .4.3.8.8.8h17c.4 0 .8-.3.8-.8V7.3c0-.1 0-.2-.1-.3l-1.5-3.8c-.1-.3-.4-.5-.7-.5H5c-.3 0-.6.2-.7.5L2.8 7c0 .1-.1.2-.1.3V10c0 .4-.3.8-.8.8s-.7-.4-.7-.8V7.3c0-.3.1-.6.2-.8l1.5-3.8c.4-.9 1.2-1.5 2.1-1.5h14c.9 0 1.7.6 2.1 1.4l1.5 3.8c.1.3.2.5.2.8v13.2c0 1.3-1.1 2.4-2.3 2.4z">
                        </path>
                        <path
                                d="M2 7h20v1.5H2zm2.8 6.8h-4c-.5 0-.8-.4-.8-.8s.3-.8.8-.8h4c.4 0 .8.3.8.8s-.4.8-.8.8zm0 3h-4c-.5 0-.8-.4-.8-.8s.3-.8.8-.8h4c.4 0 .8.3.8.8-.1.4-.4.8-.8.8z">
                        </path>
                    </svg>
                    <p class="free-shipping-return-p">Free Shipping and Returns</p>
                </div>
            </div>
            <div class="seven-day-return">
                <div class="seven-day-return-wrapper">
                    <svg viewBox="0 0 24 24" width="1em" height="1em" fill="currentColor"
                         class="seven-day-return-svg" focusable="false" aria-hidden="true">
                        <path
                                d="M14.25 4.33H1.939l3.056-3.055A.75.75 0 0 0 3.934.215L.658 3.49a2.252 2.252 0 0 0 0 3.182l3.276 3.275a.75.75 0 0 0 1.06-1.06L1.94 5.83h12.31c4.557 0 8.251 3.694 8.251 8.25s-3.695 8.42-8.251 8.42h-12a.75.75 0 0 0 0 1.5h12c5.385 0 9.75-4.534 9.75-9.919s-4.365-9.75-9.75-9.75z">
                        </path>
                    </svg>
                    <p class="seven-day-return-p">7 Days Right of Return</p>
                </div>
            </div>
        </div>
    </div>
    <div class="description-wrapper">
        <div>
            <div class="desc-container">
                <h2 class="desc-container-h2">
                    <button class="desc-container-btn" type="button" tabindex="0" aria-expanded="false"
                            onclick="slideToggle('desc-detail-list')">
                            <span class="desc-span">
                                <span class="desc-span2">
                                    <span class="desc-span3">
                                        <h5 class="desc-span-h5">Features</h5>
                                    </span>
                                </span>
                            </span>
                        <svg viewBox="0 0 24 24" width="1em" height="1em" style="display: none;"
                             fill="currentColor" class="color-dropdown-svg" id="desc-detail-list-chevron-down"
                             focusable="false" aria-hidden="true">
                            <path
                                    d="M2.64 15.994c0-.192.073-.384.219-.53l7.55-7.55a2.252 2.252 0 0 1 3.181 0l7.551 7.55a.75.75 0 1 1-1.06 1.06l-7.551-7.55a.751.751 0 0 0-1.06 0l-7.55 7.55a.75.75 0 0 1-1.28-.53z">
                            </path>
                        </svg>

                        <svg class="color-dropdown-svg" id="desc-detail-list-chevron-up" viewBox="0 0 24 24"
                             width="1em" height="1em" fill="currentColor" focusable="false"
                             aria-hidden="true">
                            <path
                                    d="M2.859 7.475a.75.75 0 0 1 1.06 0l7.55 7.55a.751.751 0 0 0 1.06 0l7.551-7.55a.75.75 0 1 1 1.061 1.06l-7.55 7.55a2.252 2.252 0 0 1-3.182 0l-7.55-7.55a.748.748 0 0 1 0-1.06z">
                            </path>
                        </svg>
                    </button>
                </h2>
                <div id="desc-detail-list" class="desc-detail-wrapper">
                    <div class="desc-detail-container">
                        <div>
                            <dl>
                                {!! $product->features !!}
                                {{--                                                <div class="desc-content"> --}}
                                {{--                                                    <dt class="desc-label" role="term">Outer layer material: --}}
                                {{--                                                    </dt> --}}
                                {{--                                                    <dd class="desc-value" role="definition">100% katoen</dd> --}}
                                {{--                                                </div> --}}
                                {{--                                                <div class="desc-content"> --}}
                                {{--                                                    <dt class="desc-label" role="term">Materiaalverwerking:</dt> --}}
                                {{--                                                    <dd class="desc-value" role="definition">Jersey</dd> --}}
                                {{--                                                </div> --}}
                                {{--                                                <div class="desc-content"> --}}
                                {{--                                                    <dt class="desc-label" role="term">Wasvoorschrift:</dt> --}}
                                {{--                                                    <dd class="desc-value" role="definition">Machinewas tot 30 --}}
                                {{--                                                        °C, --}}
                                {{--                                                        niet geschikt voor de droger, niet bleken --}}
                                {{--                                                    </dd> --}}
                                {{--                                                </div> --}}
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="desc-container">
                <h2 class="desc-container-h2">
                    <button class="desc-container-btn" type="button" tabindex="0" aria-expanded="false"
                            onclick="slideToggle('desc-detail-list2')">
                            <span class="desc-span">
                                <span class="desc-span2">
                                    <span class="desc-span3">
                                        <h5 class="desc-span-h5">All about this product</h5>
                                    </span>
                                </span>
                            </span>
                        <svg viewBox="0 0 24 24" width="1em" height="1em" style="display: none;"
                             fill="currentColor" class="color-dropdown-svg" id="desc-detail-list2-chevron-down"
                             focusable="false" aria-hidden="true">
                            <path
                                    d="M2.64 15.994c0-.192.073-.384.219-.53l7.55-7.55a2.252 2.252 0 0 1 3.181 0l7.551 7.55a.75.75 0 1 1-1.06 1.06l-7.551-7.55a.751.751 0 0 0-1.06 0l-7.55 7.55a.75.75 0 0 1-1.28-.53z">
                            </path>
                        </svg>

                        <svg class="color-dropdown-svg" id="desc-detail-list2-chevron-up" viewBox="0 0 24 24"
                             width="1em" height="1em" fill="currentColor" focusable="false"
                             aria-hidden="true">
                            <path
                                    d="M2.859 7.475a.75.75 0 0 1 1.06 0l7.55 7.55a.751.751 0 0 0 1.06 0l7.551-7.55a.75.75 0 1 1 1.061 1.06l-7.55 7.55a2.252 2.252 0 0 1-3.182 0l-7.55-7.55a.748.748 0 0 1 0-1.06z">
                            </path>
                        </svg>
                    </button>
                </h2>
                <div id="desc-detail-list2" class="desc-detail-wrapper">
                    <div class="desc-detail-container">
                        <div>
                            <dl>
                                @if (!empty($product->type_id))
                                    <div class="desc-content">
                                        <dt class="desc-label" role="term">Type:</dt>
                                        <dd class="desc-value" role="definition">{{ $product->type_id }}</dd>
                                    </div>
                                @endif
                                @if (!empty($product->mount_id))
                                    <div class="desc-content">
                                        <dt class="desc-label" role="term">Mount:</dt>
                                        <dd class="desc-value" role="definition">{{ $product->mount_id }}</dd>
                                    </div>
                                @endif
                                @if (!empty($product->modellist_id))
                                    <div class="desc-content">
                                        <dt class="desc-label" role="term">Model:</dt>
                                        <dd class="desc-value" role="definition">{{ $product->modellist_id }}
                                        </dd>
                                    </div>
                                @endif
                                @if (!empty($product->voltage_id))
                                    <div class="desc-content">
                                        <dt class="desc-label" role="term">Voltage</dt>
                                        <dd role="definition" class="desc-value">{{ $product->voltage_id }}</dd>
                                    </div>
                                @endif

                                @if (!empty($product->interface_id))
                                    <div class="desc-content">
                                        <dt class="desc-label" role="term">Interface</dt>
                                        <dd role="definition" class="desc-value">{{ $product->interface_id }}
                                        </dd>
                                    </div>
                                @endif

                                @if (!empty($product->displaytype_id))
                                    <div class="desc-content">
                                        <dt class="desc-label" role="term">Display Type</dt>
                                        <dd role="definition" class="desc-value">{{ $product->displaytype_id }}
                                        </dd>
                                    </div>
                                @endif

                                @if (!empty($product->displaycolor_id))
                                    <div class="desc-content">
                                        <dt class="desc-label" role="term">Display Color</dt>
                                        <dd role="definition" class="desc-value">{{ $product->displaycolor_id }}
                                        </dd>
                                    </div>
                                @endif

                                @if (!empty($product->pb_id))
                                    <div class="desc-content">
                                        <dt class="desc-label" role="term">PB</dt>
                                        <dd role="definition" class="desc-value">{{ $product->pb_id }}</dd>
                                    </div>
                                @endif

                                @if (!empty($product->max_g))
                                    <div class="desc-content">
                                        <dt class="desc-label" role="term">Maximum G+</dt>
                                        <dd role="definition" class="desc-value">{{ $product->max_g }}</dd>
                                    </div>
                                @endif

                                @if (!empty($product->gender_id))
                                    <div class="desc-content">
                                        <dt class="desc-label" role="term">Gender</dt>
                                        <dd role="definition" class="border-no desc-value">
                                            {{ $product->gender_id }}</dd>
                                    </div>
                                @endif

                                @if (!empty($product->style_id))
                                    <div class="desc-content">
                                        <dt class="desc-label">Style</dt>
                                        <dd role="definition" class="border-no desc-value">
                                            {{ $product->style_id }}</dd>
                                    </div>
                                @endif

                                @if (!empty($product->brand_id))
                                    <div class="desc-content">
                                        <dt class="desc-label">Brand</dt>
                                        <dd role="definition" class="border-no desc-value">
                                            {{ $product->brand_id }}</dd>
                                    </div>
                                @endif
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="desc-container">
                <h2 class="desc-container-h2">
                    <button class="desc-container-btn" type="button" tabindex="0" aria-expanded="false"
                            onclick="slideToggle('desc-detail-list3')">
                            <span class="desc-span">
                                <span class="desc-span2">
                                    <span class="desc-span3">
                                        <h5 class="desc-span-h5">Size and Fitting</h5>
                                    </span>
                                </span>
                            </span>
                        <svg viewBox="0 0 24 24" width="1em" height="1em" style="display: none;"
                             fill="currentColor" class="color-dropdown-svg" id="desc-detail-list3-chevron-down"
                             focusable="false" aria-hidden="true">
                            <path
                                    d="M2.64 15.994c0-.192.073-.384.219-.53l7.55-7.55a2.252 2.252 0 0 1 3.181 0l7.551 7.55a.75.75 0 1 1-1.06 1.06l-7.551-7.55a.751.751 0 0 0-1.06 0l-7.55 7.55a.75.75 0 0 1-1.28-.53z">
                            </path>
                        </svg>

                        <svg class="color-dropdown-svg" id="desc-detail-list3-chevron-up" viewBox="0 0 24 24"
                             width="1em" height="1em" fill="currentColor" focusable="false"
                             aria-hidden="true">
                            <path
                                    d="M2.859 7.475a.75.75 0 0 1 1.06 0l7.55 7.55a.751.751 0 0 0 1.06 0l7.551-7.55a.75.75 0 1 1 1.061 1.06l-7.55 7.55a2.252 2.252 0 0 1-3.182 0l-7.55-7.55a.748.748 0 0 1 0-1.06z">
                            </path>
                        </svg>
                    </button>
                </h2>
                <div id="desc-detail-list3" class="desc-detail-wrapper">
                    <div class="desc-detail-container">
                        <div>
                            <dl>
                                @if (Config::get('icrm.site_package.multi_vendor_store') == 1)
                                    <div class="desc-content">
                                        <dt class="desc-label" role="term">Vendor:</dt>
                                        <dd class="desc-value" role="definition">{{ $product->vendor->name }}
                                        </dd>
                                    </div>
                                @endif
                                <div class="desc-content">
                                    <dt class="desc-label" role="term">Brand:</dt>
                                    <dd class="desc-value" role="definition">{{ $product->brand_id }}</dd>
                                </div>
                                @if (!empty($product->max_g))
                                    <div class="desc-content">
                                        <dt class="desc-label" role="term">Maximum G+:</dt>
                                        <dd class="desc-value" role="definition">{{ $product->max_g }}</dd>
                                    </div>
                                @endif
                                @if (!empty($product->cost_per_g))
                                    <div class="desc-content">
                                        <dt class="desc-label" role="term">Cost per G:</dt>
                                        <dd class="desc-value" role="definition">{{ $product->cost_per_g }}</dd>
                                    </div>
                                @endif
                                <div class="desc-content">
                                    <dt class="desc-label" role="term">Length:</dt>
                                    <dd class="desc-value" role="definition">{{ $product->length }} cm</dd>
                                </div>
                                <div class="desc-content">
                                    <dt class="desc-label" role="term">Breadth:</dt>
                                    <dd class="desc-value" role="definition">{{ $product->breadth }} cm</dd>
                                </div>
                                <div class="desc-content">
                                    <dt class="desc-label" role="term">Height:</dt>
                                    <dd class="desc-value" role="definition">{{ $product->height }} cm</dd>
                                </div>
                                <div class="desc-content">
                                    <dt class="desc-label" role="term">Weight:</dt>
                                    <dd class="desc-value" role="definition">{{ $product->weight }} kg</dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
            <div class="desc-container">
                <h2 class="desc-container-h2-brand">
                    <button class="desc-container-btn" type="button" tabindex="0" aria-expanded="false">
                            <span class="desc-span">
                                <span class="desc-span2">
                                    <span class="desc-span3">
                                        <h5 class="desc-span-h5">{{ ucwords($product->brand_id) }}</h5>
                                    </span>
                                    <button class="view-more" type="button">
                                        <a class="view-more-a"
                                           href="{{ route('products', ['brands[' . $product->brand_id . ']' => $product->brand_id]) }}">View
                                            More</a>
                                    </button>
                                </span>
                            </span>
                    </button>
                </h2>
            </div>
        </div>
    </div>

@else
    <div>

        <div class="product-price">

            <ins class="new-price">{{ Config::get('icrm.currency.icon') }}
                {{ number_format($offer_price, 0) }}/-
            </ins>
            <del class="old-price">{{ Config::get('icrm.currency.icon') }} {{ number_format($mrp, 0) }}</del>

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
            <a href="#product-tab-reviews" class="link-to-tab rating-reviews">
                ( @if ($product->productreviews())
                    {{ $product->productreviews()->count() }}
                @else
                    0
                @endif reviews )
            </a>
        </div>
        <p class="product-short-desc">
            {{ $product->getTranslatedAttribute('description', App::getLocale(), 'en') }}
        </p>
        @foreach ($this->offer_coupons as $coupon)
            <div class="pdp-promotion">
                <div class="pdp-promo-block">
                    {{-- <div class="ic-offer-tag"></div> --}}
                    <div class="promo-blck">
                        <div class="promo-title-blck">
                            <div class="promo-title">Use Code <br>{{ $coupon->code }}</div>
                            <div class="promo-tnc-blck">
                                    <span class="promo-tnc">
                                        <a href="undefined" target="_blank"></a>
                                    </span>
                            </div>
                        </div>
                        <div class="promo-desc-block">
                            <div class="promo-discounted-price">Get it for
                                <span>{{ Config::get('icrm.currency.icon') }}{{ number_format($coupon->discounted_value, 0) }}/-</span>
                            </div>
                            <div class="promo-desc">{{ $coupon->description }}
                                <br>
                                <a href="{{ route('products.vendor', ['slug' => $product->seller_id]) }}"
                                   target="_blank">
                                    View All Products
                                </a>
                                {{-- <a target="_blank" href="">View All Products</a> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        @isset($product->productcolors)

            @if (count($product->productcolors->where('color', '!=', 'NA')) > 0)
                <div class="product-form product-color">
                    <label>Color: <span class="outofstock">*</span></label>
                    <div class="product-variations">
                        @foreach ($product->productcolors->where('color', '!=', 'NA') as $key => $color)
                            @if (empty($color->main_image))
                                {{-- Fetch default image --}}
                                <a class="color @if ($this->color == $color->color) active @endif"
                                   data-src="{{ Voyager::image($product->image) }}"
                                   style="background-color: @if (!empty($color->colors->rgb)) {{ $color->colors->rgb }} @else {{ $color->colors->name }} @endif"
                                   wire:key="selectcolor.{{ $color->color . $key }}"
                                   wire:click="selectcolor('{{ $color->color }}')" value="{{ $color->color }}"
                                   title="{{ $color->color }}">
                                </a>
                            @else
                                {{-- Fetch color image --}}
                                <a class="color @if ($this->color == $color->color) active @endif"
                                   data-src="{{ Voyager::image($color->main_image) }}"
                                   style="background-color: @if (!empty($color->colors->rgb)) {{ $color->colors->rgb }} @else {{ $color->colors->name }} @endif"
                                   wire:key="selectcolor.{{ $color->color . $key }}"
                                   wire:click="selectcolor('{{ $color->color }}')" value="{{ $color->color }}"
                                   title="{{ $color->color }}">
                                </a>
                            @endif
                        @endforeach

                    </div>
                </div>
            @endif

        @endisset


        @if (Config::get('icrm.product_sku.color') == 1)
            @if (!empty($this->color))
                {{-- After selecting color --}}
                @php
                    $productsizesforcolor = App\Productsku::where('product_id', $product->id)
                        ->where('color', $this->color)
                        ->where('status', 1)
                        ->get();
                @endphp
                @isset($productsizesforcolor)
                    @if (count($productsizesforcolor) > 0)
                        <div class="product-form product-size">
                            <label>Size: <span class="outofstock">*</span></label>
                            <div class="product-form-group">
                                <div class="product-size-variations">
                                    @foreach ($productsizesforcolor as $key => $size)
                                        <a class="newsize @if ($this->size == $size->size) active @endif @if ($size->available_stock <= 0) outofstock @endif"
                                           {{-- data-src="{{ Voyager::image($size->main_image) }}"  --}} style="width: auto !important;"
                                           wire:key="selectsize.{{ $size->size . $key }}"
                                           wire:click="selectsize('{{ $size->size }}')"
                                           value="{{ $size->size }}"
                                           @if ($size->available_stock <= 0) disabled="disabled"
                                           title="{{ Config::get('icrm.frontend.outofstock.name') }}" @endif>
                                            {{ $size->size }}

                                            {{-- @if ($size->available_stock <= 0)
                                            <br><span class="outofstock">{{ Config::get('icrm.frontend.outofstock.name') }}</span>
                                        @endif --}}
                                        </a>
                                    @endforeach
                                </div>

                                @if (!empty($product->size_guide))
                                    <a href="#product-tab-size-guide" class="size-guide link-to-tab ml-4"><i
                                                class="d-icon-th-list"></i>Size
                                        Guide</a>
                                @endif
                                {{-- <a href="#" class="product-variation-clean" style="display: none;">Clean All</a> --}}
                            </div>
                        </div>
                    @endif
                    <br>
                @endisset
            @else
                {{-- Disabled - First select color --}}
                @php
                    $productsizesforcolor = DB::table('productsku')
                        ->select('size')
                        ->where('product_id', $product->id)
                        ->where('status', 1)
                        ->groupBy('size')
                        ->get();

                @endphp
                @isset($productsizesforcolor)
                    @if (count($productsizesforcolor) > 0)
                        <div class="product-form product-size">
                            <label>Size: <span class="outofstock">*</span></label>
                            <div class="product-form-group">
                                <div class="product-size-variations">
                                    @foreach ($productsizesforcolor as $key => $size)
                                        <a class="newsize @if ($this->size == $size->size) active @endif"
                                           {{-- data-src="{{ Voyager::image($size->main_image) }}"  --}} style="width: auto !important;"
                                           wire:attr="disabled">
                                            {{ $size->size }}

                                        </a>
                                    @endforeach
                                </div>

                                @if (!empty($product->size_guide))
                                    <a href="#product-tab-size-guide" class="size-guide link-to-tab ml-4"><i
                                                class="d-icon-th-list"></i>Size
                                        Guide</a>
                                @endif
                            </div>
                        </div>
                    @endif
                    <br>
                @endisset
            @endif
        @else
            @isset($product->productskus)
                @if (count($product->productskus->where('size', '!=', 'NA')) > 0)
                    <div class="product-form product-size">
                        <label>Size: <span class="outofstock">*</span></label>
                        <div class="product-form-group">
                            <div class="product-size-variations">
                                @php
                                    if (Config::get('icrm.product_sku.color') == 1) {
                                        $productskus = $product->productskus;
                                    } else {
                                        $productskus = $product->productskus;
                                    }
                                @endphp
                                @foreach ($productskus as $key => $size)
                                    <a class="newsize @if ($this->size == $size->size) active @endif @if ($size->available_stock <= 0) outofstock @endif"
                                       data-src="{{ Voyager::image($size->main_image) }}"
                                       style="width: auto !important;"
                                       wire:key="selectsize.{{ $size->size . $key }}"
                                       wire:click="selectsize('{{ $size->size }}')" value="{{ $size->size }}"
                                       @if ($size->available_stock <= 0) {{-- disabled="disabled" --}}
                                       title="{{ Config::get('icrm.frontend.outofstock.name') }}" @endif>
                                        {{ $size->size }}

                                        {{-- @if ($size->available_stock <= 0)
                                        <br><span class="outofstock">Out of stock</span>
                                    @endif --}}
                                    </a>
                                @endforeach
                            </div>

                            @if (!empty($product->size_guide))
                                <a href="#product-tab-size-guide" class="size-guide link-to-tab ml-4"><i
                                            class="d-icon-th-list"></i>Size
                                    Guide</a>
                            @endif
                            {{-- <a href="#" class="product-variation-clean" style="display: none;">Clean All</a> --}}
                        </div>
                    </div>
                @endif
                <br>
            @endisset
        @endif




        @if ($product->productsubcategory->name == 'COP')
            <div class="product-form">
                <label>G+: <span class="outofstock">*</span></label>
                <div class="select-box product-variations">
                    <select wire:model="max_g_need" class="form-control"
                            @if (!empty($this->max_g_need)) style="box-shadow: inset 0 0 0 2px blue;" @endif>
                        <option value="">Select G+</option>
                        @foreach ([1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15] as $item)
                            @if ($item <= $product->max_g)
                                <option value="{{ $item }}">{{ $item }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="product-form" style="margin-top: -0.8em;">
                <label for=""></label>
                <small>Additional cost for each G+ is {{ Config::get('icrm.currency.icon') }}
                    {{ $product->cost_per_g }}</small>
            </div>
        @endif

        @if (!empty(json_decode($product->requirement_document)))
            <div class="product-form">
                <label>Custom Requirements: <span class="outofstock">*</span></label>
                <div class="product-variations"
                     @if (!empty($this->requireddocument)) style="box-shadow: inset 0 0 0 2px blue;" @endif>

                    @if (!empty($product->requirement_document))
                        @foreach (json_decode($product->requirement_document) as $key => $document)
                            <br><small class="outofstock"><a
                                        href="{{ asset('storage/' . $document->download_link) }}"
                                        style="color: blue;">Click here</a> to download document format and reupload
                                here with your custom requirements</small>
                        @endforeach
                    @endif

                    <input type="file" wire:model="requireddocument" class="required" required>

                    <br>
                    <div wire:loading wire:target="requireddocument">Uploading...</div>
                    <br>
                    @error('requireddocument')
                    <span class="error">{{ $message }}</span>
                    @enderror
                </div>

            </div>
        @endif



        {{-- <div class="product-variation-price">
        <span>{{ $this->size.'-'.$this->color.'-'.$this->max_g_need }}</span>
    </div> --}}

        <hr class="product-divider">
        @if ($this->disablebtn == true)
            <span class="outofstock">FIRST SELECT REQUIRED FIELDS:</span>
        @else
            <label for="">You're buying:
            </label>
            @if (!empty($this->color) and $this->color != 'NA')
                <span>Color: {{ $this->color }}</span>,
            @endif

            @if (!empty($this->size) and $this->size != 'NA')
                <span>Size: {{ $this->size }}</span>,
            @endif

            @if (!empty($this->max_g_need))
                <span>G+: {{ $this->max_g_need }}</span>,
            @endif

            @if (!empty($this->requireddocument))
                <span>Custom Requirement: Attached</span>
            @endif
        @endif
        <br><br>

        <div class="product-form product-qty">
            <div class="product-form-group">
                <div class="input-group mr-2">
                    <button class="quantity-minus d-icon-minus" wire:click="minusqty"></button>
                    <input class="quantity form-control" type="number" min="1" max="1000000"
                           wire:model="qty" readonly>
                    <button class="quantity-plus d-icon-plus" wire:click="plusqty"
                            @if ($this->availablestock == 0) disabled="disabled" @endif></button>
                </div>


                <button class="btn-product btn-cart text-normal ls-normal font-weight-semi-bold"
                        @if ($this->disablebtn == true) disabled="disabled" title="First select required fields!" @endif
                        wire:click="addtobag">
                    <i class="d-icon-bag"></i>
                    Add to {{ ucwords(Config::get('icrm.cart.name')) }}
                </button>

                @if (Config::get('icrm.customize.feature') == 1)
                    @if (!empty($this->product->customize_images))
                        <button
                                class="btn-product btn-cart btn-warning text-normal ls-normal font-weight-semi-bold"
                                @if ($this->disablebtn == true) disabled="disabled" title="First select required fields!" @endif
                                wire:click="addtocustomize">
                            <i class="d-icon-abacus"></i>
                            Customize
                        </button>
                        <a href="{{ route('customize.introduction') }}"><span class="fas fa-info-circle"
                                                                              title="What is customization?"></span></a>
                    @endif
                @endif

                {{-- @php
                dd($this->product->vendor());
            @endphp --}}

                @if (Config::get('icrm.showcase_at_home.feature') == 1)
                    @if (empty(Session::get('showcasecity')))
                        {{-- activate showcase --}}
                        @if ($this->product->vendor->showcase_at_home == 1)
                            <button class="btn-product btn-cart text-normal ls-normal font-weight-semi-bold"
                                    @if ($this->disablebtn == true) disabled="disabled" title="First select required fields!" @endif
                                    wire:click="addtoshowcaseathome">
                                <i class="d-icon-home"></i>
                                Showroom At Homes
                            </button>
                            <a href="{{ route('showcase.introduction') }}"><span class="fas fa-info-circle"
                                                                                 title="What is showroom at home?"></span></a>
                        @endif
                    @else
                        {{-- @php
                        dd($this->product->vendor->where('city' == Session::get('showcasecity')->where('showcase_at_home', 1)));
                    @endphp --}}

                        {{-- check if the showcase at home is available for selected city --}}
                        @if ($this->product->vendor->showcase_at_home == 1)
                            @if ($this->product->vendor->city == Session::get('showcasecity'))
                                <button class="btn-product btn-cart text-normal ls-normal font-weight-semi-bold"
                                        @if ($this->disablebtn == true) disabled="disabled" title="First select required fields!" @endif
                                        wire:click="addtoshowcaseathome">
                                    <i class="d-icon-home"></i>
                                    Shoroom At Home
                                </button>
                                <a href="{{ route('showcase.introduction') }}"><span class="fas fa-info-circle"
                                                                                     title="What is showroom at home?"></span></a>
                            @else
                                <button class="btn-product btn-cart text-normal ls-normal font-weight-semi-bold"
                                        disabled="disabled"
                                        title="Showroom at home not available for this product at {{ Session::get('showcasecity') }} area.">
                                    <i class="d-icon-home"></i>
                                    Shoroom At Home
                                </button>
                                <a href="{{ route('showcase.introduction') }}"><span class="fas fa-info-circle"
                                                                                     title="What is showroom at home?"></span></a>
                            @endif
                        @endif
                    @endif

                @endif

                {{-- disabled="disabled" --}}
            </div>
        </div>

        @if (Session::has('qtynotavailable'))
            <span class="outofstock">{{ Session::get('qtynotavailable') }}</span>
        @endif

    </div>
@endif
