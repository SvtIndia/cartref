<div class="dropdown cart-dropdown type2 mr-0 mr-lg-2">
    <a href="{{ route('bag') }}" class="cart-toggle link">
        <i class="d-icon-bag">
            <span class="cart-count" style="top: -0.15em;">{{ $hcartscount }}</span>
        </i>
    </a>
    <!-- End Cart Toggle -->
    <div class="dropdown-box">
        @if (count($hcarts) == 0)
            
            <label>Your {{ Config::get('icrm.cart.name') }} is empty</label>
            <br><br>
            <div class="cart-action">
                <a href="{{ route('products') }}" class="btn btn-dark"><span>Browse Products</span></a>
            </div>

        @else
            
            <div class="products scrollable">
                @foreach ($hcarts as $cart)
                @php
                    $cartproduct = App\Models\Product::where('id', $cart->attributes->product_id)->first();
                @endphp
                @if (!empty($cartproduct))
                <div class="product product-cart">
                    <figure class="product-media">
                        @php
                            $colorimage = App\Productcolor::where('product_id', $cartproduct->id)->where('color', $cart->attributes->color)->first();

                            if(!empty($colorimage->main_image))
                            {
                                $colorimage = $colorimage->main_image;
                            }else{
                                $colorimage = $cartproduct->image;
                            }
                        @endphp
                        <a href="{{ route('product.slug', ['slug' => $cartproduct->slug, 'color' => $cart->attributes->color]) }}">
                            <img src="{{ Voyager::image($colorimage) }}" alt="{{ $cartproduct->name }}" width="80" height="88">
                        </a>
                        <button class="btn btn-link btn-close" wire:click="removecart({{ $cart->id }})">
                            <i class="fas fa-times"></i><span class="sr-only">Close</span>
                        </button>
                    </figure>
                    <div class="product-detail">
                        <a href="{{ route('product.slug', ['slug' => $cartproduct->slug, 'color' => $cart->attributes->color]) }}" class="product-name">
                            {{ Str::limit($cartproduct->name, 20, '...') }}
                        </a>
                        <div class="price-box">
                            <span class="product-quantity">{{ $cart->quantity }}</span>
                            <span class="product-price">{{ Config::get('icrm.currency.icon') }}{{ number_format($cart->getPriceWithConditions(), 2) }}</span>
                        </div>
                    </div>
                </div>
                @endif
                @endforeach
                <!-- End of Cart Product -->
            </div>
            <!-- End of Products  -->
            <div class="cart-total">
                <label>Subtotal:</label>
                <span class="price">{{ Config::get('icrm.currency.icon') }}{{ number_format($hsubtotal, 2) }}</span>
            </div>
            <!-- End of Cart Total -->

            <div class="cart-action">
                {{-- <a href="{{ route('bag') }}" class="btn btn-dark btn-link">View Bag</a> --}}
                <a href="{{ route('bag') }}" class="btn btn-dark"><span>GO TO BAG</span></a>
            </div>
            <!-- End of Cart Action -->

        @endif
        
    </div>
    <!-- End Dropdown Box -->
</div>