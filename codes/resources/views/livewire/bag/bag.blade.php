<div>
    <main class="main cart">
        <div class="page-content pt-7 pb-10">
            @include('livewire.bag.bag_header')
            <div class="container mt-7 mb-2">
                <div class="row">
                    <div class="col-lg-8 col-md-12 pr-lg-4">

                        @if (count($carts) > 0)
                            <table class="shop-table cart-table">
                                <thead>
                                    <tr>
                                        <th><span>Product</span></th>
                                        <th><span>Details</span></th>
                                        <th><span>Weight</span></th>
                                        <th><span>Price</span></th>
                                        <th><span>quantity</span></th>
                                        <th>Subtotal</th>
                                        {{-- <th>Action</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($carts as $cart)
                                        {{-- Get cart product information --}}
                                        @php
                                            $product = App\Models\Product::where('id', $cart->attributes->product_id)->first();

                                            $userID = 0;
                                            if(\Illuminate\Support\Facades\Auth::check()){
                                                $userID = auth()->user()->id;
                                            }
                                            else{
                                                if(session('session_id')){
                                                    $userID = session('session_id');
                                                }
                                                else{
                                                    $userID = rand(1111111111,9999999999);
                                                    session(['session_id' => $userID]);
                                                }
                                            }

                                            if(empty($product))
                                            {
                                                \Cart::session($userID)->clear();
                                            }

                                        @endphp
                                        @if (!empty($product))
                                        <tr>
                                            <td class="product-thumbnail">
                                                <figure>
                                                    <a href="{{ route('product.slug', ['slug' => $product->slug, 'color' => $cart->attributes->color]) }}">
                                                        {{-- Get product color image --}}
                                                        @php
                                                            $colorimage = App\Productcolor::where('product_id', $product->id)->where('color', $cart->attributes->color)->first();

                                                            if(!empty($colorimage->main_image))
                                                            {
                                                                $colorimage = $colorimage->main_image;
                                                            }else{
                                                                $colorimage = $product->image;
                                                            }
                                                        @endphp
                                                        <img src="{{ Voyager::image($colorimage) }}" width="100" height="100"
                                                            alt="{{ $product->name }} in {{ $cart->attributes->color }} color">
                                                    </a>
                                                </figure>
                                            </td>
                                            <td class="product-name">
                                                <div class="product-name-section">
                                                    <a href="{{ route('product.slug', ['slug' => $product->slug, 'color' => $cart->attributes->color]) }}">
                                                        {{ Str::limit($product->name, 35, '...') }}
                                                    </a>
                                                    {{-- <br>
                                                    {{ $product->vendor->pincode }}
                                                    <br> --}}

                                                    @if (Config::get('icrm.site_package.multi_vendor_store') == 1)
                                                        <br><span>Vendor: <a href="{{ route('products.vendor', ['slug' => $product->vendor->id]) }}">{{ ucwords($product->vendor->brand_name) }}</a></span>
                                                    @endif

                                                    <br><span>Brand: {{ $product->brand_id }}</span>

                                                    @if ($cart->attributes->color != 'NA')
                                                        <br><span>Color: {{ $cart->attributes->color }}</span>
                                                    @endif

                                                    @if ($cart->attributes->size != 'NA')
                                                        <br><span>Size: {{ $cart->attributes->size }}</span>
                                                    @endif

                                                    @if ($cart->attributes->g_plus)
                                                        <br><span>Required G+: {{ $cart->attributes->g_plus }}</span>
                                                    @endif

                                                    @if ($cart->attributes->cost_per_g)
                                                        <br><span>Additional cost per G+: {{ Config::get('icrm.currency.icon') }} {{ $cart->attributes->cost_per_g }}/-</span>
                                                    @endif

                                                    @if ($cart->attributes->requireddocument)
                                                        <br><span>Custom requirement: <a href="{{ asset($cart->attributes->requireddocument) }}" style="color: blue">Download</a> </span>
                                                    @endif

                                                    @if ($cart->attributes->customized_image)
                                                        <br><span>Customized image: <a href="{{ asset($cart->attributes->customized_image) }}" target="_blank" style="color: blue">Download</a></span>
                                                    @endif

                                                    @if ($cart->attributes->original_file)
                                                        <br><span>Original file:
                                                        @foreach ($cart->attributes->original_file as $key => $originalfile)
                                                            <a href="{{ $originalfile }}" target="_blank" style="color: blue">Attachment {{ $key+1 }} @if($loop->last) @else , @endif</a>
                                                        @endforeach
                                                        </span>
                                                    @endif

                                                    <br><span>Order type: {{ $cart->attributes->type }}</span>
                                                    @isset($product->manufacturing_period)
                                                        @if ($product->manufacturing_period > 0)
                                                            <br><span>Manufacturing Period: {{ $product->manufacturing_period }} days</span>
                                                        @endif
                                                    @endif

                                                    <br><span>Hsn: {{ $product->productsubcategory->hsn }}</span>

                                                </div>
                                            </td>
                                            <td class="product-subtotal">
                                                <span class="amount">{{ $cart->attributes->weight }}kg</span>
                                            </td>
                                            <td class="product-subtotal">
                                                <span class="amount">{{ Config::get('icrm.currency.icon') }} {{ $cart->getPriceWithConditions() }}</span>
                                            </td>
                                            <div>
                                                <td class="product-quantity" @disabled(true)>
                                                    <div class="input-group">
                                                        <button class="quantity-minus d-icon-minus" wire:click="minusqty({{ $cart->id }}, {{ $cart->attributes->weight }})"></button>
                                                        <input class="quantity form-control" type="number" min="1"
                                                            max="1000000" value="{{ $cart->quantity }}" readonly>
                                                        <button class="quantity-plus d-icon-plus" wire:click="plusqty({{ $cart->id }}, {{ $cart->attributes->weight }})"></button>
                                                    </div>
                                                    @if (Session::has($cart->id.'qtynotavailable'))
                                                        <br>
                                                        <span class="outofstock">{{ Session::get($cart->id.'qtynotavailable') }}</span>

                                                    @endif
                                                </td>
                                            </div>
                                            <td class="product-price">
                                                <span class="amount">{{ Config::get('icrm.currency.icon') }} {{ $cart->getPriceSumWithConditions() }}</span>
                                                @if (Config::get('icrm.tax.type') == 'subcategory')
                                                    <br><small class="includingtax">Including {{ $product->productsubcategory->gst }}% {{ Config::get('icrm.tax.name') }}</small>
                                                @endif

                                            </td>
                                            <td class="product-close">
                                                <a wire:click="removecart({{ $cart->id }})" class="product-remove" title="Remove this product">
                                                    <i class="fas fa-times"></i>
                                                </a>
                                            </td>
                                            <td class="product-close">
                                                <a wire:click="wishlist({{ $product->id }},{{ $cart->id }})" class="product-remove" title="Move to wishlist">
                                                    <i class="fas fa-arrow-right"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="cart-actions mb-6 pt-4">
                                <a href="{{ route('products') }}" class="btn btn-dark btn-md btn-rounded btn-icon-left mr-4 mb-4"><i
                                    class="d-icon-arrow-left"></i>Continue Shopping</a>
                                {{-- <button type="submit"
                                    class="btn btn-outline btn-dark btn-md btn-rounded btn-disabled">Update
                                    Cart</button> --}}
                            </div>
                            {{-- <div class="cart-coupon-box mb-8">
                                <h4 class="title coupon-title text-uppercase ls-m">Coupon Discount</h4>
                                <input type="text" name="coupon_code"
                                    class="input-text form-control text-grey ls-m mb-4" id="coupon_code" value=""
                                    placeholder="Enter coupon code here...">
                                <button type="submit" class="btn btn-md btn-dark btn-rounded btn-outline">Apply
                                    Coupon</button>
                            </div> --}}
                        @else
                            <div class="p-20 mb-4 bg-light rounded-3 text-center">
                                <div class="container-fluid py-5">
                                    <img src="{{ asset('images/icrm/wishlist/empty_wishlist.svg') }}" class="img-responsive" alt="wishlist empty">
                                    <h1 class="display-5 fw-bold text-dark">Your {{ Config::get('icrm.cart.name') }} is empty</h1>
                                    <p class="fs-4 text-center">Browse products and add your favourite ones in {{ Config::get('icrm.cart.name') }}</p>
                                    <a href="{{ route('products') }}" class="btn btn-primary btn-lg" type="button">Browse Products</a>
                                </div>
                            </div>
                        @endif


                    </div>
                    <aside class="col-lg-4 sticky-sidebar-wrapper">
                        <div class="sticky-sidebar" data-sticky-options="{'bottom': 20}">
                            <div class="summary mb-4">
                                <h3 class="summary-title text-left">Cart Totals</h3>
                                <table class="shipping">
                                    <tr class="summary-subtotal">
                                        <td>
                                            <h4 class="summary-subtitle">Subtotal</h4>
                                        </td>
                                        <td>
                                            <p class="summary-subtotal-price">{{ Config::get('icrm.currency.icon') }} {{ number_format($subtotal, 2) }}</p>
                                        </td>
                                    </tr>

                                    <tr class="sumnary-shipping shipping-row-last">
                                        <td colspan="2">
                                            <h4 class="summary-subtitle">Check Shipping Serviceability</h4>
                                        </td>
                                    </tr>
                                </table>
                                <div class="shipping-address">
                                    <form wire:submit.prevent="checkshippingavailability">
                                        <input type="text"
                                            class="form-control @if(Session::has('deliveryavailable')) available @endif @if(Session::has('deliverynotavailable') ) notavailable @endif"
                                            wire:model.defer="deliverypincode"
                                            placeholder="Delivery Pincode" />

                                        @if (Session::has('deliveryavailable') == true)
                                            <small class="available">{{ Session::get('deliveryavailable') }}</small> <br>
                                        @elseif(Session::has('deliverynotavailable') == true)
                                            <small class="notavailable">{{ Session::get('deliverynotavailable') }}</small> <br>
                                        @endif

                                        <button type="submit" class="btn btn-md btn-dark btn-rounded btn-outline">Check</button>
                                    </form>
                                </div>
                                <table class="total">
                                    <tr class="summary-subtotal">
                                        <td>
                                            <h4 class="summary-subtitle">Total</h4>
                                        </td>
                                        <td>
                                            <p class="summary-total-price ls-s">{{ Config::get('icrm.currency.icon') }} {{ number_format($total, 2) }}</p>
                                        </td>
                                    </tr>
                                </table>

                                <a class="btn btn-dark btn-rounded btn-checkout" wire:click="proceedcheckout">
                                    Proceed to checkout
                                </a>
                                @if($this->deliveryavailability == false)
                                    <small class="outofstock">Before processing please check shipping serviceability</small>
                                @endif







                            </div>
                        </div>
                    </aside>
                </div>
            </div>
        </div>

    </main>
</div>

@if (!empty(setting('online-chat.cart_support')))
    <br>
    {!! setting('online-chat.cart_support') !!}
@endif
