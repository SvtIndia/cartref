@if ($this->view == 'mobile-bottom')
    <div class="dropdown cart-dropdown">
        <a href="#" class="sticky-link showroom-dropdown-btn" style="position: relative;line-height: unset;padding: unset;">
            <i>
                @if (Session::get('showcasecity'))
                    <img src="{{ config('app.url') }}/images/icons/showroom-2.png" alt="iCommerce" style="height: 24px; object-fit: cover;">
                @else
                    <img src="{{ config('app.url') }}/images/icons/showroom-1.png" alt="iCommerce" style="height: 24px; object-fit: cover;">
                @endif
            </i>
            <span>Showroom</span>
            <span class="cart-count" style="position: absolute; top: -1.1em; color: darkorange;right: 1rem;font-size: 14px;">{{ count($ssproducts) }}</span>
        </a>
        <div class="dropdown-box dropdown-box-mobile" style="left: -115px;top: auto; bottom: 100%; margin-bottom: 2rem;">
            @if (count($ssproducts) == 0)
                <label>Your showroom at home bag is empty</label>
                <br><br>
                <div class="cart-action">
                    <a href="{{ route('products.showcase') }}" class="btn btn-dark"><span>Browse Products</span></a>
                    @if (Session::get('showcasecity') == null)
                        <a class="btn btn-sm btn-link" href="{{ route('showcase.getstarted') }}" style="color: red;">Activate Showroom At Home</a>
                    @endif
                </div>
            @else
                <div class="products scrollable">
                    @foreach ($ssproducts as $product)
                        <div class="product product-cart">
                            <figure class="product-media">
                                {{-- <a href="{{ route('product.slug', ['slug' => $product->attributes->slug]) }}">
                                <img src="{{ Voyager::image($product->attributes->image) }}" alt="{{ $product->name }}" width="80" height="88">
                            </a> --}}
                                <a
                                        href="{{ route('product.slug', ['slug' => $product->attributes->slug, 'color' => $product->attributes->color]) }}">

                                    @php
                                        $colorimage = App\Productcolor::where('product_id', $product->attributes->product_id)
                                            ->where('color', $product->attributes->color)
                                            ->first();

                                        if (!empty($colorimage->main_image)) {
                                            $colorimage = $colorimage->main_image;
                                        } else {
                                            $colorimage = App\Models\Product::where('id', $product->attributes->product_id)
                                                ->where('admin_status', 'Accepted')
                                                ->first()->image;
                                        }
                                    @endphp

                                    <img src="{{ Voyager::image($colorimage) }}" width="100" height="100"
                                         alt="{{ $product->name }} in {{ $product->attributes->color }} color">
                                </a>
                                <button class="btn btn-link btn-close"
                                        wire:click="removeshowcase('{{ $product->id }}')">
                                    <i class="fas fa-times"></i><span class="sr-only">Close</span>
                                </button>
                            </figure>
                            <div class="product-detail">
                                <a href="{{ route('product.slug', ['slug' => $product->attributes->slug]) }}"
                                   class="product-name">{{ $product->name }}</a>
                                <div class="price-box">
                                    <span class="product-quantity">1</span>
                                    <span
                                            class="product-price">{{ Config::get('icrm.currency.icon') }}{{ number_format($product->price, 2) }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <!-- End of Cart Product -->
                </div>
                <!-- End of Products  -->
                <div class="cart-total">
                    <label>Service charges:</label>
                    <span
                            class="price">{{ Config::get('icrm.currency.icon') }}{{ number_format(Config::get('icrm.showcase_at_home.delivery_charges'), 2) }}</span>
                </div>
                <!-- End of Cart Total -->

                    <div class="cart-action">
                        <a href="{{ route('showcase.bag') }}" class="btn btn-dark"><span>GO TO SHOWROOM BAG</span></a>
                    </div>
                <!-- End of Cart Action -->
            @endif

            @if (Session::get('showcasecity') != null)
                <br>
                <div class="cart-action">
                    <form action="{{ route('showcase.deactivate') }}" method="post"
                          class="input-wrappers input-wrapper-rounds input-wrapper-inlines ml-lg-auto">
                        @csrf
                        <input type="hidden" class="form-control font-secondary form-solid" name="showcasepincode"
                               id="showcasepincode" placeholder="Delivery pincode..." required="">
                        <button class="btn btn-sm btn-link" type="submit" style="color: red;">Deactivate Showroom At
                            Home
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>
@else
    <div class="dropdown cart-dropdown type2 mr-0 mr-lg-4 mr-4">
        <a href="{{ route('showcase.introduction') }}" class="cart-toggle link">
            <i>
                @if (Session::get('showcasecity'))
                    <img src="{{ config('app.url') }}/images/icons/showroom-2.png" alt="iCommerce"
                         style="height: 1.5em;">
                @else
                    <img src="{{ config('app.url') }}/images/icons/showroom-1.png" alt="iCommerce"
                         style="height: 1.5em;">
                @endif
                <span class="cart-count" style="top: -0.1em; background: darkorange;">{{ count($ssproducts) }}</span>
            </i>
            {{-- <i class="d-icon-home">
                <span class="cart-count" style="top: -0.1em; background: darkorange;">{{ count($ssproducts) }}</span>
            </i> --}}
        </a>
        <!-- End Cart Toggle -->
        <div class="dropdown-box" style="right: 0;">
            @if (count($ssproducts) == 0)

                <label>Your showroom at home bag is empty</label>
                <br><br>
                <div class="cart-action">
                    <a href="{{ route('products.showcase') }}" class="btn btn-dark"><span>Browse Products</span></a>
                </div>
            @else
                <div class="products scrollable">
                    @foreach ($ssproducts as $product)
                        <div class="product product-cart">
                            <figure class="product-media">
                                {{-- <a href="{{ route('product.slug', ['slug' => $product->attributes->slug]) }}">
                                <img src="{{ Voyager::image($product->attributes->image) }}" alt="{{ $product->name }}" width="80" height="88">
                            </a> --}}
                                <a
                                        href="{{ route('product.slug', ['slug' => $product->attributes->slug, 'color' => $product->attributes->color]) }}">

                                    @php
                                        $colorimage = App\Productcolor::where('product_id', $product->attributes->product_id)
                                            ->where('color', $product->attributes->color)
                                            ->first();

                                        if (!empty($colorimage->main_image)) {
                                            $colorimage = $colorimage->main_image;
                                        } else {
                                            $colorimage = App\Models\Product::where('id', $product->attributes->product_id)
                                                ->where('admin_status', 'Accepted')
                                                ->first()->image;
                                        }
                                    @endphp

                                    <img src="{{ Voyager::image($colorimage) }}" width="100" height="100"
                                         alt="{{ $product->name }} in {{ $product->attributes->color }} color">
                                </a>
                                <button class="btn btn-link btn-close"
                                        wire:click="removeshowcase('{{ $product->id }}')">
                                    <i class="fas fa-times"></i><span class="sr-only">Close</span>
                                </button>
                            </figure>
                            <div class="product-detail">
                                <a href="{{ route('product.slug', ['slug' => $product->attributes->slug]) }}"
                                   class="product-name">{{ $product->name }}</a>
                                <div class="price-box">
                                    <span class="product-quantity">1</span>
                                    <span
                                            class="product-price">{{ Config::get('icrm.currency.icon') }}{{ number_format($product->price, 2) }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <!-- End of Cart Product -->
                </div>
                <!-- End of Products  -->
                <div class="cart-total">
                    <label>Service charges:</label>
                    <span
                            class="price">{{ Config::get('icrm.currency.icon') }}{{ number_format(Config::get('icrm.showcase_at_home.delivery_charges'), 2) }}</span>
                </div>
                <!-- End of Cart Total -->

                <div class="cart-action">
                    {{-- <a href="{{ route('bag') }}" class="btn btn-dark btn-link">View Bag</a> --}}
                    <a href="{{ route('showcase.bag') }}" class="btn btn-dark"><span>GO TO SHOWROOM BAG</span></a>
                </div>
                <!-- End of Cart Action -->

            @endif


            @if (Session::get('showcasecity') != null)
                <br>
                <div class="cart-action">
                    <form action="{{ route('showcase.deactivate') }}" method="post"
                          class="input-wrappers input-wrapper-rounds input-wrapper-inlines ml-lg-auto">
                        @csrf
                        <input type="hidden" class="form-control font-secondary form-solid" name="showcasepincode"
                               id="showcasepincode" placeholder="Delivery pincode..." required="">
                        <button class="btn btn-sm btn-link" type="submit" style="color: red;">Deactivate Showroom At
                            Home
                        </button>
                    </form>
                </div>
            @endif


        </div>
        <!-- End Dropdown Box -->
    </div>
@endif
